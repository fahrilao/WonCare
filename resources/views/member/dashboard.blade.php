@extends('layouts.member')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Card -->
    <div class="card bg-primary text-white mb-5">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-lg me-4">
                    <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="rounded-circle">
                </div>
                <div>
                    <h4 class="text-white mb-1">
                        {{ __('members.welcome_back_name', ['name' => $member->name]) }}</h4>
                    <p class="text-white-50 mb-0">{{ __('members.dashboard_subtitle') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Profile Info Cards -->
        <div class="col-md-6 col-lg-3 mb-6">
            <div class="card h-100">
                <div class="card-body d-flex">
                    <div>
                        <h6 class="mb-1">{{ __('dashboard.course_completed') }}</h6>
                        <h4 class="text-muted mb-0">8</h4>
                        <small class="text-success fw-bold">
                            2 {{ __('common.this_week') }}
                        </small>
                    </div>
                    <div class="avatar avatar-md mb-3 ms-auto">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="ti tabler-device-desktop icon-xl"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-6">
            <div class="card h-100">
                <div class="card-body d-flex">
                    <div>
                        <h6 class="mb-1">{{ __('dashboard.total_invested') }}</h6>
                        <h4 class="text-muted mb-0">Rp. 100.000,-</h4>
                    </div>
                    <div class="avatar avatar-md mb-3 ms-auto">
                        <span class="avatar-initial rounded-circle bg-label-info">
                            <i class="ti tabler-cash-banknote icon-xl"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-6">
            <div class="card h-100">
                <div class="card-body d-flex">
                    <div>
                        <h6 class="mb-1">{{ __('dashboard.total_points') }}</h6>
                        <h4 class="text-muted mb-0">100pts</h4>
                        <small class="text-success fw-bold">
                            <i class="ti tabler-arrow-up"></i> 50% {{ __('common.this_week') }}
                        </small>
                    </div>
                    <div class="avatar avatar-md mb-3 ms-auto">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="ti tabler-currency-cent icon-xl"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-6">
            <div class="card h-100">
                <div class="card-body d-flex">
                    <div>
                        <h6 class="mb-1">{{ __('dashboard.donations_made') }}</h6>
                        <h4 class="text-muted mb-0">800 T</h4>
                        <small class="text-success fw-bold">
                            {{ __('common.from_donation', [5]) }}
                        </small>
                    </div>
                    <div class="avatar avatar-md mb-3 ms-auto">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="ti tabler-tip-jar icon-xl"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Quick Action --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('dashboard.quick_actions') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <a href="#" class="col-12 col-md-6 mb-5">
                            <div class="card shadow-none bg-primary text-white">
                                <div class="card-body">
                                    <span class="ti tabler-book icon-22px"></span>
                                    <h6 class="mb-0 text-white mt-2">{{ __('navigation.e-course') }}</h6>
                                    <small class="text-muted mb-0">{{ __('dashboard.quick_actions_e_course') }}</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="col-12 col-md-6 mb-5">
                            <div class="card shadow-none border-danger border border-box">
                                <div class="card-body">
                                    <span class="ti tabler-heart-filled text-danger icon-22px"></span>
                                    <h6 class="mb-0 mt-2">{{ __('navigation.donate') }}</h6>
                                    <small class="text-muted mb-0">{{ __('dashboard.quick_actions_donate') }}</small>
                                </div>
                            </div>
                        </a>
                        {{-- <div class="col-12 col-md-6 mb-5">
                            <div class="card shadow-none border">
                                <div class="card-body">
                                    <span class="ti tabler-book icon-22px"></span>
                                    <h6 class="mb-0 mt-2">{{ __('navigation.e-course') }}</h6>
                                    <small class="text-muted mb-0">{{ __('dashboard.quick_actions_e_course') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-5">
                            <div class="card shadow-none border">
                                <div class="card-body">
                                    <span class="ti tabler-book icon-22px"></span>
                                    <h6 class="mb-0 mt-2">{{ __('navigation.e-course') }}</h6>
                                    <small class="text-muted mb-0">{{ __('dashboard.quick_actions_e_course') }}</small>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    {{-- E-Course List --}}
    <div class="mb-5">
        <div class="mb-4">
            <h4 class="font-weight-bold mb-0">{{ __('dashboard.continue_your_learning') }}</h4>
        </div>

        <!-- Horizontal Scrollable Course Cards -->
        <div class="d-flex overflow-auto pb-3" style="gap: 1rem;">
            <!-- Course Card 1 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-success text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <h5 class="text-white mb-1 mt-5">Personal Finance Mastery</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-clock me-2"></i>
                            <span>6 {{ __('common.hours') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Learn essential strategies for managing your money, budgeting effectively, and building wealth.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Progress</span>
                            <span class="fw-bold">65%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button class="btn btn-primary w-100">
                        <i class="ti tabler-book me-2"></i>{{ __('dashboard.continue_learning') }}
                    </button>
                </div>
            </div>

            <!-- Course Card 2 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-info text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                        <h5 class="text-white mb-1 mt-5">Investment Fundamentals</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-clock me-2"></i>
                            <span>8 hours</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Understand the basics of investing, portfolio diversification, and long-term wealth building.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Progress</span>
                            <span class="fw-bold">35%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button class="btn btn-primary w-100">
                        <i class="ti tabler-book me-2"></i>{{ __('dashboard.continue_learning') }}
                    </button>
                </div>
            </div>

            <!-- Course Card 3 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-warning text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);">
                        <h5 class="text-white mb-1 mt-5">Smart Donation Strategies</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-clock me-2"></i>
                            <span>4 hours</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Maximize your impact through strategic giving and understand tax benefits of charitable donations.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Progress</span>
                            <span class="fw-bold">80%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button class="btn btn-primary w-100">
                        <i class="ti tabler-book me-2"></i>{{ __('dashboard.continue_learning') }}
                    </button>
                </div>
            </div>

            <!-- Course Card 4 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-secondary text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                        <h5 class="text-white mb-1 mt-5">Financial Planning Basics</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-clock me-2"></i>
                            <span>5 hours</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Create comprehensive financial plans, set goals, and track your progress toward financial freedom.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Progress</span>
                            <span class="fw-bold">0%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Start Button -->
                    <button class="btn btn-outline-primary w-100">
                        <i class="ti tabler-play me-2"></i>Start Learning
                    </button>
                </div>
            </div>

            <!-- More Card -->
            <div class="card shrink-0 border-dashed" style="min-width: 300px; max-width: 300px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center"
                    style="min-height: 400px;">
                    <div class="avatar avatar-lg mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="ti tabler-plus icon-xl"></i>
                        </span>
                    </div>
                    <h5 class="mb-2">More Courses</h5>
                    <p class="text-muted mb-3">
                        Explore all available courses and continue your learning journey
                    </p>
                    <button class="btn btn-outline-primary">
                        <i class="ti tabler-arrow-right me-2"></i>View All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <br>
    {{-- Donation Section --}}
    <div class="mb-5">
        <div class="mb-4">
            <h4 class="font-weight-bold mb-0">{{ __('dashboard.charity') }}</h4>
        </div>

        <!-- Horizontal Scrollable Donation Cards -->
        <div class="d-flex overflow-auto pb-3" style="gap: 1rem;">
            <!-- Donation Card 1 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-success text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <h5 class="text-white mb-1 mt-5">Education for All</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-users me-2"></i>
                            <span>Help 1,000 children</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Support quality education access for underprivileged children and help them build a brighter future.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Goal Progress</span>
                            <span class="fw-bold">75%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Rp 750,000 of Rp 1,000,000 raised</small>
                    </div>

                    <!-- Donate Button -->
                    <button class="btn btn-success w-100">
                        <i class="ti tabler-heart me-2"></i>{{ __('dashboard.donate_now') }}
                    </button>
                </div>
            </div>

            <!-- Donation Card 2 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-info text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);">
                        <h5 class="text-white mb-1 mt-5">Clean Water Initiative</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-droplet me-2"></i>
                            <span>50 communities</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Provide clean and safe drinking water access to remote communities in need.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Goal Progress</span>
                            <span class="fw-bold">45%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Rp 2,250,000 of Rp 5,000,000 raised</small>
                    </div>

                    <!-- Donate Button -->
                    <button class="btn btn-info w-100">
                        <i class="ti tabler-heart me-2"></i>{{ __('dashboard.donate_now') }}
                    </button>
                </div>
            </div>

            <!-- Donation Card 3 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-warning text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);">
                        <h5 class="text-white mb-1 mt-5">Healthcare Support</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-medical-cross me-2"></i>
                            <span>Medical aid for families</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Provide essential healthcare services and medical supplies to families in crisis.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Goal Progress</span>
                            <span class="fw-bold">90%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"
                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Rp 2,700,000 of Rp 3,000,000 raised</small>
                    </div>

                    <!-- Donate Button -->
                    <button class="btn btn-warning w-100">
                        <i class="ti tabler-heart me-2"></i>{{ __('dashboard.donate_now') }}
                    </button>
                </div>
            </div>

            <!-- Donation Card 4 -->
            <div class="card shrink-0" style="min-width: 300px; max-width: 300px;">
                <div class="card-header p-0">
                    <div class="bg-gradient-danger text-white px-4 rounded-top d-flex justify-content-end flex-column pb-3"
                        style="min-height: 150px; background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);">
                        <h5 class="text-white mb-1 mt-5">Emergency Relief Fund</h5>
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-urgent me-2"></i>
                            <span>Disaster response</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3 mt-3" style="font-size: 0.9rem;">
                        Rapid response fund for natural disasters and emergency situations affecting communities.
                    </p>

                    <!-- Progress Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Goal Progress</span>
                            <span class="fw-bold">25%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Rp 1,250,000 of Rp 5,000,000 raised</small>
                    </div>

                    <!-- Donate Button -->
                    <button class="btn btn-danger w-100">
                        <i class="ti tabler-heart me-2"></i>{{ __('dashboard.donate_now') }}
                    </button>
                </div>
            </div>

            <!-- More Donations Card -->
            <div class="card shrink-0 border-dashed" style="min-width: 300px; max-width: 300px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center"
                    style="min-height: 400px;">
                    <div class="avatar avatar-lg mb-3">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="ti tabler-plus icon-xl"></i>
                        </span>
                    </div>
                    <h5 class="mb-2">More Causes</h5>
                    <p class="text-muted mb-3">
                        Discover more ways to make a positive impact in communities
                    </p>
                    <button class="btn btn-outline-success">
                        <i class="ti tabler-arrow-right me-2"></i>View All
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
