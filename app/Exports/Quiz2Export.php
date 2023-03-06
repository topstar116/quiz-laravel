<?php

namespace App\Exports;

use App\Models\Quiz2;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Quiz2Export implements FromQuery, WithHeadings
{
    public function query()
    {
        return Quiz2::select(
            '氏名',
            '項目',
            '回答項目',
            'ランク',
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
            'ランク',
            '説明概要',
            '回答日'
        ];
    }
}
