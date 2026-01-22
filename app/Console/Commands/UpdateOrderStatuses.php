<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus; // Importar el Enum para usar sus valores

class UpdateOrderStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-order-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates old "completed" order statuses to "delivered" in status histories.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting order status update...');

        $updatedCount = DB::table('order_status_histories')
            ->where('status', 'completed')
            ->update(['status' => OrderStatus::Delivered->value]); // Usar el valor del Enum Delivered

        $this->info("Updated {$updatedCount} records from 'completed' to 'delivered'.");

        $this->info('Order status update complete.');
    }
}