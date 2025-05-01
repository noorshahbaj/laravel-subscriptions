<?php

namespace App\Http\Controllers\Account\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('account.subscriptions.index');
    }

    public function cancel(Request $request)
    {
        $subscription = $request->user()->subscription('default');

        if (!$subscription || $subscription->cancel()) {
            return redirect()->route('account.subscriptions')
                ->with('error', 'You do not have an active subscription to cancel.');
        }

        return view('account.subscriptions.cancel');
    }

    public function destroy(Request $request)
    {
        $subscription = $request->user()->subscription('default');

        if (!$subscription) {
            return redirect()->route('account.subscriptions')
                ->with('error', 'You do not have an active subscription to cancel.');
        }

        $subscription->cancel();

        return redirect()->route('account.subscriptions')
            ->with('success', 'Your subscription has been cancelled successfully.');
    }
}
