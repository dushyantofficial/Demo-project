@extends('admin.layouts.app')

@section('content')

    <main id="main" class="main">
        <section class="section">
            @include('admin.flash-message')
            <div class="row">
                <div class="col-lg-12 float-right mb-5">
                    <div class="col-lg-12 float-right mb-5">
            <span class="pull-right float-right">&nbsp;&nbsp;
<a class="btn btn-outline-primary" href="{{ route('user.create') }}"
   style="float: right">
                                                + @lang('langs.add')
                                            </a>
            </span></div>

                </div>

            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive" id="sampleTable">
                        <h5 class="card-title">@lang('langs.user_table')</h5>
                        <table id="sampleTable" class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">@lang('langs.user_no')</th>
                                <th scope="col">@lang('langs.mandali_code')</th>
                                <th scope="col">@lang('langs.mandali_name')</th>
                                <th scope="col">@lang('langs.mandali_address')</th>
                                <th scope="col">@lang('langs.gst_number')</th>
                                <th scope="col">@lang('langs.registration_num')</th>
                                <th scope="col">@lang('langs.user_name')</th>
                                <th scope="col">@lang('langs.gender')</th>
                                <th scope="col">@lang('langs.email')</th>
                                <th scope="col">@lang('langs.mobile_number')</th>
                                <th scope="col">@lang('langs.created_by')</th>
                                <th scope="col">@lang('langs.user_action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                        <th scope="row">{{gujarati_number($loop->iteration)}}</th>
                                        <td>{{translateToGujarati($user->mandali_code)}}</td>
                                        <td>@if(isset($user->mandali_name)){{translateToGujarati($user->mandali_name)}} @endif</td>
                                        <td>@if(isset($user->mandali_address)){{translateToGujarati($user->mandali_address)}} @endif</td>
                                        <td>@if(isset($user->gst_number)){{translateToGujarati($user->gst_num)}} @endif</td>
                                        <td>@if(isset($user->registration_num)){{translateToGujarati($user->reg_num)}} @endif</td>
                                        <td>@if(isset($user->user_name)){{translateToGujarati($user->user_name)}} @endif</td>
                                        <td>@if(isset($user->gender)){{translateToGujarati($user->gender)}} @endif</td>
                                        <td>@if(isset($user->email)){{translateToGujarati($user->email)}} @endif</td>
                                        <td>@if(isset($user->mobile)){{gujarati_number($user->mobile)}} @endif</td>
                                        <td>@if(isset($user->created_by)){{translateToGujarati($user->users->user_name) }} @endif</td>
                                    @else
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{translateToEnglish($user->mandali_code)}}</td>
                                        <td>@if(isset($user->mandali_name)){{translateToEnglish($user->mandali_name)}} @endif</td>
                                        <td>@if(isset($user->mandali_address)){{translateToEnglish($user->mandali_address)}} @endif</td>
                                        <td>@if(isset($user->gst_number)){{translateToEnglish($user->gst_num)}} @endif</td>
                                        <td>@if(isset($user->registration_num)){{translateToEnglish($user->reg_num)}} @endif</td>
                                        <td>@if(isset($user->user_name)){{translateToEnglish($user->user_name)}} @endif</td>
                                        <td>@if(isset($user->gender)){{translateToEnglish($user->gender)}} @endif</td>
                                        <td>@if(isset($user->email)){{translateToEnglish($user->email)}} @endif</td>
                                        <td>@if(isset($user->mobile)){{translateToEnglish($user->mobile)}} @endif</td>
                                        <td>@if(isset($user->created_by)){{translateToEnglish($user->users->user_name) }} @endif</td>
                                    @endif
                                    <td>
                                        {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete']) !!}
                                        <div class='btn-group'>
                                            <a href="{{ route('user.edit', [$user->id]) }}"
                                               class='btn btn-info btn-xs'>
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            {!! Form::button('<i class="bi bi-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                        </div>
                                        {!! Form::close() !!}
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection


