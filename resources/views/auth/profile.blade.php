@extends('admin.layouts.app')

@section('content')
    <main id="main" class="main">
        @include('admin.flash-message')
        <div class="pagetitle">
            <h1>@lang('langs.profile')</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item">@lang('langs.users')</li>
                    <li class="breadcrumb-item active">@lang('langs.profile')</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        @php
            $user = \Illuminate\Support\Facades\Auth::user();
        @endphp
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @if($user->profile_pic == null)
                                <img src="{{asset('admin/assets/img/profile-img.jpg')}}" alt="Profile"
                                     class="rounded-circle">
                            @else
                                <img src="{{asset('storage/images/'.$user->profile_pic)}}" alt="Profile"
                                     class="rounded-circle">
                            @endif <h5>{{$user->customer_name}}</h5>
                            <h3>{{$user->user_name}}</h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">


                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#profile-edit">@lang('langs.edit_profile')</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#profile-change-password"
                                            id="password">@lang('langs.change_password')</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bank-details"
                                            id="bank_details">@lang('langs.bank_details')</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">


                                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="{{route('profile-update')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.profile_pic')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="pt-2">
                                                    <input type="file" name="profile_pic" class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <label for="fullName"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.mandali_code')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="mandali_code" value="{{$user->mandali_code}}"
                                                       class="form-control @error('mandali_code') is-invalid @enderror"
                                                       id="inputNanme4">
                                                @error('mandali_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <label for="fullName"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.mandali_name')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="mandali_name" value="{{$user->mandali_name}}"
                                                       class="form-control @error('mandali_name') is-invalid @enderror"
                                                       id="inputNanme4">
                                                @error('mandali_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.mandali_address')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea type="text" name="mandali_address"
                                                          class="form-control @error('mandali_address') is-invalid @enderror"
                                                          id="inputNanme4">{{$user->mandali_address}}</textarea>
                                                @error('mandali_address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.gst_number')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="gst_number" value="{{$user->gst_number}}"
                                                       class="form-control @error('customer_name') is-invalid @enderror"
                                                       id="inputNanme4">
                                                @error('gst_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.customer_name')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="customer_name" value="{{$user->customer_name}}"
                                                       class="form-control @error('customer_name') is-invalid @enderror"
                                                       id="inputNanme4">
                                                @error('customer_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="company"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.user_name')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="user_name" value="{{$user->user_name}}"
                                                       class="form-control @error('user_name') is-invalid @enderror"
                                                       id="inputEmail4">
                                                @error('user_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Job"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.email')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="email" name="email" value="{{$user->email}}"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       id="inputEmail4">
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Country"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.customer_code')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="customer_code" value="{{$user->customer_code}}"
                                                       class="form-control @error('customer_code') is-invalid @enderror"
                                                       id="inputEmail4">
                                                @error('customer_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.mobile_number')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="number" name="mobile_number"
                                                       value="{{$user->mobile_number}}"
                                                       class="form-control @error('mobile_number') is-invalid @enderror"
                                                       id="inputEmail4">
                                                @error('mobile_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.gender')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <label for="male">@lang('langs.male')</label>
                                                <input type="radio" id="html" name="gender"
                                                       value="male" {{old('gender')=="male" ? 'checked='.'"checked"' : '' }} @if(isset($user)) {{ ($user->gender=="male")? "checked" : "" }} @endif>
                                                <label for="female">@lang('langs.female')</label>
                                                <input type="radio" id="css" name="gender"
                                                       value="female" {{old('gender')=="female" ? 'checked='.'"checked"' : '' }} @if(isset($user)) {{ ($user->gender=="female")? "checked" : "" }} @endif>
                                                <br> <span style="color: red">{{$errors->first('gender')}}</span>
                                            </div>
                                        </div>


                                        <div class="text-center">
                                            <button type="submit"
                                                    class="btn btn-outline-primary">@lang('langs.update')</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>


                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="{{route('change-password')}}" method="post">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="currentPassword"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.password_old')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    name="current_password" type="password"
                                                    placeholder="Old Password">
                                                @error('current_password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.password_new')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input class="form-control @error('new_password') is-invalid @enderror"
                                                       name="new_password" type="password"
                                                       placeholder="New Password">

                                                @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword"
                                                   class="col-md-4 col-lg-3 col-form-label">@lang('langs.password_confirm')</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input
                                                    class="form-control @error('conform_password') is-invalid @enderror"
                                                    name="conform_password" type="password"
                                                    placeholder="Comfirm Password">

                                                @error('conform_password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit"
                                                    class="btn btn-outline-primary">@lang('langs.password_update')</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                                @php
                                    $banks = \App\Models\admin\Customers::where('user_id',$user->id)->first();
                                @endphp

                                <div class="tab-pane fade profile-edit pt-3" id="bank-details">

                                    <!-- Profile Edit Form -->
                                    @if(isset($banks))
                                        <form action="{{route('bank-update')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="fullName"
                                                       class="col-md-4 col-lg-3 col-form-label">@lang('langs.bank_name')</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" name="bank_name" value="{{$banks->bank_name}}"
                                                           class="form-control @error('bank_name') is-invalid @enderror"
                                                           id="inputEmail4">
                                                    @error('bank_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="Address"
                                                       class="col-md-4 col-lg-3 col-form-label">@lang('langs.account_number')</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="number" name="account_number"
                                                           value="{{$banks->account_number}}"
                                                           class="form-control @error('account_number') is-invalid @enderror"
                                                           id="inputEmail4">
                                                    @error('account_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Address"
                                                       class="col-md-4 col-lg-3 col-form-label">@lang('langs.ifsc_code')</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" name="ifsc_code" value="{{$banks->ifsc_code}}"
                                                           class="form-control @error('ifsc_code') is-invalid @enderror"
                                                           id="inputEmail4">
                                                    @error('ifsc_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="Address"
                                                       class="col-md-4 col-lg-3 col-form-label">@lang('langs.final_amount')</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="number" name="final_amount"
                                                           value="{{$banks->final_amount}}"
                                                           class="form-control @error('final_amount') is-invalid @enderror"
                                                           id="inputEmail4">
                                                    @error('final_amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit"
                                                        class="btn btn-outline-primary">@lang('langs.update')</button>
                                            </div>
                                        </form><!-- End Profile Edit Form -->
                                    @else
                                        <center><img src="{{asset('admin/assets/img/data_not_found.svg')}}" class="mb-2"
                                                     height="200px"></center>
                                        <h4 class="text-center ml-5 font-weight-bold"><b>Data Not Found</b></h4>
                                    @endif
                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
@push('page_scripts')
    @php
        $doc = request('document');
        $bank = request('bank_details');
    @endphp

    <script>
        $(document).ready(function () {
            var password = '<?php echo $doc; ?>';
            if (password == 'password') {
                $('#password').trigger('click');
            }
        });

        $(document).ready(function () {
            var bank_details = '<?php echo $bank; ?>';
            if (bank_details == 'bank_details') {
                $('#bank_details').trigger('click');
            }
        });
    </script>
@endpush
