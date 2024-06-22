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
    <div class="row mailbox">
        <div class="col-lg-3 col-md-4">
            <h6 class="m-t-10 m-b-10">مجلدات الرسائل</h6>
            <ul class="list-group list-group-divider inbox-list">
                <li class="list-group-item">
                    <a href="{{route('admin.contacts.index')}}"><i class="fa fa-inbox"></i> صندوق الوارد <i
                            class="fa fa-circle text-warning"></i>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{route('admin.contacts.important')}}"><i
                            class="fa fa-star"></i> الرسائل المهمة <i
                            class="fa fa-circle text-success"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="ibox p-3" id="mailbox-container">
                <form class="d-inline" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="mailbox-header d-flex justify-content-between"
                         style="border-bottom: 1px solid #e8e8e8;">
                        <div class="p-3">
                            <h5 class="inbox-title mt-3">{{$message->subject}}</h5>
                            <div class="mt-3 font-13">
                                <span class="font-strong">{{$message->name}}</span>
                                <a href="#">{{$message->phone}}</a>
                            </div>
                            <div class="pr-3 mt-3 font-13">{{$message->created_at->diffForHumans()}}</div>
                        </div>
                        <input type="hidden" value="{{$message->id}}" name="messages[]"/>
                        <div class="inbox-toolbar m-l-20">
                            <button class="btn btn-default btn-md" data-toggle="tooltip"
                                    formaction="{{route('admin.contacts.make.as.destroy')}}" type="submit"
                                    data-original-title="حذف"><i class="fa fa-trash"></i>
                            </button>
                            <button class="btn btn-default btn-md" data-toggle="tooltip"
                                    formaction="{{route('admin.contacts.make.as.important')}}" type="submit"
                                    data-original-title="تمييزها كمهمة"><i
                                    class="fa fa-star"></i></button>
                            <button class="btn btn-default btn-md" data-toggle="tooltip"
                                    formaction="{{route('admin.contacts.print')}}" type="submit"
                                    data-original-title="طباعة"><i class="fa fa-print"></i></button>
                        </div>
                    </div>
                    <div class="mailbox-body p-3">
                        <p>{{$message->message}}</p></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
