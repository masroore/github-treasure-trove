<?php

namespace App\Http\Controllers;

use App\Models\CompletedHours;
use App\Models\Escrow;
use App\Models\Job;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\Proposal;
use App\Models\Rating;
use App\Models\TransactionHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;

class HourlyController extends Controller
{
    public function depositOrReject(Request $request, $id)
    {
        // dd($request->all());
        if ($request->deposit) {
            // dd('accept');
            // Getting Records
            $walletAmt = Wallet::where('user_id', auth()->id())->first('amt');
            $hours = CompletedHours::where('id', $id)->first();
            $to = Proposal::where('id', $hours->proposal_id)->first('user_id');
            // Check Wallet exsist or not!
            if (!$walletAmt) {
                return redirect()->back()->with('error', 'Kindly verify your paypal account and deposit the amount first!');
            }
            // Check is Amount Exist or not
            if ($walletAmt->amt < $hours->weekly_payment) {
                return redirect()->back()->with('error', 'You have not enough amount in wallet kindly recharge your wallet!');
            }
            // Check Escrow Exist Already!
            if (!Escrow::where('source_id', $id)->where('type', 3)->where('status', 1)->first()) {
                // Create an escrow
                Escrow::create([
                    'from' => auth()->id(),
                    'to' => $to->user_id,
                    'amt' => $hours->weekly_payment,
                    'source_id' => $id,
                    'type' => 3,
                ]);
            }
            // Deduct Amt from Wallet
            self::deductAmt($hours->weekly_payment);
            // Update a MS
            $status = $hours->update(['status' => 2]);

            if ($status) {
                Notification::create([
                    'from' => auth()->id(),
                    'to' => $to->user_id,
                    'message' => 'The Weekly Payment is Deposited!',
                    'noti_type' => 'project',
                    'status' => 'unread',
                ]);
                TransactionHistory::create([
                    'user_id' => auth()->id(),
                    'transaction' => 'You Deposit the Weekly Payment from your E-Wallet',
                    'amount' => $hours->weekly_payment,
                    'type' => 3,
                    'status' => 2,
                ]);

                return redirect()->back()->with('message', 'Weekly Payment Deposit Successfully!');
            }
        } elseif ($request->reject) {
            // dd('reject');
            $hs = CompletedHours::where('id', $id)->first();
            $to = Proposal::where('id', $hs->proposal_id)->first('user_id');
            $status = $hs->update(['status' => 4]);
            if ($status) {
                Notification::create([
                    'from' => auth()->id(),
                    'to' => $to->user_id,
                    'message' => 'The Weekly Payment is Rejected!',
                    'noti_type' => 'milestone',
                    'status' => 'unread',
                ]);

                return redirect()->back()->with('message', 'Weekly Payment Rejected Successfully!');
            }
        }
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'milestone_amount' => 'required',
            'deposit_name' => 'required',
        ]);
        // Getting Records
        $walletAmt = Wallet::where('user_id', auth()->id())->first('amt');
        // Check Wallet exsist or not!
        if (!$walletAmt) {
            return redirect()->back()->with('error', 'Kindly verify your paypal account and deposit the amount first!');
        }
        // $milestone = Milestone::where('id', $id)->first();
        $to = Proposal::where('id', $request->proposal_id)->first('user_id');
        // Check is Amount Exist or not
        if ($walletAmt->amt < $request->milestone_amount) {
            return redirect()->back()->with('error', 'You have not enough amount in wallet kindly recharge your wallet!');
        }
        // Update Milestone
        $milestone = Milestone::find($request->milestone_id);
        $milestoneupdate = Milestone::where('id', $request->milestone_id)->update(['status' => 'accept']);
        // $milestone = Milestone::create([
        //     'name' => $request->deposit_name,
        //     'amount' => $request->deposit_amount,
        //     'bid_id' => $request->deposit_bid_id,
        //     'job_id' => $request->deposit_project_id,
        //     'user_id' => $request->deposit_user_id,
        //     'status' => 2,
        // ]);
        // Deduct Amt from Wallet
        self::deductAmt($request->milestone_amount);
        // Create an escrow
        $escrow = Escrow::create([
            'from' => auth()->id(),
            'to' => $to->user_id,
            'amt' => $request->milestone_amount,
            'source_id' => $request->milestone_id,
            'type' => 1,
        ]);

        if ($milestone && $escrow) {
            Notification::create([
                'from' => auth()->id(),
                'to' => $to->user_id,
                'message' => 'The Milestone is Deposited!',
                'noti_type' => 'milestone',
                'status' => 'unread',
            ]);

            TransactionHistory::create([
                'user_id' => auth()->id(),
                'transaction' => 'You Deposit the Milestone from your E-Wallet',
                'amount' => $request->milestone_amount,
                'type' => 3,
                'status' => 2,
            ]);

            return redirect()->back()->with('message', 'Milestone Deposit Successfully!');
        }
    }

    public function ReleaseRefundDispute(Request $request, $id)
    {
        // dd($request);
        // Get Escrow
        $escrow = Escrow::where('source_id', $id)->where('type', 3)->first();
        // Get Milestone
        $hs = CompletedHours::where('id', $id)->first();
        // User (To) Wallet
        $toUser = Wallet::where('user_id', $escrow->to)->first();
        // User (From) Wallet
        $fromUser = Wallet::where('user_id', $escrow->from)->first();
        // Amount Release
        if ($request->amount_release) {
            $bid = Proposal::where('id', $hs->proposal_id)->first();
            // $fee =  ($escrow->amt * 0.20) / (1 + 0.20);
            // $net = $escrow->amt / (1 + 0.20);
            if (!$toUser) {
                Wallet::create([
                    'user_id' => $escrow->to,
                    'amt' => $escrow->amt,
                    'currency_code' => 'USD',
                ]);
            } else {
                $newWalletAmt = $toUser->amt + $escrow->amt;
                $toUser->update([
                    'amt' => $newWalletAmt,
                ]);
            }
            // Company Wallet
            // $company = Wallet::where('user_id', 1)->first();
            // $companyAmt = $company->amt + $fee;
            // $company->update([
            //     'amt' => $companyAmt
            // ]);
            // Escrow Status Update
            $escrow->update([
                'status' => 2,
            ]);
            // Milestone Status Update (status -> Release Amount)
            $hs->update(['status' => 3]);
            // Project Completion when Milestones are paid according to Project's Budget
            // $msAmt = Milestone::where('job_id', $request->milestone_job_id)->where('status', 'paid')->sum('milestone_amount');

            Notification::create([
                'from' => auth()->id(),
                'to' => $toUser->user_id,
                'message' => 'The Milestone is Released!',
                'noti_type' => 'milestone',
                'status' => 'unread',
            ]);

            // if ($msAmt >= $bid->budget && !Rating::isExist(auth()->id(), $ms->proposal_id, $request->milestone_job_id)) {
            //     $bid->update(['status' => 5]);
            //     Project::where('job_id', $request->milestone_job_id)->update(['status' => 4]);
            //     return redirect()->route('job.feedback', ['job_id' => $request->milestone_job_id])->with('message', 'Milestone Amount Released, and project also completed now you can give feedback!');
            // }

            TransactionHistory::create([
                'user_id' => $toUser->user_id,
                'transaction' => 'You received the Weekly amount in your E-Wallet',
                'amount' => $escrow->amt,
                'type' => 3,
                'status' => 1,
            ]);

            return redirect()->back()->with('message', 'Weekly Amount Released Successfully!');
        }
        if ($request->refund) {
            // Chk if Amount exist
            if ($toUser->amt < $ms->amount) {
                return redirect()->back()->with('error', 'You have not enough amount in wallet!');
            }
            // Subtract from User Who Refund
            $toUserAmount = $toUser->amt - $ms->amount;
            $toUser->update([
                'amt' => $toUserAmount,
            ]);
            // Added to User Who Collected
            $fromUserAmount = $fromUser->amt + $ms->amount;
            $fromUser->update([
                'amt' => $fromUserAmount,
            ]);
            // Milestone Update from Paid to Request
            $hs->update([
                'status' => 1,
            ]);
            // Escrow Status Update
            $escrow->update([
                'status' => 1,
            ]);

            Notification::create([
                'from' => auth()->id(),
                'to' => $fromUser->user_id,
                'message' => 'The Weekly Amount is Refuned!',
                'noti_type' => 'milestone',
                'status' => 'unread',
            ]);

            TransactionHistory::create([
                'user_id' => $fromUser->user_id,
                'transaction' => 'Your Weekly amount is refunded in your E-Wallet',
                'amount' => $ms->amount,
                'type' => 3,
                'status' => 1,
            ]);

            return redirect()->back()->with('message', 'Weekly Amount Refunded Successfully!');
        }
    }

    public static function deductAmt($msAmt): void
    {
        $wallet = Wallet::where('user_id', auth()->id())->first();
        $newAmt = $wallet->amt - $msAmt;
        $wallet->update(['amt' => $newAmt]);
    }

    public function destory($id)
    {
        $milestone = Milestone::where('id', $id)->delete();
        if ($milestone) {
            return redirect()->back()->with('message', 'Milestone Successfully Canceled!');
        }
    }
}
