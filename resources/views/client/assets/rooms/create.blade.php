@extends('client.layouts.app-main')
@section('content')
 @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>@lang('main.mistake') :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row margin-tb">
        <div class="col-md-12 pl-4 pr-4">
            <a class="btn pull-left btn-primary btn-sm custom-font-size" href="{{ route('rooms.create') }}">
                <i class="fa fa-plus"></i>
                @lang('main.create_rooms')
            </a>
            <h3 class="pull-right alert alert-sm alert-success custom-font-size">
                @lang('main.file_rooms')
            </h3>
        </div>
    </div>
    <div class="col-md-7 mt-5">
        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf
            <div class="form-group col-md-12">
                <label for="code" class="custom-font-size">@lang('main.code')</label>
                <input type="text" name="code" class="form-control" id="code" value="{{ $newCode }}"
                    required maxlength="3" disabled>
                <input type="hidden" name="code" value="{{ $newCode }}">
            </div>
            <div class="form-group col-md-12">
                <label for="description_ar" class="custom-font-size">@lang('main.Description (Arabic)')</label>
                <textarea name="description_ar" class="form-control custom-font-size" id="description_ar" required>{{ old('description_ar') }}</textarea>
            </div>
            <div class="form-group col-md-12">
                <label for="description_en" class="custom-font-size">@lang('main.Description (English)')</label>
                <textarea name="description_en" class="form-control custom-font-size" id="description_en" required>{{ old('description_en') }}</textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary custom-button-size">@lang('main.Submit')</button>
            </div>
        </form>
    </div>
    <style>
        .custom-font-size {
            font-size: 16px !important;
        }

        .custom-button-size {
            width: 20%;
            font-size: 16px !important;
        }
    </style>
@endsection
