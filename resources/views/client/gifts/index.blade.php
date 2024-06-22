@extends('client.layouts.app-main')
<style>

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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('client.gifts.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-gift') }} </a>
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('sidebar.display-clients-gifts') }}
                            </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('sales_bills.client-name') }}</th>
                                    <th class="text-center">{{ __('main.product-name') }}</th>
                                    <th class="text-center">{{ __('main.quantity') }}</th>
                                    <th class="text-center">{{ __('marketing.product-balance-before') }}</th>
                                    <th class="text-center">{{ __('marketing.product-balance-after') }}</th>
                                    <th class="text-center">{{ __('main.store') }}</th>
                                    <th class="text-center">{{ __('main.date') }} - {{ __('main.time') }}</th>
                                    <th class="text-center">{{ __('main.details') }}</th>
                                    <th class="text-center">{{ __('main.notes') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($gifts as $key => $gift)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $gift->outerClient->client_name }}</td>
                                        <td>{{ $gift->product->product_name }}</td>
                                        <td>{{ floatval($gift->amount) }}</td>
                                        <td>{{ floatval($gift->balance_before) }}</td>
                                        <td>{{ floatval($gift->balance_after) }}</td>
                                        <td>{{ $gift->store->store_name }}</td>
                                        <td>{{ $gift->created_at }}</td>
                                        <td>{{ $gift->details }}</td>
                                        <td>{{ $gift->notes }}</td>
                                        <td>
                                            <a href="{{ route('client.gifts.edit', $gift->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                data-placement="top"><i class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_gift"
                                                gift_id="{{ $gift->id }}"
                                                gift_name="{{ $gift->outerClient->client_name }} [ {{ $gift->amount }} X {{ $gift->product->product_name }} ] [ {{ $gift->store->store_name }} ]"
                                                data-toggle="modal" href="#modaldemo9" title="delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" gift="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف عملية</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.gifts.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="giftid" id="giftid">
                            <input class="form-control" name="giftname" id="giftname" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_gift').on('click', function() {
            var gift_id = $(this).attr('gift_id');
            var gift_name = $(this).attr('gift_name');
            $('.modal-body #giftid').val(gift_id);
            $('.modal-body #giftname').val(gift_name);
        });
    });
</script>
