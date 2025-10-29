<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'language', 'email_verified_at', 'created_at']);

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('email_verified', function ($user) {
                    return $user->email_verified_at ?
                        '<span class="badge bg-success">' . __('datatable.users.verified') . '</span>' :
                        '<span class="badge bg-warning">' . __('datatable.users.not_verified') . '</span>';
                })
                ->addColumn('action', function ($user) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.users.show', $user->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
                    $actions .= '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
                    $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('datatable.users.delete_title') . '" data-item="' . $user->name . '" data-url="' . route('admin.users.destroy', $user->id) . '">' . __('common.delete') . '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['email_verified', 'action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Search users for Select2 API
     */
    public function search(Request $request)
    {
        $term = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = User::select(['id', 'name', 'email'])
            ->when($term, function ($query, $term) {
                return $query->where(function ($q) use ($term) {
                    $q->where('name', 'LIKE', "%{$term}%")
                        ->orWhere('email', 'LIKE', "%{$term}%");
                });
            });

        $total = $query->count();
        $users = $query->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')',
                'name' => $user->name,
                'email' => $user->email,
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}
