<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{route('home')}}" class="logo d-flex align-items-center">
            <img src="{{asset('admin/assets/img/logo.png')}}" alt="">
{{--                        <span class="d-none d-lg-block">@lang('langs.dairy_report')</span>--}}
            <span class="d-none d-lg-block">Demo-Project</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">


            <li class="nav-item dropdown">
                <a href="{{route('english')}}">
                    <button class="btn btn-outline-danger">English</button>
                </a>&nbsp;
                <a href="{{route('gujarati')}}">
                    <button class="btn btn-outline-info">ગુજરાતી</button>
                </a>

                <a href="{{url('clear_cache')}}" class="btn btn-outline-success">
                    Cache Clear
                </a><!-- End Notification Icon -->
            </li><!-- End Notification Nav -->&nbsp;

            @php
                $user = \Illuminate\Support\Facades\Auth::user();
            @endphp
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if($user->profile_pic == null)
                        <img src="{{asset('admin/assets/img/profile-img.jpg')}}" alt="Profile"
                             class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{$user->user_name}}</span>
                    @else
                        <img src="{{asset('storage/images/'.$user->profile_pic)}}" alt="Profile" class="rounded-circle">
                        {{--                    <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">--}}
                        <span class="d-none d-md-block dropdown-toggle ps-2"> @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj'){{translateToGujarati($user->user_name)}} @else {{$user->user_name}} @endif</span>
                    @endif
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('profile')}}">
                            <i class="bi bi-person"></i>
                            <span>@lang('langs.my_profile')</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                           href="{{route('profile')}}?document=password">
                            <i class="bi bi-key"></i>
                            <span>@lang('langs.change_password')</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                           href="{{route('profile')}}?bank_details=bank_details">
                            <i class="bi bi-bank"></i>
                            <span>@lang('langs.bank_details')</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>@lang('langs.user_logout')</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
