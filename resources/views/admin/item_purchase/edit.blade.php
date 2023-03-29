@extends('admin.layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>@lang('langs.item_purchase')</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('langs.item_purchase_edit_form')</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="{{route('item_purchase.update',$item_purchases->id)}}"
                                  method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.item_name')</label>
                                    <select class="form-control select2 @error('item_name_id') is-invalid @enderror"
                                            name="item_name_id">
                                        <option value="">---@lang('langs.select_item_name')---</option>
                                        @foreach($item_names as $item_name)
                                            <option
                                                value="{{$item_name->id}}" @if(isset($item_purchases)){{ $item_purchases->item_name_id == $item_name->id  ? 'selected' : ''}} @endif>{{$item_name->item_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('item_name_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">@lang('langs.itemQuantity')</label>
                                    <input type="number" name="item_quantity" value="{{$item_purchases->item_quantity}}"
                                           class="form-control @error('item_quantity') is-invalid @enderror"
                                           id="inputNanme4">

                                    @error('item_quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="inputNanme4" class="form-label">@lang('langs.Purchase_Rate')</label>
                                    <input type="number" name="Purchase_Rate" value="{{$item_purchases->Purchase_Rate}}"
                                           class="form-control @error('Purchase_Rate') is-invalid @enderror"
                                           id="inputNanme4">
                                    @error('Purchase_Rate')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="inputNanme4" class="form-label">@lang('langs.Sales_Rates')</label>
                                    <input type="number" name="Sales_Rates" value="{{$item_purchases->Sales_Rates}}"
                                           class="form-control @error('Sales_Rates') is-invalid @enderror"
                                           id="inputNanme4">
                                    @error('Sales_Rates')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="inputNanme4" class="form-label">@lang('langs.purchase_date')</label>
                                    <input type="date" name="purchase_date" value="{{$item_purchases->purchase_date}}"
                                           class="form-control @error('purchase_date') is-invalid @enderror"
                                           id="inputNanme4">
                                    @error('purchase_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-info">@lang('langs.update')</button>
                                    <a href="{{route('item_purchase.index')}}" type="reset"
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
