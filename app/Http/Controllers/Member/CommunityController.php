<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityWhatsappGroup;
use App\Models\VolunteerRegistration;
use App\Models\VolunteerEvent;
use App\Models\MentorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:member');
  }

  /**
   * Display community feed
   */
  public function index(Request $request)
  {
    $query = CommunityPost::where('status', 'published')
      ->whereNotNull('published_at')
      ->where('published_at', '<=', now())
      ->orderBy('is_pinned', 'desc')
      ->orderBy('published_at', 'desc');

    // Search functionality
    if ($request->has('search') && $request->search) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('title', 'like', "%{$search}%")
          ->orWhere('content', 'like', "%{$search}%")
          ->orWhere('author_name', 'like', "%{$search}%");
      });
    }

    $posts = $query->paginate(10);
    $pinnedPosts = CommunityPost::where('status', 'published')
      ->where('is_pinned', true)
      ->whereNotNull('published_at')
      ->where('published_at', '<=', now())
      ->orderBy('published_at', 'desc')
      ->take(3)
      ->get();

    return view('member.community.index', compact('posts', 'pinnedPosts'));
  }

  /**
   * Display single post
   */
  public function show(CommunityPost $post)
  {
    // Check if post is published
    if ($post->status !== 'published' || !$post->published_at || $post->published_at > now()) {
      abort(404);
    }

    // Get related posts
    $relatedPosts = CommunityPost::where('status', 'published')
      ->where('id', '!=', $post->id)
      ->whereNotNull('published_at')
      ->where('published_at', '<=', now())
      ->orderBy('published_at', 'desc')
      ->take(3)
      ->get();

    return view('member.community.show', compact('post', 'relatedPosts'));
  }

  /**
   * Get posts via AJAX for infinite scroll
   */
  public function getPosts(Request $request)
  {
    $page = $request->get('page', 1);

    $posts = CommunityPost::where('status', 'published')
      ->whereNotNull('published_at')
      ->where('published_at', '<=', now())
      ->orderBy('is_pinned', 'desc')
      ->orderBy('published_at', 'desc')
      ->paginate(10, ['*'], 'page', $page);

    return response()->json([
      'posts' => $posts->items(),
      'has_more' => $posts->hasMorePages(),
      'next_page' => $posts->currentPage() + 1,
    ]);
  }

  /**
   * Display WhatsApp Groups by region
   */
  public function whatsappGroups()
  {
    $groups = CommunityWhatsappGroup::where('is_active', true)
      ->orderBy('sort_order')
      ->orderBy('region')
      ->get()
      ->groupBy('region');

    return view('member.community.whatsapp-groups', compact('groups'));
  }

  /**
   * Display volunteer registration form
   */
  public function volunteerRegister()
  {
    return view('member.community.volunteer-register');
  }

  /**
   * Store volunteer registration
   */
  public function storeVolunteerRegistration(Request $request)
  {
    $validated = $request->validate([
      'full_name' => 'required|string|max:255',
      'phone' => 'required|string|max:20',
      'email' => 'required|email|max:255',
      'region' => 'required|string|max:255',
      'type' => 'required|in:digital,offline,both',
      'skills' => 'nullable|string',
      'availability' => 'nullable|string',
      'notes' => 'nullable|string',
    ]);

    $validated['status'] = 'pending';

    VolunteerRegistration::create($validated);

    return redirect()->route('member.community.volunteer-events')
      ->with('success', __('community.volunteer.registration_success'));
  }

  /**
   * Display volunteer events
   */
  public function volunteerEvents()
  {
    $upcomingEvents = VolunteerEvent::where('is_active', true)
      ->where('start_at', '>', now())
      ->orderBy('start_at')
      ->get();

    $pastEvents = VolunteerEvent::where('is_active', true)
      ->where('start_at', '<=', now())
      ->orderBy('start_at', 'desc')
      ->take(5)
      ->get();

    return view('member.community.volunteer-events', compact('upcomingEvents', 'pastEvents'));
  }

  /**
   * Display mentor profiles
   */
  public function mentors()
  {
    $mentors = MentorProfile::where('is_active', true)
      ->orderBy('sort_order')
      ->orderBy('name')
      ->get();

    return view('member.community.mentors', compact('mentors'));
  }
}
