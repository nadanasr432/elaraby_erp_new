@extends('client.layouts.app-main')
<style>
.custom-title::before {
    content: "";  
    display: inline-block;
    width: 32px;
    height: 2px;
    background-color: #ec6880;
    align-self: flex-end;
    bottom: 4px;

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
                        <div class="col-lg-12 d-flex flex-wrap align-items-center justify-content-between">
                            <h5 style="white-space: nowrap" class="alert font-weight-bold m-0 d-flex
                            custom-title align-items-end">{{ __('sidebar.display-sub-categories') }}
                            </h5>
                            <a class="btn text-white px-2 py-1"style="background-color: #ec6880"
                                href="{{ route('client.subcategories.create') }}"><i class="fa fa-plus"></i>
                                {{ __('sidebar.add-new-sub-category') }} </a>
                            
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
                                        <td class="d-flex border-0 justify-content-center">
                                            

                                            <a class="modal-effect  delete_category"
                                                category_id="{{ $category->id }}"
                                                category_name="{{ $category->sub_category_name }}" data-toggle="modal"
                                                href="#modaldemo9" title="delete">
                                                <svg width="25" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.912 7.33301L18.111 20.95C18.0812 21.4594 17.8577 21.9381 17.4865 22.2881C17.1153 22.6382 16.6243 22.8331 16.114 22.833H8.886C8.37575 22.8331 7.88475 22.6382 7.5135 22.2881C7.14226 21.9381 6.91885 21.4594 6.889 20.95L6.09 7.33301H4V6.33301C4 6.2004 4.05268 6.07322 4.14645 5.97945C4.24021 5.88569 4.36739 5.83301 4.5 5.83301H20.5C20.6326 5.83301 20.7598 5.88569 20.8536 5.97945C20.9473 6.07322 21 6.2004 21 6.33301V7.33301H18.912ZM10.5 3.33301H14.5C14.6326 3.33301 14.7598 3.38569 14.8536 3.47945C14.9473 3.57322 15 3.7004 15 3.83301V4.83301H10V3.83301C10 3.7004 10.0527 3.57322 10.1464 3.47945C10.2402 3.38569 10.3674 3.33301 10.5 3.33301ZM9.5 9.83301L10 18.833H11.5L11.1 9.83301H9.5ZM14 9.83301L13.5 18.833H15L15.5 9.83301H14Z" fill="#F55549"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('client.subcategories.edit', $category->id) }}"
                                                class=" d-flex align-items-center" data-toggle="tooltip" title="تعديل"
                                                data-placement="top">
                                                <svg width="19" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                </svg>
                                            </a>
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
