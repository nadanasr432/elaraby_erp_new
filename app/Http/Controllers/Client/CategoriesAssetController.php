<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\CategoriesAsset;
use App\Exports\CategoriesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoriesAsset::all();
        return view('client.assets.categoriesAssets.index', compact('categories'));
    }
    public function exportExcel()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestCategory = CategoriesAsset::orderBy('code', 'desc')->first();
        $newCode = $latestCategory ? sprintf('%03d', $latestCategory->code + 1) : '001';

        return view('client.assets.categoriesAssets.create', compact('newCode'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description_ar' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'code' => 'required|string|max:3',
        ]);

        CategoriesAsset::create($request->all());
        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoriesAsset  $CategoriesAsset
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoriesAsset $CategoriesAsset)
    {
        return view('CategoriesAssets.edit', compact('CategoriesAsset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoriesAsset  $CategoriesAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriesAsset $CategoriesAsset)
    {
        $request->validate([
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'code' => 'required|string|max:3',
        ]);

        $CategoriesAsset->update($request->all());
        return redirect()->route('category.index')->with('success', 'CategoriesAsset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriesAsset $categoriesAsset)
    {
        //
    }
}
