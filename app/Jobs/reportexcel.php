<?php

namespace App\Jobs;

use App\Models\Reports;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use Illuminate\Support\Facades\Storage;

class reportexcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tittle;
    protected $startDate;
    protected $endDate;

    /**
     * Create a new job instance.
     */
    public function __construct(string $tittle, string $startDate, string $endDate)
    {
        $this->tittle = $tittle;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = \App\Models\User::whereBetween('birth_date', [$this->startDate, $this->endDate])->get();

        $fileName = 'report_' . now()->timestamp .'.xlsx';
        $filePath = 'reports/' . $fileName;

        Excel::store(new DataExport($users), $filePath, 'local');

        Reports::create([
            'tittle' => $this->tittle,
            'report_link' => Storage::url($filePath),
        ]);
    }
}
