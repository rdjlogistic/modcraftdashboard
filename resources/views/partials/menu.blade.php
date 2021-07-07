<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            
            <li class="nav-item">
                <a href="{{ route("admin.apps.index") }}" class="nav-link {{ request()->is('admin/apps') || request()->is('admin/apps/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-cogs nav-icon">

                    </i>
                    {{ trans('cruds.app.title') }}
                </a>
            </li>
          
            <li class="nav-item">
                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-user nav-icon">

                    </i>
                    {{ trans('cruds.user.title') }}
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>