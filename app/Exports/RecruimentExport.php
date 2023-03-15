<?php

namespace App\Exports;

use App\Models\Man1;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecruimentExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Man1::select(
            '名前',
            'メールアドレス',
            'パスワード'
        );
    }

    public function headings(): array
    {
        return [
            '名前',
            'メールアドレス',
            'パスワード'
        ];
    }
}
