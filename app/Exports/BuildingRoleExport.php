<?php

namespace App\Exports;


use App\Models\BuildingRole;
use Maatwebsite\Excel\Concerns\FromCollection;

class BuildingRoleExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BuildingRole::all();
    }
}
