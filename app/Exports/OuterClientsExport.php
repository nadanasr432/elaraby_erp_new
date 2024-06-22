<?php

namespace App\Exports;

use App\Models\OuterClient;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class OuterClientsExport implements FromCollection
{
    public function collection()
    {
        $company_id = Auth::user()->company_id;
        return OuterClient::select('client_name','prev_balance')
            ->where('company_id', $company_id)->get();
    }
}
