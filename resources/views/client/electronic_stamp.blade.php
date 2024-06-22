@extends('client.layouts.app-main')
<style>
#submitBTN{
    padding: 8px 50px !important; 
    border-radius: 36px !important; 
    font-weight: bold !important;
}
</style>
@section('content')
    <!-- main-content closed -->
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

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left text-white"
                            onclick="window.location.href='home'">{{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.add-new-electronic-stamp') }}
                        </h5>
                    </div>
                </div>
                <div class="card-body p-1 m-1">
                    <form id="electronicStampForm" method="post">
                        {{ csrf_field() }}
                        <div class="row m-t-3 mb-3">
                            <div class="col-md-4">
                                <label> {{ __('sidebar.electronic-stamp') }} <span class="text-danger">*</span></label>
                                <input type="file" id="imgInput" class="form-control mg-b-20 mb-3" name="elec_stamp" required>
                                @if(isset($electronicStamp))
                                <img src="{{ asset('../../../assets/images/electronic_stamps/'. $electronicStamp->img) }}" alt="" style="border: 1px solid #80808082; width: 200px; border-radius: 23px !important; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;" id="my_image">
                                
                                @else
                                <img src="" alt="" style="display:none;border: 1px solid #80808082; width: 200px; border-radius: 23px !important; box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;" id="my_image">
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit" id="submitBTN">{{ __('main.save') }}</button>
                        </div>
                    </form>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#electronicStampForm").submit(function(e){
            $("#my_image").hide('slow');
            $("#submitBTN").attr('disabled',true);
            $("#submitBTN").css("cursor","no-drop");
            e.preventDefault();
            
            $.ajax({
                type:"post",
                url:"{{ route('add-electronic-stamp') }}",
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(res){
                    if(res !== 'err'){
                        $("#my_image").attr("src","../../../assets/images/electronic_stamps/"+res);
                        setTimeout(function(){
                            $("#my_image").show('slow');
                            $("#submitBTN").attr('disabled',false);
                            $("#imgInput").val(''); 
                            $("#submitBTN").css("cursor","pointer");
                        },1000);
                        
                    }
                },
                error:function(response){
                    console.log("error > ");
                    console.log(response);
                }
            });
        });
    });
</script>
