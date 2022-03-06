<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('view', 'orders');
        return OrderResource::collection(Order::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        Gate::authorize('view', 'orders');
        return new OrderResource($order);
    }



    /**
     * Export order data to csv file
     *
     * @return void
     */
    public function export()
    {
        $headers = [
            'Content-type'          =>  'text/csv',
            'Content-Disposition'   =>  'attachment; filename=orders.csv',
            "Pragma"    =>  'no-cache',
            'Cache-Control' =>  'must-revalidate, post-check=0, pre-check=0',
            "Expires"   =>  0,
        ];

        $callback = function(){
            $orders = Order::all();
            $file = fopen("php://output", 'w');
            fputcsv($file, ['Id', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);
            foreach($orders as $order){
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);
                foreach($order->orderItems as $orderItem){
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

}
