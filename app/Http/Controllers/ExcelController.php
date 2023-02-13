<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Models\Upload1;
use App\Models\UploadEx1;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Upload1Export;

class ExcelController extends Controller
{

    public function upload0(Request $request)
    {
        $A = $request->input('A');
        $P = $request->input('P');
        $E = $request->input('E');
        $G = $request->input('G');

        $cmp_price = $request->input('cmp_price');
        $bid = round($request->input('bid'));
        $cmp_sep = $request->input('cmp_sep');
        $def_keyword = $request->input('def_keyword');
        
        $sheets = (new UsersImport)->toArray($request->file);        
        
        Upload1::getQuery()->delete();

            if($A != NULL){
                foreach ($sheets[0] as $row) {           

                    if($row[3] == '子SKU') continue;
                    if($row[3] == '') break;
                    
                    //A
                    Upload1::insert(['キャンペーン'=>'A'.$cmp_sep.$row[1].$row[2], 'キャンペーンの1日の予算'=>$cmp_price, 'キャンペーン開始日'=>date('Y/m/d'), 'キャンペーンターゲティングタイプ'=>'auto', 'キャンペーンステータス'=>'有効', '入札戦略'=>'動的な入札（ダウンのみ）']);
                    Upload1::insert(['キャンペーン'=>'A'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効']);
                    Upload1::insert(['キャンペーン'=>'A'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', 'SKU'=>$row[3], 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);
                }
            }
            if($P != NULL){
                foreach ($sheets[0] as $row) {      
                    if($row[3] == '子SKU') continue;
                    if($row[3] == '') break;     
                    //P
                    Upload1::insert(['キャンペーン'=>'P'.$cmp_sep.$row[1].$row[2], 'キャンペーンの1日の予算'=>$cmp_price, 'キャンペーン開始日'=>date('Y/m/d'), 'キャンペーンターゲティングタイプ'=>'manual', 'キャンペーンステータス'=>'有効', '入札戦略'=>'動的な入札（ダウンのみ）']);
                    Upload1::insert(['キャンペーン'=>'P'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効']);
                    Upload1::insert(['キャンペーン'=>'P'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', 'SKU'=>$row[3], 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);

                    if($def_keyword != ''){
                        Upload1::insert(['キャンペーン'=>'P'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キーワードまたは商品ターゲティング'=>$def_keyword, 'マッチタイプ'=>'Phrase', 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);
                    }
                }
            }
            if($E != NULL){
                foreach ($sheets[0] as $row) {     
                    if($row[3] == '子SKU') continue;
                    if($row[3] == '') break;      
                    //E
                    Upload1::insert(['キャンペーン'=>'E'.$cmp_sep.$row[1].$row[2], 'キャンペーンの1日の予算'=>$cmp_price, 'キャンペーン開始日'=>date('Y/m/d'), 'キャンペーンターゲティングタイプ'=>'manual', 'キャンペーンステータス'=>'有効', '入札戦略'=>'動的な入札（ダウンのみ）']);
                    Upload1::insert(['キャンペーン'=>'E'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効']);
                    Upload1::insert(['キャンペーン'=>'E'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', 'SKU'=>$row[3], 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);

                    if($def_keyword != ''){
                        Upload1::insert(['キャンペーン'=>'E'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キーワードまたは商品ターゲティング'=>$def_keyword, 'マッチタイプ'=>'Exact', 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);
                    }
                }              
            }  
            if($G != NULL){        
                foreach ($sheets[0] as $row) {    
                    if($row[3] == '子SKU') continue;
                    if($row[3] == '') break;       
                    //G
                    Upload1::insert(['キャンペーン'=>'G'.$cmp_sep.$row[1].$row[2], 'キャンペーンの1日の予算'=>$cmp_price, 'キャンペーン開始日'=>date('Y/m/d'), 'キャンペーンターゲティングタイプ'=>'manual', 'キャンペーンステータス'=>'有効', '入札戦略'=>'動的な入札（ダウンのみ）']);
                    Upload1::insert(['キャンペーン'=>'G'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効']);
                    Upload1::insert(['キャンペーン'=>'G'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', 'SKU'=>$row[3], 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);
                    Upload1::insert(['キャンペーン'=>'G'.$cmp_sep.$row[1].$row[2], '広告グループ'=>'広告グループ 1', '入札額上限'=>$bid, 'キーワードまたは商品ターゲティング'=>'asin＝"'.$row[1].'"','商品ターゲティングID'=>'asin＝"'.$row[1].'"', 'マッチタイプ'=>'ターゲティングエクスプレッション', 'キャンペーンステータス'=>'有効', '広告グループステータス'=>'有効', 'ステータス'=>'有効']);
                }
            }

        return Excel::download(new Upload1Export, '0_新規広告作成'.date('Ymdhis').'.xlsx');
    }

    public function upload1(Request $request)
    {
        $click_through = $request->input('click_through');
        $sheets = (new UsersImport)->toArray($request->file);        
        
        Upload1::getQuery()->delete();

        foreach ($sheets[0] as $row) {           
            
            if(mb_substr($row[4], 0, 1, "UTF-8")=='A' && mb_substr($row[8], 0, 2, "UTF-8")!='b0' && $row[11] <= ($click_through*0.01) && $row[14] == 0){
                
                Upload1::insert(['キャンペーン'=>$row[4], '広告グループ'=>$row[5], 'キーワードまたは商品ターゲティング'=>$row[8], 'マッチタイプ'=>'Negative Exact', 'ステータス'=>'有効']);

            }

        }

        return Excel::download(new Upload1Export, '1_オート広告除外'.date('Ymdhis').'.xlsx');
    }

    public function upload2(Request $request)
    {
        $checkbox_target = $request->input('checkbox_target');
        $click_through = $request->input('click_through');
        $click_add = $request->input('click_add');
        $click_through2 = $request->input('click_through2');
        $impression = $request->input('impression');
        $conversion = $request->input('conversion');
        $click_add2 = $request->input('click_add2');


        $sheets = (new UsersImport)->toArray($request->file);        
        
        Upload1::getQuery()->delete();

        if($checkbox_target == NULL){
            
            foreach ($sheets[0] as $row) {   
                
                if(str_contains($row[12],'平均クリック単価')) continue;
                if($row[6]==$row[8]) continue;
                           
                if((mb_substr($row[4], 0, 1, "UTF-8")=='A' || mb_substr($row[4], 0, 1, "UTF-8")=='P') && mb_substr($row[8], 0, 2, "UTF-8")!='b0' && ($row[11] > ($click_through*0.01) || $row[14] > 0)){
                    
                    Upload1::insert(['キャンペーン'=>'P'.substr($row[4], 1), '広告グループ'=>$row[5], '入札額上限'=>round($row[12]+$click_add), 'キーワードまたは商品ターゲティング'=>$row[8], 'マッチタイプ'=>'Phrase', 'ステータス'=>'有効']);
    
                }
    
            }

        }else{

            foreach ($sheets[0] as $row) {         
                
                if(str_contains($row[12],'平均クリック単価')) continue;
                           
                if((mb_substr($row[4], 0, 1, "UTF-8")=='A' || mb_substr($row[4], 0, 1, "UTF-8")=='P') && mb_substr($row[8], 0, 2, "UTF-8")!='b0' && ($row[11] > ($click_through*0.01) || $row[14] > 0)){
                    
                    Upload1::insert(['キャンペーン'=>'P'.substr($row[4], 1), '広告グループ'=>$row[5], '入札額上限'=>round($row[12]+$click_add), 'キーワードまたは商品ターゲティング'=>$row[8], 'マッチタイプ'=>'Phrase', 'ステータス'=>'有効']);
    
                }
    
            }

            foreach ($sheets[0] as $row) {         
                
                if(str_contains($row[12],'平均クリック単価')) continue;
            
                if((mb_substr($row[4], 0, 1, "UTF-8")=='A' || mb_substr($row[4], 0, 1, "UTF-8")=='P') && mb_substr($row[8], 0, 2, "UTF-8")=='b0' && $row[9] > $impression && $row[11] > ($click_through2*0.01) && $row[14] > 0 && $row[19] > ($conversion*0.01)){
                    
                    Upload1::insert(['キャンペーン'=>'G'.substr($row[4], 1), '広告グループ'=>$row[5], '入札額上限'=>round($row[12]+$click_add2), 'キーワードまたは商品ターゲティング'=>$row[8], 'マッチタイプ'=>'Phrase', 'ステータス'=>'有効']);
    
                }
    
            }

        }

        

        return Excel::download(new Upload1Export, '2_キーワード仕入れ'.date('Ymdhis').'.xlsx');
    }

    public function upload3(Request $request)
    {
        $checkbox_target = $request->input('checkbox_target');
        $impression1 = $request->input('impression1');
        $impression2 = $request->input('impression2');
        $click_through1 = $request->input('click_through1');
        $click_through2 = $request->input('click_through2');
        $click_through3 = $request->input('click_through3');
        $click_through4 = $request->input('click_through4');
        
        $sheets = (new UsersImport)->toArray($request->file);        
        
        Upload1::getQuery()->delete();

        foreach ($sheets[1] as $row) {           

            if($row[19]=='クリック' || !(mb_substr($row[3],0,1)=='A' || mb_substr($row[3],0,1)=='P' || mb_substr($row[3],0,1)=='E' || mb_substr($row[3],0,1)=='G') || $row[18] ==0 || $row[19] ==0) continue;
            if($checkbox_target==NULL && !($row[1]=='キーワード' || $row[1]=='広告グループ')) continue;
            if($checkbox_target==NULL && mb_substr($row[3],0,1)=='G') continue;
            if($checkbox_target!=NULL && !($row[1]=='キーワード' || $row[1]=='商品ターゲティング' || $row[1]=='広告グループ')) continue;

            $click_through = $row[19]/$row[18]*100;
            $CPC = $row[20]/$row[19];

            $M = '';
            $N = $row[13];
            $UP = 0;

            // if(mb_substr($row[3], 0, 1, "UTF-8")=='P') $N = 'Phrase';
            // if(mb_substr($row[3], 0, 1, "UTF-8")=='E') $N = 'Exact';
            
            if($click_through > $click_through1 && $row[18] < $impression2) $UP = round($CPC+6);
            else if($click_through > $click_through2 && $row[18] > $impression2) $UP = round($CPC+3);

            else if($click_through3 < $click_through && $click_through < $click_through2 && $row[18] > $impression1) $UP = round($CPC+2);
            else if($click_through4 < $click_through && $click_through < $click_through3 && $row[18] > $impression1) $UP = round($CPC-2);
            else if($click_through < $click_through4 && $row[18] > $impression1) $UP = 3;
            else continue;

            if(mb_substr($row[3],0,1)=='A') {
                $UP = round($CPC+3);
            }

            if(mb_substr($row[3],0,1)=='G') {
                $M = $row[12];
            }

            if(mb_substr($row[3],0,1)=='A' && $row[1]=='商品ターゲティング') continue;
            
            if($row[1]=='広告グループ') Upload1::insert(['キャンペーン'=>$row[3], '広告グループ'=>$row[9], '入札額上限'=>$UP, 'キーワードまたは商品ターゲティング'=>'', '商品ターゲティングID'=>'','マッチタイプ'=>'', '広告グループステータス'=>'有効', 'ステータス'=>'']);
            else Upload1::insert(['キャンペーン'=>$row[3], '広告グループ'=>$row[9], '入札額上限'=>$UP, 'キーワードまたは商品ターゲティング'=>$row[11], '商品ターゲティングID'=>$M, 'マッチタイプ'=>$N, '広告グループステータス'=>'有効', 'ステータス'=>'有効']);

        }

        return Excel::download(new Upload1Export, '3_入札額調整'.date('Ymdhis').'.xlsx');
    }

    public function upload4(Request $request)
    {
        $checkbox_target = $request->input('checkbox_target');
        $impression = $request->input('impression');
        $click_through = $request->input('click_through');
        $conversion = $request->input('conversion');
        
        $sheets = (new UsersImport)->toArray($request->file);        
        
        Upload1::getQuery()->delete();

        foreach ($sheets[1] as $row) {           
            $B = [
                'キャンペーン',
                '掲載枠によるキャンペーン',
                '掲載枠によるキャンペーン',
                '掲載枠によるキャンペーン',
                '広告グループ',
                '広告'
            ];

            if($row[19]=='クリック' || !(mb_substr($row[3],0,1)=='P' || mb_substr($row[3],0,1)=='G') || $row[18] ==0 || $row[19] ==0 || in_array($row[1],$B)) continue;
            if($checkbox_target==NULL && !mb_substr($row[3], 0, 1, "UTF-8")=='P') continue;
            if($checkbox_target==NULL && mb_substr($row[3], 0, 1, "UTF-8")=='G') continue;
            if($checkbox_target!=NULL && !(mb_substr($row[3], 0, 1, "UTF-8")=='P' || mb_substr($row[3], 0, 1, "UTF-8")=='G')) continue;


            $click_rate = $row[19]/$row[18]*100;
            $conversion_rate = $row[21]/$row[19]*100;

            if($row[18] > $impression && ($click_rate < $click_through || $conversion_rate < $conversion)){
                
                Upload1::insert(['キャンペーン'=>$row[3], '広告グループ'=>$row[9], '入札額上限'=>$row[10], 'キーワードまたは商品ターゲティング'=>$row[11], 'マッチタイプ'=>$row[13], 'ステータス'=>'一時停止']);

            }

        }

        return Excel::download(new Upload1Export, '4_マニュアル保留設定'.date('Ymdhis').'.xlsx');
    }

    public function upload5(Request $request)
    {
        $click_through = $request->input('click_through');
        $impression = $request->input('impression');        
        $conversion = $request->input('conversion');
        $bid_add = $request->input('bid_add');    
        
        $sheets = (new UsersImport)->toArray($request->file);        
        
        Upload1::getQuery()->delete();

        foreach ($sheets[1] as $row) {        
            
            if($row[10] == '' || $row[19]=='クリック' || mb_substr($row[3],0,1,"UTF-8")!='P' || $row[18] ==0 || $row[19] ==0) continue;

            $click_rate = $row[19]/$row[18]*100;
            $conversion_rate = $row[21]/$row[19]*100;
                
            if($click_rate >  $click_through && $row[18] > $impression && $conversion_rate > $conversion){
            
                Upload1::insert(['キャンペーン'=>$row[3], '広告グループ'=>$row[9], '入札額上限'=>$row[10], 'キーワードまたは商品ターゲティング'=>$row[11], 'マッチタイプ'=>'Phrase', 'ステータス'=>'一時停止']);
                // Upload1::insert(['キャンペーン'=>'E'.substr($row[3], 1), '広告グループ'=>$row[9], '入札額上限'=>($row[10]+$bid_add), 'キーワードまたは商品ターゲティング'=>$row[11], 'マッチタイプ'=>'Exact', 'ステータス'=>'有効']);

            }       

        }

        foreach ($sheets[1] as $row) {        
            
            if($row[10] == '' || $row[19]=='クリック' || mb_substr($row[3],0,1,"UTF-8")!='P' || $row[18] ==0 || $row[19] ==0) continue;

            $click_rate = $row[19]/$row[18]*100;
            $conversion_rate = $row[21]/$row[19]*100;
                
            if($click_rate >  $click_through && $row[18] > $impression && $conversion_rate > $conversion){
            
                // Upload1::insert(['キャンペーン'=>$row[3], '広告グループ'=>$row[9], '入札額上限'=>$row[10], 'キーワードまたは商品ターゲティング'=>$row[11], 'マッチタイプ'=>'Phrase', 'ステータス'=>'一時停止']);
                Upload1::insert(['キャンペーン'=>'E'.substr($row[3], 1), '広告グループ'=>$row[9], '入札額上限'=>($row[10]+$bid_add), 'キーワードまたは商品ターゲティング'=>$row[11], 'マッチタイプ'=>'Exact', 'ステータス'=>'有効']);

            }       

        }

        return Excel::download(new Upload1Export, '5_完全一致移行'.date('Ymdhis').'.xlsx');
    }

    public function uploadEx1(Request $request)
    {
        $checkbox_target_disp = $request->input('checkbox_target_disp');        
        $sales_lower_rate = $request->input('sales_lower_rate');
        $impression = $request->input('impression');
        $acos = $request->input('acos');
        $file_type = $request->input('file_type');
        
        $sheets = (new UsersImport)->toArray($request->file);                

        if($file_type == 'csv'){

            UploadEx1::getQuery()->delete();

            foreach ($sheets[0] as $row) {           

                if($row[3] == 'SKU') continue;

                UploadEx1::insert(['SKU'=>$row[3], '注文商品売上'=>(int) filter_var($row[11], FILTER_SANITIZE_NUMBER_INT)]);       

            }

            return view('uploadEx1')->with('file_type','excel');

        }else if($file_type == 'excel'){

            $sku = UploadEx1::orderBy('注文商品売上','ASC')->get();
            $sku_arr = [];
            $loop = round(count($sku)*$sales_lower_rate/100);

            for ($i=0; $i < $loop; $i++) { 

                array_push($sku_arr,$sku[$i]['SKU']);                

            }

            Upload1::getQuery()->delete();

            foreach ($sheets[1] as $row) {           

                if($checkbox_target_disp==NULL && !(mb_substr($row[3], 0, 1, "UTF-8")=='A' || mb_substr($row[3], 0, 1,   "UTF-8")=='P' || mb_substr($row[3], 0, 1, "UTF-8")=='E')) continue;
                if($checkbox_target_disp!=NULL && !(mb_substr($row[3], 0, 1, "UTF-8")=='A' || mb_substr($row[3], 0, 1, "UTF-8")=='P' || mb_substr($row[3], 0, 1, "UTF-8")=='E' || mb_substr($row[3], 0, 1, "UTF-8")=='G')) continue;
                if(!in_array($row[14],$sku_arr)) continue;
                
                if($row[18] > $impression && $row[24] > $acos ){
                    
                    Upload1::insert(['キャンペーン'=>$row[3], '広告グループ'=>$row[9], 'SKU'=>$row[14], 'ステータス'=>'一時停止']);

                }

            }

            return Excel::download(new Upload1Export, 'Ex1_広告費削減施策'.date('Ymdhis').'.xlsx');
        }else{
            echo "Invalided file error";
        }
    }

    


    
}
