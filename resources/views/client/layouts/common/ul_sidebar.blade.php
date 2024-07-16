<style>
    .nav-item a svg {
        width: 18px;
        fill: white;
        position: relative;
        top: 5px;
    }


    .main-menu.menu-light .navigation > li.nav-item:hover {
        background: #ffffff42 !important;
    }
</style>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow no-print"
     style="background:#222751;padding-top: 35px;" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ Request::is('*home') ? 'active' : '' }}">
                <a href="{{ route('client.home') }}" style="padding-top: 14px;">
                    <i class="sidebar-item-icon fa fa-dashboard"></i>
                    <span class="menu-title text-center">
                        {{ __('sidebar.clients-dashboard') }}
                    </span>
                </a>
            </li>


            <!----------------------------------------products------------------------------------>
            @if (empty($package) || $package->products == '1')
                @if ($screen_settings->products == '1')
                    <li
                        class="nav-item {{ Request::is('*/branches*', '*/stores*', '*/categories*', '*/products*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z"/>
                            </svg>
                            <span class="menu-title">
                                {{ __('sidebar.stock') }}
                            </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/branches*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.branches') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة فرع جديد')
                                        <li class="{{ Request::is('*/branches/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.branches.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-branche') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة فروع الشركة')
                                        <li class="{{ Request::is('*/branches') ? 'active' : '' }}">
                                            <a href="{{ route('client.branches.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-company-branches') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item {{ Request::is('*/stores*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.storages') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة مخزن جديد')
                                        <li class="{{ Request::is('*/stores/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.stores.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-storage') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة مخازن الشركة')
                                        <li class="{{ Request::is('*/stores') ? 'active' : '' }}">
                                            <a href="{{ route('client.stores.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-company-storages') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/clients-stores-transfer-get') ? 'active' : '' }}">
                                            <a href="{{ route('client.stores.transfer.get') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.convert-between-storages') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/stores-inventory') ? 'active' : '' }}">
                                            <a href="{{ route('client.inventory.get') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.inventory-of-the-company-stores') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item {{ Request::is('*/categories*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.main-categories') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة فئة جديد')
                                        <li class="{{ Request::is('*/categories/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.categories.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-main-category') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة فئات الشركة')
                                        <li class="{{ Request::is('*/categories') ? 'active' : '' }}">
                                            <a href="{{ route('client.categories.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.display-main-categories') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item {{ Request::is('*/subcategories*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.sub-categories') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة فئة جديد')
                                        <li class="{{ Request::is('*/subcategories/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.subcategories.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>

                                                {{ __('sidebar.add-new-sub-category') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة فئات الشركة')
                                        <li class="{{ Request::is('*/subcategories') ? 'active' : '' }}">
                                            <a href="{{ route('client.subcategories.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>

                                                {{ __('sidebar.display-sub-categories') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item {{ Request::is('*/units*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.products-units') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة فئة جديد')
                                        <li class="{{ Request::is('*/units/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.units.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-unit') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة فئات الشركة')
                                        <li class="{{ Request::is('*/units') ? 'active' : '' }}">
                                            <a href="{{ route('client.units.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-products-units') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item {{ Request::is('*/products*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.products') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                  @can('قائمة المنتجات المتوفرة (عرض فقط)')
                                        <li class="{{ Request::is('*/products') ? 'active' : '' }}">
                                            <a href="{{ route('client.products.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('products.manage_products') }}
                                            </a>
                                        </li>
                                        @endcan
                                        @can('قائمة المنتجات المتوفرة (تحكم كامل)')
                                        <li class="{{ Request::is('*/generate-barcode') ? 'active' : '' }}">
                                            <a href="{{ route('barcode') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.print-product-barcode') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة المنتجات التى نفذت')
                                        <li class="{{ Request::is('*/clients-products-limited') ? 'active' : '' }}">
                                            <a href="{{ route('client.products.limited') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.products-are-almost-out-of-stock') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/clients-products-empty') ? 'active' : '' }}">
                                            <a href="{{ route('client.products.empty') }}" id="setProducts_viewed">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-products-sold-out') }}
                                                <span class="badge badge-danger" id="numOfProductsEnded"
                                                      style="position: absolute;display:none;margin-right:5px;border-radius: 50%;font-size: 12px !important;width: 20px;height:20px;font-weight: bold;"></span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة المنتجات التى نفذت')
                                        <li class="{{ Request::is('*/client.products.expires') ? 'active' : '' }}">
                                            <a href="{{ route('client.products.expires') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.products-are-expired') }}
                                                  <span class="badge badge-danger" id="numOfProductsExpired"
                                                      style="position: absolute;display:none;margin-right:5px;border-radius: 50%;font-size: 12px !important;width: 20px;height:20px;font-weight: bold;"></span>
                                           
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!----------------------------------------products------------------------------------>


            <!------------------------------------SALES SECTION------------------------------------>
            @if (empty($package) || $package->sales == '1')
                @if ($screen_settings->sales == '1')
                    <li class="nav-item {{ Request::is('*/quotations*', '*/sale_bills*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48H76.1l60.3 316.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H179.9l-9.1-48h317c14.3 0 26.9-9.5 30.8-23.3l54-192C578.3 52.3 563 32 541.8 32H122l-2.4-12.5C117.4 8.2 107.5 0 96 0H24zM176 512c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48zm336-48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM252 160c0-11 9-20 20-20h44V96c0-11 9-20 20-20s20 9 20 20v44h44c11 0 20 9 20 20s-9 20-20 20H356v44c0 11-9 20-20 20s-20-9-20-20V180H272c-11 0-20-9-20-20z"/>
                            </svg>
                            <span class="menu-title">
                                {{ __('sidebar.sales') }}
                            </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/sale_bills*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.sales-invoices') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                  @can('فواتير البيع السابقة (عرض فقط)')
                                        <li class="{{ Request::is('*/sale_bills') ? 'active' : '' }}">
                                            <a href="{{ route('client.sale_bills.index') }}">
                                                <svg style="width: 12px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                <span class="menu-title">
                                                    {{ __('sidebar.sales-invoices') }}
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('فواتير البيع السابقة (تحكم كامل)')
                                    <li
                                        class="nav-item {{ Request::is('*/pos-sales-report*') ? 'active open' : '' }}">
                                        <a href="{{ route('pos.sales.report') }}">
                                            <svg style="width: 12px;fill:lightgreen;"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                            </svg>
                                            <span class="menu-title">
                                                {{ __('sidebar.point-of-sale-reports') }}
                                            </span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('مرتجعات فواتير البيع عملاء')
                                        <li class="{{ Request::is('*/sale-bills/get-returns') ? 'active' : '' }}">
                                            <a href="{{ url('/client/sale-bills/get-returns') }}">
                                                <svg style="width: 12px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                <span class="menu-title">
                                                    {{ __('sidebar.returns-sales-invoices') }}
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item {{ Request::is('*/quotations/index') ? 'active open' : '' }}">
                                <a href="{{ route('client.quotations.index') }}">
                                    <svg style="width: 13px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path
                                            d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                                    </svg>
                                    <span class="menu-title">
                                        {{ __('sidebar.previous-quotes') }}
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item {{ Request::is('*/quotations*') ? 'active open' : '' }}">
                                <a href="{{ route('saleInvoices.updateInovicePolices') }}">
                                    <svg style="width: 13px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path
                                            d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                                    </svg>
                                    <span class="menu-title">
                                        {{ __('sidebar.policies') }}
                                    </span>
                                    <span class="badge badge-danger"
                                          style="padding: 7px 9px !important;">{{ __('sidebar.new') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!----------------------------------------SALES SECTION------------------------------------>


            <!----------------------------------------PURCHASES SECTION------------------------------------>
            @if (empty($package) || $package->purchases == '1')
                @if ($screen_settings->purchases == '1')
                    <li class="nav-item {{ Request::is('*/purchase_orders*', '*/buy_bills*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M168 336C181.3 336 192 346.7 192 360C192 373.3 181.3 384 168 384H120C106.7 384 96 373.3 96 360C96 346.7 106.7 336 120 336H168zM360 336C373.3 336 384 346.7 384 360C384 373.3 373.3 384 360 384H248C234.7 384 224 373.3 224 360C224 346.7 234.7 336 248 336H360zM512 32C547.3 32 576 60.65 576 96V416C576 451.3 547.3 480 512 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H512zM512 80H64C55.16 80 48 87.16 48 96V128H528V96C528 87.16 520.8 80 512 80zM528 224H48V416C48 424.8 55.16 432 64 432H512C520.8 432 528 424.8 528 416V224z"/>
                            </svg>
                            <span class="menu-title">
                                {{ __('sidebar.purchases') }}
                            </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/buy_bills*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.purchases-invoices') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة فاتورة مشتريات جديدة')
                                        <li class="{{ Request::is('*/buy_bills/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.buy_bills.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-purchase-invoice') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('فواتير المشتريات السابقة')
                                        <li class="{{ Request::is('*/buy_bills') ? 'active' : '' }}">
                                            <a href="{{ route('client.buy_bills.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.previous-purchases-invoices') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('مرتجعات فواتير المشتريات')
                                        <li class="{{ Request::is('*/buy-bills/get-returns') ? 'active' : '' }}">
                                            <a href="{{ url('/client/buy-bills/get-returns') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.returns-purchases-invoices') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="nav-item {{ Request::is('*/purchase_orders*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.purchase-orders') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    <li class="{{ Request::is('*/purchase_orders/create') ? 'active' : '' }}">
                                        <a href="{{ route('client.purchase_orders.create') }}">
                                            <svg style="width: 15px;fill:lightgreen;"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                            </svg>
                                            {{ __('sidebar.add-new-purchase-orders') }}
                                        </a>
                                    </li>
                                    <li class="{{ Request::is('*/purchase_orders') ? 'active' : '' }}">
                                        <a href="{{ route('client.purchase_orders.index') }}">
                                            <svg style="width: 15px;fill:lightgreen;"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                            </svg>
                                            {{ __('sidebar.display-previous-purchase-orders') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!----------------------------------------PURCHASES SECTION------------------------------------>

            <!----------------------------------------DEBTS SECTION------------------------------------>
            @if (empty($package) || $package->debt == '1')
                @if ($screen_settings->debt == '1')
                    <li class="nav-item {{ Request::is('*/outer_clients*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path
                                    d="M416 176c0 97.2-93.1 176-208 176c-38.2 0-73.9-8.7-104.7-23.9c-7.5 4-16 7.9-25.2 11.4C59.8 346.4 37.8 352 16 352c-6.9 0-13.1-4.5-15.2-11.1s.2-13.8 5.8-17.9l0 0 0 0 .2-.2c.2-.2 .6-.4 1.1-.8c1-.8 2.5-2 4.3-3.7c3.6-3.3 8.5-8.1 13.3-14.3c5.5-7 10.7-15.4 14.2-24.7C14.7 250.3 0 214.6 0 176C0 78.8 93.1 0 208 0S416 78.8 416 176zM231.5 383C348.9 372.9 448 288.3 448 176c0-5.2-.2-10.4-.6-15.5C555.1 167.1 640 243.2 640 336c0 38.6-14.7 74.3-39.6 103.4c3.5 9.4 8.7 17.7 14.2 24.7c4.8 6.2 9.7 11 13.3 14.3c1.8 1.6 3.3 2.9 4.3 3.7c.5 .4 .9 .7 1.1 .8l.2 .2 0 0 0 0c5.6 4.1 7.9 11.3 5.8 17.9c-2.1 6.6-8.3 11.1-15.2 11.1c-21.8 0-43.8-5.6-62.1-12.5c-9.2-3.5-17.8-7.4-25.2-11.4C505.9 503.3 470.2 512 432 512c-95.6 0-176.2-54.6-200.5-129zM228 72c0-11-9-20-20-20s-20 9-20 20V86c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V280c0 11 9 20 20 20s20-9 20-20V266.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V72z"/>
                            </svg>
                            <span class="menu-title">
                                {{ __('sidebar.debts') }}
                            </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/outer_clients*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.clients') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة عميل جديد')
                                        <li class="{{ Request::is('*/outer_clients/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.outer_clients.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-client') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة العملاء الحاليين')
                                        <li class="{{ Request::is('*/outer_clients') ? 'active' : '' }}">
                                            <a href="{{ route('client.outer_clients.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-client') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('فلترة العملاء ( بحث متقدم )')
                                        <li class="{{ Request::is('*/clients-outer-clients-filter') ? 'active' : '' }}">
                                            <a href="{{ route('client.outer_clients.filter') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.clients-filter') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="nav-item {{ Request::is('*client/suppliers/index*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                        {{ __('sidebar.suppliers') }}
                                    </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة مورد جديد')
                                        <li class="{{ Request::is('*/suppliers/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.suppliers.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-supplier') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة الموردين الحاليين')
                                        <li class="{{ Request::is('*/suppliers') ? 'active' : '' }}">
                                            <a href="{{ route('client.suppliers.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-suppliers') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('فلترة الموردين ( بحث متقدم )')

                                        <li class="{{ Request::is('*/clients-suppliers-filter') ? 'active' : '' }}">
                                            <a href="{{ route('client.suppliers.filter') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.suppliers-filter') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!----------------------------------------DEBTS SECTION------------------------------------>

            <!----------------------------------------BONDS SECTION------------------------------------>
            <li class="nav-item {{ Request::is('*/bonds/*') ? 'active open' : '' }}">
                <a href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M470.7 9.4c3 3.1 5.3 6.6 6.9 10.3s2.4 7.8 2.4 12.2l0 .1v0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3L310.6 214.6c-11.8 11.8-30.8 12.6-43.5 1.7L176 138.1 84.8 216.3c-13.4 11.5-33.6 9.9-45.1-3.5s-9.9-33.6 3.5-45.1l112-96c12-10.3 29.7-10.3 41.7 0l89.5 76.7L370.7 64H352c-17.7 0-32-14.3-32-32s14.3-32 32-32h96 0c8.8 0 16.8 3.6 22.6 9.3l.1 .1zM0 304c0-26.5 21.5-48 48-48H464c26.5 0 48 21.5 48 48V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V304zM48 416v48H96c0-26.5-21.5-48-48-48zM96 304H48v48c26.5 0 48-21.5 48-48zM464 416c-26.5 0-48 21.5-48 48h48V416zM416 304c0 26.5 21.5 48 48 48V304H416zm-96 80c0-35.3-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64s64-28.7 64-64z"/>
                    </svg>
                    <span class="menu-title">
                        {{ __('sidebar.Bonds') }}
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item {{ Request::is('*/clients-bonds/*') ? 'active open' : '' }}">
                    <li class="{{ Request::is('*/clients-bonds/*') ? 'active' : '' }}">
                        <a href="{{ route('client.bonds.index') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('sidebar.bonds_for_clients') }}
                        </a>
                    </li>
                    </li>
                    <li class="nav-item">
                    <li class="{{ Request::is('*client/suppliers-bonds/index*') ? 'active open' : '' }}">
                        <a href="{{ route('supplier.bonds.index') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('sidebar.bonds_for_suppliers') }}
                        </a>
                    </li>
                    </li>

                    <li class="nav-item">
                    <li class="{{ Request::is('*client/electronic-stamp/index*') ? 'active open' : '' }}">
                        <a href="{{ route('electronic-stamp') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('sidebar.electronic-stamp') }}
                        </a>
                    </li>
                    </li>
                </ul>
            </li>
            <!----------------------------------------BONDS SECTION------------------------------------>


            <!----------------------------------------Banks SECTION------------------------------------>
            @if (empty($package) || $package->banks_safes == '1')
                @if ($screen_settings->banks_safes == '1')
                    <li class="nav-item {{ Request::is('*/banks*', '*/safes*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8.1-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zm128-96c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/>
                            </svg>
                            <span class="menu-title">
                            {{ __('sidebar.banks-and-stores') }}
                        </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/safes*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                    {{ __('sidebar.stores') }}
                                </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة خزينة جديد')
                                        <li class="{{ Request::is('*/safes/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.safes.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-store') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة خزائن الشركة')
                                        <li class="{{ Request::is('*/safes') ? 'active' : '' }}">
                                            <a href="{{ route('client.safes.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-stores') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/safes-transfer') ? 'active' : '' }}">
                                            <a href="{{ route('client.safes.transfer') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.transfer-between-stores') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="nav-item {{ Request::is('*/banks*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                    {{ __('sidebar.banks') }}
                                </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة بنك جديد')
                                        <li class="{{ Request::is('*/banks/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.banks.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-bank') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمة البنوك الحاليين')
                                        <li class="{{ Request::is('*/banks') ? 'active' : '' }}">
                                            <a href="{{ route('client.banks.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.list-of-banks') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('سحب وايداع نقدى')
                                        <li class="{{ Request::is('*/clients-banks-process') ? 'active' : '' }}">
                                            <a href="{{ route('client.banks.process') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.cash-withdraw-and-deposit') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('تحويل بين البنوك')
                                        <li class="{{ Request::is('*/clients-banks-transfer') ? 'active' : '' }}">
                                            <a href="{{ route('client.banks.transfer') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.transfer-between-banks') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/clients-bank-safe-transfer') ? 'active' : '' }}">
                                            <a href="{{ route('client.bank.safe.transfer') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.transfer-between-bank-to-store') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/clients-safe-bank-transfer') ? 'active' : '' }}">
                                            <a href="{{ route('client.safe.bank.transfer') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.transfer-between-store-to-bank') }}
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!----------------------------------------Banks SECTION------------------------------------>


            <!------------------------------------------coupons section------------------------------------------>
            <li class="nav-item {{ Request::is('*/coupons*') ? 'active open' : '' }}">
                <a href="javascript:;">
                    <i class="fa fa-list"></i>
                    <span class="menu-title">
                    {{ __('sidebar.discount-coupon-list') }}
                </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/coupons/create') ? 'active' : '' }}">
                        <a href="{{ route('client.coupons.create') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('sidebar.add-new-coupon') }}
                        </a>
                    </li>
                    <li class="{{ Request::is('*/coupons') ? 'active' : '' }}">
                        <a href="{{ route('client.coupons.index') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('sidebar.coupons-offer') }}
                        </a>
                    </li>
                </ul>
            </li>
            <!------------------------------------------coupons section end------------------------------------------>


            <!------------------------------------------FINANCE SECTION------------------------------------------>
            @if (empty($package) || $package->finance == '1')
                @if ($screen_settings->finance == '1')
                    <li class="nav-item {{ Request::is('*/expenses*', '*/cash*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M512 80c0 18-14.3 34.6-38.4 48c-29.1 16.1-72.5 27.5-122.3 30.9c-3.7-1.8-7.4-3.5-11.3-5C300.6 137.4 248.2 128 192 128c-8.3 0-16.4 .2-24.5 .6l-1.1-.6C142.3 114.6 128 98 128 80c0-44.2 86-80 192-80S512 35.8 512 80zM160.7 161.1c10.2-.7 20.7-1.1 31.3-1.1c62.2 0 117.4 12.3 152.5 31.4C369.3 204.9 384 221.7 384 240c0 4-.7 7.9-2.1 11.7c-4.6 13.2-17 25.3-35 35.5c0 0 0 0 0 0c-.1 .1-.3 .1-.4 .2l0 0 0 0c-.3 .2-.6 .3-.9 .5c-35 19.4-90.8 32-153.6 32c-59.6 0-112.9-11.3-148.2-29.1c-1.9-.9-3.7-1.9-5.5-2.9C14.3 274.6 0 258 0 240c0-34.8 53.4-64.5 128-75.4c10.5-1.5 21.4-2.7 32.7-3.5zM416 240c0-21.9-10.6-39.9-24.1-53.4c28.3-4.4 54.2-11.4 76.2-20.5c16.3-6.8 31.5-15.2 43.9-25.5V176c0 19.3-16.5 37.1-43.8 50.9c-14.6 7.4-32.4 13.7-52.4 18.5c.1-1.8 .2-3.5 .2-5.3zm-32 96c0 18-14.3 34.6-38.4 48c-1.8 1-3.6 1.9-5.5 2.9C304.9 404.7 251.6 416 192 416c-62.8 0-118.6-12.6-153.6-32C14.3 370.6 0 354 0 336V300.6c12.5 10.3 27.6 18.7 43.9 25.5C83.4 342.6 135.8 352 192 352s108.6-9.4 148.1-25.9c7.8-3.2 15.3-6.9 22.4-10.9c6.1-3.4 11.8-7.2 17.2-11.2c1.5-1.1 2.9-2.3 4.3-3.4V304v5.7V336zm32 0V304 278.1c19-4.2 36.5-9.5 52.1-16c16.3-6.8 31.5-15.2 43.9-25.5V272c0 10.5-5 21-14.9 30.9c-16.3 16.3-45 29.7-81.3 38.4c.1-1.7 .2-3.5 .2-5.3zM192 448c56.2 0 108.6-9.4 148.1-25.9c16.3-6.8 31.5-15.2 43.9-25.5V432c0 44.2-86 80-192 80S0 476.2 0 432V396.6c12.5 10.3 27.6 18.7 43.9 25.5C83.4 438.6 135.8 448 192 448z"/>
                            </svg>
                            <span class="menu-title">
                            {{ __('sidebar.finance') }}
                        </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/expenses*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                    {{ __('sidebar.expenses') }}
                                </span>
                                </a>
                                <ul class="menu-content">
                                    @can('المصاريف الثابتة')
                                        <li class="{{ Request::is('*/clients-expenses-fixed*') ? 'active' : '' }}">
                                            <a href="{{ route('client.fixed.expenses') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.static-expenses') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('تسجيل مصاريف جديدة')
                                        <li class="{{ Request::is('*/expenses/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.expenses.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-expenses') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('عرض المصاريف')
                                        <li class="{{ Request::is('*/expenses') ? 'active' : '' }}">
                                            <a href="{{ route('client.expenses.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.display-expenses') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li
                                class="{{ Request::is('*/clients-add-cash-clients*', '*/clients-add-cash-suppliers*') ? 'active open' : '' }}">
                                <a class="menu-item" href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    {{ __('sidebar.register-cash-payment') }}
                                </a>
                                <ul class="menu-content">
                                    @can('استلام نقدية من عميل')
                                        <li class="{{ Request::is('*/clients-add-cash-clients*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.add.cash.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.receive-cash-from-client') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/clients-give-cash-clients*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.give.cash.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.giving-an-advance-to-a-client') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('دفع نقدى الى مورد')
                                        <li class="{{ Request::is('*/clients-add-cash-suppliers*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.add.cash.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.cash-to-supplier') }}
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('*/clients-give-cash-suppliers*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.give.cash.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.get-an-advance-from-a-supplier') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li
                                class="{{ Request::is('*/clients-add-cashbank-clients*', '*/clients-add-cashbank-suppliers*') ? 'active open' : '' }}">
                                <a class="menu-item" href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    {{ __('sidebar.register-bank-payment') }}
                                </a>
                                <ul class="menu-content">
                                    @can('استلام نقدية من عميل')
                                        <li class="{{ Request::is('*/clients-add-cashbank-clients*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.add.cashbank.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.bank-payment-from-client') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('دفع نقدى الى مورد')
                                        <li class="{{ Request::is('*/clients-add-cashbank-suppliers*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.add.cashbank.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.bank-payment-to-supplier') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="{{ Request::is('*/capitals*') ? 'active open' : '' }}">
                                <a class="menu-item" href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    {{ __('sidebar.capital-management') }}
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة مبلغ راس مال')
                                        <li class="{{ Request::is('*/capitals/create*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.capitals.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-capital-management') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('مبالغ راس المال المضافة')
                                        <li class="{{ Request::is('*/capitals') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.capitals.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.added-capital-amounts') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="{{ Request::is('*/cash*') ? 'active open' : '' }}">
                                <a class="menu-item" href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    {{ __('sidebar.previous-cash-payments') }}
                                </a>
                                <ul class="menu-content">
                                    @can('دفعات نقدية من العملاء')
                                        <li class="{{ Request::is('*/clients-cash-clients*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.cash.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.cash-payment-from-client') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('دفعات نقدية الى الموردين')
                                        <li class="{{ Request::is('*/clients-cash-suppliers*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.cash.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.cash-payment-to-supplier') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="{{ Request::is('*/cash*') ? 'active open' : '' }}">
                                <a class="menu-item" href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    {{ __('sidebar.previous-advances') }}
                                </a>
                                <ul class="menu-content">
                                    @can('دفعات نقدية من العملاء')
                                        <li class="{{ Request::is('*/clients-borrow-clients*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.borrow.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.advances-to-clients') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('دفعات نقدية الى الموردين')
                                        <li class="{{ Request::is('*/clients-borrow-suppliers*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.borrow.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.advances-from-supplier') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="{{ Request::is('*/cash*') ? 'active open' : '' }}">
                                <a class="menu-item" href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    دفعات بنكية سابقة
                                </a>
                                <ul class="menu-content">
                                    @can('دفعات نقدية من العملاء')
                                        <li class="{{ Request::is('*/clients-cashbank-clients*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.cashbank.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                دفعات بنكية من العملاء
                                            </a>
                                        </li>
                                    @endcan
                                    @can('دفعات نقدية الى الموردين')
                                        <li class="{{ Request::is('*/clients-cashbank-suppliers*') ? 'active' : '' }}">
                                            <a class="menu-item" href="{{ route('client.cashbank.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                دفعات بنكية الى الموردين
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!------------------------------------------FINANCE SECTION------------------------------------------>


            <!---------------------------------marketing section--------------------------------->
            @if (empty($package) || $package->marketing == '1')
                @if ($screen_settings->marketing == '1')
                    <li class="nav-item {{ Request::is('*/gifts*', '*/emails*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM229.5 173.3l72 144c5.9 11.9 1.1 26.3-10.7 32.2s-26.3 1.1-32.2-10.7L253.2 328H162.8l-5.4 10.7c-5.9 11.9-20.3 16.7-32.2 10.7s-16.7-20.3-10.7-32.2l72-144c4.1-8.1 12.4-13.3 21.5-13.3s17.4 5.1 21.5 13.3zM208 237.7L186.8 280h42.3L208 237.7zM392 256c-13.3 0-24 10.7-24 24s10.7 24 24 24s24-10.7 24-24s-10.7-24-24-24zm24-43.9V184c0-13.3 10.7-24 24-24s24 10.7 24 24v96 48c0 13.3-10.7 24-24 24c-6.6 0-12.6-2.7-17-7c-9.4 4.5-19.9 7-31 7c-39.8 0-72-32.2-72-72s32.2-72 72-72c8.4 0 16.5 1.4 24 4.1z"/>
                            </svg>
                            <span class="menu-title">
                            {{ __('sidebar.marketing') }}
                        </span>
                        </a>
                        <ul class="menu-content">
                            <li class="nav-item {{ Request::is('*/gifts*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                    {{ __('sidebar.special-customer-gifts') }}
                                </span>
                                </a>
                                <ul class="menu-content">
                                    @can('اضافة هدية جديد')
                                        <li class="{{ Request::is('*/gifts/create') ? 'active' : '' }}">
                                            <a href="{{ route('client.gifts.create') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.add-new-gift') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('عرض هدايا العملاء')
                                        <li class="{{ Request::is('*/gifts') ? 'active' : '' }}">
                                            <a href="{{ route('client.gifts.index') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.display-clients-gifts') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="nav-item {{ Request::is('*/emails*') ? 'active open' : '' }}">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-success tx-20"></i>
                                    <span class="menu-title">
                                    {{ __('sidebar.emails-section') }}
                                </span>
                                </a>
                                <ul class="menu-content">
                                    @can('ارسال ايميل الى عميل')
                                        <li class="{{ Request::is('*/clients-emails-clients') ? 'active' : '' }}">
                                            <a href="{{ route('client.emails.clients') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.send-mail-to-client') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ارسال ايميل الى مورد')
                                        <li class="{{ Request::is('*/clients-emails-suppliers') ? 'active' : '' }}">
                                            <a href="{{ route('client.emails.suppliers') }}">
                                                <svg style="width: 15px;fill:lightgreen;"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 512 512">
                                                    <path
                                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                                </svg>
                                                {{ __('sidebar.send-mail-to-supplier') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        <!---------------------------------marketing section--------------------------------->


            <!---------------------------------assets section--------------------------------->
            <li class="nav-item {{ Request::is('*/assets*') ? 'active open' : '' }}">
                <a href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M8 266.44C10.3 130.64 105.4 34 221.8 18.34c138.8-18.6 255.6 75.8 278 201.1 21.3 118.8-44 230-151.6 274-9.3 3.8-14.4 1.7-18-7.7q-26.7-69.45-53.4-139c-3.1-8.1-1-13.2 7-16.8 24.2-11 39.3-29.4 43.3-55.8a71.47 71.47 0 0 0-64.5-82.2c-39-3.4-71.8 23.7-77.5 59.7-5.2 33 11.1 63.7 41.9 77.7 9.6 4.4 11.5 8.6 7.8 18.4q-26.85 69.9-53.7 139.9c-2.6 6.9-8.3 9.3-15.5 6.5-52.6-20.3-101.4-61-130.8-119-24.9-49.2-25.2-87.7-26.8-108.7zm20.9-1.9c.4 6.6.6 14.3 1.3 22.1 6.3 71.9 49.6 143.5 131 183.1 3.2 1.5 4.4.8 5.6-2.3q22.35-58.65 45-117.3c1.3-3.3.6-4.8-2.4-6.7-31.6-19.9-47.3-48.5-45.6-86 1-21.6 9.3-40.5 23.8-56.3 30-32.7 77-39.8 115.5-17.6a91.64 91.64 0 0 1 45.2 90.4c-3.6 30.6-19.3 53.9-45.7 69.8-2.7 1.6-3.5 2.9-2.3 6q22.8 58.8 45.2 117.7c1.2 3.1 2.4 3.8 5.6 2.3 35.5-16.6 65.2-40.3 88.1-72 34.8-48.2 49.1-101.9 42.3-161-13.7-117.5-119.4-214.8-255.5-198-106.1 13-195.3 102.5-197.1 225.8z"/>
                    </svg>
                    <span class="menu-title">
                    {{ __('main.assets') }}
                </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/assets/fixed-assets/index') ? 'active' : '' }}">
                        <a href="{{ route('fixed.assets.index') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('main.fixed_assets') }}
                        </a>
                    </li>
                    <li class="{{ Request::is('*/assets/depreciations/index') ? 'active' : '' }}">
                        <a href="{{ route('client.depreciations.index') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('main.lost_assets') }}
                        </a>
                    </li>
                </ul>
            </li>
            <!---------------------------------assets section--------------------------------->


            <!---------------------------------voucher section--------------------------------->
            <li class="nav-item {{ Request::is('*/voucher*') ? 'active open' : '' }}">
                <a href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M298.93,267a48.4,48.4,0,0,0-24.36-6.21q-19.83,0-33.44,13.27t-13.61,33.42q0,21.16,13.28,34.6t33.43,13.44q20.5,0,34.11-13.78T322,307.47A47.13,47.13,0,0,0,315.9,284,44.13,44.13,0,0,0,298.93,267ZM0,32V480H448V32ZM374.71,405.26h-53.1V381.37h-.67q-15.79,26.2-55.78,26.2-27.56,0-48.89-13.1a88.29,88.29,0,0,1-32.94-35.77q-11.6-22.68-11.59-50.89,0-27.56,11.76-50.22a89.9,89.9,0,0,1,32.93-35.78q21.18-13.09,47.72-13.1a80.87,80.87,0,0,1,29.74,5.21q13.28,5.21,25,17V153l55.79-12.09Z"/>
                    </svg>
                    <span class="menu-title">
                    {{ __('main.voucher_entry') }}
                </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/voucher/create') ? 'active' : '' }}">
                        <a href="{{ route('client.voucher.create') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>

                            {{ __('main.add_voucher_entry') }}
                        </a>
                    </li>
                    <li class="{{ Request::is('*/voucher/get') ? 'active' : '' }}">
                        <a href="{{ route('client.voucher.get') }}">
                            <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                            </svg>
                            {{ __('main.view_voucher_entry') }}

                        </a>
                    </li>
                </ul>
            </li>
            <!---------------------------------voucher section--------------------------------->

            <!---------------------------------accounting section--------------------------------->

            <li class="nav-item {{ Request::is('*/accounting*', '*/cost_center*') ? 'active open' : '' }}">
                <a href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M456 32h-304C121.1 32 96 57.13 96 88v320c0 13.22-10.77 24-24 24S48 421.2 48 408V112c0-13.25-10.75-24-24-24S0 98.75 0 112v296C0 447.7 32.3 480 72 480h352c48.53 0 88-39.47 88-88v-304C512 57.13 486.9 32 456 32zM464 392c0 22.06-17.94 40-40 40H139.9C142.5 424.5 144 416.4 144 408v-320c0-4.406 3.594-8 8-8h304c4.406 0 8 3.594 8 8V392zM264 272h-64C186.8 272 176 282.8 176 296S186.8 320 200 320h64C277.3 320 288 309.3 288 296S277.3 272 264 272zM408 272h-64C330.8 272 320 282.8 320 296S330.8 320 344 320h64c13.25 0 24-10.75 24-24S421.3 272 408 272zM264 352h-64c-13.25 0-24 10.75-24 24s10.75 24 24 24h64c13.25 0 24-10.75 24-24S277.3 352 264 352zM408 352h-64C330.8 352 320 362.8 320 376s10.75 24 24 24h64c13.25 0 24-10.75 24-24S421.3 352 408 352zM400 112h-192c-17.67 0-32 14.33-32 32v64c0 17.67 14.33 32 32 32h192c17.67 0 32-14.33 32-32v-64C432 126.3 417.7 112 400 112z"/>
                    </svg>
                    <span class="menu-title">
                    {{ __('sidebar.accounting') }} 
                    {{-- <small
                            style="
        color: #e64874;
    ">(تحت الانشاء)</small> --}}
                </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item {{ Request::is('*/accounting_tree*') ? 'active open' : '' }}">
                        <a href="{{ url('/client/accounting_tree') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M456 32h-304C121.1 32 96 57.13 96 88v320c0 13.22-10.77 24-24 24S48 421.2 48 408V112c0-13.25-10.75-24-24-24S0 98.75 0 112v296C0 447.7 32.3 480 72 480h352c48.53 0 88-39.47 88-88v-304C512 57.13 486.9 32 456 32zM464 392c0 22.06-17.94 40-40 40H139.9C142.5 424.5 144 416.4 144 408v-320c0-4.406 3.594-8 8-8h304c4.406 0 8 3.594 8 8V392zM264 272h-64C186.8 272 176 282.8 176 296S186.8 320 200 320h64C277.3 320 288 309.3 288 296S277.3 272 264 272zM408 272h-64C330.8 272 320 282.8 320 296S330.8 320 344 320h64c13.25 0 24-10.75 24-24S421.3 272 408 272zM264 352h-64c-13.25 0-24 10.75-24 24s10.75 24 24 24h64c13.25 0 24-10.75 24-24S277.3 352 264 352zM408 352h-64C330.8 352 320 362.8 320 376s10.75 24 24 24h64c13.25 0 24-10.75 24-24S421.3 352 408 352zM400 112h-192c-17.67 0-32 14.33-32 32v64c0 17.67 14.33 32 32 32h192c17.67 0 32-14.33 32-32v-64C432 126.3 417.7 112 400 112z"/>
                            </svg>
                            <span class="menu-title">
                            {{ __('sidebar.accounting_tree') }}
                        </span>
                        </a>
                    </li>
                    <!---------------------------------Cost Center section--------------------------------->
                    <li class="nav-item {{ Request::is('*/cost_center*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path
                                    d="M298.93,267a48.4,48.4,0,0,0-24.36-6.21q-19.83,0-33.44,13.27t-13.61,33.42q0,21.16,13.28,34.6t33.43,13.44q20.5,0,34.11-13.78T322,307.47A47.13,47.13,0,0,0,315.9,284,44.13,44.13,0,0,0,298.93,267ZM0,32V480H448V32ZM374.71,405.26h-53.1V381.37h-.67q-15.79,26.2-55.78,26.2-27.56,0-48.89-13.1a88.29,88.29,0,0,1-32.94-35.77q-11.6-22.68-11.59-50.89,0-27.56,11.76-50.22a89.9,89.9,0,0,1,32.93-35.78q21.18-13.09,47.72-13.1a80.87,80.87,0,0,1,29.74,5.21q13.28,5.21,25,17V153l55.79-12.09Z"/>
                            </svg>
                            <span class="menu-title">
                            {{ __('main.cost_center') }}
                        </span>
                        </a>
                        <ul class="menu-content">
                            <li class="{{ Request::is('*/cost_center/create') ? 'active' : '' }}">
                                <a href="{{ route('client.cost_center.create') }}">
                                    <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path
                                            d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                    </svg>

                                    {{ __('main.add_cost_center') }}
                                </a>
                            </li>
                            <li class="{{ Request::is('*/cost_center/get') ? 'active' : '' }}">
                                <a href="{{ route('client.cost_center.get') }}">
                                    <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path
                                            d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                    </svg>
                                    {{ __('main.view_cost_center') }}

                                </a>
                            </li>
                        </ul>
                    </li>
                    <!---------------------------------Cost Center section--------------------------------->


                </ul>
            </li>

            <!---------------------------------accounting section--------------------------------->
            @if (empty($package) || $package->accounting == '1')
                @if ($screen_settings->accounting == '1')
                    @can('دفتر اليومية')
                        <li class="nav-item {{ Request::is('*/daily/get*') ? 'active open' : '' }}">
                            <a href="{{ url('/client/daily/get') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M456 32h-304C121.1 32 96 57.13 96 88v320c0 13.22-10.77 24-24 24S48 421.2 48 408V112c0-13.25-10.75-24-24-24S0 98.75 0 112v296C0 447.7 32.3 480 72 480h352c48.53 0 88-39.47 88-88v-304C512 57.13 486.9 32 456 32zM464 392c0 22.06-17.94 40-40 40H139.9C142.5 424.5 144 416.4 144 408v-320c0-4.406 3.594-8 8-8h304c4.406 0 8 3.594 8 8V392zM264 272h-64C186.8 272 176 282.8 176 296S186.8 320 200 320h64C277.3 320 288 309.3 288 296S277.3 272 264 272zM408 272h-64C330.8 272 320 282.8 320 296S330.8 320 344 320h64c13.25 0 24-10.75 24-24S421.3 272 408 272zM264 352h-64c-13.25 0-24 10.75-24 24s10.75 24 24 24h64c13.25 0 24-10.75 24-24S277.3 352 264 352zM408 352h-64C330.8 352 320 362.8 320 376s10.75 24 24 24h64c13.25 0 24-10.75 24-24S421.3 352 408 352zM400 112h-192c-17.67 0-32 14.33-32 32v64c0 17.67 14.33 32 32 32h192c17.67 0 32-14.33 32-32v-64C432 126.3 417.7 112 400 112z"/>
                                </svg>
                                <span class="menu-title">
                                {{ __('sidebar.voucher') }}
                            </span>
                            </a>
                        </li>
                    @endcan
                @endif
            @endif
        <!---------------------------------accounting section--------------------------------->


            <!---------------------------------reports section--------------------------------->
            @if (empty($package) || $package->reports == '1')
                @if ($screen_settings->reports == '1')
                    @can('تقارير عامة')
                        <li class="nav-item {{ Request::is('*/report*') ? 'active' : '' }}">
                            <a href="{{ route('client.reports') }}">
                                <svg style="width:14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path
                                        d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                                </svg>
                                <span class="menu-title text-center">
                                {{ __('sidebar.public-reports') }}
                            </span>
                            </a>
                        </li>
                    @endcan
                @endif
            @endif
        <!---------------------------------reports section--------------------------------->



            @if (empty($package) || $package->settings == '1')
                @if ($screen_settings->settings == '1')
                    @can('صلاحيات المستخدمين')
                        <li class="nav-item {{ Request::is('*/employees*', '*/roles*') ? 'active open' : '' }}">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path
                                        d="M144 160c-44.2 0-80-35.8-80-80S99.8 0 144 0s80 35.8 80 80s-35.8 80-80 80zm368 0c-44.2 0-80-35.8-80-80s35.8-80 80-80s80 35.8 80 80s-35.8 80-80 80zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM416 224c0 53-43 96-96 96s-96-43-96-96s43-96 96-96s96 43 96 96zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/>
                                </svg>
                                <span class="menu-title">
                                {{ __('sidebar.employees') }}
                            </span>
                            </a>
                            <ul class="menu-content">
                                <li class="{{ Request::is('*/employees/create') ? 'active' : '' }}">
                                    <a href="{{ route('client.employees.create') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.add-new-employee') }}
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/employees') ? 'active' : '' }}">
                                    <a href="{{ route('client.employees.index') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.list-of-current-employees') }}
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/employees-cash') ? 'active' : '' }}">
                                    <a href="{{ route('employees.get.cash') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.add-cash-to-employee') }}
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/employees-cashs') ? 'active' : '' }}">
                                    <a href="{{ route('employees.cashs') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.employees-payments') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
            @endif
            @if (empty($package) || $package->settings == '1')
                @if ($screen_settings->settings == '1')
                    @can('صلاحيات المستخدمين')
                        <li class="nav-item {{ Request::is('*/roles*') ? 'active open' : '' }}">
                            <a href="javascript:;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M243.8 339.8C232.9 350.7 215.1 350.7 204.2 339.8L140.2 275.8C129.3 264.9 129.3 247.1 140.2 236.2C151.1 225.3 168.9 225.3 179.8 236.2L224 280.4L332.2 172.2C343.1 161.3 360.9 161.3 371.8 172.2C382.7 183.1 382.7 200.9 371.8 211.8L243.8 339.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                </svg>
                                <span class="menu-title">
                                    {{ __('sidebar.users-permissions') }}
                                </span>
                            </a>
                            <ul class="menu-content">
                                <li class="{{ Request::is('*/clients/create') ? 'active' : '' }}">
                                    <a href="{{ route('client.clients.create') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.add-new-user') }}
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/clients') ? 'active' : '' }}">
                                    <a href="{{ route('client.clients.index') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.list-of-users') }}
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/roles/create') ? 'active' : '' }}">
                                    <a href="{{ route('client.roles.create') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.add-new-permission') }}
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/roles') ? 'active' : '' }}">
                                    <a href="{{ route('client.roles.index') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        {{ __('sidebar.list-of-permissions') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endif
            @endif
            @if (empty($package) || $package->settings == '1')
                @if ($screen_settings->settings == '1')
                    <li class="nav-item {{ Request::is('*/roles*', '*settings*') ? 'active open' : '' }}">
                        <a href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path
                                    d="M308.5 135.3c7.1-6.3 9.9-16.2 6.2-25c-2.3-5.3-4.8-10.5-7.6-15.5L304 89.4c-3-5-6.3-9.9-9.8-14.6c-5.7-7.6-15.7-10.1-24.7-7.1l-28.2 9.3c-10.7-8.8-23-16-36.2-20.9L199 27.1c-1.9-9.3-9.1-16.7-18.5-17.8C173.7 8.4 166.9 8 160 8s-13.7 .4-20.4 1.2c-9.4 1.1-16.6 8.6-18.5 17.8L115 56.1c-13.3 5-25.5 12.1-36.2 20.9L50.5 67.8c-9-3-19-.5-24.7 7.1c-3.5 4.7-6.8 9.6-9.9 14.6l-3 5.3c-2.8 5-5.3 10.2-7.6 15.6c-3.7 8.7-.9 18.6 6.2 25l22.2 19.8C32.6 161.9 32 168.9 32 176s.6 14.1 1.7 20.9L11.5 216.7c-7.1 6.3-9.9 16.2-6.2 25c2.3 5.3 4.8 10.5 7.6 15.6l3 5.2c3 5.1 6.3 9.9 9.9 14.6c5.7 7.6 15.7 10.1 24.7 7.1l28.2-9.3c10.7 8.8 23 16 36.2 20.9l6.1 29.1c1.9 9.3 9.1 16.7 18.5 17.8c6.7 .8 13.5 1.2 20.4 1.2s13.7-.4 20.4-1.2c9.4-1.1 16.6-8.6 18.5-17.8l6.1-29.1c13.3-5 25.5-12.1 36.2-20.9l28.2 9.3c9 3 19 .5 24.7-7.1c3.5-4.7 6.8-9.5 9.8-14.6l3.1-5.4c2.8-5 5.3-10.2 7.6-15.5c3.7-8.7 .9-18.6-6.2-25l-22.2-19.8c1.1-6.8 1.7-13.8 1.7-20.9s-.6-14.1-1.7-20.9l22.2-19.8zM208 176c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM504.7 500.5c6.3 7.1 16.2 9.9 25 6.2c5.3-2.3 10.5-4.8 15.5-7.6l5.4-3.1c5-3 9.9-6.3 14.6-9.8c7.6-5.7 10.1-15.7 7.1-24.7l-9.3-28.2c8.8-10.7 16-23 20.9-36.2l29.1-6.1c9.3-1.9 16.7-9.1 17.8-18.5c.8-6.7 1.2-13.5 1.2-20.4s-.4-13.7-1.2-20.4c-1.1-9.4-8.6-16.6-17.8-18.5L583.9 307c-5-13.3-12.1-25.5-20.9-36.2l9.3-28.2c3-9 .5-19-7.1-24.7c-4.7-3.5-9.6-6.8-14.6-9.9l-5.3-3c-5-2.8-10.2-5.3-15.6-7.6c-8.7-3.7-18.6-.9-25 6.2l-19.8 22.2c-6.8-1.1-13.8-1.7-20.9-1.7s-14.1 .6-20.9 1.7l-19.8-22.2c-6.3-7.1-16.2-9.9-25-6.2c-5.3 2.3-10.5 4.8-15.6 7.6l-5.2 3c-5.1 3-9.9 6.3-14.6 9.9c-7.6 5.7-10.1 15.7-7.1 24.7l9.3 28.2c-8.8 10.7-16 23-20.9 36.2L315.1 313c-9.3 1.9-16.7 9.1-17.8 18.5c-.8 6.7-1.2 13.5-1.2 20.4s.4 13.7 1.2 20.4c1.1 9.4 8.6 16.6 17.8 18.5l29.1 6.1c5 13.3 12.1 25.5 20.9 36.2l-9.3 28.2c-3 9-.5 19 7.1 24.7c4.7 3.5 9.5 6.8 14.6 9.8l5.4 3.1c5 2.8 10.2 5.3 15.5 7.6c8.7 3.7 18.6 .9 25-6.2l19.8-22.2c6.8 1.1 13.8 1.7 20.9 1.7s14.1-.6 20.9-1.7l19.8 22.2zM464 400c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z"/>
                            </svg>
                            <span class="menu-title">
                                {{ __('sidebar.settings') }}
                            </span>
                        </a>
                        <ul class="menu-content">
                            @can('الاعدادات العامة للنظام')
                                <li class="nav-item {{ Request::is('*settings*') ? 'active open' : '' }}">
                                    <a href="{{ route('client.basic.settings.edit') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        <span class="menu-title">
                                            {{ __('sidebar.system-settings') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('*/screens-settings*') ? 'active open' : '' }}">
                                    <a href="{{ route('screens.settings') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        <span class="menu-title">
                                            {{ __('sidebar.screens-settings') }}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('*/pos-settings*') ? 'active open' : '' }}">
                                    <a href="{{ route('pos.settings') }}">
                                        <svg style="width: 15px;fill:lightgreen;" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>
                                        <span class="menu-title">
                                            {{ __('sidebar.pos-settings') }}
                                        </span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('*/print-demo') ? 'active' : '' }}">
                                    <a href="{{ route('print.demo') }}">
                                        <svg style="width: 12px;fill:lightgreen;"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path
                                                d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/>
                                        </svg>

                                        <span class="menu-title">
                                                نموذج طباعة الفاتورة
                                            </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>
