<?php

namespace App\Events;

use App\Models\SaleBill1;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaleBillCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $saleBill;

    public function __construct(SaleBill1 $saleBill)
    {
        $this->saleBill = $saleBill;
    }
}
