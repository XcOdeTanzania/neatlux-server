<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $order->product =  Product::withTrashed()->find($order->product_id);
        }

        $response = ['orders' => $orders, 'status' => true];
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getOrder($orderId)
    {

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found', 'status' => false], 404);
        }


        return response()->json(['order' => $order, 'status' => true], 200, [], JSON_NUMERIC_CHECK);
    }

    public function postOrder(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false], 404);
        }

        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'product not found', 'status' => false], 404);
        }

        //  $hashedPassword = app('hash')->make($plainPassword);
        $lastOrder = Order::orderBy('created_at', 'desc')->first();
        if (!$lastOrder)
            $number = 0;
        else
            $number = substr($lastOrder->member_id, 3);

        $orderId = 'NEAT' . sprintf('%05d', intval($number) + 1) . 'LUX';

        $order = new Order();
        $order->phone = $request->input('phone');
        $order->number = $orderId;
        $order->status = true;

        $product->orders()->save($order);

        return response()->json(['order' => $order, 'status' => true], 200, [], JSON_NUMERIC_CHECK);
    }


    public function putOrder(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false], 404);
        }
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found',  'status' => false], 404);
        }

        $order->update([
            'status' => $request->input('status')
        ]);

        return response()->json(['order' => $order, 'status' => true], 200, [], JSON_NUMERIC_CHECK);
    }


    public function deleteOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'order not found', 'status' => false], 404);
        }

        $order->delete();
        return response()->json(['message' => 'order deleted successfully', 'status' => true], 200);
    }
}
