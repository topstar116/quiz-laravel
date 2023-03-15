<?php

namespace App\Exports;

use App\Models\Man1;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Man1::select(
            '会社名',
            'イニシャル名字',
            'イニシャル名前',
            'メールアドレス',
            'パスワード'
        );
    }

    public function headings(): array
    {
        return [
            '会社名',
            'イニシャル名字',
            'イニシャル名前',
            'メールアドレス',
            'パスワード'
        ];
    }
}
