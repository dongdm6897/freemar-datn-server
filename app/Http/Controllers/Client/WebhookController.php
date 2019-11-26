<?php

namespace App\Http\Controllers\Client;

use App\Models\Webhook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebhookController extends Controller{
    public function handle(Request $request){
        $name = $request->phone;
        $webhook = new Webhook();
        $webhook->phone = $request->phone;
        $webhook->save();

        dd($request->getContent());
    }

    public function receive(Request $request){
        dd($request->getContent());
    }
}



