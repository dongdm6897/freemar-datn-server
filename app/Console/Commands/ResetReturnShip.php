<?php

namespace App\Console\Commands;

use App\Models\Order;
use DB;
use Illuminate\Console\Command;
use App\Enums\OrderStatusEnum;

class ResetReturnShip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'returnShip:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return Shipping';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::select('call resetReturnShipping(?,?,?)',
            [OrderStatusEnum::TRANSACTION_FINISHED, OrderStatusEnum::SHIP_DONE, OrderStatusEnum::ASSESSMENT]
        );
        return;
    }
}
