<?php

namespace App\Console\Commands;

use App\Jobs\CreateOrders;
use App\Models\Order;
use Illuminate\Console\Command;

class CreateOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It dispatches a job that creates the orders';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::query()->each(function ($order){
            $this->info($order->id . ' updated.');
            sleep(2);
           CreateOrders::dispatchNow($order);
        });

        return 0;
    }
}
