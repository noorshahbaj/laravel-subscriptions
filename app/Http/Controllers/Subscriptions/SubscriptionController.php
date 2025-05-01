<?php

namespace App\Http\Controllers\Subscriptions;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        return view(
            'subscriptions.checkout',
            ['intent' => $request->user()->createSetupIntent()]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $plan = Plan::where('slug', $request->plan)
            ->first();

        if (!$plan) {
            $plan = Plan::where('slug', 'monthly')->first();
        }

        $request->user()->newSubscription('default', $plan->stripe_id)
            ->create($request->token);

        return redirect()->route('subscriptions');
    }
}
