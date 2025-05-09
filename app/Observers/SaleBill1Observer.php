<?php

namespace App\Observers;

use App\Models\SaleBill1;
use Illuminate\Support\Facades\Log;

class SaleBill1Observer
{
    /**
     * Handle the SaleBill1 "created" event.
     */
    public function created(SaleBill1 $saleBill)
    {
        Log::info('SaleBill1 created, event dispatched', ['saleBillId' => $saleBill->id]);
    }

    /**
     * Handle the SaleBill1 "updated" event.
     */
    public function updated(SaleBill1 $saleBill)
    {
        // Skip if the update only affects ZATCA-related fields
        if ($saleBill->wasChanged(['zatca_status', 'zatca_hash', 'uuid', 'zatca_date', 'zatca_error'])) {
            Log::info('SaleBill1 updated with ZATCA fields, skipping event dispatch', ['saleBillId' => $saleBill->id]);
            return;
        }

        // Optionally handle other updates if needed (e.g., re-send to ZATCA for specific changes)
        Log::info('SaleBill1 updated, dispatching SaleBillCreated event', ['saleBillId' => $saleBill->id]);
        event(new \App\Events\SaleBillCreated($saleBill));
    }
}
