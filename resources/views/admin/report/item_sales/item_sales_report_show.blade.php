@extends('admin.layouts.app')
@section('content')
    <style>

        @media print {

            div table {
                width: 80%;
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
    <style>
        .modal {
            --bs-modal-width: 1270px;
        }
    </style>
    @include('admin.flash-message')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-3">
                            <form action="{{ route('item-sales-report-show') }}" method="GET"
                                  enctype="multipart/form-data">
                                <input id="reportrange" name="date"
                                       @if(request('date') != 'null') value="{{request('date')}}"
                                       @endif class="pull-left form-control daterange"
                                       style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                        </div>

                        <div class="col-6">
                            <button class="btn btn-outline-success">Filter</button>
                            </span>
                            <a href="{{route('item-sales-report-show')}}" class="btn btn-outline-dark ml-3">Reset</a>

                            <a class="btn btn-outline-danger"
                               href="{{route('item-sales-report-show-pdf')}}?date={{request()->date}}">
                                Pdf </a>


                            <button type="button" class="btn btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target="#verticalycentered">Setup
                            </button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-outline-primary"
                                    onclick="ExportToExcel('xlsx')">Excel
                            </button>
                            <a class="btn btn-outline-warning" id="Pairings_by_Table_call"
                               href="#">
                                Print </a>

                        </div>
                        </form>
                    </div>
                </div>
                <br>
                <br>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive" id="sampleTable">
                            <h5 class="card-title">@lang('langs.item_sales_report_table')</h5>
                            <div class="tile-body" id="my_report">
                                <table id="sampleTable" class="table datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('langs.item_sales_no')</th>
                                        <th scope="col">@lang('langs.customer_name')</th>
                                        <th scope="col">@lang('langs.customer_code')</th>
                                        <th scope="col">@lang('langs.item_name')</th>
                                        <th scope="col">@lang('langs.itemQuantity')</th>
                                        <th scope="col">@lang('langs.payment_from_date')</th>
                                        <th scope="col">@lang('langs.payment_to_date')</th>
                                        <th scope="col">@lang('langs.deduct_from_date')</th>
                                        <th scope="col">@lang('langs.deduct_to_date')</th>
                                        <th scope="col">@lang('langs.entry_date')</th>
                                        <th scope="col">@lang('langs.payment')</th>
                                        <th scope="col">@lang('langs.deduct_payment')</th>
                                        <th scope="col">@lang('langs.total')</th>
                                        <th scope="col">@lang('langs.created_by')</th>
                                        <th scope="col">@lang('langs.created_at')</th>
                                        {{--                                    <th scope="col">@lang('langs.item_sales_action')</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($filter_item_sales))
                                        @foreach($filter_item_sales as $item_sales)
                                            <tr>
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_number($loop->iteration)}}</td>
                                                    <td>{{translateToGujarati($item_sales->customers->customer_name)}}</td>
                                                @else
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item_sales->customers->customer_name}}</td>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($item_sales->customers->customer_code)}}</td>
                                                @else
                                                    <td>{{$item_sales->customers->customer_code}}</td>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($item_sales->item_names->item_name->item_name)}}</td>
                                                @else
                                                    <td>{{$item_sales->item_names->item_name->item_name}}</td>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_number($item_sales->item_quantity)}}</td>
                                                @else
                                                    <td>{{$item_sales->item_quantity}}</td>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->payment_from_date)}}</td>
                                                    <td>{{gujarati_date($item_sales->payment_to_date)}}</td>
                                                @else
                                                    <td>{{formate_date($item_sales->payment_from_date)}}</td>
                                                    <td>{{formate_date($item_sales->payment_to_date)}}</td>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->deduct_from_date)}}</td>
                                                    <td>{{gujarati_date($item_sales->deduct_to_date)}}</td>
                                                    <td>{{gujarati_date($item_sales->entry_date)}}</td>
                                                @else
                                                    <td>{{formate_date($item_sales->deduct_from_date)}}</td>
                                                    <td>{{formate_date($item_sales->deduct_to_date)}}</td>
                                                    <td>{{formate_date($item_sales->entry_date)}}</td>
                                                @endif
                                                <td>{{get_rupee_currency($item_sales->payment)}}</td>
                                                <td>{{get_rupee_currency($item_sales->deduct_payment)}}</td>
                                                <td>{{get_rupee_currency($item_sales->total)}}</td>
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($item_sales->created_name->user_name)}}</td>
                                                @else
                                                    <td>{{$item_sales->created_name->user_name}}</td>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->created_at)}}</td>
                                                @else
                                                    <td>{{formate_date($item_sales->created_at)}}</td>
                                                @endif

                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        $user = \Illuminate\Support\Facades\Auth::user();
                        ?>
                        <div id="table_print">
                            <input type="hidden" id="mandali_address" value="{{$user->mandali_address}}">
                            <input type="hidden" id="mandali_code" value="{{$user->mandali_code}}">
                            <table id="pri_table" class="table table-responsive" border="1" width="100%"
                                   style="border-collapse: collapse;display: none">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('langs.item_sales_no')</th>
                                    <th scope="col">@lang('langs.customer_name')</th>
                                    <th scope="col">@lang('langs.customer_code')</th>
                                    <th scope="col">@lang('langs.item_name')</th>
                                    <th scope="col">@lang('langs.itemQuantity')</th>
                                    <th scope="col">@lang('langs.payment_from_date')</th>
                                    <th scope="col">@lang('langs.payment_to_date')</th>
                                    <th scope="col">@lang('langs.deduct_from_date')</th>
                                    <th scope="col">@lang('langs.deduct_to_date')</th>
                                    <th scope="col">@lang('langs.entry_date')</th>
                                    <th scope="col">@lang('langs.payment')</th>
                                    <th scope="col">@lang('langs.deduct_payment')</th>
                                    <th scope="col">@lang('langs.total')</th>
                                    <th scope="col">@lang('langs.created_by')</th>
                                    <th scope="col">@lang('langs.created_at')</th>
                                    {{--                                    <th scope="col">@lang('langs.item_sales_action')</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($filter_item_sales))
                                    @foreach($filter_item_sales as $item_sales)
                                        <tr>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($loop->iteration)}}</td>
                                                <td>{{translateToGujarati($item_sales->customers->customer_name)}}</td>
                                            @else
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item_sales->customers->customer_name}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($item_sales->customers->customer_code)}}</td>
                                            @else
                                                <td>{{$item_sales->customers->customer_code}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{translateToGujarati($item_sales->item_names->item_name->item_name)}}</td>
                                            @else
                                                <td>{{$item_sales->item_names->item_name->item_name}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($item_sales->item_quantity)}}</td>
                                            @else
                                                <td>{{$item_sales->item_quantity}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_date($item_sales->payment_from_date)}}</td>
                                                <td>{{gujarati_date($item_sales->payment_to_date)}}</td>
                                            @else
                                                <td>{{formate_date($item_sales->payment_from_date)}}</td>
                                                <td>{{formate_date($item_sales->payment_to_date)}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_date($item_sales->deduct_from_date)}}</td>
                                                <td>{{gujarati_date($item_sales->deduct_to_date)}}</td>
                                                <td>{{gujarati_date($item_sales->entry_date)}}</td>
                                            @else
                                                <td>{{formate_date($item_sales->deduct_from_date)}}</td>
                                                <td>{{formate_date($item_sales->deduct_to_date)}}</td>
                                                <td>{{formate_date($item_sales->entry_date)}}</td>
                                            @endif
                                            <td>{{get_rupee_currency($item_sales->payment)}}</td>
                                            <td>{{get_rupee_currency($item_sales->deduct_payment)}}</td>
                                            <td>{{get_rupee_currency($item_sales->total)}}</td>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{translateToGujarati($item_sales->created_name->user_name)}}</td>
                                            @else
                                                <td>{{$item_sales->created_name->user_name}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_date($item_sales->created_at)}}</td>
                                            @else
                                                <td>{{formate_date($item_sales->created_at)}}</td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('langs.item_sales_report_table')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="myform" action="{{route('item_sales_report_export')}}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>@lang('langs.select_date'):</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="reportrange" name="date"
                                               @if(request('date') != 'null') value="{{request('date')}}"
                                               @endif class="pull-left form-control daterange"
                                               style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>@lang('langs.check_all'):</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="checkbox"
                                               id="checkall">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>@lang('langs.fields'):</label>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="checkbox" id="customer_name" class="check_all"
                                               name="field[customer_id]"
                                               value="customer_id">
                                        <label for="customer_name"> @lang('langs.customer_name') </label><br>
                                        <input type="checkbox" id="payment_from_date" class="check_all"
                                               name="field[payment_from_date]"
                                               value="payment_from_date">
                                        <label for="payment_from_date"> @lang('langs.payment_from_date')</label><br>

                                        <input type="checkbox" id="to_morning_evening" class="check_all"
                                               name="field[to_morning_evening]"
                                               value="to_morning_evening">
                                        <label for="to_morning_evening"> @lang('langs.to_morning_evening')</label><br>
                                        <input type="checkbox" id="entry_date" class="check_all"
                                               name="field[entry_date]"
                                               value="entry_date">
                                        <label for="entry_date"> @lang('langs.entry_date')</label><br>
                                        <input type="checkbox" id="deduct_payment" class="check_all"
                                               name="field[deduct_payment]"
                                               value="deduct_payment">
                                        <label for="deduct_payment"> @lang('langs.deduct_payment')</label><br>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" id="item_name" class="check_all"
                                               name="field[item_name_id]"
                                               value="item_name_id">
                                        <label for="bank_name"> @lang('langs.item_name')</label><br>
                                        <input type="checkbox" id="payment_to_date" class="check_all"
                                               name="field[payment_to_date]"
                                               value="payment_to_date">
                                        <label for="dob">@lang('langs.payment_to_date') </label><br>
                                        <input type="checkbox" id="deduct_from_date" class="check_all"
                                               name="field[deduct_from_date]"
                                               value="deduct_from_date">
                                        <label for="deduct_from_date"> @lang('langs.deduct_from_date')</label><br>
                                        <input type="checkbox" id="deduct_morning_evening" class="check_all"
                                               name="field[deduct_morning_evening]"
                                               value="deduct_morning_evening">
                                        <label for="deduct_morning_evening"> @lang('langs.deduct_mor_eve')</label><br>
                                        <input type="checkbox" id="total" class="check_all" name="field[total]"
                                               value="total">
                                        <label for="total"> @lang('langs.total')</label><br>

                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" id="item_quantity" class="check_all"
                                               name="field[item_quantity]"
                                               value="item_quantity">
                                        <label for="itemQuantity"> @lang('langs.itemQuantity')</label><br>
                                        <input type="checkbox" id="from_morning_evening" class="check_all"
                                               name="field[from_morning_evening]"
                                               value="from_morning_evening">
                                        <label
                                            for="from_morning_evening"> @lang('langs.from_morning_evening')</label><br>
                                        <input type="checkbox" id="payment_to_date" class="check_all"
                                               name="field[payment_to_date]"
                                               value="payment_to_date">
                                        <label for="payment_to_date"> @lang('langs.payment_to_date')</label><br>
                                        <input type="checkbox" id="payment" class="check_all" name="field[payment]"
                                               value="payment">
                                        <label for="payment"> @lang('langs.payment')</label><br>
                                        <input type="checkbox" id="created_by" class="check_all"
                                               name="field[created_by]"
                                               value="created_by">
                                        <label for="payment"> @lang('langs.created_by')</label><br>
                                    </div>
                                    <span style="color: red;margin-left: 421px;">{{$errors->first('field')}}</span>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-outline-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End Vertically centered Modal-->

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

    <script>
        $('#checkall').change(function () {
            $('.check_all').prop('checked', this.checked);
        });

        $('.check_all').change(function () {
            if ($('.check_all:checked').length == $('.check_all').length) {
                $('#checkall').prop('checked', true);
            } else {
                $('#checkall').prop('checked', false);
            }
        });
    </script>
    <script type="text/javascript">
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
