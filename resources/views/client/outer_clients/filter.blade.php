@extends('client.layouts.app-main')
<style>
    .bootstrap-select {
        width: 75% !important;
        display: inline !important;
        float: right !important;
    }

    .button_search {
        height: 40px !important;
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-danger btn-sm" href="{{ route('client.outer_clients.index') }}">
                                {{ __('main.back') }} </a>
                            <h5 class="pull-right alert alert-sm alert-info"> {{ __('sidebar.clients-filter') }} </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body p-3">
                    <h4 class="alert alert-sm alert-dark text-center  no-print"> {{ __('sidebar.clients-filter') }}</h4>
                    <div class="col-lg-3 pull-right  no-print">
                        <form action="{{ route('client.outer_clients.filter.key') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label style="display:block;"
                                    for="national">{{ __('clients.search-by-nationality') }}</label>
                                <select class="selectpicker" required data-live-search="true" title="اكتب او اختر الجنسية"
                                    data-style="btn-info" name="national" id="national">
                                    @if (!empty($nationals[0]->client_national))
                                        <?php
                                        if ($nationals->count() > 0) {
                                            $i = 1;
                                            foreach ($nationals as $national) {
                                                $client_national = $national->client_national;
                                                echo '
                                                                                                                                                                                                                                                                                                <option title="' .
                                                    $client_national .
                                                    '" value="' .
                                                    $client_national .
                                                    '">' .
                                                    $i .
                                                    ' - ' .
                                                    $client_national .
                                                    '</option>
                                                                                                                                                                                                                                                                                            ';
                                                $i++;
                                            }
                                        }
                                        ?>
                                    @endif
                                </select>
                                <button type="submit" class="button_search btn btn-md btn-info"
                                    style="display: inline !important;width: 20% !important; float: left !important;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 pull-right  no-print">
                        <form action="{{ route('client.outer_clients.filter.key') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label style="display:block;" for="city">{{ __('clients.search-by-type') }} </label>
                                <select required
                                    style="width: 75% !important; display: inline !important; float: right !important;"
                                    class="form-control" name="category">
                                    <option value="">اختر الفئة</option>
                                    <option value="جملة">جملة</option>
                                    <option value="قطاعى">قطاعى</option>
                                </select>
                                <button type="submit" class="button_search btn btn-md btn-warning"
                                    style="display: inline !important;width: 20% !important; float: left !important;">
                                    <i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="bill_details">
                @if (isset($outer_clients) && !$outer_clients->isEmpty())
                    <p class="alert alert-sm alert-success text-center">
                        عرض نتائج البحث
                    </p>
                    <table class="table table-condensed table-striped table-bordered text-center table-hover"
                        id="example-table">
                        <thead>
                            <tr>
                                <th class="text-center">الاسم</th>
                                <th class="text-center">الفئة</th>
                                <th class="text-center">تليفون</th>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">رقم ضريبى</th>
                                <th class="text-center">المحل</th>
                                <th class="text-center"> مديونية</th>
                                <th class="text-center" style="width: 20% !important;">تحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($outer_clients as $key => $outer_client)
                                <tr>
                                    <td>{{ $outer_client->client_name }}</td>
                                    <td>{{ $outer_client->client_category }}</td>
                                    <td dir="ltr">
                                        @if (!$outer_client->phones->isEmpty())
                                            {{ $outer_client->phones[0]->client_phone }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$outer_client->addresses->isEmpty())
                                            {{ $outer_client->addresses[0]->client_address }}
                                        @endif
                                    </td>
                                    <td>{{ $outer_client->tax_number }}</td>
                                    <td>{{ $outer_client->shop_name }}</td>
                                    <td>
                                        @if ($outer_client->prev_balance > 0)
                                            عليه
                                            {{ floatval($outer_client->prev_balance) }}
                                        @elseif($outer_client->prev_balance < 0)
                                            له
                                            {{ floatval(abs($outer_client->prev_balance)) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td style="width: 20% !important;">
                                        <a href="{{ route('client.outer_clients.show', $outer_client->id) }}"
                                            class="btn btn-sm btn-success" data-toggle="tooltip" title="عرض"
                                            data-placement="top"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('client.outer_clients.edit', $outer_client->id) }}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                            data-placement="top"><i class="fa fa-edit"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger delete_client"
                                            client_id="{{ $outer_client->id }}"
                                            client_name="{{ $outer_client->client_name }}" data-toggle="modal"
                                            href="#modaldemo9" title="delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" client="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف عميل</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('client.outer_clients.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متأكد من الحذف ?</p><br>
                        <input type="hidden" name="clientid" id="clientid">
                        <input class="form-control" name="clientname" id="clientname" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.delete_client').on('click', function() {
                var client_id = $(this).attr('client_id');
                var client_name = $(this).attr('client_name');
                $('.modal-body #clientid').val(client_id);
                $('.modal-body #clientname').val(client_name);
            });
        });
    </script>
@endsection
