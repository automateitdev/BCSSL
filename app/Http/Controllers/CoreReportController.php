<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\IncomeStatementRepo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CoreReportController extends Controller
{
    protected $incomeStatementRepo;

    public function __construct(IncomeStatementRepo $incomeStatementRepo)
    {
        $this->incomeStatementRepo = $incomeStatementRepo;
    }
    public function income_statement()
    {
        return view('pages.admin.core-report.income-statement');
    }

    public function income_statement_search(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        $from = $request->from;
        $to = $request->to;

        //  Accessing income statemet repositories
        $response = $this->incomeStatementRepo->incomeStatementSearch($request);

        $incomeledgerinfo = $response->incomeledgerinfo;
        $expenseledgerinfo = $response->expenseledgerinfo;
        $from = date('d M Y', strtotime($from));
        $to = date('d M Y', strtotime($to));
        return view('pages.admin.core-report.income-statement', compact('incomeledgerinfo', 'expenseledgerinfo', 'from', 'to'));
    }


    public function income_statement_pdf(Request $request)
    {
        $path = $request->path;
        $from =  $request->from;
        $to =  $request->to;
        $pdfname = $request->pdfname . '.pdf';
        $response = $this->incomeStatementRepo->incomeStatementSearch($request);
        $incomeledgerinfo = $response->incomeledgerinfo;
        $expenseledgerinfo = $response->expenseledgerinfo;

        $pdf = Pdf::setOption([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true
        ])->loadView($path, compact('incomeledgerinfo', 'expenseledgerinfo', 'from', 'to', 'pdfname'));

        $content = $pdf->download()->getOriginalContent();
        Storage::put('public/core-report/' . $pdfname, $content);
        $pdf_path = storage_path('app/public/core-report/' . $pdfname);

        return response()->download($pdf_path);
    }
}
