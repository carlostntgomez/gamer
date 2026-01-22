<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AssignUuidsToExistingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-uuids-to-existing-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigns UUIDs to existing orders that do not have one.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ordersWithoutUuid = Order::whereNull('uuid')->get();

        if ($ordersWithoutUuid->isEmpty()) {
            $this->info('All existing orders already have a UUID.');
            return Command::SUCCESS;
        }

        $this->info(sprintf('Assigning UUIDs to %d existing orders...', $ordersWithoutUuid->count()));

        $ordersWithoutUuid->each(function (Order $order) {
            $order->uuid = (string) Str::uuid();
            $order->save();
            $this->comment(sprintf('Assigned UUID %s to order ID %d.', $order->uuid, $order->id));
        });

        $this->info('UUID assignment complete!');

        return Command::SUCCESS;
    }
}