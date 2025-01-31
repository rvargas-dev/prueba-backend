<?php

namespace App\Services;
use App\Jobs\reportexcel;
use App\Repositories\ReportRepository;

class ReportService {
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function reportUser(array $data)
    {
        $tittle = $data['tittle'];
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        ReportExcel::dispatch($tittle, $startDate, $endDate);

        return ['message' => 'El reporte se está generando en segundo plano.'];
    }

    public function getReportsByDateRange(string $startDate, string $endDate)
    {
        return $this->reportRepository->getReportsByDateRange($startDate, $endDate);
    }


    public function getReportFileById(int $id)
    {
        $report = $this->reportRepository->findBy($id);

        // Corregimos la ruta: storage/app/reports/
        $filePath = storage_path('app/reports/' . basename($report->report_link));

        return response()->download($filePath);
    }

    public function findAll()
    {
        return $this->reportRepository->findAll();
    }

}
