<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityWhatsappGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommunityWhatsappGroupController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $groups = CommunityWhatsappGroup::select(['id', 'region', 'name', 'whatsapp_link', 'is_active', 'sort_order', 'created_at']);

      return DataTables::of($groups)
        ->addIndexColumn()
        ->addColumn('status', function ($group) {
          return $group->is_active
            ? '<span class="badge bg-success">' . __('common.active') . '</span>'
            : '<span class="badge bg-secondary">' . __('common.inactive') . '</span>';
        })
        ->addColumn('action', function ($group) {
          $actions = '<div class="btn-group" role="group">';
          $actions .= '<a href="' . route('admin.community.whatsapp-groups.show', $group->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
          $actions .= '<a href="' . route('admin.community.whatsapp-groups.edit', $group->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
          $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('community.whatsapp_groups.delete_title') . '" data-item="' . e($group->name) . '" data-url="' . route('admin.community.whatsapp-groups.destroy', $group->id) . '">' . __('common.delete') . '</button>';
          $actions .= '</div>';
          return $actions;
        })
        ->editColumn('created_at', function ($group) {
          return $group->created_at?->format('Y-m-d H:i:s');
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    return view('admin.community.whatsapp-groups.index');
  }

  public function create()
  {
    return view('admin.community.whatsapp-groups.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'region' => ['required', 'string', 'max:255'],
      'name' => ['required', 'string', 'max:255'],
      'whatsapp_link' => ['required', 'string', 'max:2048'],
      'description' => ['nullable', 'string'],
      'sort_order' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable'],
    ]);

    $validated['is_active'] = $request->has('is_active');
    $validated['sort_order'] = $validated['sort_order'] ?? 0;

    CommunityWhatsappGroup::create($validated);

    return redirect()->route('admin.community.whatsapp-groups.index')
      ->with('success', __('community.whatsapp_groups.created_successfully'));
  }

  public function show(CommunityWhatsappGroup $whatsapp_group)
  {
    return view('admin.community.whatsapp-groups.show', [
      'group' => $whatsapp_group,
    ]);
  }

  public function edit(CommunityWhatsappGroup $whatsapp_group)
  {
    return view('admin.community.whatsapp-groups.edit', [
      'group' => $whatsapp_group,
    ]);
  }

  public function update(Request $request, CommunityWhatsappGroup $whatsapp_group)
  {
    $validated = $request->validate([
      'region' => ['required', 'string', 'max:255'],
      'name' => ['required', 'string', 'max:255'],
      'whatsapp_link' => ['required', 'string', 'max:2048'],
      'description' => ['nullable', 'string'],
      'sort_order' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable'],
    ]);

    $validated['is_active'] = $request->has('is_active');
    $validated['sort_order'] = $validated['sort_order'] ?? 0;

    $whatsapp_group->update($validated);

    return redirect()->route('admin.community.whatsapp-groups.index')
      ->with('success', __('community.whatsapp_groups.updated_successfully'));
  }

  public function destroy(CommunityWhatsappGroup $whatsapp_group)
  {
    $whatsapp_group->delete();

    return redirect()->route('admin.community.whatsapp-groups.index')
      ->with('success', __('community.whatsapp_groups.deleted_successfully'));
  }
}
