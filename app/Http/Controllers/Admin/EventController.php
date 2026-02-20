<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRSVP;
use App\Models\EventDocumentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events = Event::with(['creator', 'rsvps'])
                ->select('events.*')
                ->orderBy('start_datetime', 'desc');

            return DataTables::of($events)
                ->addIndexColumn()
                ->addColumn('type', function ($event) {
                    return $event->type_badge;
                })
                ->addColumn('date_range', function ($event) {
                    return $event->formatted_date_range;
                })
                ->addColumn('participants', function ($event) {
                    $confirmed = $event->confirmedRsvps()->count();
                    $max = $event->max_participants ?? '∞';
                    return "{$confirmed} / {$max}";
                })
                ->addColumn('status', function ($event) {
                    return $event->status_badge;
                })
                ->addColumn('action', function ($event) {
                    $showUrl = route('admin.events.show', $event);
                    $editUrl = route('admin.events.edit', $event);
                    $deleteUrl = route('admin.events.destroy', $event);

                    return '
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="' . $showUrl . '" class="btn btn-sm btn-info" title="' . __('common.view') . '">
                                <i class="ti tabler-eye"></i>
                            </a>
                            <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="' . __('common.edit') . '">
                                <i class="ti tabler-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                data-url="' . $deleteUrl . '" 
                                data-title="' . __('events.delete_title') . '" 
                                title="' . __('common.delete') . '">
                                <i class="ti tabler-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['type', 'status', 'action'])
                ->make(true);
        }

        return view('admin.events.index');
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:offline,online',
            'location' => 'required_if:type,offline|nullable|string',
            'meeting_link' => 'required_if:type,online|nullable|url',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,cancelled,completed',
            'banner_image' => 'nullable|image|max:2048',
            'require_rsvp' => 'boolean',
            'send_reminder' => 'boolean',
            'reminder_hours_before' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        $validated['created_by'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', __('events.created_successfully'));
    }

    public function show(Event $event)
    {
        $event->load(['creator', 'rsvps.member', 'documentation']);

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:offline,online',
            'location' => 'required_if:type,offline|nullable|string',
            'meeting_link' => 'required_if:type,online|nullable|url',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,cancelled,completed',
            'banner_image' => 'nullable|image|max:2048',
            'require_rsvp' => 'boolean',
            'send_reminder' => 'boolean',
            'reminder_hours_before' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('banner_image')) {
            // Delete old banner if exists
            if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', __('events.updated_successfully'));
    }

    public function destroy(Event $event)
    {
        // Delete banner image if exists
        if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => __('events.deleted_successfully')
        ]);
    }

    // RSVP Management
    public function rsvps(Event $event)
    {
        $rsvps = $event->rsvps()->with('member')->orderBy('created_at', 'desc')->get();

        return view('admin.events.rsvps', compact('event', 'rsvps'));
    }

    public function updateRsvpStatus(Request $request, EventRSVP $rsvp)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,attended',
        ]);

        $rsvp->update($validated);

        if ($validated['status'] === 'attended') {
            $rsvp->markAsAttended();
        }

        return response()->json([
            'success' => true,
            'message' => __('events.rsvp_updated_successfully')
        ]);
    }

    // Reminder Functions
    public function sendReminders(Event $event)
    {
        $rsvps = $event->confirmedRsvps()
            ->where('reminder_sent', false)
            ->get();

        foreach ($rsvps as $rsvp) {
            // Send Email Reminder
            $this->sendEmailReminder($rsvp);

            // Send WhatsApp Reminder (placeholder for you to implement)
            $this->sendWhatsAppReminder($rsvp);

            $rsvp->markReminderSent();
        }

        return response()->json([
            'success' => true,
            'message' => __('events.reminders_sent_successfully', ['count' => $rsvps->count()])
        ]);
    }

    protected function sendEmailReminder(EventRSVP $rsvp)
    {
        // TODO: Implement email reminder logic
        // Example: Mail::to($rsvp->email)->send(new EventReminderMail($rsvp));
    }

    protected function sendWhatsAppReminder(EventRSVP $rsvp)
    {
        // TODO: Implement WhatsApp reminder logic
        // This is a placeholder function for you to implement later
        // You can integrate with WhatsApp Business API or third-party services
    }

    // Documentation Management
    public function uploadDocumentation(Request $request, Event $event)
    {
        $validated = $request->validate([
            'type' => 'required|in:photo,video',
            'file' => 'required|file|max:10240', // 10MB max
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('events/documentation', 'public');

        $event->documentation()->create([
            'type' => $validated['type'],
            'file_path' => $filePath,
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('events.documentation_uploaded_successfully')
        ]);
    }

    public function deleteDocumentation(EventDocumentation $documentation)
    {
        $documentation->delete();

        return response()->json([
            'success' => true,
            'message' => __('events.documentation_deleted_successfully')
        ]);
    }
}
