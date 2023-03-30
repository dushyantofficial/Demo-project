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
            --bs-modal-width: 906px;
        }
    </style>
    @include('admin.flash-message')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-3">
                            <form action="{{ route('item-name-report-show') }}" method="GET"
                                  enctype="multipart/form-data">
                                <input id="reportrange" name="date"
                                       @if(request('date') != 'null') value="{{request('date')}}"
                                       @endif class="pull-left form-control daterange"
                                       style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                        </div>

                        <div class="col-6">
                            <button class="btn btn-outline-success">Filter</button>
                            </span>
                            <a href="{{route('item-name-report-show')}}" class="btn btn-outline-dark ml-3">Reset</a>

                            <a class="btn btn-outline-danger"
                               href="{{route('item-name-report-show-pdf')}}?date={{request()->date}}">
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
                            <h5 class="card-title">@lang('langs.item_name_report_table')</h5>
                            <div class="tile-body" id="my_report">
                                <table id="sampleTable" class="table datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('langs.item_name_no')</th>
                                        <th scope="col">@lang('langs.item_name')</th>
                                        <th scope="col">@lang('langs.created_by')</th>
                                        <th scope="col">@lang('langs.created_at')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item_names as $item_name)
                                        <tr>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($loop->iteration)}}</td>
                                                <td>{{translateToGujarati($item_name->item_name)}}</td>
                                                <td>{{translateToGujarati($item_name->created_bys->user_name)}}</td>
                                            @else
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item_name->item_name}}</td>
                                                <td>{{$item_name->created_bys->user_name}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_date($item_name->created_at)}} </td>
                                            @else
                                                <td>{{formate_date($item_name->created_at)}} </td>
                                            @endif
                                        </tr>
                                    @endforeach
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
                                    <th scope="col">@lang('langs.item_name_no')</th>
                                    <th scope="col">@lang('langs.item_name')</th>
                                    <th scope="col">@lang('langs.created_by')</th>
                                    <th scope="col">@lang('langs.created_at')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($item_names))
                                    @foreach($item_names as $item_name)
                                        <tr>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($loop->iteration)}}</td>
                                                <td>{{translateToGujarati($item_name->item_name)}}</td>
                                            <td>{{translateToGujarati($item_name->created_bys->user_name)}}</td>
                                            @else
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item_name->item_name}}</td>
                                                <td>{{$item_name->created_bys->user_name}}</td>
                                            @endif
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_date($item_name->created_at)}} </td>
                                            @else
                                                <td>{{formate_date($item_name->created_at)}} </td>
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
                            <h5 class="modal-title">@lang('langs.item_name_report_table')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="myform" action="{{route('item_name_report_export')}}" method="get">
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
                                        <input type="checkbox" id="name" class="check_all" name="field[item_name]"
                                               value="item_name">
                                        <label for="name"> @lang('langs.item_name') </label><br>


                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" id="insertedByUserId" class="check_all"
                                               name="field[insertedByUserId]"
                                               value="insertedByUserId">
                                        <label for="admission_date"> @lang('langs.created_by')</label><br>

                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" id="created_at" class="check_all"
                                               name="field[created_at]"
                                               value="created_at">
                                        <label for="admission_date"> @lang('langs.created_at')</label><br>

                                    </div>

                                </div>
                                <span style="color: red;margin-left: 301px;">{{$errors->first('field')}}</span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-outline-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                    <input type="hidden" id="filter_date" value="{{request()->date}}">
                </div>
            </div><!-- End Vertically centered Modal-->


        </section>
    </main>



    <!-- Modal -->
@endsection
@push('page_scripts')
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
