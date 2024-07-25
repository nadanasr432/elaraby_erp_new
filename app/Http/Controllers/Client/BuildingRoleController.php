<?php

namespace App\Http\Controllers\Client;

use App\Models\BuildingRole;
use Illuminate\Http\Request;
use App\Exports\BuildingRoleExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class BuildingRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BuildingRole::all();
        return view('client.assets.buildingRoles.index', compact('categories'));
    }
    public function exportExcel()
    {
        return Excel::download(new BuildingRoleExport, 'categories.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestbuilding_rolee = BuildingRole::orderBy('code', 'desc')->first();
        $newCode = $latestbuilding_rolee ? sprintf('%03d', $latestbuilding_rolee->code + 1) : '001';

        return view('client.assets.buildingRoles.create', compact('newCode'));
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

        BuildingRole::create($request->all());
        return redirect()->route('building_roles.index')->with('success', 'building_rolee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuildingRole  $building_role
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingRole $building_role)
    {
        return view('building_roles.edit', compact('building_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuildingRole  $building_role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuildingRole $building_role)
    {
        $request->validate([
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'code' => 'required|string|max:3',
        ]);

        $building_role->update($request->all());
        return redirect()->route('building_roles.index')->with('success', 'building_role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BuildingRole $buildingRole)
    {
        //
    }
}
