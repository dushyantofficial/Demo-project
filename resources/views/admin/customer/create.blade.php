@extends('admin.layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>@lang('langs.customer')</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('langs.customer_form')</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="{{route('customer.store')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="col-12">
                                    <label for="inputNanme4" class="form-label">@lang('langs.user_name')</label>

                                    <select class="form-control  select2 @error('user_id') is-invalid @enderror"
                                            name="user_id"
                                            id="users">
                                        <option value="">---@lang('langs.select_user_name')---</option>
                                        @foreach($users as $user)
                                            <option
                                                value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{$user->user_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.customer_name')</label>
                                    <input type="text" name="customer_name" value="{{old('customer_name')}}"
                                           class="form-control @error('customer_name') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.customer_code')</label>
                                    <input type="text" name="customer_code" value="{{old('customer_code')}}"
                                           class="form-control @error('customer_code') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('customer_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.bank_name')</label>
                                    <input type="text" name="bank_name" value="{{old('bank_name')}}"
                                           class="form-control @error('bank_name') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('bank_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.account_number')</label>
                                    <input type="number" name="account_number" value="{{old('account_number')}}"
                                           class="form-control @error('account_number') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.ifsc_code')</label>
                                    <input type="text" name="ifsc_code" value="{{old('ifsc_code')}}"
                                           class="form-control @error('ifsc_code') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('ifsc_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.final_amount')</label>
                                    <input type="number" name="final_amount" value="{{old('final_amount')}}"
                                           class="form-control @error('final_amount') is-invalid @enderror"
                                           id="inputEmail4">
                                    @error('final_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-primary">@lang('langs.save')</button>
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
@push('page_scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

    </script>
@endpush
