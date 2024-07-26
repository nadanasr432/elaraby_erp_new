@extends('client.layouts.app-main')

@section('content')
    <div class="card">
        <div class="card-header control-column">
            <h3 class="pull-right alert alert-sm alert-success custom-font-size">
                @lang('main.menue_rooms')
            </h3>
        </div>
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
                    <div class="card-header pb-0 control-column">
                        <div id="example1_wrapper" class="col-lg-12 dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="dt-buttons btn-group">
                                <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                    aria-controls="example1" type="button">
                                    <a href="{{ route('rooms.export.excel') }}"
                                        style="color: inherit; text-decoration: none;">إكسيل</a>
                                </button>
                                <button class="btn btn-secondary buttons-print" type="button" onclick="window.print()">
                                    <span>طباعة</span>
                                </button>
                                <div class="btn-group">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>الحقول</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input column-checkbox" id="column1"
                                                data-column="1" data-table="rooms-table" checked>
                                            <label class="form-check-label"
                                                for="column1">{{ __('rooms.code') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input column-checkbox" id="column2"
                                                data-column="2" data-table="rooms-table" checked>
                                            <label class="form-check-label"
                                                for="column2">{{ __('rooms.rooms-description-ar') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input column-checkbox" id="column3"
                                                data-column="3" data-table="rooms-table" checked>
                                            <label class="form-check-label"
                                                for="column3">{{ __('rooms.rooms-description-en') }}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="example1_processing" class="dataTables_processing card" style="display: none;">
                                الرجاء الإنتظار جاري تحميل البيانات
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="col-lg-12 margin-tb">
                                <a class="btn pull-left btn-primary btn-sm custom-button-size" href="{{ route('rooms.create') }}"><i
                                        class="fa fa-plus"></i> {{ __('sidebar.add-new-file_rooms') }} </a>
                                {{-- <h5 class="pull-right alert alert-sm alert-success">{{ __('branches.show-all-branches') }}
                            </h5> --}}
                            </div>
                            <br>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover"
                                id="rooms-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('rooms.code') }}</th>
                                        <th class="text-center">{{ __('rooms.rooms-description-ar') }}</th>
                                        <th class="text-center">{{ __('rooms.rooms-description-en') }}</th>
                                        <th class="text-center control-column">{{ __('main.control') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($rooms as $place)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $place->code }}</td>
                                            <td>{{ $place->description_ar }}</td>
                                            <td>{{ $place->description_en }}</td>
                                            <td class="control-column">
                                                <a href="{{ route('rooms.edit', $place->id) }}"
                                                    class="btn btn-sm btn-info" data-toggle="tooltip"
                                                    title="{{ __('main.edit') }}" data-placement="top"><i
                                                        class="fa fa-edit"></i></a>
                                                <a class="modal-effect btn btn-sm btn-danger delete_rooms"
                                                    rooms_id="{{ $place->id }}"
                                                    rooms_name="{{ $place->name }}" data-toggle="modal"
                                                    href="#modaldemo9" title="delete"><i class="fa fa-trash"></i></a>
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
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header text-center">
                            <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                                {{ __('place.delete-rooms') }}
                            </h6>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('rooms.destroy', 'test') }}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                                <input type="hidden" name="roomsid" id="roomsid">
                                <input class="form-control" name="roomsname" id="roomsname" type="text"
                                    readonly>
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to show/hide columns based on checkbox status
            function updateTableColumns() {
                // Get all checkboxes
                $('.column-checkbox').each(function() {
                    // Get column index and table ID from data attributes
                    var columnIndex = $(this).data('column');
                    var tableId = $(this).data('table');
                    var isChecked = $(this).is(':checked');

                    // Show/hide the column
                    $(`#${tableId} th:nth-child(${columnIndex + 1})`).toggle(isChecked);
                    $(`#${tableId} td:nth-child(${columnIndex + 1})`).toggle(isChecked);
                });
            }

            // Initialize the table column visibility
            updateTableColumns();

            // Add event listener for checkbox changes
            $('.column-checkbox').change(function() {
                updateTableColumns();
            });
        });

        function printTable() {
            var printWindow = window.open('', '', 'height=600,width=800');
            var table = document.getElementById('rooms-table').cloneNode(true);

            // Remove the "Control" column
            var headerRow = table.querySelector('thead tr');
            var controlIndex = Array.from(headerRow.children).findIndex(th => th.textContent.trim() ===
                '{{ __('main.control') }}');
            if (controlIndex !== -1) {
                Array.from(table.querySelectorAll('tbody tr')).forEach(row => row.deleteCell(controlIndex));
                headerRow.deleteCell(controlIndex);
            }

            // Optional: Hide the buttons
            var buttons = document.querySelectorAll('.btn-group, .dt-buttons');
            buttons.forEach(button => button.style.display = 'none');

            // Optional: Add styles for printing
            var style = `
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                }
                body {
                    margin: 20px;
                }
            </style>
        `;
            printWindow.document.open();
        }
    </script>

    <style>
        @media print {

            .btn-group,
            .dt-buttons,
            .control-column {
                display: none !important;
            }

            body {
                margin: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
                text-align: center;
            }

            th {
                background-color: #f2f2f2;
            }
        }
         .custom-font-size {
            font-size: 16px !important;
        }

        .custom-button-size {
            width: 20%;
            font-size: 16px !important;
        }
    </style>
@endsection
