<?php

namespace App\Exports;

use App\Models\Place;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlaceExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Place::all();
    }
}
