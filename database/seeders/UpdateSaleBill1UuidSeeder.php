<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleBill1; // Replace with your actual model
use Illuminate\Support\Str;

class UpdateSaleBill1UuidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Process records in chunks to avoid memory issues
        SaleBill1::whereNull('uuid')->chunk(1000, function ($saleBills) {
            $updates = [];
            foreach ($saleBills as $saleBill) {
                $updates[] = [
                    'id' => $saleBill->id,
                    'uuid' => Str::uuid(),
                ];
            }

            // Perform bulk update
            SaleBill1::upsert($updates, ['id'], ['uuid']);
        });

        $this->command->info('UUIDs have been updated for SaleBill1 records.');
    }
}
