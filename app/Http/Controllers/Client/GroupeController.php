<?php

namespace App\Http\Controllers\Client;

use App\Models\Groupe;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use App\Exports\GroupeExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Groupe::all();
        return view('client.assets.groupes.index', compact('categories'));
    }
    public function exportExcel()
    {
        return Excel::download(new GroupeExport, 'categories.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestGroupee = Groupe::orderBy('code', 'desc')->first();
        $newCode = $latestGroupee ? sprintf('%03d', $latestGroupee->code + 1) : '001';

        return view('client.assets.groupes.create', compact('newCode'));
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

        Groupe::create($request->all());
        return redirect()->route('groupes.index')->with('success', 'Groupee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function edit(Groupe $groupe)
    {
        return view('groupes.edit', compact('Groupe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Groupe $groupe)
    {
        $request->validate([
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'code' => 'required|string|max:3',
        ]);

        $groupe->update($request->all());
        return redirect()->route('groupes.index')->with('success', 'Groupe updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groupe $groupe)
    {
        //
    }
}