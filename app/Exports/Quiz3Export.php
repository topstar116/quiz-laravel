<?php

namespace App\Exports;

use App\Models\Quiz3;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Quiz3Export implements FromQuery, WithHeadings
{
    public function query()
    {
        return Quiz3::select(
            '氏名',
            '項目',
            '回答項目',
            '状況',
            '説明概要',
            '回答日'
        );
    }

    public function headings(): array
    {
        return [
            '氏名',
            '項目',
            '回答項目',
            '状況',
            '説明概要',
            '回答日'
        ];
    }
}
