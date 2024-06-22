@extends('admin.layouts.app-main')
<style>
    .mailbox i.fa {
        font-size: 15px !important;
        margin-left: 10px;
        margin-right: 10px;
    }

    .mailbox a {
        color: #333;
    }

    .tooltip {
        font-family: 'Cairo' !important;
    }
</style>
@section('content')
    @if (session('success'))

        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12 mt-5">
            <div class="card p-4">
                <div class="row mailbox">
                    <div class="col-lg-3 col-md-4">
                        <h6 class="m-t-10 m-b-10">مجلدات الرسائل </h6>
                        <ul class="list-group list-group-divider inbox-list">
                            <li class="list-group-item">
                                <a href="{{route('admin.contacts.index')}}"><i class="fa fa-inbox"></i> صندوق الوارد
                                    ({{$data->total()}}) <i
                                        class="fa fa-circle text-warning"></i>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{route('admin.contacts.important')}}"><i class="fa fa-star"></i> الرسائل
                                    المهمة <i
                                        class="fa fa-circle text-success"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="ibox p-3" id="mailbox-container">
                            <div class="mailbox-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="d-none d-lg-block inbox-title ml-3"><i
                                            class="fa fa-envelope m-r-5"></i> صندوق الوارد ({{$data->total()}})
                                    </h5>
                                    <div class="mail-search w-50">
                                        <form class="d-inline" action="{{ route('admin.contacts.index') }}"
                                              method="get">
                                            <div class="input-group">
                                                <input dir="ltr" class="form-control text-left" type="text"
                                                       value="{{ request()->query('search') }}"
                                                       name="search" placeholder="ابحث بالاسم فى الرسائل"/>
                                                <div class="input-group-btn">
                                                    <button type="submit"
                                                            formaction="{{ route('admin.contacts.index') }}"
                                                            class="btn btn-info"
                                                            style="border-radius: 0;">ابحث
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between inbox-toolbar p-t-20">
                                    @if(($data)->count() >0)
                                        <div class="d-flex" style="padding: 10px;">
                                            <label class="ui-checkbox ui-checkbox-info check-single p-t-5">
                                                <input type="checkbox" id="check_all" data-select="all">
                                                <span class="input-span"></span>
                                            </label>
                                            <div id="inbox-actions" class="m-l-20 m-r-20">
                                                <form class="d-inline" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button formaction="{{route('admin.contacts.make.as.read')}}"
                                                            type="submit"
                                                            class="btn btn-default btn-md" data-toggle="tooltip"
                                                            data-original-title="تمييزها كمقروءة"><i
                                                            class="fa fa-eye"></i>
                                                    </button>
                                                    <button formaction="{{route('admin.contacts.make.as.important')}}"
                                                            type="submit"
                                                            class="btn btn-default btn-md" data-toggle="tooltip"
                                                            data-original-title="تمييزها كمهمة"><i
                                                            class="fa fa-star"></i></button>
                                                    <button formaction="{{route('admin.contacts.make.as.destroy')}}"
                                                            type="submit"
                                                            class="btn btn-default btn-md" data-toggle="tooltip"
                                                            data-original-title="حذف"><i class="fa fa-trash"></i>
                                                    </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-md alert-danger m-3 text-center w-100">لا توجد رسائل
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mailbox clf">
                                <table class="table table-hover table-inbox" id="table-inbox">
                                    <tbody class="rowlinkx" data-link="row">
                                    @foreach($data as $msg)
                                        <tr>
                                            <td class="check-cell rowlink-skip">
                                                <label class="ui-checkbox ui-checkbox-info check-single">
                                                    <input name="messages[]" value="{{$msg->id}}"
                                                           class="mail-check" type="checkbox">
                                                    <span class="input-span"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a class="@if($msg->status == 1) text-muted @elseif($msg->status == 2) text-success  @endif"
                                                   href="{{route('admin.contacts.show',$msg->id)}}">{{$msg->name}}
                                                    <br> <small>{{$msg->phone}}</small>
                                                </a>
                                            </td>
                                            <td class="mail-message @if($msg->status == 1) text-muted @elseif($msg->status == 2) text-success  @endif">
                                                {{$msg->message}} ...
                                            </td>
                                            <td>@if($msg->status == 0) <i
                                                    class="fa fa-circle text-warning"></i> @elseif($msg->status == 2) <i
                                                    class="fa fa-circle text-success d-inline"></i><i
                                                    class="fa fa-star d-inline text-success"></i> @endif</td>
                                            <td class="text-right @if($msg->status == 1) text-muted @elseif($msg->status == 2) text-success  @endif"
                                                style="width: 20%;">{{$msg->created_at->diffForHumans()}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <span @if(App::getLocale()=="ar") dir="rtl" class="text-right pull-right"
                                      @else dir="ltr"
                                      class="text-left pull-left"  @endif> عرض النتائج : {{ $data->total() }}</span>
                                <span @if(App::getLocale()=="ar") dir="rtl"
                                      class="text-right pull-left" @else @endif>{{ $data->withQueryString()->links() }}</span>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content closed -->
    <script src="{{asset('admin-assets/js/jquery.min.js')}}"></script>
    <script>
        $('#check_all').click(function () {
            $('input[type=checkbox]').prop('checked', true);
        });
    </script>
@endsection
