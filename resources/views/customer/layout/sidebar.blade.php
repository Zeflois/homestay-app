<div class="main-sidebar">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('customer_home') }}">Admin Panel</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ route('customer_home') }}"></a>
                </div>

                <ul class="sidebar-menu">     

                            <li class="{{ Request::is('customer/home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('customer_home') }}"><i class="fa fa-hand-o-right"></i> Dashboard</span></a></li>

                </ul>
            </aside>
        </div>