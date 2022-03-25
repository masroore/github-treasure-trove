<?php

namespace App\Jobs\wallet;

use App\Notifications\Wallet\Walletmail;
use App\Wallettop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class WalletTopup implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wallet = Wallettop::where('status', 'uppaid')->get();

        foreach ($wallet as $row => $value) {
            $nvoice = $row->tr_id;
            $inid = $row->id;
            $indexnum = $row->indexnumber;

            $curl = curl_init();

            curl_setopt_array($curl, [
              \CURLOPT_URL => 'https://manage.ipaygh.com/gateway/json_status_chk?merchant_key=5c841bf2-d29b-11e7-aebc-f23c9170642f&invoice_id=' . $nvoice,
              \CURLOPT_RETURNTRANSFER => true,
              \CURLOPT_ENCODING => '',
              \CURLOPT_MAXREDIRS => 10,
              \CURLOPT_TIMEOUT => 0,
              \CURLOPT_FOLLOWLOCATION => true,
              \CURLOPT_HTTP_VERSION => \CURL_HTTP_VERSION_1_1,
              \CURLOPT_CUSTOMREQUEST => 'GET',  ]);

            $response = curl_exec($curl);

            curl_close($curl);
            $tr = json_decode($response);

            $success = $tr->$nvoice->success;
            $status = $tr->$nvoice->status;
            $buyer_firstname = $tr->$nvoice->buyer_firstname;
            $buyer_lastname = $tr->$nvoice->buyer_lastname;
            $buyer_email = $tr->$nvoice->buyer_email;
            $buyer_phone = $tr->$nvoice->buyer_phone;
            $payment_reference = $tr->$nvoice->payment_reference;
            $payment_instrument = $tr->$nvoice->payment_instrument;
            $amount = $tr->$nvoice->amount;
            $total_amount_charged = $tr->$nvoice->total_amount_charged;
            $status_reason = $tr->$nvoice->status_reason;
            $service_fee = $tr->$nvoice->service_fee;
            $date = $tr->$nvoice->as_at;
            $narration = $tr->$nvoice->narration;
            $invoice_id = $tr->$nvoice->invoice_id;
            $tran_type = $tr->$nvoice->tran_type;
            $wallet_issuer_hint = $tr->$nvoice->extra->wallet_issuer_hint;
            $channel = $tr->$nvoice->extra->channel;
            $card_type = $tr->$nvoice->extra->card_type;
            $mobile_no = $tr->$nvoice->extra->mobile_no;
            $name = $tr->$nvoice->extra->name;
            $wallet_issuer_hint = $tr->$nvoice->extra->email;

            if ('paid' == $status) {
                Wallettop::findorfail($inid)->update(['status' => 'Paid']);
                $user = User::where('indexnumber', $indexnum)->first();
                $user->deposit($amount, ['Trantype' => 'WALLET TOPUP/DEPOSITE', 'Reference' => 'DEPOSITE']);

                //send mail to student
                Notification::route('mail', $user->email)
                    ->notify(new Walletmail($user->name, $nvoice, $amount));
            }

            if ('deferred' == $status) {
                Wallettop::findorfail($inid)->update(['status' => 'deferred']);
            }

            // if ($status == 'cancelled') {
            //     Wallettop::findorfail($inid)->update(['status' => 'Cancelled']);
            // }

            // if ($status == 'failed') {
            //     Wallettop::findorfail($inid)->update(['status' => 'Failed']);
            // }
        }
    }
}
