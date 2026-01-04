<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommunityPostController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $posts = CommunityPost::select(['id', 'title', 'author_name', 'status', 'is_pinned', 'published_at', 'created_at']);

      return DataTables::of($posts)
        ->addIndexColumn()
        ->addColumn('pinned', function ($post) {
          return $post->is_pinned
            ? '<span class="badge bg-primary">' . __('community.posts.fields.pinned') . '</span>'
            : '<span class="badge bg-light text-dark">' . __('common.no_value') . '</span>';
        })
        ->editColumn('published_at', function ($post) {
          return $post->published_at?->format('Y-m-d H:i:s');
        })
        ->addColumn('action', function ($post) {
          $actions = '<div class="btn-group" role="group">';
          $actions .= '<a href="' . route('admin.community.posts.show', $post->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
          $actions .= '<a href="' . route('admin.community.posts.edit', $post->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
          $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('community.posts.delete_title') . '" data-item="' . e($post->title) . '" data-url="' . route('admin.community.posts.destroy', $post->id) . '">' . __('common.delete') . '</button>';
          $actions .= '</div>';
          return $actions;
        })
        ->editColumn('created_at', function ($post) {
          return $post->created_at?->format('Y-m-d H:i:s');
        })
        ->rawColumns(['pinned', 'action'])
        ->make(true);
    }

    return view('admin.community.posts.index');
  }

  public function create()
  {
    return view('admin.community.posts.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'content' => ['required', 'string'],
      'author_name' => ['nullable', 'string', 'max:255'],
      'status' => ['required', 'string', 'max:50'],
      'is_pinned' => ['nullable'],
      'published_at' => ['nullable', 'date'],
    ]);

    $validated['is_pinned'] = $request->has('is_pinned');

    CommunityPost::create($validated);

    return redirect()->route('admin.community.posts.index')
      ->with('success', __('community.posts.created_successfully'));
  }

  public function show(CommunityPost $post)
  {
    return view('admin.community.posts.show', compact('post'));
  }

  public function edit(CommunityPost $post)
  {
    return view('admin.community.posts.edit', compact('post'));
  }

  public function update(Request $request, CommunityPost $post)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'content' => ['required', 'string'],
      'author_name' => ['nullable', 'string', 'max:255'],
      'status' => ['required', 'string', 'max:50'],
      'is_pinned' => ['nullable'],
      'published_at' => ['nullable', 'date'],
    ]);

    $validated['is_pinned'] = $request->has('is_pinned');

    $post->update($validated);

    return redirect()->route('admin.community.posts.index')
      ->with('success', __('community.posts.updated_successfully'));
  }

  public function destroy(CommunityPost $post)
  {
    $post->delete();

    return redirect()->route('admin.community.posts.index')
      ->with('success', __('community.posts.deleted_successfully'));
  }
}
