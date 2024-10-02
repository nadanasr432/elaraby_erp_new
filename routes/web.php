<?php

use App\Models\Safe;
use App\Models\Store;
use App\Models\Branch;
use App\Models\IntroMovie;
use App\Models\Information;
use App\Http\Middleware\CheckStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Client\PosController;
use App\Http\Controllers\Client\BankController;
use App\Http\Controllers\Client\CashController;
use App\Http\Controllers\Client\GiftController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\RoleController;
use App\Http\Controllers\Client\RoomController;
use App\Http\Controllers\Client\SafeController;
use App\Http\Controllers\Client\UnitController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\Client\BondsController;
use App\Http\Controllers\Client\DailyController;
use App\Http\Controllers\Client\EmailController;
use App\Http\Controllers\Client\PlaceController;
use App\Http\Controllers\Client\StoreController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Client\AssetsController;
use App\Http\Controllers\Client\BranchController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\GroupeController;
use App\Http\Controllers\Client\ReportController;
use App\Http\Controllers\Client\BuyBillController;
use App\Http\Controllers\Client\CapitalController;
use App\Http\Controllers\Client\CountryController;
use App\Http\Controllers\Client\ExpenseController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\SummaryController;
use App\Http\Controllers\Client\CashBankController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\EmployeeController;
use App\Http\Controllers\Client\SaleBillController;
use App\Http\Controllers\Client\SettingsController;
use App\Http\Controllers\Client\SupplierController;
// use App\Http\Controllers\Client\JournalEntryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Client\QuotationController;
use App\Http\Controllers\Client\SaleBillController1;
use App\Http\Controllers\Client\CostCenterController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Client\OuterClientController;
use App\Http\Controllers\Client\SubCategoryController;
use App\Http\Controllers\Client\BuildingRoleController;
use App\Http\Controllers\Client\ImportExportController;
use App\Http\Controllers\Client\ClientProfileController;
use App\Http\Controllers\Client\PurchaseOrderController;
use App\Http\Controllers\Client\CategoriesAssetController;
use App\Http\Controllers\Client\SaleBillPrintDemoController;

Route::get('admin/createTokensForAllInvoices', [\App\Http\Controllers\Client\SaleBillController::class, 'createTokensForAllInvoices']);
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [\Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class, \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class, \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class]], function () {

    Route::get('/', function () {
        $intro_movie = IntroMovie::First();
        return view('site.index', compact('intro_movie'));
    })->name('index');

    Route::get('/about', function () {
        return view('site.about');
    })->name('about');
    Route::get('/privacypolicy', function () {
        return view('site.privacypolicy');
    })->name('privacypolicy');
    Route::get('/contact', function () {
        $informations = Information::First();
        return view('site.contact', compact('informations'));
    })->name('contact');
    Route::post('/send-message', [\App\Http\Controllers\Site\ContactController::class, 'send_message'])->name('send.message');

    Route::get('/step-3', function () {
        return view('site.index3');
    })->name('index3');

    Route::post('/company-store', [\App\Http\Controllers\Site\CompanyController::class, 'store'])->name('company.store');

    Route::get('/step-4/{id?}', function () {
        return view('site.index4');
    })->name('index4');

    Route::post('/company-store-step2', [\App\Http\Controllers\Site\CompanyController::class, 'store_s2'])->name('company.store.s2');

    Route::get('/step-5/{id?}', function () {
        return view('site.index5');
    })->name('index5');

    Route::get('to-admin-login/{id?}', [\App\Http\Controllers\Site\CompanyController::class, 'to_admin_login'])->name('to.admin.login');

    Route::post('/company-admin-login-store', [\App\Http\Controllers\Site\CompanyController::class, 'admin_login'])->name('company.admin.login.store');

    Route::get('/step-6/{id?}', function () {
        return view('site.index6');
    })->name('index6');

    Route::get('/branches/{id?}', [\App\Http\Controllers\Site\CompanyController::class, 'branches'])->name('branches');

    Route::post('/company-branch-store', [\App\Http\Controllers\Site\CompanyController::class, 'store_branch'])->name('company.branch.store');

    Route::get('/to-stores/{id?}', [\App\Http\Controllers\Site\CompanyController::class, 'stores'])->name('to.stores');

    Route::post('/company-store-store', [\App\Http\Controllers\Site\CompanyController::class, 'store_store'])->name('company.store.store');

    Route::get('/to-safes/{id?}', [\App\Http\Controllers\Site\CompanyController::class, 'safes'])->name('to.safes');

    Route::post('/company-safe-store', [\App\Http\Controllers\Site\CompanyController::class, 'safe_store'])->name('company.safe.store');

    Route::get('/clients-summary-post', [\App\Http\Controllers\Client\SummaryController::class, 'post_clients_summary'])->name('clients.summary.post');

    Route::get('/suppliers-summary-post', [\App\Http\Controllers\Client\SummaryController::class, 'post_suppliers_summary'])->name('suppliers.summary.post');

    Route::get('/sale-bills/print/{hashtoken?}/{invoiceType?}/{printColor?}/{isMoswada?}', [\App\Http\Controllers\Client\SaleBillController::class, 'print'])->name('client.sale_bills.print');
    Route::get('/sent/sale-bills/print/{hashtoken?}/{invoiceType?}/{printColor?}/{isMoswada?}', [\App\Http\Controllers\Client\SaleBillController::class, 'sent'])->name('client.sale_bills.sent');

    Route::get('/buy-bills/print/{id?}', [\App\Http\Controllers\Client\BuyBillController::class, 'print'])->name('client.buy_bills.print');

    Route::get('/pos-print/{pos_id?}', [\App\Http\Controllers\Client\PosController::class, 'print'])->name('pos.open.print');

    // *********  Admin Routes ******** //

    Route::group(['namespace' => 'Admin'], function () {
        Auth::routes(
            [
                'verify' => false,
                'register' => false,
            ]
        );
        Route::GET('admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::POST('admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
        Route::POST('admin/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
        Route::GET('admin/password/confirm', [App\Http\Controllers\Admin\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('admin.password.confirm');
        Route::POST('admin/password/confirm', [App\Http\Controllers\Admin\Auth\ConfirmPasswordController::class, 'confirm']);
        Route::POST('admin/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
        Route::GET('admin/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
        Route::POST('admin/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('admin.password.update');
        Route::GET('admin/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    });

    Route::group(
        [],
        function () {
            Auth::routes(
                [
                    'verify' => false,
                    'register' => false,
                ]
            );
            Route::GET('client/login', [App\Http\Controllers\Client\Auth\LoginController::class, 'showLoginForm'])->name('client.login');
            Route::POST('client/login', [App\Http\Controllers\Client\Auth\LoginController::class, 'login']);
            Route::POST('client/logout', [App\Http\Controllers\Client\Auth\LoginController::class, 'logout'])->name('client.logout');
            Route::GET('client/password/confirm', [App\Http\Controllers\Client\Auth\LoginController::class, 'showConfirmForm'])->name('client.password.confirm');
            Route::POST('client/password/confirm',  [App\Http\Controllers\Client\Auth\LoginController::class, 'confirm']);
            Route::POST('client/password/email',  [App\Http\Controllers\Client\Auth\LoginController::class, 'sendResetLinkEmail'])->name('client.password.email');
            Route::GET('client/password/reset', [App\Http\Controllers\Client\Auth\LoginController::class, 'showLinkRequestForm'])->name('client.password.request');
            Route::POST('client/password/reset', [App\Http\Controllers\Client\Auth\LoginController::class, 'reset'])->name('client.password.update');
            Route::GET('client/password/reset/{token}', [App\Http\Controllers\Client\Auth\LoginController::class, 'showResetForm'])->name('client.password.reset');
        }
    );
    Route::group(
        [
            'middleware' => ['auth:admin-web'],
            'prefix' => 'admin',

        ],
        function () {
            Route::get('/',  [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm']);
            Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');

            Route::get('profile/edit/{id}', [App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::patch('profile/edit/{id}', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');
            Route::patch('profile/store/{id}',  [App\Http\Controllers\Admin\AdminProfileController::class, 'store'])->name('admin.profile.store');

            Route::get('intro', [App\Http\Controllers\Admin\HomeController::class, 'intro_movie'])->name('intro');
            Route::post('intro-movie-post', [App\Http\Controllers\Admin\HomeController::class, 'intro_movie_post'])->name('admin.intro.movie.post');

            Route::get('/social-links', [App\Http\Controllers\Admin\HomeController::class, 'social_links'])->name('social.links');
            Route::post('/update-social-links', [App\Http\Controllers\Admin\HomeController::class, 'update_social_links'])->name('update.social.links');

            // Contacts Routes
            Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class)->names([
                'index' => 'admin.contacts.index',
                'show' => 'admin.contacts.show',
                'destroy' => 'admin.contacts.destroy'
            ]);
            // types Routes
            Route::resource('types', TypeController::class)->names([
                'index' => 'admin.types.index',
                'create' => 'admin.types.create',
                'update' => 'admin.types.update',
                'destroy' => 'admin.types.destroy',
                'edit' => 'admin.types.edit',
                'store' => 'admin.types.store',
            ]);

            // Companies Routes
            Route::resource('companies', CompanyController::class)->names([
                'index' => 'admin.companies.index',
                'update' => 'admin.companies.update',
                'edit' => 'admin.companies.edit',
                'destroy' => 'admin.companies.destroy',
            ]);
            // payments Routes
            Route::resource('payments', PaymentController::class)->names([
                'index' => 'admin.payments.index',
                'create' => 'admin.payments.create',
                'update' => 'admin.payments.update',
                'destroy' => 'admin.payments.destroy',
                'edit' => 'admin.payments.edit',
                'store' => 'admin.payments.store',
            ]);
            Route::get('payments-report-get', [PaymentController::class, 'get_report'])->name('payments.report.get');

            Route::resource('packages', PackageController::class)->names([
                'index' => 'admin.packages.index',
                'create' => 'admin.packages.create',
                'update' => 'admin.packages.update',
                'destroy' => 'admin.packages.destroy',
                'edit' => 'admin.packages.edit',
                'store' => 'admin.packages.store',
            ]);

            // subscriptions Routes
            Route::resource('subscriptions', SubscriptionController::class)->names([
                'index' => 'admin.subscriptions.index',
                'create' => 'admin.subscriptions.create',
                'update' => 'admin.subscriptions.update',
                'destroy' => 'admin.subscriptions.destroy',
                'edit' => 'admin.subscriptions.edit',
                'store' => 'admin.subscriptions.store',
            ]);
            Route::get('subscriptions-filter-get', [SubscriptionController::class, 'get_filter'])->name('subscriptions.filter.get');
            Route::post('subscriptions-filter-post', [SubscriptionController::class, 'post_filter'])->name('subscriptions.filter.post');


            Route::patch('contacts-make-as-read', [App\Http\Controllers\Admin\ContactController::class, 'makeAsRead'])->name('admin.contacts.make.as.read');
            Route::patch('contacts-make-as-important', [App\Http\Controllers\Admin\ContactController::class, 'makeAsImportant'])->name('admin.contacts.make.as.important');
            Route::patch('contacts-make-as-destroy', [App\Http\Controllers\Admin\ContactController::class, 'makeAsDestroy'])->name('admin.contacts.make.as.destroy');
            Route::patch('contacts-print', [App\Http\Controllers\Admin\ContactController::class, 'print'])->name('admin.contacts.print');
            Route::get('contacts-important', [App\Http\Controllers\Admin\ContactController::class, 'showImportant'])->name('admin.contacts.important');
        }
    );

    Route::group(
        [
            'middleware' => ['auth:client-web', CheckStatus::class],
            'prefix' => 'client',

        ],
        function () {
            Route::get('/', [App\Http\Controllers\Client\Auth\LoginController::class, 'showLoginForm']);
            Route::get('/home',  [HomeController::class, 'index'])->name('client.home');


            Route::post('toggleSearchCardOpen', [HomeController::class, 'toggleSearchCardOpen'])->name('toggleSearchCardOpen');
            Route::post('toggleFastRecordCardOpen', [HomeController::class, 'toggleFastRecordCardOpen'])->name('toggleFastRecordCardOpen');
            Route::post('toggleFastPayCardOpen', [HomeController::class, 'toggleFastPayCardOpen'])->name('toggleFastPayCardOpen');
            Route::post('toggleFastAddCardOpen', [HomeController::class, 'toggleFastAddCardOpen'])->name('toggleFastAddCardOpen');

            Route::get('/go-to-upgrade', [HomeController::class, 'go_to_upgrade'])->name('go.to.upgrade');
            Route::get('/go-to-upgrade2/{id?}', [HomeController::class, 'go_to_upgrade2'])->name('go.to.upgrade2');

            Route::post('save-notes', [SaleBillController::class, 'save_notes'])->name('save.notes');

            // clients Routes
            Route::resource('clients', ClientController::class)->names([
                'index' => 'client.clients.index',
                'create' => 'client.clients.create',
                'update' => 'client.clients.update',
                'destroy' => 'client.clients.destroy',
                'edit' => 'client.clients.edit',
                'store' => 'client.clients.store',
            ]);

            // ClientProfile Routes
            Route::get('profile/edit/{id}', [ClientProfileController::class, 'edit'])->name('client.profile.edit');
            Route::patch('profile/edit/{id}', [ClientProfileController::class, 'update'])->name('client.profile.update');
            Route::patch('profile/store/{id}', [ClientProfileController::class, 'store'])->name('client.profile.store');

            // settings
            Route::get('client-basic-settings-edit', [SettingsController::class, 'basic'])->name('client.basic.settings.edit');
            Route::get('client-billing-settings-edit', [SettingsController::class, 'billing'])->name('client.billing.settings.edit');
            Route::get('client-extra-settings-edit', [SettingsController::class, 'extra'])->name('client.extra.settings.edit');
            Route::get('client-backup-settings-edit', [SettingsController::class, 'backup'])->name('client.backup.settings.edit');
            Route::get('client-backup', [SettingsController::class, 'get_backup'])->name('client.get.backup');
            Route::get('product-expires', [SettingsController::class, 'product_expires'])->name('client.get.product_expires');
            Route::patch('client-basic-settings-update', [SettingsController::class, 'update_basic'])->name('client.basic.settings.update');
            Route::patch('client-billing-settings-update', [SettingsController::class, 'update_billing'])->name('client.billing.settings.update');
            Route::patch('client-fiscal-settings-update', [SettingsController::class, 'update_fiscal'])->name('client.fiscal.settings.update');
            Route::patch('client-product-expires-update', [SettingsController::class, 'update_extra'])->name('client.extra.settings.update');
            Route::patch('client-extra-settings-update', [SettingsController::class, 'update_product_expires'])->name('client.product_expires.settings.update');
            Route::post('client-restore', [SettingsController::class, 'restore'])->name('client.restore');

            Route::get('screens-settings', [SettingsController::class, 'screens_settings'])->name('screens.settings');
            Route::get('screens-settings-edit/{id?}', [SettingsController::class, 'screens_settings_edit'])->name('screens.settings.edit');
            Route::patch('screens-settings-update', [SettingsController::class, 'screens_settings_update'])->name('screens.settings.update');

            Route::get('pos-settings', [SettingsController::class, 'pos_settings'])->name('pos.settings');
            Route::get('pos-settings-edit/{id?}', [SettingsController::class, 'pos_settings_edit'])->name('pos.settings.edit');
            Route::patch('pos-settings-update', [SettingsController::class, 'pos_settings_update'])->name('pos.settings.update');

            // Branches Routes
            Route::resource('branches', BranchController::class)->names([
                'index' => 'client.branches.index',
                'create' => 'client.branches.create',
                'update' => 'client.branches.update',
                'destroy' => 'client.branches.destroy',
                'edit' => 'client.branches.edit',
                'store' => 'client.branches.store',
            ]);


            // Stores Routes
            Route::resource('stores', StoreController::class)->names([
                'index' => 'client.stores.index',
                'create' => 'client.stores.create',
                'update' => 'client.stores.update',
                'destroy' => 'client.stores.destroy',
                'edit' => 'client.stores.edit',
                'store' => 'client.stores.store',
            ]);

            Route::get('clients-stores-inventory-get', [StoreController::class, 'inventory_get'])->name('client.inventory.get');
            Route::post('clients-stores-inventory-post', [StoreController::class, 'inventory_post'])->name('client.inventory.post');
            Route::post('export-inventory', [ImportExportController::class, 'export_inventory'])->name('inventory.export');

            Route::get('clients-stores-transfer-get', [StoreController::class, 'transfer_get'])->name('client.stores.transfer.get');
            Route::post('clients-stores-transfer-post', [StoreController::class, 'transfer_post'])->name('client.stores.transfer.post');

            Route::post('get-products-by-store-id', [StoreController::class, 'get_products_by_store_id'])->name('get.products.by.store.id');

            // Safes Routes
            Route::resource('safes', SafeController::class)->names([
                'index' => 'client.safes.index',
                'create' => 'client.safes.create',
                'update' => 'client.safes.update',
                'destroy' => 'client.safes.destroy',
                'edit' => 'client.safes.edit',
                'store' => 'client.safes.store',
            ]);
            Route::get('safes-transfer', [SafeController::class, 'transfer_get'])->name('client.safes.transfer');
            Route::post('safes-transfer-post', [SafeController::class, 'transfer_post'])->name('client.safes.transfer.post');
            Route::delete('safes-transfer-destroy', [SafeController::class, 'transfer_destroy'])->name('client.safes.transfer.destroy');

            // Categories Routes
            Route::resource('categories', CategoryController::class)->names([
                'index' => 'client.categories.index',
                'create' => 'client.categories.create',
                'update' => 'client.categories.update',
                'destroy' => 'client.categories.destroy',
                'edit' => 'client.categories.edit',
                'store' => 'client.categories.store',
            ]);

            // SubCategories Routes
            Route::resource('subcategories', SubCategoryController::class)->names([
                'index' => 'client.subcategories.index',
                'create' => 'client.subcategories.create',
                'update' => 'client.subcategories.update',
                'destroy' => 'client.subcategories.destroy',
                'edit' => 'client.subcategories.edit',
                'store' => 'client.subcategories.store',
            ]);

            // Units Routes
            Route::resource('units', UnitController::class)->names([
                'index' => 'client.units.index',
                'create' => 'client.units.create',
                'update' => 'client.units.update',
                'destroy' => 'client.units.destroy',
                'edit' => 'client.units.edit',
                'store' => 'client.units.store',
            ]);

            /////////////////////////////////////////////////////// Products Routes/////////////////////////////////////////////////////
            Route::post('/getNumProductsOutOfStock', [ProductController::class, 'getNumProductsOutOfStock'])->name('getNumProductsOutOfStock');
            Route::post('/setProductsOutOfStockViewed', [ProductController::class, 'setProductsOutOfStockViewed'])->name('setProductsOutOfStockViewed');
            // routes/web.php
            Route::get('/client/products/search', [ProductController::class, 'search'])->name('client.products.search');
            Route::get('/client/products-expires', [ProductController::class, 'products_expires'])->name('client.products.expires');

            Route::resource('products', ProductController::class)->names([
                'index' => 'client.products.index',
                'create' => 'client.products.create',
                'update' => 'client.products.update',
                'destroy' => 'client.products.destroy',
                'edit' => 'client.products.edit',
                'store' => 'client.products.store',
                'show' => 'client.products.show',
            ]);
            Route::get('products/create/service', [ProductController::class, 'createservice'])->name('client.products.createservice');

            Route::post('products_store', [ProductController::class, 'storeProduct'])->name('pos.product.store');

            Route::get('clients-products-empty', [ProductController::class, 'empty'])->name('client.products.empty');
            Route::get('clients-products-limited', [ProductController::class, 'limited'])->name('client.products.limited');
            Route::get('clients-products-print', [ProductController::class, 'print'])->name('client.products.print');

            Route::post('clients-products-storePos', [ProductController::class, 'store_pos'])->name('client.products.storePos');
            Route::get('/generate-barcode', [ProductController::class, 'barcode'])->name('barcode');
            Route::post('/generate-barcode', [ProductController::class, 'generate_barcode'])->name('generate.barcode');
            Route::post('/get_subcategories_by_category_id', [ProductController::class, 'get_subcategories_by_category_id'])->name('get_subcategories_by_category_id');

            //clients bonds..
            Route::post('/create-clients-bonds', [BondsController::class, 'storeNewBond'])->name("create-clients-bonds");
            Route::post('/client_bonds_delete', [BondsController::class, 'deleteClientBond'])->name("client_bonds_delete");
            Route::get('/edit_client_bond/{clientid}', [BondsController::class, 'getClientBond'])->name("edit_client_bond");
            Route::post('/udpate_client_bonds', [BondsController::class, 'updateClientBond'])->name("updateClientBond");
            Route::get('/showClientBondPrint/{clientid}', [BondsController::class, 'showClientBondPrint'])->name("showClientBondPrint");

            //electronic-stamps
            Route::get('/electronic-stamp', [BondsController::class, 'electronicStmapPage'])->name("electronic-stamp");
            Route::post('/add-electronic-stamp', [BondsController::class, 'addElectronicStamp'])->name("add-electronic-stamp");

            //suppliers bonds..
            Route::post('/create-suppliers-bonds', [BondsController::class, 'storeNewBondSupplier'])->name("create-suppliers-bonds");
            Route::get('/edit_supplier_bond/{supplierid}', [BondsController::class, 'getSupplierBond'])->name("edit_supplier_bond");
            Route::post('/udpate_supplier_bonds', [BondsController::class, 'updateSupplierBond'])->name("updateSupplierBond");
            Route::post('/supplier_bonds_delete', [BondsController::class, 'deleteSupplierBond'])->name("supplier_bonds_delete");
            Route::get('/showSupplierBondPrint/{supplierid}', [BondsController::class, 'showSupplierBondPrint'])->name("showSupplierBondPrint");


            // outer_clients Routes
            Route::resource('outer_clients', OuterClientController::class)->names([
                'index' => 'client.outer_clients.index',
                'create' => 'client.outer_clients.create',
                'update' => 'client.outer_clients.update',
                'destroy' => 'client.outer_clients.destroy',
                'edit' => 'client.outer_clients.edit',
                'store' => 'client.outer_clients.store',
                'show' => 'client.outer_clients.show',
            ]);
            Route::get('clients-outer-clients-print', [OuterClientController::class, 'print'])->name('client.outer_clients.print');
            Route::post('outer-clients', [OuterClientController::class, 'storeClient'])->name('pos.outer_clients.store');

            Route::get('clients-outer-clients-filter', [OuterClientController::class, 'filter_clients'])->name('client.outer_clients.filter');
            Route::get('clients-outer-clients-filter-key', [OuterClientController::class, 'filter_clients']);
            Route::post('clients-outer-clients-filter-key', [OuterClientController::class, 'filter_key'])->name('client.outer_clients.filter.key');

            Route::post('outer-clients-filter-name', [OuterClientController::class, 'filter_name'])->name('client.outer_clients.filter.name');

            Route::post('clients-outer-clients-storePos', [OuterClientController::class, 'store_pos'])->name('client.outer_clients.storePos');
            Route::post('clients-outer-clients-showPos', [OuterClientController::class, 'show_pos'])->name('client.outer_clients.showPos');

            // suppliers Routes
            Route::resource('suppliers', SupplierController::class)->names([
                'index' => 'client.suppliers.index',
                'create' => 'client.suppliers.create',
                'update' => 'client.suppliers.update',
                'destroy' => 'client.suppliers.destroy',
                'edit' => 'client.suppliers.edit',
                'store' => 'client.suppliers.store',
                'show' => 'client.suppliers.show',
            ]);

            Route::get('clients-suppliers-print', [SupplierController::class, 'print'])->name('client.suppliers.print');

            Route::get('clients-suppliers-filter', [SupplierController::class, 'filter_suppliers'])->name('client.suppliers.filter');
            Route::get('clients-suppliers-filter-key', [SupplierController::class, 'filter_suppliers']);
            Route::post('clients-suppliers-filter-key', [SupplierController::class, 'filter_key'])->name('client.suppliers.filter.key');

            // banks Routes
            Route::resource('banks', BankController::class)->names([
                'index' => 'client.banks.index',
                'create' => 'client.banks.create',
                'update' => 'client.banks.update',
                'destroy' => 'client.banks.destroy',
                'edit' => 'client.banks.edit',
                'store' => 'client.banks.store',
                'show' => 'client.banks.show',
            ]);

            Route::get('clients-banks-process', [BankController::class, 'banks_process'])->name('client.banks.process');
            Route::post('clients-banks-process-store', [BankController::class, 'banks_process_store'])->name('client.banks.process.store');
            Route::delete('clients-banks-process-destroy', [BankController::class, 'banks_process_destroy'])->name('client.banks.process.destroy');

            Route::get('clients-banks-transfer', [BankController::class, 'banks_transfer'])->name('client.banks.transfer');
            Route::post('clients-banks-transfer-store', [BankController::class, 'banks_transfer_store'])->name('client.banks.transfer.store');
            Route::delete('clients-banks-transfer-destroy', [BankController::class, 'banks_transfer_destroy'])->name('client.banks.transfer.destroy');

            Route::get('clients-bank-safe-transfer', [BankController::class, 'bank_safe_transfer'])->name('client.bank.safe.transfer');
            Route::post('clients-bank-safe-transfer-store', [BankController::class, 'bank_safe_transfer_store'])->name('client.bank.safe.transfer.store');
            Route::delete('clients-bank-safe-transfer-destroy', [BankController::class, 'bank_safe_transfer_destroy'])->name('client.bank.safe.transfer.destroy');

            Route::get('clients-safe-bank-transfer', [BankController::class, 'safe_bank_transfer'])->name('client.safe.bank.transfer');
            Route::post('clients-bank-safe-bank-transfer-store', [BankController::class, 'safe_bank_transfer_store'])->name('client.safe.bank.transfer.store');
            Route::delete('clients-bank-safe-bank-transfer-destroy', [BankController::class, 'safe_bank_transfer_destroy'])->name('client.safe.bank.transfer.destroy');

            Route::get('clients-expenses-fixed', [ExpenseController::class, 'fixed_expenses'])->name('client.fixed.expenses');
            Route::post('clients-fixed-expenses-store', [ExpenseController::class, 'fixed_expenses_store'])->name('client.fixed.expenses.store');
            Route::delete('clients-fixed-expenses-destroy', [ExpenseController::class, 'fixed_expenses_destroy'])->name('client.fixed.expenses.destroy');
            Route::get('clients-fixed-expenses-edit/{id?}', [ExpenseController::class, 'fixed_expenses_edit'])->name('client.fixed.expenses.edit');
            Route::patch('clients-fixed-expenses-update/{id?}', [ExpenseController::class, 'fixed_expenses_update'])->name('client.fixed.expenses.update');

            // expenses Routes
            Route::resource('expenses', ExpenseController::class)->names([
                'index' => 'client.expenses.index',
                'create' => 'client.expenses.create',
                'update' => 'client.expenses.update',
                'destroy' => 'client.expenses.destroy',
                'edit' => 'client.expenses.edit',
                'store' => 'client.expenses.store',
                'show' => 'client.expenses.show',
            ]);

            Route::get('clients-add-cash-clients', [CashController::class, 'add_cash_clients'])->name('client.add.cash.clients');
            Route::post('clients-store-cash-clients', [CashController::class, 'store_cash_clients'])->name('client.store.cash.clients');
            Route::get('clients-cash-clients', [CashController::class, 'cash_clients'])->name('client.cash.clients');
            Route::get('clients-edit-cash-clients/{id?}', [CashController::class, 'edit_cash_clients'])->name('client.edit.cash.clients');
            Route::delete('clients-delete-cash-clients', [CashController::class, 'destroy_cash_clients'])->name('client.destroy.cash.clients');
            Route::patch('clients-update-cash-clients/{id?}', [CashController::class, 'update_cash_clients'])->name('client.update.cash.clients');

            Route::get('print-cash-receipt/{id?}', [CashController::class, 'print_cash_receipt'])->name('print.cash.receipt');
            Route::get('print-bank-cash-receipt/{id?}', [CashBankController::class, 'print_bank_cash_receipt'])->name('print.bank.cash.receipt');
            Route::get('print-buy-cash-receipt/{id?}', [CashController::class, 'print_buy_cash_receipt'])->name('print.buy.cash.receipt');
            Route::get('print-bank-buy-cash-receipt/{id?}', [CashBankController::class, 'print_bank_buy_cash_receipt'])->name('print.bank.buy.cash.receipt');

            Route::get('clients-give-cash-clients', [CashController::class, 'give_cash_clients'])->name('client.give.cash.clients');
            Route::post('clients-store2-cash-clients', [CashController::class, 'store2_cash_clients'])->name('client.store2.cash.clients');
            Route::get('clients-borrow-clients', [CashController::class, 'borrow_clients'])->name('client.borrow.clients');
            Route::get('clients-edit-borrow-clients/{id?}', [CashController::class, 'edit_borrow_clients'])->name('client.edit.borrow.clients');
            Route::delete('clients-delete-borrow-clients', [CashController::class, 'destroy_borrow_clients'])->name('client.destroy.borrow.clients');
            Route::patch('clients-update-borrow-clients/{id?}', [CashController::class, 'update_borrow_clients'])->name('client.update.borrow.clients');

            Route::get('clients-add-cashbank-clients', [CashBankController::class, 'add_cashbank_clients'])->name('client.add.cashbank.clients');
            Route::post('clients-store-cashbank-clients', [CashBankController::class, 'store_cashbank_clients'])->name('client.store.cashbank.clients');
            Route::get('clients-cashbank-clients', [CashBankController::class, 'cashbank_clients'])->name('client.cashbank.clients');
            Route::get('clients-edit-cashbank-clients/{id?}', [CashBankController::class, 'edit_cashbank_clients'])->name('client.edit.cashbank.clients');
            Route::delete('clients-delete-cashbank-clients', [CashBankController::class, 'destroy_cashbank_clients'])->name('client.destroy.cashbank.clients');
            Route::patch('clients-update-cashbank-clients/{id?}', [CashBankController::class, 'update_cashbank_clients'])->name('client.update.cashbank.clients');

            Route::get('clients-add-cash-suppliers', [CashController::class, 'add_cash_suppliers'])->name('client.add.cash.suppliers');
            Route::post('clients-store-cash-suppliers', [CashController::class, 'store_cash_suppliers'])->name('client.store.cash.suppliers');
            Route::get('clients-cash-suppliers', [CashController::class, 'cash_suppliers'])->name('client.cash.suppliers');
            Route::get('clients-edit-cash-suppliers/{id?}', [CashController::class, 'edit_cash_suppliers'])->name('client.edit.cash.suppliers');
            Route::delete('clients-delete-cash-suppliers', [CashController::class, 'destroy_cash_suppliers'])->name('client.destroy.cash.suppliers');
            Route::patch('clients-update-cash-suppliers/{id?}', [CashController::class, 'update_cash_suppliers'])->name('client.update.cash.suppliers');


            Route::get('clients-give-cash-suppliers', [CashController::class, 'give_cash_suppliers'])->name('client.give.cash.suppliers');
            Route::post('clients-store2-cash-suppliers', [CashController::class, 'store2_cash_suppliers'])->name('client.store2.cash.suppliers');
            Route::get('clients-borrow-suppliers', [CashController::class, 'borrow_suppliers'])->name('client.borrow.suppliers');
            Route::get('clients-edit-borrow-suppliers/{id?}', [CashController::class, 'edit_borrow_suppliers'])->name('client.edit.borrow.suppliers');
            Route::delete('clients-delete-borrow-suppliers', [CashController::class, 'destroy_borrow_suppliers'])->name('client.destroy.borrow.suppliers');
            Route::patch('clients-update-borrow-suppliers/{id?}', [CashController::class, 'update_borrow_suppliers'])->name('client.update.borrow.suppliers');

            Route::get('clients-add-cashbank-suppliers', [CashBankController::class, 'add_cashbank_suppliers'])->name('client.add.cashbank.suppliers');
            Route::post('clients-store-cashbank-suppliers', [CashBankController::class, 'store_cashbank_suppliers'])->name('client.store.cashbank.suppliers');
            Route::get('clients-cashbank-suppliers', [CashBankController::class, 'cashbank_suppliers'])->name('client.cashbank.suppliers');
            Route::get('clients-edit-cashbank-suppliers/{id?}', [CashBankController::class, 'edit_cashbank_suppliers'])->name('client.edit.cashbank.suppliers');
            Route::delete('clients-delete-cashbank-suppliers', [CashBankController::class, 'destroy_cashbank_suppliers'])->name('client.destroy.cashbank.suppliers');
            Route::patch('clients-update-cashbank-suppliers/{id?}', [CashBankController::class, 'update_cashbank_suppliers'])->name('client.update.cashbank.suppliers');

            // capitals Routes
            Route::resource('capitals', CapitalController::class)->names([
                'index' => 'client.capitals.index',
                'create' => 'client.capitals.create',
                'update' => 'client.capitals.update',
                'destroy' => 'client.capitals.destroy',
                'edit' => 'client.capitals.edit',
                'store' => 'client.capitals.store',
                'show' => 'client.capitals.show',
            ]);

            // gifts Routes
            Route::resource('gifts', GiftController::class)->names([
                'index' => 'client.gifts.index',
                'create' => 'client.gifts.create',
                'update' => 'client.gifts.update',
                'destroy' => 'client.gifts.destroy',
                'edit' => 'client.gifts.edit',
                'store' => 'client.gifts.store',
                'show' => 'client.gifts.show',
            ]);


            Route::get('clients-emails-clients', [EmailController::class, 'emails_clients'])->name('client.emails.clients');
            Route::post('clients-send-client-email', [EmailController::class, 'send_client_email'])->name('client.send.client.email');

            Route::get('clients-emails-suppliers', [EmailController::class, 'emails_suppliers'])->name('client.emails.suppliers');
            Route::get('sale-bills/polices', [SaleBillController::class, 'updateInovicePolices'])->name('saleInvoices.updateInovicePolices');
            Route::post('clients-send-supplier-email', [EmailController::class, 'send_supplier_email'])->name('client.send.supplier.email');
            Route::post('updateSaleBillsConditions', [SaleBillController::class, 'updateConditions'])->name('saleBills.updateConditions');
            Route::post('updateQuotationConditions', [QuotationController::class, 'updateConditions'])->name('quotation.updateConditions');

            // quotations Routes
            Route::get('quotations/view/{quotation_id?}', [QuotationController::class, 'view'])->name('client.quotations.view');
            Route::resource('quotations', QuotationController::class)->names([
                'index' => 'client.quotations.index',
                'create' => 'client.quotations.create',
                'update' => 'client.quotations.update',
                'destroy' => 'client.quotations.destroy',
                'edit' => 'client.quotations.edit',
                'store' => 'client.quotations.store',
                'show' => 'client.quotations.show',
            ]);

            Route::post('/quotations/get', [QuotationController::class, 'get_product_price']);
            Route::post('/quotations/elements', [QuotationController::class, 'get_quotation_elements']);
            Route::post('/quotations/element/delete', [QuotationController::class, 'destroy_element']);
            Route::post('/quotations/element/destroy', [QuotationController::class, 'delete_element']);
            Route::post('/quotations/post', [QuotationController::class, 'save']);
            Route::post('/quotations/discount', [QuotationController::class, 'apply_discount']);
            Route::post('/quotations/extra', [QuotationController::class, 'apply_extra']);
            Route::post('/quotations/updateData', [QuotationController::class, 'updateData']);
            Route::post('/quotations-changeQuotation', [QuotationController::class, 'changeQuotation']);

            Route::post('/quotations/get-edit', [QuotationController::class, 'get_edit_product_price']);
            Route::post('/quotations/element/update', [QuotationController::class, 'update_element']);
            Route::post('/quotations/edit-element', [QuotationController::class, 'edit_element']);


            Route::get('/quotations/send/{id?}', [QuotationController::class, 'send'])->name('client.quotations.send');
            Route::get('/quotations-redirect', [QuotationController::class, 'redirect'])->name('client.quotations.redirect');
            Route::post('/quotations-save', [QuotationController::class, 'redirectANDprint'])->name('client.quotations.redirectANDprint');

            Route::post('clients-quotations-filter-key', [QuotationController::class, 'filter_key'])->name('client.quotations.filter.key');
            Route::post('clients-quotations-filter-client', [QuotationController::class, 'filter_client'])->name('client.quotations.filter.client');
            Route::post('clients-quotations-filter-code', [QuotationController::class, 'filter_code'])->name('client.quotations.filter.code');
            Route::post('clients-quotations-filter-product', [QuotationController::class, 'filter_product'])->name('client.quotations.filter.product');
            Route::post('clients-quotations-filter-all', [QuotationController::class, 'filter_all'])->name('client.quotations.filter.all');

            Route::post('/quotations/getOuterClientDetails', [QuotationController::class, 'get_outer_client_details']);
            Route::post('/quotations/getProducts', [QuotationController::class, 'get_products']);
            Route::delete('/quotations-deleteBill', [QuotationController::class, 'delete_bill'])->name('client.quotations.deleteBill');

            Route::get('/convert-to-salebill/{id?}', [QuotationController::class, 'convert_to_salebill'])
                ->name('convert.to.salebill');

            Route::get('purchase_orders/view', [PurchaseOrderController::class, 'filter_key'])->name('client.purchase_orders.view');

            // purchase_orders Routes
            Route::resource('purchase_orders', PurchaseOrderController::class)->names([
                'index' => 'client.purchase_orders.index',
                'create' => 'client.purchase_orders.create',
                'update' => 'client.purchase_orders.update',
                'destroy' => 'client.purchase_orders.destroy',
                'edit' => 'client.purchase_orders.edit',
                'store' => 'client.purchase_orders.store',
                'show' => 'client.purchase_orders.show',
            ]);

            Route::post('/purchase_orders/get', [PurchaseOrderController::class, 'get_product_price']);
            Route::post('/purchase_orders/elements', [PurchaseOrderController::class, 'get_purchase_order_elements']);
            Route::post('/purchase_orders/element/delete', [PurchaseOrderController::class, 'destroy_element']);
            Route::post('/purchase_orders/element/destroy', [PurchaseOrderController::class, 'delete_element']);
            Route::post('/purchase_orders/post', [PurchaseOrderController::class, 'save']);
            Route::post('/purchase_orders/discount', [PurchaseOrderController::class, 'apply_discount']);
            Route::post('/purchase_orders/extra', [PurchaseOrderController::class, 'apply_extra']);
            Route::post('/purchase_orders/updateData', [PurchaseOrderController::class, 'updateData']);
            Route::post('/purchase_orders-changepurchase_order', [PurchaseOrderController::class, 'changePurchaseOrder']);

            Route::get('/purchase_orders/send/{id?}', [PurchaseOrderController::class, 'send'])->name('client.purchase_orders.send');
            Route::get('/purchase_orders-redirect', [PurchaseOrderController::class, 'redirect'])->name('client.purchase_orders.redirect');

            Route::post('/purchase_orders/get-edit', [PurchaseOrderController::class, 'get_edit_product_price']);
            Route::post('/purchase_orders/element/update', [PurchaseOrderController::class, 'update_element']);
            Route::post('/purchase_orders/edit-element', [PurchaseOrderController::class, 'edit_element']);


            Route::post('clients-purchase_orders-filter-key', [PurchaseOrderController::class, 'filter_key'])->name('client.purchase_orders.filter.key');
            Route::post('clients-purchase_orders-filter-supplier', [PurchaseOrderController::class, 'filter_supplier'])->name('client.purchase_orders.filter.supplier');
            Route::post('clients-purchase_orders-filter-code', [PurchaseOrderController::class, 'filter_code'])->name('client.purchase_orders.filter.code');
            Route::post('clients-purchase_orders-filter-product', [PurchaseOrderController::class, 'filter_product'])->name('client.purchase_orders.filter.product');
            Route::post('clients-purchase_orders-filter-all', [PurchaseOrderController::class, 'filter_all'])->name('client.purchase_orders.filter.all');

            Route::post('/purchase_orders/getSupplierDetails', [PurchaseOrderController::class, 'get_supplier_details']);
            Route::post('/purchase_orders/getProducts', [PurchaseOrderController::class, 'get_products']);
            Route::delete('/purchase_orders-deleteBill', [PurchaseOrderController::class, 'delete_bill'])->name('client.purchase_orders.deleteBill');

            Route::get('/convert-to-buybill/{id?}', [PurchaseOrderController::class, 'convert_to_buybill'])
                ->name('convert.to.buybill');

            Route::resource('sale_bills', SaleBillController::class)->names([
                'index' => 'client.sale_bills.index',
                'create' => 'client.sale_bills.create',
                'update' => 'client.sale_bills.update',
                'destroy' => 'client.sale_bills.destroy',
                'edit' => 'client.sale_bills.edit',
                'store' => 'client.sale_bills.store',
                'show' => 'client.sale_bills.show',
            ]);
            Route::resource('sale-bills-new', SaleBillController1::class)->names([
                'index' => 'client.sale_bills.index1',
                'create' => 'client.sale_bills.create1',
                'update' => 'client.sale_bills.update1',
                'destroy' => 'client.sale_bills.destroy1',
                'edit' => 'client.sale_bills.edit1',
                'store' => 'client.sale_bills.store1',
                'show' => 'client.sale_bills.show1',
            ]);
            Route::get('/generate-invoice-pdf/{saleBillId}/{hashtoken?}/{invoiceType?}/{printColor?}/{isMoswada?}', [SaleBillController::class, 'generateInvoicePdf'])
                ->name('generate.invoice.pdf');

            Route::get('/print-demo', [SaleBillPrintDemoController::class, 'edit_print_demo'])->name('print.demo');
            Route::post('/print-demo-update', [SaleBillPrintDemoController::class, 'update_print_demo'])->name('print.demo.update');

            Route::POST('/updateInvTaxValue', [SaleBillController::class, 'updateInvTaxValue'])->name('updateInvTaxValue');
            Route::post('/sale-bills/get', [SaleBillController::class, 'get_product_price']);
            Route::post('/sale-bills/getOuterClientDetails', [SaleBillController::class, 'get_outer_client_details']);
            Route::post('/sale-bills/elements', [SaleBillController::class, 'get_sale_bill_elements']);
            Route::post('/sale-bills/element/delete', [SaleBillController::class, 'delete_element']);

            Route::post('/sale-bills/get-edit', [SaleBillController::class, 'get_edit_product_price']);
            Route::post('/sale-bills/element/update', [SaleBillController::class, 'update_element']);
            Route::post('/sale-bills/edit-element', [SaleBillController::class, 'edit_element']);

            Route::post('/sale-bills/post', [SaleBillController::class, 'save']);
            Route::post('/sale-bills/post1', [SaleBillController1::class, 'save']);
            Route::post('/sale-bills/update', [SaleBillController1::class, 'update']);
            Route::post('/sale-bills/discount', [SaleBillController::class, 'apply_discount']);
            Route::post('/sale-bills/extra', [SaleBillController::class, 'apply_extra']);
            Route::post('/sale-bills/updateData', [SaleBillController::class, 'updateData']);
            Route::post('/sale-bills/saveAll', [SaleBillController::class, 'saveAll']);
            Route::post('/sale-bills/saveAll1', [SaleBillController1::class, 'saveAll']);
            Route::post('/clients-store-cash-outer-clients-sale-bills', [SaleBillController::class, 'store_cash_outer_clients'])->name('client.store.cash.outerClients.SaleBill');
            Route::post('/clients-store-cash-outer-clients-sale-bills1', [SaleBillController1::class, 'store_cash_outer_clients'])->name('client.store.cash.outerClients.SaleBill1');
            Route::post('/sale-bills/refresh', [SaleBillController::class, 'refresh']);

            Route::post('clients-sale-bills-filter-key', [SaleBillController::class, 'filter_key'])->name('client.sale_bills.filter.key');
            Route::post('clients-sale-bills-filter-outer-client', [SaleBillController::class, 'filter_outer_client'])->name('client.sale_bills.filter.outer_client');
            Route::post('clients-sale-bills-filter-code', [SaleBillController::class, 'filter_code'])->name('client.sale_bills.filter.code');
            Route::post('clients-sale-bills-filter-product', [SaleBillController::class, 'filter_product'])->name('client.sale_bills.filter.product');

            ///new
            Route::post('client-sale-bills-copy', [SaleBillController::class, 'copy_product'])->name('client.sale_bills.copy');

            Route::post('clients-sale-bills-filter-all', [SaleBillController::class, 'filter_all'])->name('client.sale_bills.filter.all');

            Route::POST('/sale-bills/get-return', [SaleBillController::class, 'get_return'])->name('client.sale_bills.return');
            Route::get('/sale-bills/print-return/{id}', [SaleBillController::class, 'print_return']);
            Route::get('/sale-bills/print-returnAll/{bill_id}', [SaleBillController::class, 'print_returnAll']);
            Route::post('/sale-bills/post-return', [SaleBillController::class, 'post_return'])->name('client.sale_bills.post.return');
            Route::post('/sale-bills/post-returnAll', [SaleBillController::class, 'post_returnAll'])->name('client.sale_bills.post.returnAll');
            Route::get('/sale-bills/get-returns', [SaleBillController::class, 'get_returns'])->name('client.sale_bills.returns');
            Route::get('/sale-bills-redirect', [SaleBillController::class, 'redirect'])->name('client.sale_bills.redirect');
            Route::get('/sale-bills/send/{id?}', [SaleBillController::class, 'send'])->name('client.sale_bills.send');

            Route::post('/sale-bills/getProducts', [SaleBillController::class, 'get_products']);
            Route::delete('/sale-bills/deleteBill', [SaleBillController::class, 'delete_bill'])->name('client.sale_bills.deleteBill');
            Route::post('/sale-bills/deleteSaleBill', [SaleBillController::class, 'destroy'])->name('client.sale_bills.cancel');
            Route::post('/sale-bills/pay-delete', [SaleBillController::class, 'pay_delete'])->name('sale_bills.pay.delete');
            Route::post('/sale-bills/updateStatusOnEdit', [SaleBillController::class, 'updateStatusOnEdit'])->name('sale_bills.updateStatusOnEdit');
            Route::post('/sale_bills/toggle_status', [SaleBillController::class, 'toggleStatus'])->name('client.sale_bills.toggle_status');
            Route::get('/sale-bill/{id}', [SaleBillController::class, 'show'])->name('sale-bill-show');
            Route::get('/sale-bill1/{id}', [SaleBillController1::class, 'show'])->name('sale-bill-show1');


            // buy_bills Routes
            Route::resource('buy_bills', BuyBillController::class)->names([
                'index' => 'client.buy_bills.index',
                'create' => 'client.buy_bills.create',
                'update' => 'client.buy_bills.update',
                'destroy' => 'client.buy_bills.destroy',
                'edit' => 'client.buy_bills.edit',
                'store' => 'client.buy_bills.store',
                'show' => 'client.buy_bills.show',
            ]);

            Route::post('/buy-bills/get', [BuyBillController::class, 'get_product_price']);
            Route::post('/buy-bills/elements', [BuyBillController::class, 'get_buy_bill_elements']);
            Route::post('/buy-bills/element/delete', [BuyBillController::class, 'delete_element']);
            Route::post('/buy-bills/post', [BuyBillController::class, 'save']);
            Route::post('/buy-bills/discount', [BuyBillController::class, 'apply_discount']);
            Route::post('/buy-bills/extra', [BuyBillController::class, 'apply_extra']);
            Route::post('/buy-bills/updateData', [BuyBillController::class, 'updateData']);
            Route::post('/buy-bills/saveAll', [BuyBillController::class, 'saveAll']);
            Route::post('/clients-store-cash-suppliers-buy-bills', [BuyBillController::class, 'store_cash_suppliers'])->name('client.store.cash.suppliers.buyBill');
            Route::post('/buy-bills/refresh', [BuyBillController::class, 'refresh']);

            Route::post('/buy-bills/get-edit', [BuyBillController::class, 'get_edit_product_price']);
            Route::post('/buy-bills/element/update', [BuyBillController::class, 'update_element']);
            Route::post('/buy-bills/edit-element', [BuyBillController::class, 'edit_element']);

            Route::post('clients-buy-bills-filter-key', [BuyBillController::class, 'filter_key'])->name('client.buy_bills.filter.key');
            Route::post('clients-buy-bills-filter-supplier', [BuyBillController::class, 'filter_supplier'])->name('client.buy_bills.filter.supplier');
            Route::post('clients-buy-bills-filter-code', [BuyBillController::class, 'filter_code'])->name('client.buy_bills.filter.code');
            Route::post('clients-buy-bills-filter-product', [BuyBillController::class, 'filter_product'])->name('client.buy_bills.filter.product');
            Route::post('clients-buy-bills-filter-all', [BuyBillController::class, 'filter_all'])->name('client.buy_bills.filter.all');

            Route::post('/buy-bills/get-return', [BuyBillController::class, 'get_return']);
            Route::post('/buy-bills/post-return', [BuyBillController::class, 'post_return'])->name('client.buy_bills.post.return');
            Route::get('/buy-bills/get-returns', [BuyBillController::class, 'get_returns'])->name('client.buy_bills.returns');
            Route::get('/buy-bills-redirect', [BuyBillController::class, 'redirect'])->name('client.buy_bills.redirect');
            Route::get('/buy-bills/send/{id?}', [BuyBillController::class, 'send'])->name('client.buy_bills.send');

            Route::post('/buy-bills/getSupplierDetails', [BuyBillController::class, 'get_supplier_details']);
            Route::post('/buy-bills/getProducts', [BuyBillController::class, 'get_products']);
            Route::delete('/buy-bills/deleteBill', [BuyBillController::class, 'delete_bill'])->name('client.buy_bills.deleteBill');
            Route::post('/buy-bills/deleteBuyBill', [BuyBillController::class, 'destroy'])->name('client.buy_bills.cancel');
            Route::post('/buy-bills/pay-delete', [BuyBillController::class, 'pay_delete'])->name('buy_bills.pay.delete');

            // summary routes
            Route::get('/clients-summary-get', [SummaryController::class, 'get_clients_summary']);
            Route::get('/suppliers-summary-get', [SummaryController::class, 'get_suppliers_summary']);

            Route::get('/employees-summary-get', [SummaryController::class, 'get_employees_summary']);
            Route::post('/employees-summary-post', [SummaryController::class, 'post_employees_summary'])->name('employees.summary.post');

            Route::post('/clients-summary/send', [SummaryController::class, 'send_client_summary'])->name('client.summary.send');
            Route::post('/suppliers-summary/send', [SummaryController::class, 'send_supplier_summary'])->name('supplier.summary.send');

            // daily routes
            Route::get('/daily/get', [DailyController::class, 'get_daily']);
            Route::post('/daily/post', [DailyController::class, 'post_daily'])->name('client.daily.post');

            // reports
            Route::get('/reports', [ReportController::class, 'reports'])->name('client.reports');
            Route::get('/report1/get', [ReportController::class, 'get_report1']);
            Route::post('/report1/post', [ReportController::class, 'post_report1'])->name('client.report1.post');

            Route::get('/accounting_tree', [DailyController::class, 'accounting_tree'])->name('client.accounting_tree');
            Route::post('/accounting_tree/store', [DailyController::class, 'accounting_tree_store'])->name('client.accouning_tree.store');
            Route::post('get_data_accounting_tree', [DailyController::class, 'get_data_accounting_tree'])->name('client.accouning_tree.get_data');
            Route::post('edit-accounting_tree', [DailyController::class, 'edit_accounting_tree'])->name('client.accouning_tree.edit_data');
            Route::post('delete_data_accounting_tree', [DailyController::class, 'delete_data_accounting_tree'])->name('client.accouning_tree.delete_data');

            Route::get('/report2/get', [ReportController::class, 'get_report2']);
            Route::post('/report2/post', [ReportController::class, 'post_report2'])->name('client.report2.post');

            Route::get('/report3/get', [ReportController::class, 'get_report3']);
            Route::post('/report3/post', [ReportController::class, 'post_report3'])->name('client.report3.post');

            Route::get('/report4/get', [ReportController::class, 'get_report4']);
            Route::post('/report4/post', [ReportController::class, 'post_report4'])->name('client.report4.post');

            Route::get('/report5/get', [ReportController::class, 'get_report5']);
            Route::post('/report5/post', [ReportController::class, 'post_report5'])->name('client.report5.post');

            Route::get('/report6/get', [ReportController::class, 'get_report6']);
            Route::post('/report6/post', [ReportController::class, 'post_report6'])->name('client.report6.post');

            Route::get('/report7/get', [ReportController::class, 'get_report7']);
            Route::post('/report7/post', [ReportController::class, 'post_report7'])->name('client.report7.post');

            Route::get('/report8/get', [ReportController::class, 'get_report8']);
            Route::post('/report8/post', [ReportController::class, 'post_report8'])->name('client.report8.post');

            Route::get('/report9/get', [ReportController::class, 'get_report9']);
            Route::post('/report9/post', [ReportController::class, 'post_report9'])->name('client.report9.post');

            Route::get('/report10/get', [ReportController::class, 'get_report10']);
            Route::post('/report10/post', [ReportController::class, 'post_report10'])->name('client.report10.post');

            Route::get('/report11/get', [ReportController::class, 'get_report11']);
            Route::post('/report11/post', [ReportController::class, 'post_report11'])->name('client.report11.post');

            Route::get('/report12/get', [ReportController::class, 'get_report12']);
            Route::post('/report12/post', [ReportController::class, 'post_report12'])->name('client.report12.post');

            Route::get('/report13/get', [ReportController::class, 'get_report13']);
            Route::post('/report13/post', [ReportController::class, 'post_report13'])->name('client.report13.post');

            Route::get('/report14/get', [ReportController::class, 'get_report14']);
            Route::post('/report14/post', [ReportController::class, 'post_report14'])->name('client.report14.post');

            Route::get('/report15/get', [ReportController::class, 'get_report15']);
            Route::post('/report15/post', [ReportController::class, 'post_report15'])->name('client.report15.post');

            Route::get('/report16/get', [ReportController::class, 'get_report16']);
            Route::post('/report16/post', [ReportController::class, 'post_report16'])->name('client.report16.post');

            Route::get('/report17/get', [ReportController::class, 'get_report17']);
            Route::post('/report17/post', [ReportController::class, 'post_report17'])->name('client.report17.post');

            Route::get('/report18/get', [ReportController::class, 'get_report18']);
            Route::post('/report18/post', [ReportController::class, 'post_report18'])->name('client.report18.post');

            Route::get('/report19/get', [ReportController::class, 'get_report19']);
            Route::post('/report19/post', [ReportController::class, 'post_report19'])->name('client.report19.post');

            Route::get('/report20/get', [ReportController::class, 'get_report20']);
            Route::post('/report20/post', [ReportController::class, 'post_report20'])->name('client.report20.post');

            Route::get('/report21/get', [ReportController::class, 'get_report21']);
            Route::post('/report21/post', [ReportController::class, 'post_report21'])->name('client.report21.post');

            Route::get('/report22/get', [ReportController::class, 'get_report22']);
            Route::post('/report22/post', [ReportController::class, 'post_report22'])->name('client.report22.post');

            // Roles Routes
            Route::resource('roles', RoleController::class)->names([
                'index' => 'client.roles.index',
                'create' => 'client.roles.create',
                'update' => 'client.roles.update',
                'destroy' => 'client.roles.destroy',
                'edit' => 'client.roles.edit',
                'store' => 'client.roles.store',
            ]);

            Route::get('export-suppliers', [ImportExportController::class, 'export_suppliers'])->name('suppliers.export');
            Route::post('import-suppliers', [ImportExportController::class, 'import_suppliers'])->name('suppliers.import');

            Route::get('export-outer-clients', [ImportExportController::class, 'export_outer_clients'])->name('outer_clients.export');
            Route::post('import-outer-clients', [ImportExportController::class, 'import_outer_clients'])->name('outer_clients.import');

            Route::get('export-products', [ImportExportController::class, 'export_products'])->name('products.export');
            Route::post('import-products', [ImportExportController::class, 'import_products'])->name('products.import');

            // employees Routes
            Route::resource('employees', EmployeeController::class)->names([
                'index' => 'client.employees.index',
                'create' => 'client.employees.create',
                'update' => 'client.employees.update',
                'destroy' => 'client.employees.destroy',
                'edit' => 'client.employees.edit',
                'store' => 'client.employees.store',
            ]);

            Route::get('employees-cashs', [EmployeeController::class, 'cashs'])->name('employees.cashs');

            Route::get('employees-cash', [EmployeeController::class, 'get_cash'])->name('employees.get.cash');
            Route::post('employees-cash-post', [EmployeeController::class, 'post_cash'])->name('employees.post.cash');

            Route::get('employees-cash-edit/{id?}', [EmployeeController::class, 'edit_cash'])->name('employees.cash.edit');
            Route::patch('employees-cash-update/{id?}', [EmployeeController::class, 'update_cash'])->name('employees.cash.update');

            Route::delete('employees-cash-destroy', [EmployeeController::class, 'destroy_cash'])->name('employees.cash.destroy');


            //---------------------------------------------POS SECTION------------------------------------
            Route::get('pos-create/', [PosController::class, 'create2'])->name('client.pos.create');
            Route::get('pos-create2/', [PosController::class, 'create2'])->name('client.pos.create2');
            Route::get('sales_products_today/', [PosController::class, 'sales_products_today'])->name('client.pos.sales_products_today');
            Route::post('/pos/get-subcategories-by-category-id', [PosController::class, 'get_subcategories_by_category_id']);
            Route::post('/pos/get-subcategories-and-products', [PosController::class, 'getAllSubCatsAndProducts']);
            Route::post('/pos/get-products-by-sub-category-id', [PosController::class, 'get_products_by_sub_category_id']);
            Route::post('/pos/get-products-by-category-id', [PosController::class, 'get_products_by_category_id']);
            Route::post('/posTodayReport', [PosController::class, 'posTodayReport'])->name('posTodayReport');
            Route::post('/posReportsBetweenDates', [PosController::class, 'posReportsBetweenDates'])->name('posReportsBetweenDates');

            Route::post('/pos-open/post', [PosController::class, 'save']);
            Route::post('/pos-open/elements', [PosController::class, 'get_pos_open_elements']);
            Route::post('/pos-open/edit-quantity', [PosController::class, 'edit_quantity']);
            Route::post('/pos-open/edit-discount', [PosController::class, 'edit_discount']);
            Route::post('/pos-open/edit-price', [PosController::class, 'edit_price']);
            Route::post('/pos-open/delete-element', [PosController::class, 'delete_element']);

            Route::post('/store-tax', [SettingsController::class, 'store_tax'])->name('store.tax');
            Route::delete('/delete-tax', [SettingsController::class, 'delete_tax'])->name('delete.tax');

            Route::post('/pos-open-store-discount', [PosController::class, 'store_discount'])->name('pos.open.store.discount');
            Route::post('/pos-open-store-tax', [PosController::class, 'store_tax'])->name('pos.open.store.tax');
            Route::post('/pos-open-update_inclusive', [PosController::class, 'update_inclusive'])->name('pos.open.update_inclusive');
            Route::post('/pos-open-checkTaxEntka2ya', [PosController::class, 'checkTaxEntka2ya'])->name('pos.open.checkTaxEntka2ya');

            Route::post('/pos-open-delete', [PosController::class, 'delete_pos_open'])->name('pos.open.delete');
            Route::post('/pos-open-pending', [PosController::class, 'pending_pos_open'])->name('pos.open.pending');

            //button --> حفظ وطباعة
            Route::post('/pos-open-done', [PosController::class, 'done_pos_open'])->name('pos.open.done');
            Route::post('/pos-open-finish', [PosController::class, 'finish_pos_open'])->name('pos.open.finish');
            Route::post('/pos-open-finishBank', [PosController::class, 'finishBank_pos_open'])->name('pos.open.finishBank');
            Route::post('/pos-open-check', [PosController::class, 'check_pos_open'])->name('pos.open.check');
            Route::post('/pos-open-close', [PosController::class, 'close_pos_open'])->name('pos.open.close');
            Route::post('/pos-open-open', [PosController::class, 'open_pos_open'])->name('pos.open.open');

            Route::post('/pos-open-restore', [PosController::class, 'restore_pos_open'])->name('pos.open.restore');
            Route::post('/shuffle-coupon-codes', [PosController::class, 'shuffle_coupon_codes'])->name('shuffle.coupon.codes');
            Route::post('/add-coupon-code', [PosController::class, 'add_coupon_code'])->name('add.coupon.code');

            Route::post('/pos-open/refresh', [PosController::class, 'refresh']);
            Route::get('/pos-sales-report', [PosController::class, 'pos_sales_report'])->name('pos.sales.report');
            Route::get('/pos-sales-report-print', [PosController::class, 'pos_sales_report_print'])->name('pos.sales.report.print');
            Route::get('/pos-sales-report-print-today', [PosController::class, 'pos_sales_report_print_today'])->name('pos.sales.report.print-today');
            Route::get('/pos-sales-report-button-print-today', [PosController::class, 'pos_sales_report_print_today_button'])->name('pos.sales.report.button.print-today');

            Route::get('/pos-printProductSales', [PosController::class, 'printProductSales'])->name('pos.printProductSales');

            Route::post('/pos-edit', [PosController::class, 'pos_edit'])->name('pos.edit');
            Route::post('/pos-delete', [PosController::class, 'pos_delete'])->name('pos.delete');
            Route::post('/pay-delete', [PosController::class, 'pay_delete'])->name('pay.delete');
            Route::post('/get-coupon-codes', [PosController::class, 'get_coupon_codes'])->name('get.coupon.codes');

            // pos-invoice -- فاتورة الاعداد
            Route::get('/prod_pos/{invID}', [PosController::class, 'prod_pos'])->name('pos.prod_pos');


            // Journal routes voucher routes
            Route::get('/voucher/create', [VoucherController::class, 'create_voucher_entries'])->name('client.voucher.create');
            Route::get('/vouchers', [VoucherController::class, 'get_voucher_entries'])->name('client.voucher.get');
            Route::post('/voucher/store', [VoucherController::class, 'store'])->name('client.voucher.store');
            Route::get('/account/{accountId}/statement', [VoucherController::class, 'showAccountStatement'])->name('account.statement');

            // Route::post('/journal/store', [VoucherController::class, 'store_journal_entries'])->name('client.journal.store');

            // Cost Center routes
            Route::get('/cost_center/get', [CostCenterController::class, 'index'])->name('client.cost_center');
            Route::get('/cost_center/create', [CostCenterController::class, 'create_cost_center'])->name('client.cost_center.create');
            Route::post('/cost_center/get', [CostCenterController::class, 'get_cost_center'])->name('client.cost_center.get');
            Route::post('/cost_center/store', [CostCenterController::class, 'store_cost_center'])->name('client.cost_center.store');
            Route::post('/cost_center/edit_cost_center', [CostCenterController::class, 'edit_cost_center'])->name('client.cost_center.edit_data');
            Route::get('/cost_center/edit/{id}', [CostCenterController::class, 'edit'])->name('client.cost_center.edit');
            Route::post('/cost_center/delete_cost_center', [CostCenterController::class, 'delete_cost_center'])->name('client.cost_center.delete_data');

            // Bonds routes
            Route::get('/clients-bonds/index', [BondsController::class, 'getClientsBonds'])->name('client.bonds.index');
            Route::get('/clients-bonds/create', [BondsController::class, 'createClientsBonds'])->name('client.bonds.create');
            Route::get('/suppliers-bonds/index', [BondsController::class, 'getSuppliersBonds'])->name('supplier.bonds.index');
            Route::get('/suppliers-bonds/create', [BondsController::class, 'createSuppliersBonds'])->name('supplier.bonds.create');

            // Assets routes
            Route::get('/assets/fixed-assets/index', [AssetsController::class, 'getStaticAssets'])->name('fixed.assets.index');
            Route::get('/assets/fixed-assets/create', [AssetsController::class, 'createStaticAssets'])->name('fixed.assets.create');
            Route::get('/depreciations/index', [AssetsController::class, 'getDeprec'])->name('client.depreciations.index');
            Route::get('/depreciations/create', [AssetsController::class, 'createDeprec'])->name('client.depreciations.create');
            Route::resource('groupes', GroupeController::class);
            Route::resource('building_roles', BuildingRoleController::class);
            Route::resource('rooms', RoomController::class);
            Route::resource('places', PlaceController::class);
            Route::resource('countries', CountryController::class);
            Route::resource('/assets/category', CategoriesAssetController::class);
            Route::get('/categories/export/excel', [CategoriesAssetController::class, 'exportExcel'])->name('category.export.excel');
            Route::get('/groups/export/excel', [GroupeController::class, 'exportExcel'])->name('groupe.export.excel');
            Route::get('/countries/export/excel', [CountryController::class, 'exportExcel'])->name('countries.export.excel');
            Route::get('/building_roles/export/excel', [BuildingRoleController::class, 'exportExcel'])->name('building_roles.export.excel');
            Route::get('/rooms/export/excel', [RoomController::class, 'exportExcel'])->name('rooms.export.excel');
            Route::get('/places/export/excel', [PlaceController::class, 'exportExcel'])->name('places.export.excel');

            // Coupons Routes
            Route::resource('coupons', CouponController::class)->names([
                'index' => 'client.coupons.index',
                'create' => 'client.coupons.create',
                'update' => 'client.coupons.update',
                'destroy' => 'client.coupons.destroy',
                'edit' => 'client.coupons.edit',
                'store' => 'client.coupons.store',
            ]);

            Route::post('/get-coupon-code', [PosController::class, 'get_coupon_code'])->name('get.coupon.code');
            Route::post('/getNewPosBillID', [PosController::class, 'getNewPosBillID'])->name('getNewPosBillID');
            Route::post('/clients-store-cash-clients-pos', [PosController::class, 'store_cash_clients'])
                ->name('client.store.cash.clients.pos');
            // Route::resource('Manufactures', ManufactureController::class);
            Route::resource('manufactures', ManufactureController::class)->names([
                'index' => 'client.manufactures.index',
                'create' => 'client.manufactures.create',
                'update' => 'client.manufactures.update',
                'destroy' => 'client.manufactures.destroy',
                'edit' => 'client.manufactures.edit',
                'store' => 'client.manufactures.store',
                'show' => 'client.manufactures.show',
            ]);
            Route::get('manufactures/{manufacturing}/status', [ManufactureController::class, 'cancel'])->name('client.manufactures.cancel');
        }
    );
});

Route::get('/get_csid', 'FatooraController@get_csid');
