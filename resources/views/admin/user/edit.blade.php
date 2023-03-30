@extends('admin.layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>@lang('langs.users')</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('langs.user_edit_form')</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="{{route('user.update',$users->id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <div class="col-12">
                                    <label for="inputNanme4" class="form-label">@lang('langs.mandali_code')</label>
                                    <input type="text" name="mandali_code" value="{{$users->mandali_code}}"
                                           class="form-control @error('mandali_code') is-invalid @enderror"
                                           id="inputNanme4">
                                    @error('mandali_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.mandali_name')</label>
                                    <input type="text" name="mandali_name" value="{{$users->mandali_name}}"
                                           class="form-control @error('mandali_name') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('mandali_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.mandali_address')</label>
                                    <textarea type="text" name="mandali_address"
                                              class="form-control @error('mandali_address') is-invalid @enderror"
                                              id="inputEmail4">{{$users->mandali_address}}</textarea>
                                    @error('mandali_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.gst_number')</label>
                                    <input type="text" name="gst_num" value="{{$users->gst_num}}"
                                           class="form-control @error('gst_num') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('gst_num')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.registration_num')</label>
                                    <input type="text" name="reg_num" value="{{$users->reg_num}}"
                                           class="form-control @error('reg_num') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('reg_num')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.user_name')</label>
                                    <input type="text" name="user_name" value="{{$users->user_name}}"
                                           class="form-control @error('user_name') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('user_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.gender')</label>
                                    <br><label for="male">@lang('langs.male')</label>
                                    <input type="radio" id="html" name="gender"
                                           value="male" {{old('gender')=="male" ? 'checked='.'"checked"' : '' }} @if(isset($users)) {{ ($users->gender=="male")? "checked" : "" }} @endif>
                                    <label for="female">@lang('langs.female')</label>
                                    <input type="radio" id="css" name="gender"
                                           value="female" {{old('gender')=="female" ? 'checked='.'"checked"' : '' }} @if(isset($users)) {{ ($users->gender=="female")? "checked" : "" }} @endif>
                                    <br> <span style="color: red">{{$errors->first('gender')}}</span>

                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.mobile_number')</label>
                                    <input type="number" name="mobile" value="{{$users->mobile}}"
                                           class="form-control @error('mobile') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.profile_pic')</label>
                                    <input type="file" name="profile" value="{{old('profile')}}"
                                           class="form-control @error('profile') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('profile')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <img src="{{asset('storage/images/'.$users->profile)}}" width="50px">
                                </div>


                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.email')</label>
                                    <input type="email" name="email" value="{{$users->email}}"
                                           class="form-control @error('email') is-invalid @enderror" id="inputEmail4">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-info">@lang('langs.update')</button>
                                    <a href="{{route('customer.index')}}" type="reset"
                                       class="btn btn-outline-secondary">@lang('langs.back')</a>
                                    {{--                                    <button type="reset" class="btn btn-secondary">Back</button>--}}
                                </div>
                            </form><!-- Vertical Form -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->


@endsection
