<div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
        <ul class="vertical-nav-menu">
            <li class="app-sidebar__heading">Dashboards</li>
            <li>
                <a href="/admin/admin-users" class="
                {{ request()->segment(2) == 'admin-users' ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-monitor"></i>
                    Admin Users
                </a>
            </li>
            <li>
                <a href="/admin/users" class="
                {{ request()->segment(2) == 'users' ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-users"></i>
                    Users
                </a>
            </li>
            <li>
                <a href="/admin/wallets" class="
                {{ request()->segment(2) == 'wallets' ? 'mm-active' : '' }}">
                    <i class="metismenu-icon pe-7s-wallet"></i>
                    Wallets
                </a>
            </li>
        </ul>
    </div>
</div>
