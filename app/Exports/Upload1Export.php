<?php

namespace App\Exports;

use App\Models\Upload1;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Upload1Export implements FromQuery, WithHeadings
{
    public function query()
    {
        return Upload1::select('レコードID',
        'レコードタイプ',
        'キャンペーンID',
        'キャンペーン',
        'キャンペーンの1日の予算',
        'ポートフォリオID',
        'キャンペーン開始日',
        'キャンペーン終了日',
        'キャンペーンターゲティングタイプ',
        '広告グループ',
        '入札額上限',
        'キーワードまたは商品ターゲティング',
        '商品ターゲティングID',
        'マッチタイプ',
        'SKU',
        'キャンペーンステータス',
        '広告グループステータス',
        'ステータス',
        'インプレッション',
        'クリック',
        '広告費',
        '注文数',
        '商品点数の合計',
        '売上',
        'ACOS',
        '入札戦略',
        '掲載枠タイプ',
        '掲載枠による入札額の引き上げ');
    }

    public function headings() : array
    {
        return ['レコードID',
                'レコードタイプ',
                'キャンペーンID',
                'キャンペーン',
                'キャンペーンの1日の予算',
                'ポートフォリオID',
                'キャンペーン開始日',
                'キャンペーン終了日',
                'キャンペーンターゲティングタイプ',
                '広告グループ',
                '入札額上限',
                'キーワードまたは商品ターゲティング',
                '商品ターゲティングID',
                'マッチタイプ',
                'SKU',
                'キャンペーンステータス',
                '広告グループステータス',
                'ステータス',
                'インプレッション',
                'クリック',
                '広告費',
                '注文数',
                '商品点数の合計',
                '売上',
                'ACOS',
                '入札戦略',
                '掲載枠タイプ',
                '掲載枠による入札額の引き上げ'
            ];
    }
}
