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
                            <a class="btn pull-left btn-primary btn-sm"
                                href="{{ route('client.subcategories.create') }}"><i class="fa fa-plus"></i>
                                {{ __('sidebar.add-new-sub-category') }} </a>
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('sidebar.display-sub-categories') }}
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
                                    <th class="text-center">{{ __('subcategories.subcategory-name') }}</th>
                                    <th class="text-center"> {{ __('sidebar.main-category') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($sub_categories as $key => $category)
                                    <tr dir="ltr">
                                        <td>{{ ++$i }}</td>
                                        <td dir="ltr">{{ $category->sub_category_name }}</td>
                                        <td dir="ltr">{{ $category->category->category_name }}</td>
                                        <td>
                                            <a href="{{ route('client.subcategories.edit', $category->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                data-placement="top"><i class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_category"
                                                category_id="{{ $category->id }}"
                                                category_name="{{ $category->sub_category_name }}" data-toggle="modal"
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
            <div class="modal-dialog modal-dialog-centered" category="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف فئة</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.subcategories.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ؟</p>
                            <p> سيؤدى حذف هذه الفئة الفرعية الى حذف جميع المنتجات المتعلقة بها
                            </p>
                            <input type="hidden" name="categoryid" id="categoryid">
                            <input class="form-control" name="categoryname" id="categoryname" type="text" readonly>
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
        $('.delete_category').on('click', function() {
            var category_id = $(this).attr('category_id');
            var category_name = $(this).attr('category_name');
            $('.modal-body #categoryid').val(category_id);
            $('.modal-body #categoryname').val(category_name);
        });
    });
</script>
