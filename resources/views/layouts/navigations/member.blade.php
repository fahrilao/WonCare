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
                                <li class="menu-item">
                                    <a href="#" class="menu-link">
                                        <i class="menu-icon icon-base ti tabler-heart"></i>
                                        <div>{{ __('navigation.donate') }}</div>
                                    </a>
                                </li>