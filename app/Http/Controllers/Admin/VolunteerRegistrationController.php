<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VolunteerRegistration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VolunteerRegistrationController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $registrations = VolunteerRegistration::select([
        'id',
        'full_name',
        'phone',
        'email',
        'region',
        'type',
        'status',
        'created_at',
      ]);

      return DataTables::of($registrations)
        ->addIndexColumn()
        ->addColumn('action', function ($registration) {
          $actions = '<div class="btn-group" role="group">';
          $actions .= '<a href="' . route('admin.community.volunteer-registrations.show', $registration->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
          $actions .= '<a href="' . route('admin.community.volunteer-registrations.edit', $registration->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
          $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('community.volunteer_registrations.delete_title') . '" data-item="' . e($registration->full_name) . '" data-url="' . route('admin.community.volunteer-registrations.destroy', $registration->id) . '">' . __('common.delete') . '</button>';
          $actions .= '</div>';
          return $actions;
        })
        ->editColumn('created_at', function ($registration) {
          return $registration->created_at?->format('Y-m-d H:i:s');
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    return view('admin.community.volunteer-registrations.index');
  }

  public function create()
  {
    return view('admin.community.volunteer-registrations.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'full_name' => ['required', 'string', 'max:255'],
      'phone' => ['nullable', 'string', 'max:50'],
      'email' => ['nullable', 'email', 'max:255'],
      'region' => ['nullable', 'string', 'max:255'],
      'type' => ['required', 'string', 'max:50'],
      'skills' => ['nullable', 'string'],
      'availability' => ['nullable', 'string'],
      'status' => ['required', 'string', 'max:50'],
      'notes' => ['nullable', 'string'],
    ]);

    VolunteerRegistration::create($validated);

    return redirect()->route('admin.community.volunteer-registrations.index')
      ->with('success', __('community.volunteer_registrations.created_successfully'));
  }

  public function show(VolunteerRegistration $volunteer_registration)
  {
    return view('admin.community.volunteer-registrations.show', [
      'registration' => $volunteer_registration,
    ]);
  }

  public function edit(VolunteerRegistration $volunteer_registration)
  {
    return view('admin.community.volunteer-registrations.edit', [
      'registration' => $volunteer_registration,
    ]);
  }

  public function update(Request $request, VolunteerRegistration $volunteer_registration)
  {
    $validated = $request->validate([
      'full_name' => ['required', 'string', 'max:255'],
      'phone' => ['nullable', 'string', 'max:50'],
      'email' => ['nullable', 'email', 'max:255'],
      'region' => ['nullable', 'string', 'max:255'],
      'type' => ['required', 'string', 'max:50'],
      'skills' => ['nullable', 'string'],
      'availability' => ['nullable', 'string'],
      'status' => ['required', 'string', 'max:50'],
      'notes' => ['nullable', 'string'],
    ]);

    $volunteer_registration->update($validated);

    return redirect()->route('admin.community.volunteer-registrations.index')
      ->with('success', __('community.volunteer_registrations.updated_successfully'));
  }

  public function destroy(VolunteerRegistration $volunteer_registration)
  {
    $volunteer_registration->delete();

    return redirect()->route('admin.community.volunteer-registrations.index')
      ->with('success', __('community.volunteer_registrations.deleted_successfully'));
  }
}
