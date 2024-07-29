<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Transaction;
use Stripe\StripeClient;

use Illuminate\Support\Facades\Auth;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class CreditController extends Controller
{
    // initial page load
    public function index()
    {
        $packages = Package::all();
        $features = Feature::where('active', true)->get();
        return inertia("Credit/Index", [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success'),
            'error' => session('error')
        ]);
    }


    // 
    public function buyCredits(Package $package)
    {
        $strip = new StripeClient(env("STRIP_SECRET_KEY"));
        $checkout_session = $strip->checkout->sessions->create([

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $package->name . '-' . $package->credits . ' credits',
                        ],
                        'unit_amount' => $package->price * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('credit.success', [], true),
            'cancel_url' => route('credit.cancel', [], true)
        ]);


        Transaction::create([
            'status' => 'pending',
            'price' => $package->price,
            'credits' => $package->credits,
            'session_id' => $checkout_session->id,
            'user_id' => Auth::id(),
            'package_id' => $package->id
        ]);

        return redirect($checkout_session->url);
    }
    public function success()
    {
        return to_route("credit.index")->with('success', 'You have successfully bought new credits.');
    }
    public function cancel()
    {
        return to_route("credit.index")->with('error', 'There was an error in payment process. Please try again.');
    }


    // payment webhook
    public function webhook()
    {
        $endpoint_secret = env("STRIP_WEBHOOK_KEY");
        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;
        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (UnexpectedValueException $e) {
            // invalid payload
            return response("", 400);
        } catch (SignatureVerificationException $e) {
            //    invalid signature
            return response("", 400);
        }


        // handle event 

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $transection = Transaction::where(
                    'session_id',
                    $session->id
                )->first();
                if ($transection && $transection->status === 'pending') {
                    $transection->status = 'paid';
                    $transection->save();
                    $transection->user->available_credits += $transection->credits;
                    $transection->user->save();
                }
            default:
                echo 'Received unknown event type' . $event->type;
        }

        return response('');
    }
}
