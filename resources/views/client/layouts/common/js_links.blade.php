<script src="{{asset('app-assets/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/app-menu.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/app.js')}}" type="text/javascript"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $(function () {
        $('#example-table, #posReportToday').DataTable({
            pageLength: 25
        });
    });
    $(".alert.alert-success.alert-dismissable").fadeTo(2000, 5000).slideUp(500);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.progress-pie-chart').each(function(){
        var $ppc = $(this),
            percent = parseInt($ppc.data('percent')),
            deg = 360*percent/100;
        if (percent > 50) {
            $ppc.addClass('gt-50');
        }
        if (percent <= 25) {
            $ppc.addClass('red');
        } else if (percent >= 25 && percent <= 90) {
            $ppc.addClass('orange');
        } else if (percent >= 90) {
            $ppc.addClass('green');
        }
        $ppc.find('.ppc-progress-fill').css('transform','rotate('+ deg +'deg)');
        $ppc.find('.ppc-percents span').html('<cite>'+percent+'</cite>'+'%');
    });
</script>
