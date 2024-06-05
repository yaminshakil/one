<?php

namespace App\Http\Controllers\Settings;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Controller;

// use Laravel\Spark\Contracts\Interactions\Subscribe;
// use Laravel\Spark\Events\Subscription\SubscriptionUpdated;
// use Laravel\Spark\Events\Subscription\SubscriptionCancelled;
// use Laravel\Spark\Http\Requests\Settings\Subscription\UpdateSubscriptionRequest;
// use Laravel\Spark\Contracts\Http\Requests\Settings\Subscription\CreateSubscriptionRequest;

use Laravel\Spark\Contracts\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Mail;

class OneOffPurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notifications)
    {
        $this->middleware('auth');
        $this->notifications = $notifications;
    }

    /**
     * Update the given team's extra info.
     *
     * @param  Request  $request
     * @param  \Laravel\Spark\Team  $team
     * @return Response
     */
    public function purchase(Request $request, $team)
    {
        abort_unless($request->user()->ownsTeam($team), 404);

        //check for this one time option
        $options = config('app.oneOffOptions');

        abort_unless(isset($options[$request->option]), 400);

        $user = request()->user();

        //determine amount in cents
        $option = $options[$request->option];
        //if (braintree) need to send in dollars
        //post to payment processor
        try{
            $response = $request->user()->invoiceFor($team->name.': '.$option['name'],$option['price']*100);
            if ($response->paid!=true){
              throw new Exception('Payment rejected');
            }
            $this->notifications->create($user, [
                'icon' => 'fa-credit-card',
                'body' => 'You have purchased: '.$option['name']. '[Invoice: '.$response->id.']',
            ]);
            //send confirmation to user: should happen automatically with InvoiceFor
            //send message to admins
            Mail::send('emails.oneoffpurchase', [
                'item' => $option['name'],
                'user' => $user,
                'invoice' => $response,
                'team' => $team,
              ], function ($message)
            {
                $message->from('system@nist-800-171.com', 'OneSevenOne One-Off Purchase');
                $message->to(config('app.salesEmail'));
                $message->subject('171: New Consulting Purchase');
            });

            return [
              'id'=>$response->id,
              'desc'=>$team->name.': '.$option['name'],
              'amount'=>$response->total/100,
              'paid'=>$response->paid,
            ];
        }
        catch (Exception $e) {
          dd($e);
            //
        }


    }


}
