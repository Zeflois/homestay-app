<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\Post;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // $this->load->helper('url');
        \Midtrans\Config::$serverKey = 'SB-Mid-server-Ts3-hKQ9aUU6Y7ojNMddab6t';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;


        $slide_all = Slide::get();
        $feature_all = Feature::get();
        $testimonial_all = Testimonial::get();
        $post_all = Post::orderBy('id','desc')->limit(3)->get();
        $room_all = Room::get();

        $getOrderId = DB::select("select transaction_id from orders where status = 'pending' ORDER BY created_at DESC");
        // dd($getOrderId);
        foreach ($getOrderId as $ord) {
            // dd($ord->order_no);
            if ($ord->transaction_id != null) {
                $getDataMidtrans = \Midtrans\Transaction::status($ord->transaction_id);
                // dd($getDataMidtrans);
                if ($getDataMidtrans->status_code == 200) {
                    $data = [
                        'status' => "Lunas"
                    ];
                } elseif ($getDataMidtrans->status_code == 201) {
                    $data = [
                        'status' => "Pending"
                    ];
                } else {
                    $data = [
                        'status' => "Failed"
                    ];
                }
                DB::table('orders')->where('transaction_id', $ord->transaction_id)->update($data);
            }

            // dd($status);
        }
        
        return view('front.home', compact('slide_all','feature_all','testimonial_all','post_all','room_all'));
    }
}
