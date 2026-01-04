<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorProfile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MentorProfileController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $mentors = MentorProfile::select(['id', 'name', 'title', 'is_active', 'sort_order', 'created_at']);

      return DataTables::of($mentors)
        ->addIndexColumn()
        ->addColumn('status', function ($mentor) {
          return $mentor->is_active
            ? '<span class="badge bg-success">' . __('common.active') . '</span>'
            : '<span class="badge bg-secondary">' . __('common.inactive') . '</span>';
        })
        ->addColumn('action', function ($mentor) {
          $actions = '<div class="btn-group" role="group">';
          $actions .= '<a href="' . route('admin.community.mentors.show', $mentor->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
          $actions .= '<a href="' . route('admin.community.mentors.edit', $mentor->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
          $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('community.mentors.delete_title') . '" data-item="' . e($mentor->name) . '" data-url="' . route('admin.community.mentors.destroy', $mentor->id) . '">' . __('common.delete') . '</button>';
          $actions .= '</div>';
          return $actions;
        })
        ->editColumn('created_at', function ($mentor) {
          return $mentor->created_at?->format('Y-m-d H:i:s');
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    return view('admin.community.mentors.index');
  }

  public function create()
  {
    return view('admin.community.mentors.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'title' => ['nullable', 'string', 'max:255'],
      'bio' => ['nullable', 'string'],
      'expertise' => ['nullable', 'string'],
      'photo_path' => ['nullable', 'string', 'max:2048'],
      'sort_order' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable'],
    ]);

    $validated['is_active'] = $request->has('is_active');
    $validated['sort_order'] = $validated['sort_order'] ?? 0;

    MentorProfile::create($validated);

    return redirect()->route('admin.community.mentors.index')
      ->with('success', __('community.mentors.created_successfully'));
  }

  public function show(MentorProfile $mentor)
  {
    return view('admin.community.mentors.show', compact('mentor'));
  }

  public function edit(MentorProfile $mentor)
  {
    return view('admin.community.mentors.edit', compact('mentor'));
  }

  public function update(Request $request, MentorProfile $mentor)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'title' => ['nullable', 'string', 'max:255'],
      'bio' => ['nullable', 'string'],
      'expertise' => ['nullable', 'string'],
      'photo_path' => ['nullable', 'string', 'max:2048'],
      'sort_order' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable'],
    ]);

    $validated['is_active'] = $request->has('is_active');
    $validated['sort_order'] = $validated['sort_order'] ?? 0;

    $mentor->update($validated);

    return redirect()->route('admin.community.mentors.index')
      ->with('success', __('community.mentors.updated_successfully'));
  }

  public function destroy(MentorProfile $mentor)
  {
    $mentor->delete();

    return redirect()->route('admin.community.mentors.index')
      ->with('success', __('community.mentors.deleted_successfully'));
  }
}
