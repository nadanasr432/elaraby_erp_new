<?php
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('products/{id?}', ['middleware' => 'auth.basic', function ($id = null) {
    if ($id == null) {
        $products = Product::all(array('id', 'product_name', 'first_balance'));
    } else {
        $products = Product::FindOrFail($id, array('id', 'product_name', 'first_balance'));
    }
    return Response::json(array(
        'error' => false,
        'products' => $products,
        'status_code' => 200
    ));
}]);
