<?php

namespace App\Exports;

use App\Models\Quiz1;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Quiz1Export implements FromQuery, WithHeadings
{
    public function query()
    {
        return Quiz1::select(
            '氏名',
            '項目',
            '回答項目',
            '提案№',
            'お勧め進路',
            '回答日'
        );
    }

    public function headings(): array
    {
        return [
            '氏名',
            '項目',
            '回答項目',
            '提案№',
            'お勧め進路',
            '回答日'
        ];
    }
}
