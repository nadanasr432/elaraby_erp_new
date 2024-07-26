<?php

namespace App\Exports;

use App\Models\Groupe;
use Maatwebsite\Excel\Concerns\FromCollection;

class GroupeExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Groupe::all();
    }
}
