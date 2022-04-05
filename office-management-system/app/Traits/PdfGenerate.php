<?php

namespace App\Traits;

use PDF;

trait PdfGenerate
{
    public function getInvoice($view, $data)
    {
        $pdf = PDF::loadView($view, compact('data'))->setPaper('a4', 'portrait');

        return $pdf->download("invoice-{$data->invoice_no}.pdf");
    }

    public function getPayroll($view, $payrollDetails)
    {
        $pdf = PDF::loadView($view, compact('payrollDetails'))->setPaper('a4', 'landscape');

        return $pdf->download("Payroll-{$payrollDetails->staff->employee_id}.pdf");
    }
}
