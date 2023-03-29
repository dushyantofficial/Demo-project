@extends('admin.layouts.app')

@section('content')

    <main id="main" class="main">
        <section class="section">
            @include('admin.flash-message')
            <div class="row">
                <div class="col-lg-12 float-right mb-5">
            <span class="pull-right float-right">&nbsp;&nbsp;
 <a class="btn btn-outline-primary" href="{{ route('item_purchase.create') }}" style="float: right">
                + @lang('langs.add')
            </a>
            </span></div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive" id="sampleTable">
                            <h5 class="card-title">@lang('langs.item_purchase_table')</h5>
                            <table id="sampleTable" class="table datatable">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('langs.item_purchase_no')</th>
                                    <th scope="col">@lang('langs.item_name')</th>
                                    <th scope="col">@lang('langs.itemQuantity')</th>
                                    <th scope="col">@lang('langs.Purchase_Rate')</th>
                                    <th scope="col">@lang('langs.Sales_Rates')</th>
                                    <th scope="col">@lang('langs.purchase_date')</th>
                                    <th scope="col">@lang('langs.item_name_action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item_purchases as $item_purchase)
                                    <tr>
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <th scope="row">{{gujarati_number($loop->iteration)}}</th>
                                            <td>{{translateToGujarati($item_purchase->item_name->item_name)}}</td>
                                            <td>{{gujarati_number($item_purchase->item_quantity)}}</td>
                                        @else
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$item_purchase->item_name->item_name}}</td>
                                            <td>{{$item_purchase->item_quantity}}</td>
                                        @endif
                                        <td>{{get_rupee_currency($item_purchase->Purchase_Rate)}}</td>
                                        <td>{{get_rupee_currency($item_purchase->Sales_Rates)}}</td>
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_date($item_purchase->purchase_date)}}</td>
                                        @else
                                            <td>{{formate_date($item_purchase->purchase_date)}}</td>
                                        @endif
                                        <td>
                                            {!! Form::open(['route' => ['item_purchase.destroy', $item_purchase->id], 'method' => 'delete']) !!}
                                            <div class='btn-group'>
                                                <a href="{{ route('item_purchase.edit', [$item_purchase->id]) }}"
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


