@extends('client.layouts.app-main')
<!-- Internal Data table css -->
<style>
    [role='combobox'] {
        left: -90px !important;
        width: 220px;
    }

</style>

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Errors :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row -->
    <div id="form-control-repeater">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="font-family: 'Cairo';" id="tel-repeater">
                            {{ __('main.main-information') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="la la-minus"></i></a></li>
                                <li><a data-action="reload"><i class="la la-refresh"></i></a></li>
                                <li><a data-action="expand"><i class="la la-expand"></i></a></li>
                                <li><a data-action="close"><i class="la la-close"></i></a></li>
                            </ul>
                        </div>
                    </div>
                   <div class="card-content collapse show">
    <div class="card-body">
        <form method="POST" action="{{ route('client.profile.update', Auth::user()->id) }}" class="row">
            @csrf
            @method('PATCH')

            <div class="form-group col-lg-6 mb-2">
                <label for="name">{{ __('main.name') }}</label>
                <input type="text" class="form-control" required value="{{ Auth::user()->name }}" placeholder="{{ __('main.name') }}" name="name">
            </div>
            <div class="form-group col-lg-6 mb-2">
                <label for="email">{{ __('main.email') }}</label>
                <input type="text" class="form-control text-left" dir="ltr" required value="{{ Auth::user()->email }}" placeholder="{{ __('main.email') }}" name="email">
            </div>

            <div class="form-group col-lg-6 mb-2">
                <label for="password">{{ __('main.password') }}</label>
                <input type="password" class="form-control" style="text-align: left;" dir="ltr" required placeholder="{{ __('main.password') }}" name="password">
            </div>
            <div class="form-group col-lg-6 mb-2">
                <label for="confirm-password">{{ __('main.confirm-password') }}</label>
                <input type="password" class="form-control" style="text-align: left;" dir="ltr" required placeholder="{{ __('main.confirm-password') }}" name="confirm-password">
            </div>

            <div class="card-footer">
                <div class="col-lg-12 text-center">
                    <button type="reset" name="reset" class="btn btn-info btn-sm">
                        <i class="la la-refresh"></i> {{ __('main.reset') }}
                    </button>
                    <button type="submit" name="submit" class="btn btn-success btn-sm">
                        <i class="la la-check"></i> {{ __('main.update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="font-family: 'Cairo';" id="tel-repeater"> البيانات الشخصية </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="la la-minus"></i></a></li>
                                <li><a data-action="reload"><i class="la la-refresh"></i></a></li>
                                <li><a data-action="expand"><i class="la la-expand"></i></a></li>
                                <li><a data-action="close"><i class="la la-close"></i></a></li>
                            </ul>
                        </div>
                    </div>
                   <div class="card-content collapse show">
    <div class="card-body">
        <form method="POST" action="{{ route('client.profile.store', Auth::user()->id) }}" enctype="multipart/form-data" class="row">
            @csrf
            @method('PATCH')

            <div class="col-lg-12 mb-3">
                <div class="col-lg-6 pull-right">
                    <label>{{ __('main.gender') }}: <span class="text-danger">*</span></label>
                    <select required name="gender" id="select-beast" class="form-control">
                        <option value="">{{ __('main.gender') }}</option>
                        <option @if ($profile->gender == 'male') selected @endif value="male">{{ __('main.male') }}</option>
                        <option @if ($profile->gender == 'female') selected @endif value="female">{{ __('main.female') }}</option>
                        <option @if ($profile->gender == 'other') selected @endif value="other">{{ __('main.other') }}</option>
                    </select>
                </div>
                <div class="col-lg-6 pull-right">
                    <label class="form-label d-block">{{ __('main.age') }}<span class="text-danger">*</span></label>
                    <input value="{{ $profile->age }}" type="text" min="1" required max="100" name="age" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-12 mb-3">
                <div class="col-lg-6 pull-right">
                    <label class="form-label d-block">{{ __('main.city') }}<span class="text-danger">*</span></label>
                    <input value="{{ $profile->city_name }}" type="text" required name="city_name" class="form-control">
                </div>
                <div class="col-lg-6 pull-right">
                    <label>{{ __('main.image') }}</label>
                    <input accept=".jpg,.png,.jpeg" type="file" onchange="pic.src=window.URL.createObjectURL(this.files[0])" id="file" name="profile_pic" class="form-control">
                </div>
            </div>

            <div class="col-lg-12 text-center mb-2">
                <label for="" class="d-block">{{ __('main.preview') }}</label>
                <img id="pic" src="{{ asset($profile->profile_pic) }}" style="width: 100px; height:100px;" />
            </div>

            <div class="card-footer">
                <div class="col-lg-12 text-center">
                    <button type="reset" name="reset" id="reset-btn" class="btn btn-info btn-sm">
                        <i class="la la-refresh"></i> {{ __('main.reset') }}
                    </button>
                    <button type="submit" name="submit" class="btn btn-success btn-sm">
                        <i class="la la-check"></i> {{ __('main.update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#reset-btn').on('click', function() {
                var $image = $('#pic');
                $image.removeAttr('src').replaceWith($image.clone());
            });
        });
    </script>
@endsection
