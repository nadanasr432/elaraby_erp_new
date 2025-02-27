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
                        <h5  class=" alert custom-title">
                            {{ __('sidebar.list-of-users') }}</h5>
                        <a class="btn text-white px-3 py-1" style="background-color:#ec6880"" href="{{ route('client.clients.create') }}">
                            <i class="fa fa-plus"></i> {{ __('sidebar.add-new-user') }} </a>
                       
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
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.username') }}</th>
                                    <th class="wd-20p border-bottom-0 text-center">{{ __('main.email') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.status') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('branches.branche-name') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('main.permission') }}</th>
                                    <th class="wd-10p border-bottom-0 text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($data as $key => $client)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>
                                            @if ($client->Status == 'active')
                                                <span class="badge badge-success">
                                                    {{ __('main.active') }}
                                                </span>
                                            @elseif ($client->Status == 'blocked')
                                                <span class="badge badge-danger">
                                                    {{ __('main.deactive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($client->branch == '')
                                                غير محدد
                                            @else
                                                {{ $client->branch->branch_name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($client->getRoleNames()))
                                                @foreach ($client->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.clients.edit', $client->id) }}"
                                                class="btn " data-toggle="tooltip" title="تعديل"
                                                data-placement="top"><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                    </svg>
                                                    </a>
                                            @if (!in_array('مدير النظام', $client->role_name))
                                                <a class="modal-effect btn btn-sm btn-third delete_client"
                                                    client_id="{{ $client->id }}" email="{{ $client->email }}"
                                                    data-toggle="modal" href="#modaldemo8" title="delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
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

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('main.delete') }}</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.clients.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                            <input type="hidden" name="client_id" id="client_id" value="">
                            <input class="form-control" name="email" id="email" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('main.cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('main.delete') }}</button>
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
        $('.delete_client').on('click', function() {
            var client_id = $(this).attr('client_id');
            var email = $(this).attr('email');
            $('.modal-body #client_id').val(client_id);
            $('.modal-body #email').val(email);
        });
    });
</script>
