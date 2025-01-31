<?php

namespace App\Repositories;
use App\Models\Reports;
use App\Models\User;

class ReportRepository
{
    public function create(array $data)
    {
        return Reports::create($data);
    }

    public function getReportsByDateRange(string $startDate, string $endDate)
    {
        return User::whereBetween('birth_date', [$startDate, $endDate])->get();
    }

    public function findBy($id)
    {
        return Reports::find($id);
    }

    public function findAll()
    {
        return Reports::all();
    }
}
