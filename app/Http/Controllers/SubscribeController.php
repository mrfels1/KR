<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request, $userid)
    {
        $subscription = Subscription::where('subscriber_id', $request->user()->id)->where('subscribee_id', $userid)->first();
        if (!$subscription) {
            Subscription::create([
                'subscriber_id' => $request->user()->id,
                'subscribee_id' => $userid,
            ]);
        }
    }

    public function unsubscribe(Request $request, $userid)
    {
        $subscription = Subscription::where('subscriber_id', $request->user()->id)->where('subscribee_id', $userid)->first();
        if ($subscription) {
            $subscription->delete();
        }
    }
}
