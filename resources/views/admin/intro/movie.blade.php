@extends('admin.layouts.app-main')
<style>

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('admin.home') }}">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث فيديو شرح المقدمة
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{route('admin.intro.movie.post')}}" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        @method('POST')
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-lg-6 mb-2">
                                <label for=""> اختر فيديو للرفع </label>
                                <input required accept=".mp4,.webm,.mkv" type="file"
                                       oninput="intro.src=window.URL.createObjectURL(this.files[0])" id="file"
                                       name="intro_movie" class="form-control">
                            </div>
                            <div class="col-lg-6 text-center mb-2">
                                <label for="intro" class="d-block"> معاينة الفيديو </label>
                                <video id="intro" autoplay controls
                                       @if(isset($intro_movie))
                                       src="{{asset($intro_movie->intro_movie)}}"
                                       @else
                                       src=""
                                       @endif
                                       width="100%" height="auto"></video>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
