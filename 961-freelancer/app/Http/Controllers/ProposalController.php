<?php

namespace App\Http\Controllers;

use App\Models\Escrow;
use App\Models\Job;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\Proposal;
use App\Models\Rating;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mail;
use Redirect;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'cover_letter' => 'required',
      ]);
        // dd($request->all());
        $proposal = new Proposal();
        $proposal->job_id = $request->input('job_id');
        $proposal->user_id = auth()->user()->id;
        $proposal->budget = $request->input('budget');
        $proposal->budget_receive = $request->input('budget_receive');
        $proposal->service_fee = $request->input('service_fee');
        $proposal->cover_letter = $request->input('cover_letter');
        $proposal->proposal_type = $request->input('proposal_type');
        $proposal->duration = $request->input('duration');
        $proposal->proposed_hours = $request->input('proposed_hours');
        $proposal->status = 1;
        $images = [];
        if ($files = $request->file('attachments')) {
            foreach ($files as $file) {
                $imagename = 'proposal-' . rand(000000, 999999) . '.' . $file->getClientOriginalExtension();
                $extension = $file->getClientOriginalExtension();
                // $imagename= $filename;
                $destinationpath = public_path('assets/images/proposal/');
                $file->move($destinationpath, $imagename);

                $images[] = $imagename;
            }
        }
        $proposal->attachments = implode(',', $images);

        $freelancer = User::where('id', auth()->user()->id)->first();
        $jobUser = Job::where('job_id', $request->input('job_id'))->first();
        $client = User::where('id', $jobUser->user_id)->first();
        $toemail = $client->email;
        if ($proposal->save()) {
            if ('by_milestone' == $request->proposal_type) {
                if ($request->milestone_detail && $request->milestone_due_date && $request->milestone_amount) {
                    for ($i = 0; $i < \count($request->milestone_detail); $i++) {
                        Milestone::create([
                      'proposal_id' => $proposal->id,
                      'job_id' => $request->job_id,
                      'user_id' => auth()->id(),
                      'detail' => $request->milestone_detail[$i],
                      'milestone_amount' => $request->milestone_amount[$i],
                      'due_date' => $request->milestone_due_date[$i],
                      'status' => 'request',
                  ]);
                    }
                }
            }
            Notification::create([
          'from' => auth()->id(),
          'to' => $client->id,
          'message' => $freelancer->username . ' sent proposal on your project "' . $jobUser->job_title . '"',
          'noti_type' => 'proposal',
          'status' => 'unread',
        ]);
            Mail::send(
                'mail.propsalsubmit-email',
                ['user' =>$freelancer, 'job' => $jobUser, 'client'=>$client],
                function ($message) use ($toemail) {
                    $message->subject('961Freelancer - Proposal Submit');
                    $message->from('support@961freelancer.com', '961Freelancer');
                    $message->to($toemail);
                }
            );

            return redirect()->route('job.show', $request->job_id)->with('message', 'Proposal submitted Successfully!');
        }

        return redirect()->route('job.show', $request->job_id)->with('error', 'Something wrong please check details again');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function jobProposal(Request $request, $id)
    {
        $job = Job::where('job_id', $id)->first();

        return View::make('frontend.job-proposal')->with([
        'jobData' => $job,
      ]);
    }

    public function allProposalClient(Request $request)
    {
        $user_id = auth()->user()->id;
        $job = Job::with('proposal', 'clientInfo')->whereuser_id($user_id)->wherejob_status(1)->orderBy('created_at', 'DESC')->paginate(5);

        $proposals = Proposal::with('job', 'rating')->withCount('rating')->whereuser_id($user_id)->where('status', '!=', 5)->orderBy('created_at', 'DESC')->paginate(5);

        $freelancerrating = Rating::where('rating_to', $user_id)->get();
        $rating_avg = 0.0;
        $total = 0;
        foreach ($freelancerrating as $rate) {
            $total += $rate->general_rating;
            $rating_avg = $total / \count($freelancerrating);
        }

        return View::make('frontend.proposal')->with([
        'jobData' => $job,
        'proposals' => $proposals,
        'rating' => $rating_avg,
      ]);
    }

    public function hireFreelancer(Request $request)
    {
        $walletAmt = Wallet::where('user_id', auth()->user()->id)->first('amt');
        // Check is Amount Exist or not

        $id = $request->proposal_id;
        $job_id = $request->job_id;
        $findData = Proposal::find($id);
        $job = Job::where('job_id', $job_id)->first();
        if ('hourly' != $findData->proposal_type) {
            if (!$walletAmt) {
                return response()->json(['status'=>'error', 'message' => 'Kindly verify your paypal account and deposit the amount first!'], 200);
            }
            if ($walletAmt->amt < $findData->budget) {
                // dd($findData->budget);
                return response()->json(['status'=>'error', 'message' => 'You have not enough amount in wallet kindly recharge your wallet!'], 200);
            }
        }
        // Check Wallet exsist or not!

        $findData->status = 2;
        $freelancer = User::where('id', $findData->user_id)->first();
        $toemail = $freelancer->email;
        Job::where('job_id', $job_id)->update(['job_status'=>2]);
        if ($findData->save()) {
            if ('hourly' != $findData->proposal_type) {
                self::deductAmt($findData->budget);
                // Create an escrow
                $escrow = Escrow::create([
              'from' => auth()->user()->id,
              'to' => $findData->user_id,
              'amt' => $findData->budget,
              'source_id' => $request->proposal_id,
              'type' => 2,
          ]);
                if ($findData && $escrow) {
                    Notification::create([
              'from' => auth()->user()->id,
              'to' => $findData->user_id,
              'message' => 'You have been hired for the project "' . $job->job_title . '"',
              'noti_type' => 'hire',
              'status' => 'unread',
            ]);
                    Notification::create([
                'from' => auth()->user()->id,
                'to' => $findData->user_id,
                'message' => 'Project Amount is Deposited!',
                'noti_type' => 'project',
                'status' => 'unread',
            ]);
                    TransactionHistory::create([
                'user_id' => auth()->user()->id,
                'transaction' => 'You Deposit the amount from your E-Wallet',
                'amount' => $findData->budget,
                'type' => 3,
                'status' => 2,
            ]);
                }
            }
            Mail::send(
                'mail.hired-email',
                ['user' =>$freelancer, 'job' => $job],
                function ($message) use ($toemail) {
                    $message->subject('961Freelancer - Hired By Client');
                    $message->from('support@961freelancer.com', '961Freelancer');
                    $message->to($toemail);
                }
            );

            return response()->json(['status'=>'true', 'message' => 'Freelancer Hired'], 200);
        }

        return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
    }

    public function rejectFreelancer(Request $request)
    {
        $id = $request->proposal_id;
        $job_id = $request->job_id;
        $findData = Proposal::find($id);
        $job = Job::where('job_id', $job_id)->first();
        $findData->status = 3;
        $freelancer = User::where('id', $findData->user_id)->first();
        $toemail = $freelancer->email;
        Job::where('job_id', $job_id)->update(['job_status'=>1]);
        if ($findData->save()) {
            Notification::create([
          'from' => auth()->id(),
          'to' => $findData->user_id,
          'message' => 'You proposal has been rejected for this "' . $job->job_title . '" project.',
          'noti_type' => 'reject',
          'status' => 'unread',
        ]);
            Mail::send(
                'mail.rejectProposal-email',
                ['user' =>$freelancer, 'job' => $job],
                function ($message) use ($toemail) {
                    $message->subject('961Freelancer - Rejected By Client');
                    $message->from('support@961freelancer.com', '961Freelancer');
                    $message->to($toemail);
                }
            );

            return response()->json(['status'=>'true', 'message' => 'Freelancer proposal rejected'], 200);
        }

        return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
    }

    public function projectStatus(Request $request)
    {

      // dd($request->all());
        $proposal_id = $request->proposal_id;
        $job_id = $request->job_id;
        $findData = Proposal::find($proposal_id);
        if (2 == $request->project_status) {
            $proposal_status = 2;
        } elseif (3 == $request->project_status) {
            $proposal_status = 3;
        } else {
            $proposal_status = 5;
        }
        $findData->status = $proposal_status;
        Job::where('job_id', $job_id)->update(['job_status'=>$request->project_status]);

        if ($findData->save()) {
            if (4 == $request->project_status) {
                $job_data = Job::where('job_id', $job_id)->first();
                $escrow = Escrow::where('source_id', $proposal_id)->where('type', 2)->first();
                // dd($escrow);
                // Get Milestone
                // $ms = Milestone::where('id', $id)->first();
                // User (To) Wallet
                $toUser = Wallet::where('user_id', $escrow->to)->first();
                // User (From) Wallet
                $fromUser = Wallet::where('user_id', $escrow->from)->first();

                $bid = Proposal::where('id', $proposal_id)->first();
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

                // Escrow Status Update
                $escrow->update([
              'status' => 2,
          ]);
                // Milestone Status Update (status -> Release Amount)
                // $ms->update(['status' => 'paid']);
                // Project Completion when Milestones are paid according to Project's Budget
                // $msAmt = Milestone::where('job_id', $request->milestone_job_id)->where('status', 4)->sum('milestone_amount');
                Notification::create([
              'from' => auth()->id(),
              'to' => $toUser->user_id,
              'message' => 'Your project "' . $job_data->job_title . '" is completed!',
              'noti_type' => 'project',
              'status' => 'unread',
          ]);
                Notification::create([
              'from' => auth()->id(),
              'to' => $toUser->user_id,
              'message' => 'The project amount is Released!',
              'noti_type' => 'project',
              'status' => 'unread',
          ]);
                TransactionHistory::create([
            'user_id' => $toUser->user_id,
            'transaction' => 'You received the project amount in your E-Wallet',
            'amount' => $escrow->amt,
            'type' => 3,
            'status' => 1,
          ]);
                if (!Rating::isExist(auth()->id(), $proposal_id, $request->job_id)) {
                    $bid->update(['status' => 5]);
                    // Job::where('job_id', $request->milestone_job_id)->update(['status' => 3]);
                    // return redirect()->route('job.feedback', ['job_id' => $request->job_id])->with('message', 'Project Amount Released, and project also completed now you can give feedback!');
                    return response()->json(['status'=>'true', 'message' => 'Project Status updated', 'job_id' => $job_id, 'job_status' => $proposal_status, 'job_id' => $request->job_id], 200);
                }
            } else {
                return response()->json(['status'=>'true', 'message' => 'Project Status updated', 'job_id' => $job_id, 'job_status' => $proposal_status], 200);
            }
        } else {
            return response()->json(['status'=>'error', 'message' => 'error occured please try again'], 200);
        }
    }

    public static function deductAmt($msAmt)
    {
        $wallet = Wallet::where('user_id', auth()->id())->first();
        $newAmt = $wallet->amt - $msAmt;
        $wallet->update(['amt' => $newAmt]);
    }
}
