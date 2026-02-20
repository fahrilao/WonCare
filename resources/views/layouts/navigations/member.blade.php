 <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
     <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
         <i class="icon-base ti tabler-smart-home me-2"></i>
         <span>{{ __('navigation.home') }}</span>
     </a>
 </li>
 <li class="nav-item {{ request()->routeIs('member.courses.*') ? 'active' : '' }}">
     <a href="{{ route('member.courses.index') }}"
         class="nav-link {{ request()->routeIs('member.courses.*') ? 'active' : '' }}">
         <i class="icon-base ti tabler-book me-2"></i>
         <span>{{ __('ecourse.course_catalog') }}</span>
     </a>
 </li>
 <li class="nav-item {{ request()->routeIs('member.donate.index') ? 'active' : '' }}">
     <a href="{{ route('member.donate.index') }}"
         class="nav-link {{ request()->routeIs('member.donate.index') ? 'active' : '' }}">
         <i class="icon-base ti tabler-heart me-2"></i>
         <span>{{ __('navigation.donate') }}</span>
     </a>
 </li>
 <li class="nav-item {{ request()->routeIs('member.zakat.*') ? 'active' : '' }}">
     <a href="{{ route('member.zakat.calculator') }}"
         class="nav-link {{ request()->routeIs('member.zakat.*') ? 'active' : '' }}">
         <i class="icon-base ti tabler-calculator me-2"></i>
         <span>{{ __('navigation.zakat_calculator') }}</span>
     </a>
 </li>
 <li class="nav-item {{ request()->routeIs('member.financial-tools.*') ? 'active' : '' }}">
     <a href="{{ route('member.financial-tools.index') }}"
         class="nav-link {{ request()->routeIs('member.financial-tools.*') ? 'active' : '' }}">
         <i class="icon-base ti tabler-wallet me-2"></i>
         <span>{{ __('financial.title') }}</span>
     </a>
 </li>
 <li class="nav-item {{ request()->routeIs('member.community.*') ? 'active' : '' }}">
     <a href="{{ route('member.community.index') }}"
         class="nav-link {{ request()->routeIs('member.community.*') ? 'active' : '' }}">
         <i class="icon-base ti tabler-users me-2"></i>
         <span>{{ __('community.title') }}</span>
     </a>
 </li>
 <li class="nav-item {{ request()->routeIs('member.donate.history') ? 'active' : '' }}">
     <a href="{{ route('member.donate.history') }}"
         class="nav-link {{ request()->routeIs('member.donate.history') ? 'active' : '' }}">
         <i class="icon-base ti tabler-history me-2"></i>
         <span>{{ __('navigation.donation_history') }}</span>
     </a>
 </li>
