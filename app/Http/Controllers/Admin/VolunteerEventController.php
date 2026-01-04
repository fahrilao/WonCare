<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VolunteerEvent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VolunteerEventController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $events = VolunteerEvent::select([
        'id',
        'title',
        'region',
        'start_at',
        'end_at',
        'is_online',
        'is_active',
        'created_at',
      ]);

      return DataTables::of($events)
        ->addIndexColumn()
        ->addColumn('status', function ($event) {
          return $event->is_active
            ? '<span class="badge bg-success">' . __('common.active') . '</span>'
            : '<span class="badge bg-secondary">' . __('common.inactive') . '</span>';
        })
        ->addColumn('mode', function ($event) {
          return $event->is_online
            ? '<span class="badge bg-info">' . __('common.online') . '</span>'
            : '<span class="badge bg-light text-dark">' . __('common.offline') . '</span>';
        })
        ->editColumn('start_at', function ($event) {
          return $event->start_at?->format('Y-m-d H:i:s');
        })
        ->editColumn('end_at', function ($event) {
          return $event->end_at?->format('Y-m-d H:i:s');
        })
        ->addColumn('action', function ($event) {
          $actions = '<div class="btn-group" role="group">';
          $actions .= '<a href="' . route('admin.community.volunteer-events.show', $event->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
          $actions .= '<a href="' . route('admin.community.volunteer-events.edit', $event->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
          $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('community.volunteer_events.delete_title') . '" data-item="' . e($event->title) . '" data-url="' . route('admin.community.volunteer-events.destroy', $event->id) . '">' . __('common.delete') . '</button>';
          $actions .= '</div>';
          return $actions;
        })
        ->editColumn('created_at', function ($event) {
          return $event->created_at?->format('Y-m-d H:i:s');
        })
        ->rawColumns(['status', 'mode', 'action'])
        ->make(true);
    }

    return view('admin.community.volunteer-events.index');
  }

  public function create()
  {
    return view('admin.community.volunteer-events.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'start_at' => ['nullable', 'date'],
      'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
      'region' => ['nullable', 'string', 'max:255'],
      'location' => ['nullable', 'string', 'max:255'],
      'registration_link' => ['nullable', 'string', 'max:2048'],
      'is_online' => ['nullable'],
      'is_active' => ['nullable'],
    ]);

    $validated['is_online'] = $request->has('is_online');
    $validated['is_active'] = $request->has('is_active');

    VolunteerEvent::create($validated);

    return redirect()->route('admin.community.volunteer-events.index')
      ->with('success', __('community.volunteer_events.created_successfully'));
  }

  public function show(VolunteerEvent $volunteer_event)
  {
    return view('admin.community.volunteer-events.show', [
      'event' => $volunteer_event,
    ]);
  }

  public function edit(VolunteerEvent $volunteer_event)
  {
    return view('admin.community.volunteer-events.edit', [
      'event' => $volunteer_event,
    ]);
  }

  public function update(Request $request, VolunteerEvent $volunteer_event)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'start_at' => ['nullable', 'date'],
      'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
      'region' => ['nullable', 'string', 'max:255'],
      'location' => ['nullable', 'string', 'max:255'],
      'registration_link' => ['nullable', 'string', 'max:2048'],
      'is_online' => ['nullable'],
      'is_active' => ['nullable'],
    ]);

    $validated['is_online'] = $request->has('is_online');
    $validated['is_active'] = $request->has('is_active');

    $volunteer_event->update($validated);

    return redirect()->route('admin.community.volunteer-events.index')
      ->with('success', __('community.volunteer_events.updated_successfully'));
  }

  public function destroy(VolunteerEvent $volunteer_event)
  {
    $volunteer_event->delete();

    return redirect()->route('admin.community.volunteer-events.index')
      ->with('success', __('community.volunteer_events.deleted_successfully'));
  }
}
