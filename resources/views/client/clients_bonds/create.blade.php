@extends('client.layouts.app-main')
<style>
    table thead tr th,
    table tbody tr td {
        border: inherit !importnat
    }
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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.bonds.index') }}">
                            {{ __('main.back') }}
                        </a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('bonds.add_new_client_bonds') }}
                    </div>

                    <div class="clearfix"></div>
                    <br>

                    <div class="alert alert-danger m-3" id="errMsg" style="display:none;">

                    </div>

                    <div class="alert alert-success m-3" id="succMsg" style="display:none;">

                    </div>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.branches.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" id="company_id" value="{{Auth::user()->company_id}}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> {{ __('bonds.client_name') }} <span class="text-danger">*</span></label>
                                <select dir="rtl" id="client" required class="form-control selectpicker" data-style="btn-danger"
                                    data-live-search="true" name="client">
                                    <option value="none" disabled selected>{{ __('bonds.choose_client') }}</option>
                                    @foreach($outer_clients as $client)
                                        <option value="{{ $client->client_name }}">{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('bonds.account') }} <span class="text-danger">*</span></label>
                                <select dir="rtl" id="account" required class="form-control" name="account">
                                    <option value="كاش"> كاش </option>
                                    <option value="شبكه">شبكه</option>
                                    <option value="تحويل بنكي">تحويل بنكي</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('bonds.type') }} <span class="text-danger">*</span></label>
                                <select dir="rtl" required class="form-control" id="type" name="type">
                                    <option>قبض</option>
                                    <option>صرف</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label> {{ __('bonds.date') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" id="date" name="date" type="date">
                            </div>

                            <div class="col-md-3" style="    margin-top: 20px;">
                                <label> {{ __('bonds.amount') }} <span class="text-danger">*</span></label>
                                <input required class="form-control" dir="ltr" id="amount" name="amount" type="number" step="any">
                            </div>



                            <div class="col-md-3" style="    margin-top: 20px;">
                                <label> {{ __('bonds.notes') }} <span class="text-danger"></span></label>
                                <textarea rows="5" class="form-control" id="notes" name="notes" style="height: 100px; padding: 9px; text-align: right;">

                                </textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
$(document).ready(function(){
    $("#selectForm2").submit(function(e){

        e.preventDefault();

        //validaiton...

        var company_id = $("#company_id").val();
        var client = $("#client").val();
        var account = $("#account").val();
        var type = $("#type").val();
        var date = $("#date").val();
        var amount = $("#amount").val();
        var notes = $("#notes").val();

        if(client == "none" || client == null){
            $("#errMsg").text("يجب ان تختار اسم العميل!!");
            $("#errMsg").show("slow");

            setTimeout(function(){
                $("#errMsg").hide("slow");
            },3000);
            return false;
        }

        //start Ajax...
        $.ajax({
           url:"{{route('create-clients-bonds')}}",
           type:"POST",
           data:{
               company_id:company_id,
               client:client,
               account:account,
               type:type,
               date:date,
               amount:amount,
               notes:notes
           },
           success:function(res){
                if(res){
                    $("#succMsg").text("تمت الاضافة بنجاح");
                    $("#succMsg").show("slow");

                    setTimeout(function(){
                        window.location.href="/client/showClientBondPrint/"+ res ;
                    },2000);
                }else{
                    alert("not" + res);
                }

           },
           error:function(res){
               console.log("err" + res);
           },
        });
        return false;
    });
});
</script>







