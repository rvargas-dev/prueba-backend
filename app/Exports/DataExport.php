<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Nombre' => $user->name,
                'Fecha de Nacimiento' => $user->birth_date,
            ];
        }));
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Fecha de Nacimiento'];
    }
}
