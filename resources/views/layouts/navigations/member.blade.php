                                <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard') }}" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-smart-home"></i>
                                        <div>{{ __('navigation.home') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('member.courses.*') ? 'active' : '' }}">
                                    <a href="{{ route('member.courses.index') }}" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-book"></i>
                                        <div>{{ __('ecourse.course_catalog') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('member.donate.index') ? 'active' : '' }}">
                                    <a href="{{ route('member.donate.index') }}" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-heart"></i>
                                        <div>{{ __('navigation.donate') }}</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('member.zakat.*') ? 'active' : '' }}">
                                    <a href="{{ route('member.zakat.calculator') }}" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-calculator"></i>
                                        <div>{{ __('navigation.zakat_calculator') }}</div>
                                    </a>
                                </li>
                                <li
                                    class="menu-item {{ request()->routeIs('member.donate.history') ? 'active' : '' }}">
                                    <a href="{{ route('member.donate.history') }}" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-history"></i>
                                        <div>{{ __('navigation.donation_history') }}</div>
                                    </a>
                                </li>
