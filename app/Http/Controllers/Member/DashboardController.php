<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    /**
     * Show the member dashboard
     */
    public function index()
    {
        $member = Auth::guard('member')->user();

        $continueCourses = Enrollment::with(['class.modules.lessons'])
            ->forMember($member->id)
            ->active()
            ->latest('enrolled_at')
            ->take(3)
            ->get();

        return view('member.dashboard', compact('member', 'continueCourses'));
    }
}
