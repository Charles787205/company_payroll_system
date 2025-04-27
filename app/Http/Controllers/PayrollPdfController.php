<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollPdfController extends Controller
{
    public function downloadPdf(Payroll $payroll)
    {
        // Load the payroll data
        $payroll->load('employee', 'employee.loansAndDeductions');

        // Generate the PDF
        $pdf = Pdf::loadView('pdf.payroll', compact('payroll'));

        // Return the PDF for download
        return $pdf->download('payroll-' . $payroll->id . '.pdf');
    }
}
