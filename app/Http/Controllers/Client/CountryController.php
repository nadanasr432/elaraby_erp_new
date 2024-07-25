<?php

namespace App\Http\Controllers\Client;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Exports\CountryExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    public function index()
    {
        $categories = Country::all();
        return view('client.assets.countries.index', compact('categories'));
    }
    public function exportExcel()
    {
        return Excel::download(new CountryExport, 'categories.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestcountriee = Country::orderBy('code', 'desc')->first();
        $newCode = $latestcountriee ? sprintf('%03d', $latestcountriee->code + 1) : '001';

        return view('client.assets.countries.create', compact('newCode'));
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

        Country::create($request->all());
        return redirect()->route('countries.index')->with('success', 'countriee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('countries.edit', compact('countrie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'code' => 'required|string|max:3',
        ]);

        $country->update($request->all());
        return redirect()->route('countries.index')->with('success', 'countrie updated successfully.');
    }

}
