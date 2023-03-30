@extends('admin.layouts.app')
@section('content')
    <style>

        @media print {

            div table {
                width: 100%;
                margin: 0;

            }

            .print-table {
                max-width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .print-table #pri_table {
                max-width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

        }

    </style>
    @include('admin.flash-message')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-outline-danger"
                               href="{{route('payment-register-report-export-pdf')}}?field={{request()}}">
                                Pdf</a>
                            <button type="button" onclick="ExportToExcel('xlsx')" class="btn btn-outline-success">
                                Excel
                            </button>&nbsp;&nbsp;
                            <span class="pull-right float-right"><button type="button"
                                                                         id="Pairings_by_Table_call"
                                                                         class="btn btn-outline-warning">Print</button>
                    <a href="{{route('payment-register-report')}}"><button type="button"
                                                                           class="btn btn-outline-dark">Back</button></a>&nbsp</span><br><br>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive" id="sampleTable">
                            <h5 class="card-title">@lang('langs.payment_register_report')</h5>
                            <div class="tile-body" id="my_report">
                                <table id="sampleTable" class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>@lang('langs.customer_no')</th>
                                        @if(isset($input['field']['user_id']))
                                            <th> @lang('langs.mobile_number')</th>
                                        @endif

                                        @if(isset($input['field']['cust_name']))
                                            <th> @lang('langs.customer_name')</th>

                                        @endif
                                        @if(isset($input['field']['cust_code']))
                                            <th> @lang('langs.customer_code')</th>

                                        @endif

                                        @if(isset($input['field']['bank_name']))
                                            <th> @lang('langs.bank_name')</th>

                                        @endif

                                        @if(isset($input['field']['account_number']))
                                            <th> @lang('langs.account_number')</th>

                                        @endif
                                        @if(isset($input['field']['ifsc_code']))
                                            <th> @lang('langs.ifsc_code')</th>

                                        @endif
                                        @if(isset($input['field']['final_amount']))
                                            <th> @lang('langs.final_amount')</th>

                                        @endif


                                        @if(isset($input['field']['created_at']))
                                            <th> @lang('langs.created_at')</th>

                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($loop->iteration)}}</td>
                                            @else
                                                <td>{{$loop->iteration}}</td>
                                            @endif

                                            @if(isset($input['field']['user_id']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($customer->user->mobile)}} </td>
                                                @else
                                                    <td>{{$customer->user->mobile_number}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['cust_name']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($customer->cust_name)}} </td>
                                                @else
                                                    <td>{{$customer->cust_name}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['cust_code']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($customer->cust_code)}} </td>
                                                @else
                                                    <td>{{$customer->cust_code}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['bank_name']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($customer->bank_name)}} </td>
                                                @else
                                                    <td>{{$customer->bank_name}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['account_number']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($customer->account_number)}} </td>
                                                @else
                                                    <td>{{$customer->account_number}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['ifsc_code']))
                                                <td>{{$customer->ifsc_code}} </td>
                                            @endif
                                            @if(isset($input['field']['final_amount']))
                                                <td>{{get_rupee_currency($customer->final_amount)}} </td>
                                            @endif


                                            @if(isset($input['field']['created_at']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_date($customer->created_at)}} </td>
                                                @else
                                                    <td>{{formate_date($customer->created_at)}} </td>
                                                @endif
                                            @endif

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            ?>
                            <div id="table_print">
                                <input type="hidden" id="mandali_address" value="{{$user->mandali_address}}">
                                <input type="hidden" id="mandali_code" value="{{$user->mandali_code}}">
                                <input type="hidden" id="date" value="{{request()->date}}">
                                <table id="pri_table" class="table table-responsive" border="1" width="100%"
                                       style="border-collapse: collapse;display: none">
                                    <thead>
                                    <tr>
                                        <th>@lang('langs.customer_no')</th>
                                        @if(isset($input['field']['user_id']))
                                            <th> @lang('langs.mobile_number')</th>
                                        @endif

                                        @if(isset($input['field']['cust_name']))
                                            <th> @lang('langs.customer_name')</th>

                                        @endif
                                        @if(isset($input['field']['cust_code']))
                                            <th> @lang('langs.customer_code')</th>

                                        @endif

                                        @if(isset($input['field']['bank_name']))
                                            <th> @lang('langs.bank_name')</th>

                                        @endif

                                        @if(isset($input['field']['account_number']))
                                            <th> @lang('langs.account_number')</th>

                                        @endif
                                        @if(isset($input['field']['ifsc_code']))
                                            <th> @lang('langs.ifsc_code')</th>

                                        @endif
                                        @if(isset($input['field']['final_amount']))
                                            <th> @lang('langs.final_amount')</th>

                                        @endif

                                        @if(isset($input['field']['created_at']))
                                            <th> @lang('langs.created_at')</th>

                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($loop->iteration)}}</td>
                                            @else
                                                <td>{{$loop->iteration}}</td>
                                            @endif

                                            @if(isset($input['field']['user_id']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($customer->user->mobile)}} </td>
                                                @else
                                                    <td>{{$customer->user->mobile_number}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['cust_name']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($customer->cust_name)}} </td>
                                                @else
                                                    <td>{{$customer->cust_name}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['cust_code']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($customer->cust_code)}} </td>
                                                @else
                                                    <td>{{$customer->cust_code}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['bank_name']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($customer->bank_name)}} </td>
                                                @else
                                                    <td>{{$customer->bank_name}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['account_number']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_number($customer->account_number)}} </td>
                                                @else
                                                    <td>{{$customer->account_number}} </td>
                                                @endif
                                            @endif
                                            @if(isset($input['field']['ifsc_code']))
                                                <td>{{$customer->ifsc_code}} </td>
                                            @endif
                                            @if(isset($input['field']['final_amount']))
                                                <td>{{get_rupee_currency($customer->final_amount)}} </td>
                                            @endif


                                            @if(isset($input['field']['created_at']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($customer->created_at)}} </td>
                                                @else
                                                    <td>{{formate_date($customer->created_at)}} </td>
                                                @endif
                                            @endif

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="filter_date" value="{{request()->date}}">
        </section>
    </main>

@endsection
@push('page_scripts')


    <script type="text/javascript">
        $(function () {
            $("#Pairings_by_Table_call").click(function () {

                $('#pri_table').show();
                var mandali_address = $('#mandali_address').val();
                var mandali_code = $('#mandali_code').val();
                var filter_dates = $('#filter_date').val();
                if (filter_dates != ''){
                    var date = $('#filter_date').val();
                }
                else {
                    var date = $('#reportrange').val();
                }

                var contents = $("#table_print").html();
                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({"position": "absolute", "top": "-1000000px"});
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                //Create a new HTML document.

                frameDoc.document.write('<html><head><title> </title><center>' + mandali_address + '-' + mandali_code + '<center>Bank Payment Statement<br><center>Date:' + date + '');
                frameDoc.document.write('</head><body>');
                //Append the external CSS file.
                // frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
                //Append the DIV contents.
                frameDoc.document.write(contents);
                frameDoc.document.write('</body></html>');
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                }, 500);
                $('#pri_table').attr("style", "display:none");
            });
        });
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


    @php
        $user = request()->user_id;
        if (isset($user)){
        $user_report = \App\Models\User::findOrfail($user);
        }
    @endphp

    <script>

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('my_report')
            var wb = XLSX.utils.table_to_book(elt, {sheet: "sheet1"});
            return dl ?
                XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
                @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                XLSX.writeFile(wb, fn || ('<?php if (isset($user_report)) {
                    echo $user_report->name;
                } ?>_Reports.' + (type || 'xlsx')));
            @else
            XLSX.writeFile(wb, fn || ('<?php if (isset(Auth::user()->name)) {
                echo Auth::user()->name;
            } ?>_Reports.' + (type || 'xlsx')));
            @endif
        }

    </script>

@endpush
