<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassCreateRequest;
use App\Http\Requests\ClassUpdateRequest;
use App\Models\ClassModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ClassController extends Controller
{
    /**
     * Display a listing of the classes.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $classes = ClassModel::with('categories')->select(['id', 'title', 'status', 'created_at']);

            return DataTables::of($classes)
                ->addIndexColumn()
                ->addColumn('categories', function ($class) {
                    $categories = $class->categories->pluck('name')->toArray();
                    return implode(', ', $categories);
                })
                ->addColumn('status_badge', function ($class) {
                    $badgeClass = $class->status === 'published' ? 'bg-success' : 'bg-warning';
                    $statusText = $class->status === 'published' ? 
                        __('datatable.classes.published') : 
                        __('datatable.classes.draft');
                    return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('action', function ($class) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.classes.show', $class->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
                    $actions .= '<a href="' . route('admin.classes.edit', $class->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
                    $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('datatable.classes.delete_title') . '" data-item="' . $class->title . '" data-url="' . route('admin.classes.destroy', $class->id) . '">' . __('common.delete') . '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('created_at', function ($class) {
                    return $class->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return view('admin.classes.index');
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.classes.create', compact('categories'));
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(ClassCreateRequest $request)
    {
        $validated = $request->validated();
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('classes/thumbnails', 'public');
        }

        // Remove categories from validated data before creating class
        $categories = $validated['categories'];
        unset($validated['categories']);

        $class = ClassModel::create($validated);
        
        // Attach categories
        $class->categories()->attach($categories);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified class.
     */
    public function show(ClassModel $class)
    {
        $class->load('categories');
        return view('admin.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(ClassModel $class)
    {
        $categories = Category::orderBy('name')->get();
        $class->load('categories');
        return view('admin.classes.edit', compact('class', 'categories'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(ClassUpdateRequest $request, ClassModel $class)
    {
        $validated = $request->validated();
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($class->thumbnail) {
                Storage::disk('public')->delete($class->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('classes/thumbnails', 'public');
        }

        // Remove categories from validated data before updating class
        $categories = $validated['categories'];
        unset($validated['categories']);

        $class->update($validated);
        
        // Sync categories
        $class->categories()->sync($categories);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(ClassModel $class)
    {
        // Delete thumbnail if exists
        if ($class->thumbnail) {
            Storage::disk('public')->delete($class->thumbnail);
        }

        // Detach categories
        $class->categories()->detach();
        
        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class deleted successfully.');
    }

    /**
     * Search classes for Select2 API
     */
    public function search(Request $request)
    {
        $term = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = ClassModel::select(['id', 'title', 'status'])
            ->when($term, function ($query, $term) {
                return $query->where('title', 'LIKE', "%{$term}%");
            });

        $total = $query->count();
        $classes = $query->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $results = $classes->map(function ($class) {
            return [
                'id' => $class->id,
                'text' => $class->title . ' (' . ucfirst($class->status) . ')',
                'title' => $class->title,
                'status' => $class->status,
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
