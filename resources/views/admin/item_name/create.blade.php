@extends('admin.layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>@lang('langs.item_name')</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('langs.item_name_form')</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="{{route('item_name.store')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">
                                    <label for="inputNanme4" class="form-label">@lang('langs.item_name')</label>
                                    <input type="text" name="item_name" value="{{old('item_name')}}"
                                           class="form-control @error('item_name') is-invalid @enderror"
                                           id="inputNanme4">
                                    @error('item_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-primary">@lang('langs.save')</button>
                                    <a href="{{route('item_name.index')}}" type="reset"
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
