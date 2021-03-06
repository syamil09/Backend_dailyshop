<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckoutRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
    	if ($request->validator->fails()) {
	        return ResponseFormatter::error(null,$request->validator->messages());
	    }

    	$data = $request->except('transaction_details');
        
        $data['uuid'] = 'TRX' . mt_rand(10000,99999) . mt_rand(100,999);
        $data['transactions_status'] = $request->transactions_status ?? 'PENDING';
    	
    	$transaction = Transaction::create($data);
 
    	foreach ($request->transaction_details as $product) {

    		$details[] = new TransactionDetail([
    			'product_id' => $product
    		]);

    		Product::find($product)->decrement('quantity');
    	}
    	$transaction->details()->saveMany($details);

    	return ResponseFormatter::success($transaction);
    }
}
