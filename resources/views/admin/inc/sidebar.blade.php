<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <a href="{{route('admin.dashboard')}}" class="logo-text">Dashboard</a>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Sales</div>
            </a>
            <ul>
                <li> <a href="{{ route('sales.index') }}"><i class="bx bx-right-arrow-alt"></i>All Sales</a>
                </li>
                <li> <a href="{{route('sales.create')}}"><i class="bx bx-right-arrow-alt"></i>Add Sale</a>
                </li>
            </ul>
        </li>
       

        
    </ul>
    <!--end navigation-->
</div>