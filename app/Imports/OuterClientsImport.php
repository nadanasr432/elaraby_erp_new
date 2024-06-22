<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\OuterClient;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class OuterClientsImport implements ToModel, WithBatchInserts ,SkipsEmptyRows
{
    function model(array $row)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $now = date("Y-m-d H:i:s");
        return new OuterClient([
            'company_id' => $company_id,
            'client_name' => $row[0],
            'client_category' => 'جملة',
            'prev_balance' => $row[1],
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
