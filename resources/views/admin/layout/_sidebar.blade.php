<div class="page-sidebar">

    <ul class="x-navigation">
        <li class="" style="background: #9e9e9e; text-align: center;">
            <a style="font-size: 22px;" href="{{ url('admin/dashboard') }}"><b>Food App</b></a>
            <a href="#" class="x-navigation-control"></a>
        </li>

        <li class="@if ( Request::segment(2)== 'dashboard') active @endif">
            <a href="{{ url('admin/dashboard') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
        </li>

        @if(Auth::user()->is_admin == '1')
        <li class="@if ( Request::segment(2)== 'restaurant') active @endif">
            <a href="{{ url('admin/restaurant') }}"><span class="fa fa-cutlery"></span> <span class="xn-text">Restaurant</span></a>
        </li>
        @endif

        <li class="@if ( Request::segment(2)== 'customer') active @endif">
            <a href="{{ url('admin/customer') }}"><span class="fa fa-user"></span> <span class="xn-text">Customer</span></a>
        </li>
        @if(Auth::user()->is_age == '1')
                <li class="@if ( Request::segment(2)== 'ageid') active @endif">
                    <a href="{{ url('admin/ageid') }}"><span class="fa fa-user"></span> <span class="xn-text">Age 18 + ID</span></a>
                </li>
        @endif

        <li class="@if ( Request::segment(2)== 'category') active @endif">
            <a href="{{ url('admin/category') }}"><span class="fa fa-list-alt"></span> <span class="xn-text">Category</span></a>
        </li>

        @if(Auth::user()->is_admin == '1')
        <li class="@if ( Request::segment(2)== 'category_option') active @endif">
            <a href="{{ url('admin/category_option') }}"><span class="fa fa-list-alt"></span> <span class="xn-text">Category Option</span></a>
        </li>

        <li class="@if ( Request::segment(2)== 'support') active @endif">
            <a href="{{ url('admin/support') }}"><span class="fa fa-support"></span> <span class="xn-text">Support</span></a>
        </li>

        @endif

         <li class="@if ( Request::segment(2)== 'item') active @endif">
            <a href="{{ url('admin/item') }}"><span class="fa fa-list-alt"></span> <span class="xn-text">Item</span></a>
        </li>

        <li class="@if ( Request::segment(2) == 'orders' ) active @endif">
            <a href="{{ url('admin/orders') }}"><span class="fa fa-shopping-cart"></span>
                <span class="xn-text">Orders</span></a>
        </li>
        <li class="@if ( Request::segment(2) == 'review' ) active @endif">
            <a href="{{ url('admin/review') }}"><span class="fa fa-star"></span><span class="xn-text">Review</span></a>
        </li>

         @if(Auth::user()->is_admin == '2')
         <li class="@if ( Request::segment(2)== 'payment') active @endif">
            <a href="{{ url('admin/payment') }}"><span class="fa fa-money"></span> <span class="xn-text">Payment</span></a>
        </li>
        @endif



        <li class="@if ( Request::segment(2)== 'myaccount') active @endif">
            <a href="{{ url('admin/myaccount') }}"><span class="fa fa-cog"></span> <span class="xn-text">My Account</span></a>
        </li>

       <li class="@if ( Request::segment(2)== 'schedule') active @endif">
            <a href="{{ url('admin/schedule') }}"><span class="fa fa-calendar"></span> <span class="xn-text">Schedule</span></a>
        </li>

        <li class="@if ( Request::segment(2)== 'notification') active @endif">
            <a href="{{ url('admin/notification') }}"><span class="fa fa-bell"></span> <span class="xn-text">Notification</span></a>
        </li>

       <li class="@if ( Request::segment(2) =='discountcode' ) active @endif">
            <a href="{{ url( 'admin/discountcode' ) }}"><span class="fa fa-info-circle"></span><span class="xn-text">Discount Code</span></a>
        </li>
       
       
       
        @if(Auth::user()->is_admin == '1')
        <li class="@if ( Request::segment(2) == 'package' ) active @endif">
            <a href="{{ url( 'admin/package' ) }}"><span class="fa fa-gift"></span><span class="xn-text">Package</span></a>
        </li>

       <li class="@if ( Request::segment(2) =='page' ) active @endif">
            <a href="{{ url( 'admin/page' ) }}"><span class="fa fa-info-circle"></span><span class="xn-text">Page</span></a>
        </li>


        <li class="@if ( Request::segment(2)== 'setting') active @endif">
            <a href="{{ url('admin/setting') }}"><span class="fa fa-cog"></span> <span class="xn-text">Setting</span></a>
        </li>



        @endif
        
     
     


     



    </ul>
</div>