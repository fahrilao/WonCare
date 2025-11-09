<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the member dashboard
     */
    public function index()
    {
        $member = Auth::guard('member')->user();

        return view('member.dashboard', compact('member'));
    }
}
