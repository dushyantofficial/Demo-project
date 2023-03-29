@extends('admin.layouts.app')

@section('content')

    <main id="main" class="main">
        <section class="section">
            @include('admin.flash-message')
            <div class="row">
                <div class="col-lg-12 float-right mb-5">

                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-5">
                                            <form action="{{ route('import') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                        <input id="reportrange" name="date"
                                                               @if(request('date') != 'null') value="{{request('date')}}"
                                                               @endif class="pull-left form-control daterange"
                                                             >


                                        </div>
                                        <div class="col-5">
                                            <input type="file" name="file"
                                                   class="form-control @error('file') is-invalid @enderror"><span>
                  @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                <span style="color: red">{{$errors->first('account_number')}}</span><br>
                <span style="color: red">{{$errors->first('customer_name')}}</span><br>
                <span style="color: red">{{$errors->first('user_name')}}</span><br>
                <span style="color: red">{{$errors->first('mobile_number')}}</span>
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-outline-success">Import</button>
                                            </span>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6" style="margin-left: 201px;">
                                            <a class="btn btn-outline-primary" href="{{ route('customer.create') }}"
                                               style="float: right">
                                                + @lang('langs.add')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive" id="sampleTable">
                            <h5 class="card-title">@lang('langs.customer_table')</h5>
                            <table id="sampleTable" class="table datatable">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('langs.customer_no')</th>
                                    <th scope="col">@lang('langs.user_name')</th>
                                    <th scope="col">@lang('langs.customer_name')</th>
                                    <th scope="col">@lang('langs.customer_code')</th>
                                    <th scope="col">@lang('langs.bank_name')</th>
                                    <th scope="col">@lang('langs.account_number')</th>
                                    <th scope="col">@lang('langs.ifsc_code')</th>
                                    <th scope="col">@lang('langs.final_amount')</th>
                                    <th scope="col">@lang('langs.customer_action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <th scope="row">{{gujarati_number($loop->iteration)}}</th>
                                            <td>{{translateToGujarati($customer->user->user_name)}}</td>
                                            <td>{{translateToGujarati($customer->customer_name)}}</td>
                                            <td>{{gujarati_number($customer->customer_code)}}</td>
                                            <td>{{translateToGujarati($customer->bank_name)}}</td>
                                            <td>{{gujarati_number($customer->account_number)}}</td>
                                            <td>{{translateToGujarati($customer->ifsc_code)}}</td>
                                            <td>{{translateToGujarati(get_rupee_currency($customer->final_amount))}}</td>
                                        @else
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$customer->user->user_name}}</td>
                                            <td>{{$customer->customer_name}}</td>
                                            <td>{{$customer->customer_code}}</td>
                                            <td>{{$customer->bank_name}}</td>
                                            <td>{{$customer->account_number}}</td>
                                            <td>{{$customer->ifsc_code}}</td>
                                            <td>{{get_rupee_currency($customer->final_amount)}}</td>
                                        @endif
                                        <td>
                                            {!! Form::open(['route' => ['customer.destroy', $customer->id], 'method' => 'delete']) !!}
                                            <div class='btn-group'>
                                                <a href="{{ route('customer.edit', [$customer->id]) }}"
                                                   class='btn btn-info btn-xs'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                {!! Form::button('<i class="bi bi-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                {{--                                            <a href="{{ route('customer.show', [$customer->id]) }}" class='btn btn-info btn-xs'>--}}
                                                {{--                                                <i class="bi bi-eye" aria-hidden="true"></i>--}}
                                                {{--                                            </a>--}}
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
@push('page_scripts')

    <script>
        $(function () {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('.daterange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>

@endpush
