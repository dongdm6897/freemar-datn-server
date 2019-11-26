<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveProviderOrderCode  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order_code;
    protected $shipping_status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_code, $shipping_status)
    {
        $this->order_code = $order_code;
        $this->shipping_status = $shipping_status;
    }

    /**
     * Execute the job.
     *

     */
    public function  handle()
    {
        $query = Order::where('provider_order_code',$this->order_code)
            ->update(['shipping_status_id' =>$this->shipping_status]);
        return $query;
    }
}
