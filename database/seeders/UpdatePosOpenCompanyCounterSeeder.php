<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdatePosOpenCompanyCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            // Get all unique company_ids from pos_open table
            $companyIds = DB::table('pos_open')
                ->distinct()
                ->pluck('company_id');

            foreach ($companyIds as $companyId) {
                // Get all pos_open records for this company, ordered by created_at
                $posOpenRecords = DB::table('pos_open')
                    ->where('company_id', $companyId)
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Assign company_counter starting from 1
                foreach ($posOpenRecords as $index => $record) {
                    DB::table('pos_open')
                        ->where('id', $record->id)
                        ->update(['company_counter' => $index + 1]);
                }
            }

            DB::commit();
            Log::info('UpdatePosOpenCompanyCounterSeeder completed successfully.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('UpdatePosOpenCompanyCounterSeeder failed: ' . $e->getMessage());
            throw $e; // Re-throw to halt execution and show error in console
        }
    }
}
