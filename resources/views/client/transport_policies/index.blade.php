@extends('client.layouts.app-main')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-lg-12 margin-tb d-flex flex-wrap align-items-center justify-content-between">
                        <h5 class=" alert custom-title">
                            {{ __('main.list-of-Transport_policies') }}</h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color:#36c7d6""
                            href="{{ route('transport-policies.create') }}">
                            <i class="fa fa-plus"></i> {{ __('main.add-new-policy') }} </a>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body p-1 m-1">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-striped table-bordered zero-configuration" id="example-table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0 text-center">#</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.client') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.charging_station') }}</th>
                                    <th class="wd-20p border-bottom-0 text-center">{{ __('main.discharging_station') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.driver') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.payload_type') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.vehicle_plate_number') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.vehicle_owner') }}</th>
                                    <th class="wd-10p border-bottom-0 text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($policies as $key => $policy)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $policy->outer_client->client_name ?? ' ' }}</td>
                                        <td>{{ $policy->chargingStation->country ?? ' '  }} - {{ $policy->chargingStation->region ?? ' '  }} - {{ $policy->chargingStation->city ?? ' '  }}</td>
                                        <td>{{ $policy->dischargingStation->country }} - {{ $policy->dischargingStation->region ?? ' '  }} - {{ $policy->dischargingStation->city ?? ' '  }}</td>
                                        <td>{{ $policy->driver->name ?? ' '  }}</td>
                                        <td>{{ $policy->shipment->payload_type ?? ' '  }}</td>
                                        <td>{{ $policy->vehicle->plate_number ?? ' '  }}</td>
                                        <td>{{ $policy->vehicleOwner->company_name ?? ' '  }}</td>
                                        <td>
                                            <a href="{{ route('transport-policies.edit', $policy->id) }}" class=" "
                                                data-toggle="tooltip" title="تعديل" data-placement="top"><svg
                                                    width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z"
                                                        fill="#4AA16A" />
                                                </svg>
                                            </a>
                                            <a class="modal-effect delete_policy" data-id="{{ $policy->id }}"
                                                data-name="{{ $policy->country }}" data-toggle="modal" href="#modaldemo9"
                                                title="{{ __('main.delete') }}">
                                                <svg width="17" height="20" viewBox="0 0 17 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.912 4.33301L14.111 17.95C14.0812 18.4594 13.8577 18.9381 13.4865 19.2881C13.1153 19.6382 12.6243 19.8331 12.114 19.833H4.886C4.37575 19.8331 3.88475 19.6382 3.5135 19.2881C3.14226 18.9381 2.91885 18.4594 2.889 17.95L2.09 4.33301H0V3.33301C0 3.2004 0.0526785 3.07322 0.146447 2.97945C0.240215 2.88569 0.367392 2.83301 0.5 2.83301H16.5C16.6326 2.83301 16.7598 2.88569 16.8536 2.97945C16.9473 3.07322 17 3.2004 17 3.33301V4.33301H14.912ZM6.5 0.333008H10.5C10.6326 0.333008 10.7598 0.385686 10.8536 0.479455C10.9473 0.573223 11 0.7004 11 0.833008V1.83301H6V0.833008C6 0.7004 6.05268 0.573223 6.14645 0.479455C6.24021 0.385686 6.36739 0.333008 6.5 0.333008ZM5.5 6.83301L6 15.833H7.5L7.1 6.83301H5.5ZM10 6.83301L9.5 15.833H11L11.5 6.83301H10Z"
                                                        fill="#F55549" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('transport-policies.print', $policy) }}" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-print"></i>  @lang('main.print')
                                            </a>

                                            <!-- Optional: Add this if you want it to auto-print when opened -->
                                            <!--<a href="{{ route('transport-policies.print', $policy) }}?autoprint=1" class="btn btn-sm btn-warning" target="_blank">-->
                                            <!--    <i class="fas fa-print"></i> طباعة تلقائية-->
                                            <!--</a>-->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" supplier="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">@lang('main.delete_policy')  </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="deleteForm" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="name" id="name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
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
        $('.delete_policy').click(function() {
            let policyId = $(this).data('id');
            let actionUrl = "{{ route('transport-policies.destroy', ':id') }}".replace(':id',
            policyId);

            $('#deleteForm').attr('action', actionUrl);
        });
    });
</script>
