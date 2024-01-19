<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SnapController extends Controller
{
    public function token(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey ='SB-Mid-server-Ts3-hKQ9aUU6Y7ojNMddab6t';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;


        // Required
        // Required
        // dd($request->all());
        $transaction_details = [
            'order_id' => rand(),
            'gross_amount' => $request->total, // no decimal allowed for creditcard
        ];

        // Optional
        $item1_details = [
            'id' => rand(000, 999),
            'price' => $request->total,
            'quantity' => 1,
            'name' => $request->detailsCheckout,
        ];

        // Optional

        // Optional
        $item_details = [$item1_details];

        // Optional
        $billing_address = [
            'first_name' => $request->billing_name,
            'last_name' => 'a',
            'address' => 'a',
            'city' => 'a',
            'postal_code' => 'a',
            'phone' => 'a',
            'country_code' => 'IDN',
        ];

        // Optional
        $shipping_address = [
            'first_name' => $request->billing_name,
            'last_name' => 'Supriadi',
            'address' => 'Manggis 90',
            'city' => 'Jakarta',
            'postal_code' => '16601',
            'phone' => '08113366345',
            'country_code' => 'IDN',
        ];

        // Optional
        $customer_details = [
            'first_name' => $request->billing_name,
            'last_name' => '',
            'email' => $request->billing_email,
            'phone' => $request->billing_phone,
            'billing_address' => $billing_address,
            'shipping_address' => $shipping_address,
        ];

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = [
            'start_time' => date('Y-m-d H:i:s O', $time),
            'unit' => 'minute',
            'duration' => 1440,
        ];

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
            'credit_card' => $credit_card,
            'expiry' => $custom_expiry,
        ];

        error_log(json_encode($transaction_data));
        $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);
        error_log($snapToken);
        echo $snapToken;
    }
}
