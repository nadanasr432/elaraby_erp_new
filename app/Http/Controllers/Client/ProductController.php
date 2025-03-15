<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Combo;
use App\Models\Store;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ServiceRequest;

class ProductController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;

        // Validate that the company exists
        $company = Company::findOrFail($company_id);

        // Fetch products explicitly tied to the company
        $products = Product::where('company_id', $company_id)
            ->where(function ($query) {
                $query->where('first_balance', '>', 0)
                    ->orWhereNull('first_balance');
            })
            ->get();


        $purchase_prices = [];
        $balances = [];

        foreach ($products as $product) {
            $product_price = $product->purchasing_price;
            $product_balance = $product->first_balance;

            array_push($balances, $product_balance);

            // Calculate only if both are integers
            if (is_numeric($product_balance) && is_numeric($product_price)) {
                $total_price = $product_price * $product_balance;
                array_push($purchase_prices, $total_price);
            }
        }

        $total_purchase_prices = array_sum($purchase_prices);
        $total_balances = array_sum($balances);

        return view('client.products.index', compact('company', 'total_balances', 'total_purchase_prices', 'company_id', 'products'));
    }
    public function deleted_products()
    {
        $company_id = Auth::user()->company_id;

        // Validate that the company exists
        $company = Company::findOrFail($company_id);

        // Fetch products explicitly tied to the company
        $products = Product::where('company_id', $company_id)->onlyTrashed()
            ->where(function ($query) {
                $query->where('first_balance', '>', 0)
                    ->orWhereNull('first_balance');
            })
            ->get();


        $purchase_prices = [];
        $balances = [];

        foreach ($products as $product) {
            $product_price = $product->purchasing_price;
            $product_balance = $product->first_balance;

            array_push($balances, $product_balance);

            // Calculate only if both are integers
            if (is_numeric($product_balance) && is_numeric($product_price)) {
                $total_price = $product_price * $product_balance;
                array_push($purchase_prices, $total_price);
            }
        }

        $total_purchase_prices = array_sum($purchase_prices);
        $total_balances = array_sum($balances);

        return view('client.products.deleted_products', compact('company', 'total_balances', 'total_purchase_prices', 'company_id', 'products'));
    }
    public function restore(Request $request)
    {
        $request->validate([
            'productid' => 'required|exists:products,id',
        ]);
        $product = Product::withTrashed()->findOrFail($request->productid);
        $product->restore();
        return back()
        ->with('success', 'تم استرجاع المنتج بنجاح');
    }


    public function createservice()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id', $company_id)->get();
        $categories = Category::where(['company_id' => $company_id, 'category_name' => 'خدمية'])->get();
        $sub_categories = SubCategory::where('company_id', $company_id)->get();
        $units = $company->units;
        $check = Product::where('company_id', $company_id)->get();
        if ($check->isEmpty()) {
            $code_universal = "100000001";
        } else {
            do {
                $code_universal = time() . substr(time(), 0, 2);
                $exists = Product::where('code_universal', $code_universal)->exists();
            } while ($exists);
        }
        return view(
            'client.products.createservice',
            compact('company_id', 'units', 'sub_categories', 'code_universal', 'categories', 'stores', 'company')
        );
    }

    public function empty()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '<=', 0)
            ->get();
        return view('client.products.empty', compact('company', 'company_id', 'products'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id', $company_id)->get();
        $categories = Category::where('company_id', $company_id)->get();
        $sub_categories = SubCategory::where('company_id', $company_id)->get();
        $units = $company->units;
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '!=', 0)
            ->whereHas('category', function ($query) {
                $query->where('category_type', 'مخزونية');
            })->get();
        $check = Product::where('company_id', $company_id)->get();
        if ($check->isEmpty()) {
            $code_universal = "100000001";
        } else {
            do {
                $code_universal = time() . substr(time(), 0, 2);
                $exists = Product::where('code_universal', $code_universal)->exists();
            } while ($exists);
        }

        return view(
            'client.products.create',
            compact('company_id', 'units', 'sub_categories', 'code_universal', 'categories', 'stores', 'company','products')
        );
    }

    public function store_pos(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();

        $data['company_id'] = Auth::user()->company_id;
        $product = Product::create($data);
        if ($product) {
            return response()->json([
                'status' => true,
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'code_universal' => $product->code_universal,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى تسجيل الدفع النقدى حاول مرة اخرى',
            ]);
        }
    }

    public function store(ProductRequest $request)
    {
        // dd($request);
        $data = $request->all();

        if (empty($data['first_balance'])) $data['first_balance'] = 0;
        if (empty($data['qr'])) $company_id = $data['company_id'];

        // Check for category if khadamya
        $cat = Category::find($data['category_id']);
        if ($cat->category_type == 'خدمية') $data['first_balance'] = 10000000;

        // Create the main product
        $product = Product::create($data);
        if ($cat->category_type != 'خدمية') {
            StockService::record($product, $product->store_id, $product->first_balance);
        }

        // Handle file upload for product_pic
        if ($request->hasFile('product_pic')) {
            $image = $request->file('product_pic');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/products/' . $product->id;
            $image->move($uploadDir, $fileName);
            $product->product_pic = $uploadDir . '/' . $fileName;
            $product->save();
        }

        // Save combo products
        if (!empty($data['combo_products'])) {
            foreach ($data['combo_products'] as $comboProductData) {
                $comboProductData['parent_id'] = $product->id;
                Combo::create($comboProductData);
            }
        }

        return redirect()->route('client.products.index')
            ->with('success', 'تم اضافة المنتج بنجاح');
    }
    public function storeProduct(ServiceRequest $request)
    {
        $data = $request->all();
        if (empty($data['first_balance'])) $data['first_balance'] = 0;
        if (empty($data['qr'])) $company_id = $data['company_id'];

        // Check for category if khadamya
        $cat = Category::find($data['category_id']);
        if ($cat->category_type == 'خدمية') $data['first_balance'] = 10000000;

        // Create the main product
        $product = Product::create($data);

        // Handle file upload for product_pic
        if ($request->hasFile('product_pic')) {
            $image = $request->file('product_pic');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/products/' . $product->id;
            $image->move($uploadDir, $fileName);
            $product->product_pic = $uploadDir . '/' . $fileName;
            $product->save();
        }

        // Save combo products
        if (!empty($data['combo_products'])) {
            foreach ($data['combo_products'] as $comboProductData) {
                $comboProductData['parent_id'] = $product->id;
                Combo::create($comboProductData);
            }
        }

        return redirect()->route('client.products.index')
            ->with('success', 'تم اضافة المنتج بنجاح');
    }

    public function show($id)
    {
        $product = Product::FindOrFail($id);
        return view('client.products.show', compact('product'));
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id', $company_id)->get();
        $categories = Category::where('company_id', $company_id)->get();
        $sub_categories = SubCategory::where('company_id', $company_id)->get();
        $product = Product::findOrFail($id);
        $units = $company->units;
        return view('client.products.edit', compact('stores', 'sub_categories', 'units', 'categories', 'product', 'company_id', 'company'));
    }

    public function update(ProductRequest  $request, $id)
    {
        $data = $request->all();

        // check for category if khadamya
        $cat = Category::find($data['category_id']);
        if ($cat->category_type == 'خدمية') $data['first_balance'] = 10000000;

        $data['viewed'] = 0;
        $company_id = $data['company_id'];
        $product = Product::findOrFail($id);
        $product->update($data);
        if ($request->hasFile('product_pic')) {
            $image = $request->file('product_pic');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/products/' . $product->id;
            $image->move($uploadDir, $fileName);
            $product->product_pic = $uploadDir . '/' . $fileName;
            $product->save();
        }
        return redirect()->route('client.products.index')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    public function destroy(Request $request)
    {
        $product = Product::FindOrFail($request->productid);
        $product->delete();
        return redirect()->route('client.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
    public function print()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '>', 0)
            ->get();
        return view('client.products.print', compact('products', 'company'));
    }
    public function limited()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '>', '0')
            ->whereColumn('first_balance', '<', 'min_balance')
            ->get();
        return view('client.products.limited', compact('company', 'company_id', 'products'));
    }
    // public function products_expires()
    // {
    //     $company_id = Auth::user()->company_id;
    //     // Assuming $company_id is already defined
    //     $company = Company::find($company_id);

    //     // Calculate remaining days until expiration based on $expDuration
    //     $expDuration = $company->extra_settings->exp_duration;

    //     // Get current date
    //     $currentDate = Carbon::now();

    //     // Query to fetch products
    //     $products = Product::where('company_id', $company_id)
    //     ->where(function ($query) use ($expDuration, $currentDate) {
    //         // Calculate the condition for remaining days
    //         $query->whereRaw('DATEDIFF(end_date, ?) <= DATEDIFF(end_date, start_date) * ?', [$currentDate, $expDuration]);
    //     })
    //         ->get();
    //     // dd($products);

    //     return view('client.products.expired', compact('company', 'company_id', 'products'));
    // }
    public function products_expires(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);

        // Calculate remaining days until expiration based on $expDuration
        $expDuration = $company->extra_settings->exp_duration;

        // Get current date
        $currentDate = Carbon::now();

        // Get start date, end date, and expiry status from request, if available
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $expiryStatus = $request->input('expiry_status');

        // Query to fetch products
        $products = Product::where('company_id', $company_id)
            ->where(function ($query) use ($expDuration, $currentDate, $startDate, $endDate, $expiryStatus) {
                // Calculate the condition for remaining days
                $query->whereRaw('DATEDIFF(end_date, ?) <= DATEDIFF(end_date, start_date) * ?', [$currentDate, $expDuration]);

                // Add start date and end date filters if provided
                if ($startDate) {
                    $query->where('start_date', '>=', $startDate);
                }
                if ($endDate) {
                    $query->where('end_date', '<=', $endDate);
                }

                // Add expiry status filter if provided
                if ($expiryStatus === 'expired') {
                    $query->where('end_date', '<', $currentDate);
                } elseif ($expiryStatus === 'soon_expired') {
                    $query->whereRaw('DATEDIFF(end_date, ?) >= ?', [$currentDate, $expDuration]);
                }
            })
            ->get();

        return view('client.products.expired', compact('company', 'company_id', 'products'));
    }


    public function barcode()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = Product::where('company_id', $company_id)
            ->where('code_universal', '!=', '')
            ->get();
        return view('client.products.generate', compact('products'));
    }
    public function generate_barcode(Request $request)
    {
        $count = $request->count;
        $exp_date = $request->exp_date;
        $start_date = $request->start_date;
        $product = Product::FindOrFail($request->product_id);
        return view('client.products.barcode', compact('product', 'count', 'exp_date', 'start_date'));
    }
   public function getStoreProducts(Request $request)
    {
        $storeId = $request->store_id;
    
        if (!$storeId) {
            return response()->json(['error' => 'Store ID is required'], 400);
        }
    
        $company_id = Auth::user()->company_id;
        $company = Company::findOrFail($company_id);
        $stores = $company->stores; // Now, this is defined before using it
        $flatStores = $stores->pluck('id')->toArray();
    
    $products = Product::where('company_id', $company_id)
    ->where(function ($query) use ($flatStores) {
        $query->whereIn('store_id', $flatStores)
              ->where(function ($q) {
                  $q->where('first_balance', '>', 0)
                    ->orWhereNull('first_balance');
              });
    })
    ->orWhere(function ($query) use ($company_id) {
        $query->where('company_id', $company_id)
              ->whereHas('category', function ($q) {
                  $q->where('category_type', 'خدمية');
              });
    })
    ->get();

    
    
        return response()->json($products);
    }
     





    //check if there are products out of stock...
    public function getNumProductsOutOfStock()
    {
        $num = Product::where('company_id', Auth::user()->company_id)
            ->where('first_balance', '<=', 0)
            ->where('viewed', 0)
            ->count();
        return json_encode($num);
    }

    //set products that are out of stock ===> ok i viewed it...
    public function setProductsOutOfStockViewed()
    {
        $products = Product::where('company_id', Auth::user()->company_id)
            ->where('first_balance', '<=', 0)
            ->get();

        foreach ($products as $prod) {
            $prod->viewed = 1;
            $prod->save();
        }
    }
    public function search(Request $request)
    {
        $query = $request->get('query');

        $products = Product::where('product_name', 'like', '%' . $query . '%')
            ->orWhere('purchasing_price', 'like', '%' . $query . '%')
            ->orWhere('first_balance', 'like', '%' . $query . '%')
            ->get();

        return response()->json($products);
    }
     public function getStoreProducts(Request $request)
    {
        $products = Product::where('store_id', $request->store_id)->get();
        
        return response()->json($products);
    }
}
