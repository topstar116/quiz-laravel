<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'レコードID',
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
        '掲載枠による入札額の引き上げ',
    ];
}
