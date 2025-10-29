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

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __('navigation.e-course') }}</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-category"></i>
                            <div data-i18n="Categories">{{ __('navigation.categories') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.classes.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-school"></i>
                            <div data-i18n="Classes">{{ __('navigation.classes') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.modules.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-components"></i>
                            <div data-i18n="Modules">{{ __('navigation.modules') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.lessons.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-book"></i>
                            <div data-i18n="Lessons">{{ __('navigation.lessons') }}</div>
                        </a>
                    </li>
