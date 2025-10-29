                    <li class="menu-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                        <a href="{{ route('admin.home') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-smart-home"></i>
                            <div data-i18n="Home">{{ __('navigation.home') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-users"></i>
                            <div data-i18n="Home">{{ __('navigation.users') }}</div>
                        </a>
                    </li>
