<?php

namespace App\Http\Controllers;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function createReport(Request $request)
    {
        $data = $request->validate([
            'tittle' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $response = $this->reportService->reportUser($data);

        return response()->json($response, 201);
    }

    public function findAllReports()
    {
        $report = $this->reportService->findAll();

        return response()->json($report);
    }

    public function findById(Request $request)
    {
        $id = $request->input('id');
        $fileResponse = $this->reportService->getReportFileById($id);

        return $fileResponse;
    }

}
