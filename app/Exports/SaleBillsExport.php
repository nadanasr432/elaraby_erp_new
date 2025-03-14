<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\SaleBill;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class SaleBillsExport implements FromView
{
    protected $from, $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);
        // Filter data based on the date
        $query = SaleBill::query();
        if ($this->from && $this->to) {
            $query->where('company_id', $company_id)
                ->whereBetween('date', [$this->from, $this->to]);
        }
        $sale_bills = $query->where('company_id', $company_id)->get();

        return view('client.sale_bills1.export', compact('sale_bills','company'));
    }
}
