@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.categories.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('categories.edit-category') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.categories.update', $category->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('categories.edit-category') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> {{ __('categories.category-name') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" value="{{ $category->category_name }}" required class="form-control"
                                    name="category_name" type="text">
                            </div>

                            <div class="col-md-4">
                                <label> {{ __('categories.category-type') }} <span class="text-danger">*</span></label>
                                <select required name="category_type" class="form-control">
                                    <option value="">{{ __('categories.category-type') }}</option>
                                    <option @if ($category->category_type == 'مخزونية') selected @endif value="مخزونية">مخزونية
                                    </option>
                                    <option
                                    @if ($category->category_type == 'خدمية')
                                    @endif
                                    value="خدمية">خدمية</option>
                                    <option
                                    @if ($category->category_type == 'مجمع')
                                    @endif
                                    value="مجمع">مجمع</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('main.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
