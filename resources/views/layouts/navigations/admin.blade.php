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

                    <!-- Donation Section -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __('navigation.donation') }}</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.donation-campaigns.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.donation-campaigns.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-heart-handshake"></i>
                            <div data-i18n="Donation Campaigns">{{ __('navigation.donation_campaigns') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.donation-tags.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.donation-tags.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-tags"></i>
                            <div data-i18n="Donation Tags">{{ __('navigation.donation_tags') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.donation-reports.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.donation-reports.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-file-report"></i>
                            <div data-i18n="Donation Reports">{{ __('navigation.donation_reports') }}</div>
                        </a>
                    </li>

                    <!-- Community & Volunteer Section -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __('community.section') }}</span>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('admin.community.whatsapp-groups.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.community.whatsapp-groups.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-brand-whatsapp"></i>
                            <div data-i18n="WhatsApp Groups">{{ __('community.whatsapp_groups.title') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.community.posts.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.community.posts.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-message-circle"></i>
                            <div data-i18n="Community Posts">{{ __('community.posts.title') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('admin.community.volunteer-registrations.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.community.volunteer-registrations.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-user-plus"></i>
                            <div data-i18n="Volunteer Registrations">
                                {{ __('community.volunteer_registrations.title') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('admin.community.volunteer-events.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.community.volunteer-events.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-calendar-event"></i>
                            <div data-i18n="Volunteer Events">{{ __('community.volunteer_events.title') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.community.mentors.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.community.mentors.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-user-star"></i>
                            <div data-i18n="Mentors">{{ __('community.mentors.title') }}</div>
                        </a>
                    </li>

                    <!-- Event & Activities Section -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __('events.title') }}</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.events.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-calendar-event"></i>
                            <div data-i18n="Events">{{ __('events.subtitle') }}</div>
                        </a>
                    </li>

                    <!-- Settings Section -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __('navigation.settings') }}</span>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.payment-gateways.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.payment-gateways.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-credit-card"></i>
                            <div data-i18n="Payment Gateways">{{ __('navigation.payment_gateways') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.zakat-settings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.zakat-settings.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-calculator"></i>
                            <div data-i18n="Zakat Settings">{{ __('zakat.settings') }}</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.currency-settings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.currency-settings.index') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-currency"></i>
                            <div data-i18n="Currency Settings">Currency Settings</div>
                        </a>
                    </li>
