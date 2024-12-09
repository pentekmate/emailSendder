<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function processPayment(Request $request){
        $request->validate([
            'amount'=>'required|numeric',
            'currency'=>'required|string',
            'source'=>'required|string'
        ]);

        try{
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Stripe uses cents
                'currency' => $request->currency,
                'source' => $request->source,
                'description' => 'Payment description',
            ]);
            return response()->json(['success' => true, 'charge' => $charge]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
        ]);
    
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Centben megadva
                'currency' => $request->currency,
                'automatic_payment_methods' => [
                    'enabled' => true, // Engedélyezi az összes elérhető fizetési módot
                ],
            ]);
    
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
