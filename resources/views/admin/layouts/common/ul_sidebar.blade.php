<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow no-print" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ Request::is('*home') ? 'active' : '' }}">
                <a href="{{route('admin.home')}}"><i class="sidebar-item-icon fa fa-dashboard"></i>
                    <span class="menu-title text-center">
                      لوحة تحكم الادارة
                    </span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('*/companies*') ? 'active open' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-building-o"></i>
                    <span class="menu-title">
                     الشركات
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/companies') ? 'active' : '' }}">
                        <a href="{{ route('admin.companies.index') }}">
                            <i class="fa fa-plus"></i>
                            قائمة الشركات
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('*/packages*') ? 'active open' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-gift"></i>
                    <span class="menu-title">
                     الباقات المتاحة
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/packages/create') ? 'active' : '' }}">
                        <a href="{{ route('admin.packages.create') }}">
                            <i class="fa fa-plus"></i>
                            اضافة باقة جديدة
                        </a>
                    </li>
                    <li class="{{ Request::is('*/packages') ? 'active' : '' }}">
                        <a href="{{ route('admin.packages.index') }}">
                            <i class="fa fa-plus"></i>
                            قائمة الباقات المتاحة
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('*/types*') ? 'active open' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-ticket"></i>
                    <span class="menu-title">
                     انواع واسعار الاشتراكات
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/types/create') ? 'active' : '' }}">
                        <a href="{{ route('admin.types.create') }}">
                            <i class="fa fa-plus"></i>
                            اضافة نوع اشتراك جديد
                        </a>
                    </li>
                    <li class="{{ Request::is('*/types') ? 'active' : '' }}">
                        <a href="{{ route('admin.types.index') }}">
                            <i class="fa fa-plus"></i>
                            قائمة انواع واسعار الاشتراكات
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('*/subscriptions*') ? 'active open' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-ticket"></i>
                    <span class="menu-title">
                     الاشتراكات
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/subscriptions') ? 'active' : '' }}">
                        <a href="{{ route('admin.subscriptions.index') }}">
                            <i class="fa fa-plus"></i>
                            قائمة الاشتراكات
                        </a>
                    </li>
                    <li class="{{ Request::is('*/subscriptions-filter-get') ? 'active' : '' }}">
                        <a href="{{ route('subscriptions.filter.get') }}">
                            <i class="fa fa-plus"></i>
                            فلترة الشركات بنوع الاشتراك
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ Request::is('*/payments*') ? 'active open' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-money"></i>
                    <span class="menu-title">
                     مدفوعات الاشتراكات
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/payments/create*') ? 'active' : '' }}">
                        <a href="{{route('admin.payments.create')}}">
                            <i class="fa fa-plus"></i>
                            اضافة مدفوعات جديدة
                        </a>
                    </li>

                    <li class="{{ Request::is('*/payments') ? 'active' : '' }}">
                        <a href="{{ route('admin.payments.index') }}">
                            <i class="fa fa-plus"></i>
                            قائمة مدفوعات الاشتراكات
                        </a>
                    </li>
                    <li class="{{ Request::is('*/payments-report-get') ? 'active' : '' }}">
                        <a href="{{ route('payments.report.get') }}">
                            <i class="fa fa-plus"></i>
                            تقرير مدفوعات الاشتراكات
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('*/contacts*') ? 'active open' : '' }}">
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-envelope-o"></i>
                    <span class="menu-title">
                        رسائل الزوار
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('*/contacts') ? 'active' : '' }}">
                        <a href="{{ route('admin.contacts.index') }}">
                            <i class="fa fa-plus"></i>
                            عرض رسائل الزوار
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('*/social-links*') ? 'active open' : '' }}">
                <a href="{{route('social.links')}}"><i class="sidebar-item-icon fa fa-info-circle"></i>
                    <span class="menu-title">
                     معلومات مواقع التواصل
                    </span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('*/intro*') ? 'active open' : '' }}">
                <a href="{{route('intro')}}"><i class="sidebar-item-icon fa fa-file-movie-o"></i>
                    <span class="menu-title">
                     فيديو شرح المقدمة
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
