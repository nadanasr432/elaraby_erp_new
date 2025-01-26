<?php

namespace App\Exports;

use App\Models\SaleBill;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class SaleBillsExport implements FromView
{
    protected $date;

    public function __construct($date = null)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $company_id = Auth::user()->company_id;

        // Filter data based on the date
        $query = SaleBill::query();

        if ($this->date) {
            $query->where('company_id', $company_id)->whereDate('date', $this->date);
        }

        $sale_bills = $query->where('company_id', $company_id)->get();

        return view('client.sale_bills1.export', compact('sale_bills'));
    }
}
