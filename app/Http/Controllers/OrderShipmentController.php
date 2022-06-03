<?php

namespace App\Http\Controllers;

use App\Events\OrderShipped;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderShipmentController extends Controller
{
    public function index() {
        return view('welcome');
    }
    //To dispatch an event, you may call the static dispatch
    // method on the event. This method is made available on the event
    // by the Illuminate\Foundation\Events\Dispatchable trait.
    // Any arguments passed to the dispatch method will be passed to
    // the event's constructor:

    public function store(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        // Order shipment logic...

        OrderShipped::dispatch($order);
    }
}
