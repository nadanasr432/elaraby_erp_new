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
    @if (session('error'))
        <div class="alert alert-danger text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('error') }}
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb  d-flex flex-wrap justify-content-between">
                            <h5 class=" alert custom-title ">{{ __('sidebar.list-of-client') }} </h5>
                            <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880"
                               href="{{ route('client.outer_clients.create') }}"><i class="fa fa-plus"></i>
                                {{ __('sidebar.add-new-client') }} 
                            </a>
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
                                <th class="text-center">{{ __('main.name') }}</th>
                                <th class="text-center">{{ __('main.user') }}</th>
                                <th class="text-center">{{ __('main.category') }}</th>
                                <th class="text-center">{{ __('main.phone') }}</th>
                                <th class="text-center">{{ __('main.address') }}</th>
                                <th class="text-center">{{ __('main.tax-number') }}</th>
                                <th class="text-center">{{ __('main.company') }}</th>
                                <th class="text-center"> {{ __('main.indebtedness') }}</th>
                                <th class="text-center" style="width: 20% !important;">{{ __('main.control') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($outer_clients as $key => $outer_client)
                                <tr>
                                    <td>{{ $outer_client->client_name }}</td>
                                    <td>
                                        @if (!empty($outer_client->client_id))
                                            {{ $outer_client->client->name }}
                                        @else
                                            كل المستخدمين
                                        @endif
                                    </td>
                                    <td>{{ $outer_client->client_category }}</td>
                                    <td dir="ltr" class="" >
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
                                            {{ __('main.from') }}
                                            {{ floatval($outer_client->prev_balance) }}
                                        @elseif($outer_client->prev_balance < 0)
                                            {{ __('main.to') }}
                                            {{ floatval(abs($outer_client->prev_balance)) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td class="d-flex  justify-content-center">
                                        @if($outer_client->client_name != "Cash")
                                            <a href="{{ route('client.outer_clients.show', $outer_client->id) }}"
                                               class=" " data-toggle="tooltip" title="عرض"
                                               data-placement="top">
                                               <svg  width="19" height="16" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                            </a>

                                            <a href="{{ route('client.outer_clients.edit', $outer_client->id) }}"
                                               class=" " data-toggle="tooltip" title="تعديل"
                                               data-placement="top">
                                               <svg width="19" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                </svg>
                                            </a>

                                            <a class="modal-effect   delete_client"
                                               client_id="{{ $outer_client->id }}"
                                               client_name="{{ $outer_client->client_name }}" data-toggle="modal"
                                               href="#modaldemo9" title="delete">
                                               <svg width="25" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.912 7.33301L18.111 20.95C18.0812 21.4594 17.8577 21.9381 17.4865 22.2881C17.1153 22.6382 16.6243 22.8331 16.114 22.833H8.886C8.37575 22.8331 7.88475 22.6382 7.5135 22.2881C7.14226 21.9381 6.91885 21.4594 6.889 20.95L6.09 7.33301H4V6.33301C4 6.2004 4.05268 6.07322 4.14645 5.97945C4.24021 5.88569 4.36739 5.83301 4.5 5.83301H20.5C20.6326 5.83301 20.7598 5.88569 20.8536 5.97945C20.9473 6.07322 21 6.2004 21 6.33301V7.33301H18.912ZM10.5 3.33301H14.5C14.6326 3.33301 14.7598 3.38569 14.8536 3.47945C14.9473 3.57322 15 3.7004 15 3.83301V4.83301H10V3.83301C10 3.7004 10.0527 3.57322 10.1464 3.47945C10.2402 3.38569 10.3674 3.33301 10.5 3.33301ZM9.5 9.83301L10 18.833H11.5L11.1 9.83301H9.5ZM14 9.83301L13.5 18.833H15L15.5 9.83301H14Z" fill="#F55549"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class=" bg-white d-flex flex-wrap justify-content-between align-items-center p-2 ">
                <p class="alert " dir="rtl">
                    {{ __('clients.total-clients-indebtedness') }} :
                    @if ($total_balances > 0)
                        {{ __('main.from') }}
                        {{ floatval($total_balances) }}
                    @elseif($total_balances < 0)
                        {{ __('main.to') }}
                        {{ floatval(abs($total_balances)) }}
                    @else
                        0
                    @endif
                </p>
        
                <a href="{{ route('client.outer_clients.print') }}" target="_blank" role="button"
                   class="btn-warning btn btnn btn-md px-3 py-1" dir="rtl">
                    <i class="fa fa-print"></i>
                    {{ __('clients.print-clients') }}
                </a>
            </div>

            <div class="clearfix"></div>
            <hr>
            <form class="d-inline bg-white d-flex flex-wrap justify-content-between align-items-center " action="{{ route('outer_clients.import') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="row w-100">
                    <div class="col-lg-12  p-3" >
                        <a href="javascript:;" class="text-danger open_box">
                            <i class="fa fa-plus"></i>
                            {{ __('clients.customer-import-instructions') }} :
                        </a>
                        <div class="box mt-2 mb-2" style="display: none;">
                            <ul>
                                <li>
                                    ان يكون الملف اكسيل فقط وامتداده .xlsx
                                </li>
                                <li>
                                    لا يحتوى على heading row او مايسمى صف عناوين الاعمدة
                                </li>
                                <li>
                                    تجنب وجود صفوف فارغة او خالية من البيانات قدر الامكان
                                </li>
                                <li>
                                    اول عمود مخصص لاسم العميل
                                </li>
                                <li>
                                    ثانى عمود مخصص لمستحقات العميل
                                </li>
                            </ul>
                            <p>
                                مرفق صورة توضيحية لشكل الملف من الداخل
                                <br>
                                <br>
                                <img style="width: 100%;border-radius: 5px; padding: 5px;border: 1px solid #000;"
                                     src="{{ asset('images/clients.png') }}" alt="">
                            </p>
                        </div>
                        {{-- <label class="d-block mt-2" for="">{{ __(key: 'main.import-data') }}</label> --}}
                        <input accept=".xlsx" required type="file" name="file" class="form-control col-lg-6">
                        <br>
                        <div class="col-lg-12 p-0 d-flex flex-wrap">
                            <button class="btn btnn btn-success mb-1 py-1 px-3 mx-1">{{ __('main.click-to-import') }}</button>

                            {{-- <label class="d-block" for="">{{ __('main.export-data') }}</label> --}}
                            <a class="btn btnn text-white mb-1 mx-1 py-1 px-3" style="background-color: #ec6880"
                               href="{{ route('outer_clients.export') }}">{{ __('main.click-to-export') }}</a>
                        </div>
                    </div>
                    
                </div>
            </form>
            <div class="clearfix"></div>
            <hr>

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
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.delete_client').on('click', function () {
            var client_id = $(this).attr('client_id');
            var client_name = $(this).attr('client_name');
            $('.modal-body #clientid').val(client_id);
            $('.modal-body #clientname').val(client_name);
        });

        $('.open_box').on('click', function () {
            $('.box').toggle();
        });
    });
</script>
