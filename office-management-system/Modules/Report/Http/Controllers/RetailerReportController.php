<?php

namespace Modules\Report\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Agent\Repositories\AgentRepositoryInterface;

class RetailerReportController extends Controller
{
    public $agentRepository;

    public function __construct(AgentRepositoryInterface $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        try {
            $data['AgentList'] = $this->agentRepository->all();

            return view('report::retailer_report.index', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Operation Failed', 'Error!');

            return back();
        }
    }
}
