<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('home*') ? 'active' : 'collapsed' }}" href="{{route('home')}}">
                <i class="bi bi-grid"></i>
                <span>@lang('langs.dashboard')</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('user*') ? 'active' : 'collapsed' }}" href="{{route('user.index')}}">
                <i class="bi bi-people"></i>
                <span>@lang('langs.users')</span>
            </a>
        </li><!-- End Users Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('customer*') ? 'active' : 'collapsed' }}"
               href="{{route('customer.index')}}">
                <i class="bi bi-bank bi bi-people"></i>
                <span>@lang('langs.customer')</span>
            </a>
        </li><!-- End Customer Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('item_name*') ? 'active' : 'collapsed' }}"
               href="{{route('item_name.index')}}">
                <i class="bi bi-inbox"></i>
                <span>@lang('langs.item_name')</span>
            </a>
        </li><!-- End Item Name Nav -->


        <li class="nav-item">
            <a class="nav-link {{ Request::is('item_sales*') ? 'active' : 'collapsed' }}"
               href="{{route('item_sales.index')}}">
                <i class="bi bi-safe"></i>
                <span>@lang('langs.item_sales')</span>
            </a>
        </li><!-- End Item Sales Nav -->


        <li class="nav-item">
            <a class="nav-link {{ Request::is('item_purchase*') ? 'active' : 'collapsed' }}"
               href="{{route('item_purchase.index')}}">
                <i class="bi bi-dropbox"></i>
                <span>@lang('langs.item_purchase')</span>
            </a>
        </li><!-- End Item Purchase Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::is('profile*') ? 'active' : 'collapsed' }}" href="{{route('profile')}}">
                <i class="bi bi-person"></i>
                <span>@lang('langs.profile')</span>
            </a>
        </li><!-- End Profile Page Nav -->


        {{--Report Section--}}
        <li class="nav-item ">
            <a class="nav-link collapsed @if(Request::is('*customer_report*') ||  Request::is('*item_name_report*') ||  Request::is('*item_sales_report*') ||  Request::is('*item_purchase_report*')) active @endif "
               data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-bill-line"></i><span>@lang('langs.report')</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav"
                class="nav-content collapse @if(Request::is('*customer_report*') ||  Request::is('*item_name_report*') ||  Request::is('*item_sales_report*') ||  Request::is('*item_purchase_report*')) active show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('customer-report-show')}}"
                       class="{{ Request::is('customer_report*') ? 'active' : '' }} ">
                        <i class="bi bi-circle"></i><span>@lang('langs.customer_report')</span>
                    </a>
                </li>


                <li>
                    <a href="{{route('item-name-report-show')}}"
                       class="{{ Request::is('item_name_report*') ? 'active' : '' }} ">
                        <i class="bi bi-circle"></i><span>@lang('langs.item_name_report')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('item-sales-report-show')}}"
                       class="{{ Request::is('item_sales_report*') ? 'active' : '' }} ">
                        <i class="bi bi-circle"></i><span>@lang('langs.item_sales_report')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('item-purchase-report-show')}}"
                       class="{{ Request::is('item_purchase_report*') ? 'active' : '' }} ">
                        <i class="bi bi-circle"></i><span>@lang('langs.item_purchase_report')</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- End Report Section -->


        {{--Payment Report Section--}}


        <li class="nav-item">
            <a class="nav-link collapsed @if(Request::is('*payment_register_report*') ||  Request::is('*payment_deduct_report*')) active @endif" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>@lang('langs.payment_report')</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse @if(Request::is('*payment_register_report*') ||  Request::is('*payment_deduct_report*')) active show @endif" data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{route('payment-register-report')}}"
                       class="{{ Request::is('payment_register_report*') ? 'active' : '' }} ">
                        <i class="bi bi-circle"></i><span>@lang('langs.payment_register_report')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('payment-deduct-report')}}"
                       class="{{ Request::is('payment_deduct_report*') ? 'active' : '' }} ">
                        <i class="bi bi-circle"></i><span>@lang('langs.payment_deduct_report')</span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- End Payment Report Section -->


    </ul>

</aside><!-- End Sidebar-->

