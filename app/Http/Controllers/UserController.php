<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Models\Quiz1;
use App\Exports\Quiz1Export;
use App\Models\Quiz2;
use App\Exports\Quiz2Export;
use App\Models\Quiz3;
use App\Exports\Quiz3Export;

use App\Models\Man1;
use App\Exports\RecruimentExport;
use App\Exports\SalesExport;
use App\Exports\AdminExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Services\OpenAIService;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;




date_default_timezone_set('Asia/Tokyo');

class UserController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }








    ////////////////////// QUIZ ///////////////////////////////////

    //recruiment

    public function viewQuiz1(Request $request)
    {
        $user_id = Auth::user()->id;
        // DB::table('users')->where('id', $user_id)->update(['engineer' => 'true']);
        $quizs = DB::table('recruiment_quiz_table')->where('項目', '職種適正')->get();
        $項目 = '職種適正';
        return view('quiz.quiz1', compact('quizs', '項目'));
    }


    public function viewQuiz2(Request $request)
    {
        $quizs = DB::table('recruiment_quiz_table')->where('項目', '企業適正')->get();
        $項目 = '企業適正';
        return view('quiz.quiz2', compact('quizs', '項目'));
    }


    public function viewQuiz3_1(Request $request)
    {

        $quizs = DB::table('recruiment_quiz_table')->where('項目', '現状確認')->get();
        $項目 = '現状確認';

        return view('quiz.quiz3_1', compact('quizs', '項目'));
    }


    public function viewQuiz3_2(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where(['user_id' => $id])->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id])->orderBy('id', 'desc')->take(1)->update(['quiz3' => $quiz_result]);
        } else {
            DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz3' => $quiz_result, 'type' => 'recruiment']);
        }

        $quizs = DB::table('recruiment_quiz_table')->where('項目', '現状確認')->get();
        $項目 = '現状確認';

        return view('quiz.quiz3_2', compact('quizs', '項目'));
    }


    public function viewQuiz3_3(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        $old_quiz_result = DB::table('quiz_result')->where(array('user_id' => $id))->orderBy('id', 'desc')->first('quiz3');
        $old_quiz_result = $old_quiz_result->quiz3;

        if (!str_contains($old_quiz_result, $quiz_result)) {
            $sql = 'CONCAT(quiz3,",' . $quiz_result . '")';
            DB::table('quiz_result')->where(array('user_id' => $id))->orderBy('id', 'desc')->take(1)->update(['quiz3' => DB::raw($sql)]);
            $quiz_result = $old_quiz_result . ',' . $quiz_result;
        } else {
            $quiz_result = $old_quiz_result;
        }

        $quizs = DB::table('recruiment_quiz_table')->where('項目', '現状確認')->get();
        $項目 = '現状確認';

        return view('quiz.quiz3_3', compact('quizs', '項目'));
    }

    public function viewResult3_1(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        $old_quiz_result = DB::table('quiz_result')->where(array('user_id' => $id))->orderBy('id', 'desc')->first('quiz3');
        $old_quiz_result = $old_quiz_result->quiz3;

        if (!str_contains($old_quiz_result, $quiz_result)) {
            $sql = 'CONCAT(quiz3,",' . $quiz_result . '")';
            DB::table('quiz_result')->where(array('user_id' => $id))->orderBy('id', 'desc')->take(1)->update(['quiz3' => DB::raw($sql)]);
            $quiz_result = $old_quiz_result . ',' . $quiz_result;
        } else {
            $quiz_result = $old_quiz_result;
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'recruiment');

        DB::table('quiz_result')->where(array('user_id' => $id))->orderBy('id', 'desc')->take(1)->update(['no3' => $result['sub_type'], 'res3' => $result['sub_title']]);

        return view('quiz.result3_1', compact('result'));
    }



    //sales

    // public function viewQuiz1_s(Request $request)
    // {


    //     $quizs = DB::table('sales_quiz_table')->where('項目', 'PJ適性')->get();
    //     $項目 = 'PJ適性';

    //     return view('quiz.quiz1_s', compact('quizs', '項目'));
    // }
    public function work_question() {
         $quizs = DB::table('work_question')->where('項目', '柔軟性')->get();
        $項目 = '柔軟性';

        return view('work.workQuestion', compact('quizs', '項目'));
    }


    public function viewQuiz2_s(Request $request)
    {

        $quizs = DB::table('work_question')->where('項目', '協調性')->get();
        $項目 = '協調性';

        return view('quiz.quiz2_s', compact('quizs', '項目'));
    }

    public function viewQuiz3_s(Request $request)
    {

        $quizs = DB::table('work_question')->where('項目', 'リーダー適性')->get();
        $項目 = 'リーダー適性';

        return view('quiz.quiz3_s', compact('quizs', '項目'));
    }


    //management
    public function viewQuiz1_m(Request $request)
    {

        $quizs = DB::table('management_quiz_table')->where('項目', '仕事内容')->get();
        $項目 = '仕事内容';

        return view('quiz.quiz1_m', compact('quizs', '項目'));
    }


    public function viewQuiz2_m(Request $request)
    {


        $quizs = DB::table('management_quiz_table')->where('項目', '人間関係')->get();
        $項目 = '人間関係';

        return view('quiz.quiz2_m', compact('quizs', '項目'));
    }


    public function viewQuiz3_m(Request $request)
    {

        $quizs = DB::table('management_quiz_table')->where('項目', '業務負担')->get();
        $項目 = '業務負担';

        return view('quiz.quiz3_m', compact('quizs', '項目'));
    }



    public function viewExpress(Request $request)
    {
        return view('quiz.express');
    }


    public function resultExpress(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();

        $rows = DB::table('quiz_result')->where(array('user_id' => $id))->count();

        $result = '';

        if ($rows < 1) {
            $result = DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'express' => $quiz_result['express'], 'type' => 'management']);
        } else {
            $result = DB::table('quiz_result')->where(array('user_id' => $id))->update(['express' => $quiz_result['express']]);
        }


        return view('quiz.express', compact('result'));
    }

    public function checkResult($str, $level)
    {
        $type = '';
        $sub_type = '';
        $sub_title = '';
        $url = '';
        $count = 0;
        if ($level == "recruiment") {

            //右はSier、左はWEBに分岐
            if (str_contains($str, '職種適正-1-1')) {
                $type = 'WEB';
                $url = 'https://result.engineermatch.net/web/';

                //№1が左の場合、右であれば6
                if (str_contains($str, '職種適正-6-2')) {
                    $sub_type = 6;
                    $sub_title = 'テスター';
                    $no = 6;
                }

                //左であればその他7
                else if (str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                }

                //№1が左の場合、左であれば4
                else if (str_contains($str, '職種適正-8-1')) {
                    $sub_type = 4;
                    $sub_title = '開発ディレクター';
                }

                //№1が左の場合、右であれば5
                else if (str_contains($str, '職種適正-8-2')) {
                    $sub_type = 5;
                    $sub_title = 'WEB開発エンジニア';
                }

                //except
                if (str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                    $url = 'https://result.engineermatch.net/sales/';
                }
            }

            //右はSier、左はWEBに分岐
            if (str_contains($str, '職種適正-1-2')) {
                $type = 'Sier';
                $url = 'https://result.engineermatch.net/sier/';
                //№1が右の場合、右であれば3
                if (str_contains($str, '職種適正-6-2')) {
                    $sub_type = 3;
                    $sub_title = 'メンバーエンジニア';
                }

                //左であればその他7
                else if (str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                }

                //№1が右の場合、左であれば1
                else if (str_contains($str, '職種適正-8-1')) {
                    $sub_type = 1;
                    $sub_title = 'ITコンサルタント';
                }

                //№1が右の場合、右であれば2
                else if (str_contains($str, '職種適正-8-2')) {
                    $sub_type = 2;
                    $sub_title = '技術リーダー';
                }

                //except
                if (str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                    $url = 'https://result.engineermatch.net/sales/';
                }
            }
            //右はSES、左は事業会社に分岐
            if (str_contains($str, '企業適正-1-1')) {
                $type = '事業会社';
                $url = 'https://result.engineermatch.net/mc/';

                //№1が左の場合、左は1で右は2
                if (str_contains($str, '企業適正-4-1')) {
                    $sub_type = 1;
                    $sub_title = 'WEB企業';
                } else if (str_contains($str, '企業適正-4-2')) {
                    $sub_type = 2;
                    $sub_title = 'SaaS';
                }
            }

            //右はSES、左は事業会社に分岐
            if (str_contains($str, '企業適正-1-2')) {
                $type = 'SES';
                $url = 'https://result.engineermatch.net/ses/';

                //№1が右の場合、左は3で右は4
                if (str_contains($str, '企業適正-7-1')) {
                    $sub_type = 3;
                    $sub_title = '中堅以上SES';
                } else if (str_contains($str, '企業適正-7-2')) {
                    $sub_type = 4;
                    $sub_title = '小規模SES';
                }
            }
            //全部左あれば1、一つでも右あれば次ページに遷移
            if (str_contains($str, '現状確認-1-1-1') && str_contains($str, '現状確認-1-2-1') && str_contains($str, '現状確認-1-3-1')) {

                $type = '';
                $sub_type = 1;
                $sub_title = 'PMO';
                $url = 'https://result.engineermatch.net/status/';
            }

            //全部左あれば2、一つでも右あれば次ページに遷移
            else if (str_contains($str, '現状確認-2-1-1') && str_contains($str, '現状確認-2-2-1') && str_contains($str, '現状確認-2-3-1')) {

                $type = '';
                $sub_type = 2;
                $sub_title = '開発・テスト';
                $url = 'https://result.engineermatch.net/status/';
            }

            //全部左あれば3、一つでも右あれば4
            else if (str_contains($str, '現状確認-3-1-1') && str_contains($str, '現状確認-3-2-1') && str_contains($str, '現状確認-3-3-1')) {

                $type = '';
                $sub_type = 3;
                $sub_title = 'インフラ';
                $url = 'https://result.engineermatch.net/status/';
            } else if (str_contains($str, '現状確認')) {

                $type = '';
                $sub_type = 4;
                $sub_title = 'IT研修受講';
                $url = 'https://result.engineermatch.net/status/';
            }
        }
        if($level == "work"){

            if (str_contains($str, '柔軟性-1-1')) $count++;
            if (str_contains($str, '柔軟性-2-1')) $count++;
            if (str_contains($str, '柔軟性-3-1')) $count++;
            if (str_contains($str, '柔軟性-4-1')) $count++;
            if (str_contains($str, '柔軟性-5-1')) $count++;
            if (str_contains($str, '柔軟性-6-1')) $count++;
            if (str_contains($str, '柔軟性-7-1')) $count++;
            if (str_contains($str, '柔軟性-8-1')) $count++;
            if (str_contains($str, '柔軟性-9-1')) $count++;
            if (str_contains($str, '柔軟性-10-1')) $count++;
    
            if (str_contains($str, '協調性-1-1')) $count++;
            if (str_contains($str, '協調性-2-1')) $count++;
            if (str_contains($str, '協調性-3-1')) $count++;
            if (str_contains($str, '協調性-4-1')) $count++;
            if (str_contains($str, '協調性-5-1')) $count++;
            if (str_contains($str, '協調性-6-1')) $count++;
            if (str_contains($str, '協調性-7-1')) $count++;
            if (str_contains($str, '協調性-8-1')) $count++;
            if (str_contains($str, '協調性-9-1')) $count++;
            if (str_contains($str, '協調性-10-1')) $count++;
    
            if (str_contains($str, 'リーダー適性-1-1')) $count++;
            if (str_contains($str, 'リーダー適性-2-1')) $count++;
            if (str_contains($str, 'リーダー適性-3-1')) $count++;
            if (str_contains($str, 'リーダー適性-4-1')) $count++;
            if (str_contains($str, 'リーダー適性-5-1')) $count++;
            if (str_contains($str, 'リーダー適性-6-1')) $count++;
            if (str_contains($str, 'リーダー適性-7-1')) $count++;
            if (str_contains($str, 'リーダー適性-8-1')) $count++;
            if (str_contains($str, 'リーダー適性-9-1')) $count++;
            if (str_contains($str, 'リーダー適性-10-1')) $count++;
    
            if ($count >= 8) {
                $sub_type = 'A';
                $sub_title = 'どんな現場でも活躍できそうです！';
            } elseif ($count >= 6 and $count < 8) {
                $sub_type = 'B';
                $sub_title = '現場によって合う合わないが分かれそうです！';
            } else {
                $sub_type = 'C';
                $sub_title = '現場によっては少し不安な面があります！';
            }
        }
        if($level == "management"){
            if (str_contains($str, '仕事内容-1-1')) $count++;
            if (str_contains($str, '仕事内容-2-1')) $count++;
            if (str_contains($str, '仕事内容-3-1')) $count++;
            if (str_contains($str, '仕事内容-4-1')) $count++;
            if (str_contains($str, '仕事内容-5-1')) $count++;
    
            if (str_contains($str, '人間関係-1-1')) $count++;
            if (str_contains($str, '人間関係-2-1')) $count++;
            if (str_contains($str, '人間関係-3-1')) $count++;
            if (str_contains($str, '人間関係-4-1')) $count++;
            if (str_contains($str, '人間関係-5-1')) $count++;
    
            if (str_contains($str, '業務負担-1-1')) $count++;
            if (str_contains($str, '業務負担-2-1')) $count++;
            if (str_contains($str, '業務負担-3-1')) $count++;
            if (str_contains($str, '業務負担-4-1')) $count++;
            if (str_contains($str, '業務負担-5-1')) $count++;
    
            if ($count == 5) {
                $sub_type = '◎';
                $sub_title = '次現場でも引き続き活躍していきしょう！';
            } else if ($count == 3 || $count == 4) {
                $sub_type = '〇';
                $sub_title = '少し気になることがあれば就業前に相談しましょう！';
            } else {
                $sub_type = '△';
                $sub_title = '就業前にご自身の仕事ぶりを相談しましょう！';
            }
        }

        return array(
            'type' => $type,
            'sub_type' => $sub_type,
            'sub_title' => $sub_title,
            'url' => $url,

        );
    }

    //result
    public function viewResult1(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where('user_id', $id)->count();
        
        if($rows > 0){
            DB::table('quiz_result')->where('user_id', $id)->update(['updated_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result, 'type' => 'recruiment']);
        }else{
            DB::table('quiz_result')->where('user_id', $id)->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result, 'type' => 'recruiment']);
        }

        DB::table('users')->where('id', $id)->update(['engineer' => 'true']);

        $result = $this->checkResult($quiz_result, 'recruiment');

        DB::table('quiz_result')->where('user_id', $id)->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);
        $next = 2;
        return view('quiz.result', compact('result', 'next'));
    }

    public function viewResult2(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where('user_id', $id)->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where('user_id', $id)->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('quiz_result')->where('user_id', $id)->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result, 'type' => 'recruiment']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'recruiment');

        DB::table('quiz_result')->where('user_id', $id)->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

        $next = 3;

        return view('quiz.result', compact('result', 'next'));
    }


    public function viewResult1_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('work_result')->where('user_id', $id)->count();
        if($rows > 0) {
            DB::table('work_result')->where('user_id', $id)->update(['updated_at' => date('Y-m-d h:i:s'), 'quiz1' => $quiz_result]);
        }else{
            DB::table('work_result')->where('user_id', $id)->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result]);
        }
        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, "work");

        DB::table('work_result')->where('user_id', $id)->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

        $next = 2;

        return view('quiz.result_s', compact('result', 'next'));
    }

    public function viewResult2_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('work_result')->where('user_id', $id)->count();

        if ($rows > 0) {
            DB::table('work_result')->where('user_id', $id)->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('work_result')->where('user_id', $id)->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result]);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, "work");

        DB::table('work_result')->where('user_id', $id)->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

        $next = 3;

        return view('quiz.result_s', compact('result', 'next'));
    }

    public function viewResult3_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('work_result')->where(['user_id' => $id])->count();

        if ($rows > 0) {
            DB::table('work_result')->where(['user_id' => $id])->orderBy('id', 'desc')->take(1)->update(['quiz3' => $quiz_result]);
        } else {
            DB::table('work_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz3' => $quiz_result, 'type' => 'sales']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, "work");

        DB::table('work_result')->where(array('user_id' => $id))->update(['no3' => $result['sub_type'], 'res3' => $result['sub_title']]);
        $results = DB::table('work_result')->where('user_id', $id)->select('no1', 'no2', 'no3')->first();
        $values = array_values(get_object_vars($results));
        if(in_array("C", $values)){
            $result = "職人";
        }elseif(in_array("B", $values)) {
            $result = "技術リーダー";
        }else{
            $result = "管理職リーダー";
        }
        $next = 1;

        return view('quiz.result_s', compact('result', 'next'));
    }

    public function viewResult1_m(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('work_second_result')->where('user_id', $id)->count();

        if($rows > 0) {
            DB::table('work_second_result')->where('user_id', $id)->update(['updated_at' => date('Y-m-d h:i:s'), 'quiz1' => $quiz_result]);
        }
        else{
            DB::table('work_second_result')->where('user_id', $id)->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result]);
        }

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('work_second_result')->where('user_id', $id)->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

        $next = 2;

        return view('quiz.result_m', compact('result', 'next'));
    }

    public function viewResult2_m(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        $rows = DB::table('work_second_result')->where(['user_id' => $id])->count();

        if ($rows > 0) {
            DB::table('work_second_result')->where(['user_id' => $id])->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('work_second_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result, 'type' => 'management']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('work_second_result')->where(array('user_id' => $id))->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

        $next = 3;

        return view('quiz.result_m', compact('result', 'next'));
    }
    public function viewResult3_m(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        $rows = DB::table('work_second_result')->where(['user_id' => $id])->count();
        if ($rows > 0) {
            DB::table('work_second_result')->where(['user_id' => $id])->orderBy('id', 'desc')->take(1)->update(['quiz3' => $quiz_result]);
        } else {
            DB::table('work_second_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz3' => $quiz_result, 'type' => 'management']);
        }
        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('work_second_result')->where(array('user_id' => $id))->update(['no3' => $result['sub_type'], 'res3' => $result['sub_title']]);

        $next = 4;
        return view('quiz.result_m', compact('result', 'next'));
    }
    ////////////////////////////////////////////////////////////////


    ////////////////////////// admin ///////////////////////////////
    public function recruimentUser()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $users = DB::table('users')->get();
        $page = "recruimentUser";
        return view('quiz.admin.recruiment_user', compact('users', 'page'));
    }

    public function adminone() {
        return view('quiz.recruiment_user');
    }


    public function salesUser()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $users = DB::table('users')->get();
        $page = "salesUser";
        return view('quiz.admin.sales_user', compact('users', 'page'));
    }

    public function managementUser()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $users = DB::table('users')->get();
        $page = "managementUser";
        return view('quiz.admin.management_user', compact('users', 'page'));
    }

    public function memberUser()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $users = DB::table('users')->get();
        $page = "memberUser";

        // dd($users); exit();

        return view('quiz.admin.member_user', compact('users', 'page'));
    }

    public function Update(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        return DB::table('users')->where('id', $id)->update(['status' => $status]);
    }

    public function email() {
        $user = Auth::user()->role;
        $page = 'email';
        $email_datas = DB::table('email')->get();
        if($user == "admin"){
            return view('manager.email', compact('email_datas','page'));
        }
    }

    public function insert_email(Request $request) {
        $title = $request->input('title');
        $rows = DB::table('email')->where('title', $title)->first();
        if($rows){
            return back()->with('emailError', "The data is already exited!");
        }else{
            DB::table('email')->insert(['title' => $request->input('title'), 'content' => $request->input('content'), 'created_at' => date('Y-m-d h:i:s'), 'select' => 'none']);
        }
        return $this->email();
    }

    public function update_email(Request $request) {
        $id = $request->input('id');
        $rows = DB::table('email')->where('id', $id)->first();
        if($rows){
            DB::table('email')->where('id', $id)->update(['title' => $request->input('title'), 'content' => $request->input('content'), 'updated_at' => date('Y-m-d h:i:s')]);
        }
        return $this->email();
    }

    public function email_delete(Request $request) {
        $email_id = $request->input('email_id');
        DB::table('email')->where('id', $email_id)->delete();
        return $this->email();
    }

    public function email_display(Request $request) {
        $email_id = $request->input('email_id');
        DB::table('email')->where('select', 'display')->update(['select' => 'none']);
        DB::table('email')->where('id', $email_id)->update(['select' => 'display']);
        return $this->email();
    }

    public function manager_movie() {
        $page = "movie";
        
        $results = DB::table('resume_result')
            ->join('users', 'resume_result.user_id', '=', 'users.id')
            ->select('resume_result.video_urls', 'resume_result.resume_url', 'resume_result.cv_url', 'resume_result.user_id',  'users.name')
            ->get();
        
        // Transform the video URLs and include docs_url in the data structure
        $results->transform(function ($item) {
            $item->video_urls = $item->video_urls ? explode(',', $item->video_urls) : [];
            return $item;
        });

        // Create an associative array with combined first and last names as keys
        $videoUrls = $results->mapWithKeys(function ($item) {
            $key = $item->name; // Combine first and last names
            
            // Get the video file sizes
            $videoFileSizes = array_map(function ($videoUrl) {
                $filePath = public_path($videoUrl); // Adjust path as necessary
                if (file_exists($filePath)) {
                    $sizeInBytes = filesize($filePath);
                    return $sizeInBytes ? round($sizeInBytes / 1048576, 2) . "MB" : 0; // Convert to MB and round to 2 decimal places
                }
                return 'File not found';
            }, $item->video_urls);

            $value = [
                'videos' => $item->video_urls,       // Get the video URLs
                'file_sizes' => $videoFileSizes,     // Get the file sizes
                'resume_url' => $item->resume_url,      // Get the docs URL
                'cv_url' => $item->cv_url,      // Get the docs URL
                'user_id' => $item->user_id,
                'name' => $item->name
            ];
            
            return [$key => $value]; // Return as an associative array
        });

        return view('manager.movie', compact('videoUrls', 'page'));
    }

    //admin quiz
    public function recruimentQuiz()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $quizs = DB::table('recruiment_quiz_table') -> orderBy('項目', 'desc') -> get();
        $page = "recruimentQuiz";
        return view('quiz.admin.recruiment_quiz', compact('quizs', 'page'));
    }

    public function workQuiz()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $quizs = DB::table('work_question') -> orderBy('項目', 'desc') -> get();
        $page = "workQuiz";
        return view('quiz.admin.work_quiz', compact('quizs', 'page'));
    }

    public function managementQuiz()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $quizs = DB::table('management_quiz_table') -> orderBy('項目', 'desc') -> get();
        $users = User::paginate();
        $page = "managementQuiz";
        return view('quiz.admin.management_quiz', compact('quizs', 'page'));
    }
    public function resumingQuiz()
    {
        $resumingquizs = DB::table('resume_question')->get();
        $users = User::paginate();
        $page = "resumingQuiz";
        return view('resume.admin.resuming_quiz', compact('resumingquizs', 'page'));
    }


    public function addQuiz(Request $request)
    {

        if ($request->input('level') == "recruiment") {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('recruiment_quiz_table')->insert($data);
            return $this->recruimentQuiz();
        } else if ($request->input('level') == "sales") {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('work_question')->insert($data);
            return $this->workQuiz();
        } else {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('management_quiz_table')->insert($data);
            return $this->managementQuiz();
        }
    }

    public function updateQuiz(Request $request)
    {

        if ($request->input('level') == "recruiment") {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('recruiment_quiz_table')->where('id', $request->input('id'))->update($data);
            return $this->recruimentQuiz();
        } else if ($request->input('level') == "sales") {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('work_question')->where('id', $request->input('id'))->update($data);
            return $this->workQuiz();
        } else {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('management_quiz_table')->where('id', $request->input('id'))->update($data);
            return $this->managementQuiz();
        }
    }


    public function delQuiz(Request $request)
    {
        if ($request->input('level') == "recruiment") {

            $id = $request->id;
            $res = DB::table('recruiment_quiz_table')->where('id', $id)->delete();
            return $this->recruimentQuiz();
        } else if ($request->input('level') == "sales") {

            $id = $request->id;
            $res = DB::table('work_question')->where('id', $id)->delete();
            return $this->workQuiz();
        } else {
            $id = $request->id;
            $res = DB::table('management_quiz_table')->where('id', $id)->delete();
            return $this->managementQuiz();
        }
    }

    // resume Quiz
    public function addresumeQuiz(Request $request)
    {
        $question_id = $request->input('question_id');
        $id = DB::table('resume_question')->where('question_id', $question_id)->first();
        if($id) {
            return $this->resumingQuiz();
        }
        else{
            $data = array(
                'job' => $request->input('job'),
                'question_id' => $request->input('question_id'),
                'question' => $request->input('question1') . "," . $request->input('question2'),
                'comment' => $request->input('comment'),
                'url' => $request->input('url')
            );
    
            $res = DB::table('resume_question')->insert($data);
            return $this->resumingQuiz();
        }
    }
    public function updateresumeQuiz(Request $request)
    {
 
        $data = array(
            'job' => $request->input('job'),
            'question_id' => $request->input('question_id'),
            'question' => $request->input('question1') . "," . $request->input('question2'),
            'comment' => $request->input('comment'),
            'url' => $request->input('url')
        );

        $res = DB::table('resume_question')->where('id', $request->input('id'))->update($data);
        return $this->resumingQuiz();
        
    }


    public function delresumeQuiz(Request $request)
    {
        $id = $request->id;
        $res = DB::table('resume_question')->where('id', $id)->delete();
        return $this->resumingQuiz();
    }

    //admin restul
    public function recruimentResult()
    {
        if (Auth::user()->status == '0') {
            return view('pending');
        }

        $results = DB::table('quiz_result')
            ->join('users', 'quiz_result.user_id', '=', 'users.id')
            ->where('users.engineer', "true") // Add this line to filter by engineer
            ->select('quiz_result.*', 'users.name')
            ->get();

        $page = "recruimentResult";
        return view('quiz.admin.recruiment_result', compact('results', 'page'));
    }

    public function showEngineerPage(Request $request) {

        $data = $request->all();
        $type = $data['type'];

        // dd($data);
        $quizs = DB::table($type . '_quiz_table')->get();
        $quiz_array = [];
        foreach ($quizs as $quiz) {
            $temp = [];
            $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
            $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
            $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
            $quiz_array = array_merge($quiz_array, $temp);
        }

        // dd($quiz_array);

        $content = [
            'name' => $data['name'],
            'type' => $data['type'],
            'quiz_array' => $quiz_array,
            'quiz1' => $data['quiz1'],
            'no1' => $data['no1'],
            'res1' => $data['res1'],
            'quiz2' => $data['quiz2'],
            'no2' => $data['no2'],
            'res2' => $data['res2'],
            'quiz3' => $data['quiz3'],
            'no3' => $data['no3'],
            'res3' => $data['res3'],
            'express' => $data['express'],
            'created_at' => $data['created_at'],
        ];

        // Pass data to modal view
        return view('pdfpage.engineerpage', $content);
    }

    public function workResult()
    {
        $id = Auth::user()->id;
        if (Auth::user()->status == '0')
            return view('pending');

        $results = DB::table('work_result')
            ->join('users', 'work_result.user_id', '=', 'users.id')
            ->select('work_result.*', 'users.name')
            ->get();
        $page = "workResult";
        return view('work.work_result', compact('results', 'page'));
    }

    public function managementResult()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $results = DB::table('work_second_result')
            ->join('users', 'work_second_result.user_id', '=', 'users.id')
            ->select('work_second_result.*', 'users.name')
            ->get();

        $page = "managementResult";
        return view('quiz.admin.management_result', compact('results', 'page'));
    }

    public function resumingResult()
    {
        $results = DB::table('resume_result')
            ->join('users', 'resume_result.user_id', '=', 'users.id')
            ->select('resume_result.*', 'users.name', 'users.role')
            ->get();
        $page = "resumingResult";
        return view('resume.admin.resuming_result', compact('results', 'page'));
    }

    public function resumingMovie(Request $request) {
        $user_id = $request->input('user_id');
        $movieList = DB::table('resume_result')->where('user_id', $user_id)->select('video_urls')->get();

        if($movieList[0]->video_urls){
            $movieList = explode(',', $movieList[0]->video_urls);
            $page = "resumingMovie";
            return view('resume.admin.view_moving', compact('movieList', 'page'));
        }
        else{
            return back()->with('error', 'Video file is not exited!');
        }
    }

    public function Pdf(Request $request)
    {

        $data = $request->all();

        // dd($data);
        $worktype = $request->input('worktype');
        if($worktype == "one"){
            $quizs = DB::table('work_question')->get();
        }
        else{
            $quizs = DB::table('management_quiz_table')->get();
        }

        $quiz_array = [];
        foreach ($quizs as $quiz) {
            $temp = [];
            $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
            $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
            $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
            $quiz_array = array_merge($quiz_array, $temp);
        }

        // dd($quiz_array);

        $content = [
            'name' => $data['name'],
            'quiz_array' => $quiz_array,
            'quiz1' => $data['quiz1'],
            'no1' => $data['no1'],
            'res1' => $data['res1'],
            'quiz2' => $data['quiz2'],
            'no2' => $data['no2'],
            'res2' => $data['res2'],
            'quiz3' => $data['quiz3'],
            'no3' => $data['no3'],
            'res3' => $data['res3'],
            'created_at' => $data['created_at'],
        ];

        $pdf = PDF::loadView('pdf', $content);

        if($worktype == "one"){
            $pdf_str = '_業務適性データ.pdf';
        }
        else{
            $pdf_str = '_現状確認データ.pdf';
        }

        return $pdf->download($data['name'] . $pdf_str);
        // return $pdf->stream($data['name'] . $pdf_str);
    }

    public function admin_workresultpage(Request $request) {
        $data = $request->all();
    $worktype = $request->input('worktype');

    // Fetch quizzes based on worktype
    $quizs = ($worktype == "one")
        ? DB::table('work_question')->get()
        : DB::table('management_quiz_table')->get();

    // Prepare quiz array
    $quiz_array = [];
    foreach ($quizs as $quiz) {
        $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
        $answers = explode(',', $quiz->回答項目);
        
        foreach ($answers as $index => $answer) {
            $quiz_array[$quiz_key . '-' . ($index + 1)] = trim($answer);
        }
    }

    // Prepare content for the view
    $content = [
        'name' => $data['name'],
        'quiz_array' => $quiz_array,
        'quiz1' => $data['quiz1'] ?? '',
        'no1' => $data['no1'] ?? '',
        'res1' => $data['res1'] ?? '', // Ensure this is set
        'quiz2' => $data['quiz2'] ?? '',
        'no2' => $data['no2'] ?? '',
        'res2' => $data['res2'] ?? '', // Ensure this is set
        'quiz3' => $data['quiz3'] ?? '',
        'no3' => $data['no3'] ?? '',
        'res3' => $data['res3'] ?? '', // Ensure this is set
        'created_at' => $data['created_at'] ?? '',
    ];

    return view('pdfpage.workresultpage', compact('content'));
    }

    public function admin_managementpage(Request $request) {
                $data = $request->all();
    $worktype = $request->input('worktype');

    // Fetch quizzes based on worktype
    $quizs = ($worktype == "one")
        ? DB::table('work_question')->get()
        : DB::table('management_quiz_table')->get();

    // Prepare quiz array
    $quiz_array = [];
    foreach ($quizs as $quiz) {
        $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
        $answers = explode(',', $quiz->回答項目);
        
        foreach ($answers as $index => $answer) {
            $quiz_array[$quiz_key . '-' . ($index + 1)] = trim($answer);
        }
    }

    // Prepare content for the view
    $content = [
        'name' => $data['name'],
        'quiz_array' => $quiz_array,
        'quiz1' => $data['quiz1'] ?? '',
        'no1' => $data['no1'] ?? '',
        'res1' => $data['res1'] ?? '', // Ensure this is set
        'quiz2' => $data['quiz2'] ?? '',
        'no2' => $data['no2'] ?? '',
        'res2' => $data['res2'] ?? '', // Ensure this is set
        'quiz3' => $data['quiz3'] ?? '',
        'no3' => $data['no3'] ?? '',
        'res3' => $data['res3'] ?? '', // Ensure this is set
        'created_at' => $data['created_at'] ?? '',
    ];

    return view('pdfpage.managementpage', compact('content'));
    }

    public function engineerpdf(Request $request)
    {

        $data = $request->all();
        $type = $data['type'];

        // dd($data);
        $quizs = DB::table($type . '_quiz_table')->get();
        $quiz_array = [];
        foreach ($quizs as $quiz) {
            $temp = [];
            $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
            $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
            $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
            $quiz_array = array_merge($quiz_array, $temp);
        }

        // dd($quiz_array);

        $content = [
            'name' => $data['name'],
            'type' => $data['type'],
            'quiz_array' => $quiz_array,
            'quiz1' => $data['quiz1'],
            'no1' => $data['no1'],
            'res1' => $data['res1'],
            'quiz2' => $data['quiz2'],
            'no2' => $data['no2'],
            'res2' => $data['res2'],
            'quiz3' => $data['quiz3'],
            'no3' => $data['no3'],
            'res3' => $data['res3'],
            'express' => $data['express'],
            'created_at' => $data['created_at'],
        ];

        $pdf = PDF::loadView('pdf', $content);

        $pdf_str = $type == 'recruiment' ? '_採用候補者データ.pdf' : ($type == 'sales' ? '_人材データ.pdf' : '_就業状況データ.pdf');

        return $pdf->download($data['name'] . $pdf_str);
        // return $pdf->stream($data['name'] . $pdf_str);
    }

    public function work_pdf(Request $request) {
        $answer = $request->input('resume_content');
        $answers = explode(',', $answer);
        $answerArray = collect($answers)->map(function ($item) {
            return preg_replace('/-\d+(-\d+)?$/', '', $item);
        })->toArray();

        $content = [
            'name' => $request->input('name'),
            'quiz_array' => $answerArray,
            'result' => $request->input('job'),
            'created_at' => $request->input('created_at'),
        ];

        $pdf = PDF::loadView('work_pdf', $content);

        $pdf_str = $request->input('name') . '_職種適性回答データ.pdf';

        return $pdf->download($pdf_str);
       
    }

    public function admin_workPage(Request $request) {
        $answer = $request->input('resume_content');
        $answers = explode(',', $answer);
        $answerArray = collect($answers)->map(function ($item) {
            return preg_replace('/-\d+(-\d+)?$/', '', $item);
        })->toArray();

        $content = [
            'name' => $request->input('name'),
            'quiz_array' => $answerArray,
            'result' => $request->input('job'),
            'created_at' => $request->input('created_at'),
        ];

        return view('pdfpage.workpage', compact('content'));
    }

    public function resumepdf(Request $request)
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->initName_f;
        $data = $request->all();
        $resume_content = $data['resume_content'];
        // save to database
        $user = DB::table('users')->where('id', $user_id)->first();
    
        if ($user) {
            // Update existing resume content
            DB::table('users')->where('id', $user_id)->update(['resume_content' => $resume_content]);
        } else {
            // Insert new resume content (note: this part might not be needed if the user exists)
            DB::table('users')->where('id', $user_id)->insert('resume_content', $resume_content);
        }
        
        // save pdf and download this file
        $pdf = PDF::loadView('resumepdf', ['resume_content' => $resume_content]);

        $pdf_str = $user_id . '経歴書.pdf';

        return $pdf->download($name . $pdf_str);
    }

    public function Csv(Request $request)
    {

        // Quiz1::getQuery()->delete();
        // Quiz2::getQuery()->delete();
        // Quiz3::getQuery()->delete();
        // Man1::getQuery()->delete();

        $type = $request->type;

        // dd($type);

        $items = explode(',', $request->items);
        foreach ($items as $item) {

            $user = DB::table('users')->where('id', $item)->first();

            if ($type == 'user') {
                DB::table('users')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd
                ));
            }else if ($type == 'sales_user') {
                DB::table('users')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd
                ));
            }else if ($type == 'admin') {
                DB::table('users')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd
                ));
            }else if ($type == 'member_user') {
                DB::table('users')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd,
                    'ステータス' => $user->status == 0 ? '申請中' : 'システム管理者'
                ));
            }else if($type == 'management'){
                $res = DB::table('work_second_result')->where('user_id', $item)->first();
                $user = DB::table('users')->where('id', $res->user_id)->first();

                $quizs = DB::table('management_quiz_table')->get();
                $quiz_array = [];
                foreach ($quizs as $quiz) {
                    $temp = [];
                    $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
                    $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
                    $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
                    $quiz_array = array_merge($quiz_array, $temp);
                }

                // dd($quiz_array['現状確認-2-1-2']);

                // dd($user->initName_f);

                $quiz1 = $res->quiz1;
                if ($quiz1 != '') {
                    $quiz1_array = explode(',', $quiz1);
                    $answer_str = '';
                    foreach ($quiz1_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no1 = $res->no1;
                    $res1 = $res->res1;

                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no1,
                            'お勧め進路' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }

                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no1,
                            '説明概要' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no1,
                            '説明概要' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }
                }

                ////////2

                $quiz2 = $res->quiz2;
                if ($quiz2 != '') {
                    $quiz2_array = explode(',', $quiz2);
                    $answer_str = '';
                    foreach ($quiz2_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no2 = $res->no2;
                    $res2 = $res->res2;


                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no2,
                            'お勧め進路' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no2,
                            '説明概要' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no2,
                            '説明概要' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                }

                //////3

                $quiz3 = $res->quiz3;
                if ($quiz3 != '') {
                    $quiz3_array = explode(',', $quiz3);
                    $answer_str = '';
                    foreach ($quiz3_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no3 = $res->no3;
                    $res3 = $res->res3;

                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no3,
                            'お勧め進路' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }

                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no3,
                            '説明概要' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no3,
                            '説明概要' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }
                }
            }
            else if($type == "recruiment"){
                $res = DB::table('quiz_result')->where('user_id', $item)->first();
                // dd($res);
                $user = DB::table('users')->where('id', $res->user_id)->first();

                $quizs = DB::table('recruiment_quiz_table')->get();
                $quiz_array = [];
                foreach ($quizs as $quiz) {
                    $temp = [];
                    $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
                    $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
                    $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
                    $quiz_array = array_merge($quiz_array, $temp);
                }

                // dd($quiz_array['現状確認-2-1-2']);

                // dd($user->initName_f);

                $quiz1 = $res->quiz1;
                if ($quiz1 != '') {
                    $quiz1_array = explode(',', $quiz1);
                    $answer_str = '';
                    foreach ($quiz1_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no1 = $res->no1;
                    $res1 = $res->res1;

                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no1,
                            'お勧め進路' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }

                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no1,
                            '説明概要' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no1,
                            '説明概要' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }
                }

                ////////2

                $quiz2 = $res->quiz2;
                if ($quiz2 != '') {
                    $quiz2_array = explode(',', $quiz2);
                    $answer_str = '';
                    foreach ($quiz2_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no2 = $res->no2;
                    $res2 = $res->res2;


                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no2,
                            'お勧め進路' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no2,
                            '説明概要' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no2,
                            '説明概要' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                }

                //////3

                $quiz3 = $res->quiz3;
                if ($quiz3 != '') {
                    $quiz3_array = explode(',', $quiz3);
                    $answer_str = '';
                    foreach ($quiz3_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no3 = $res->no3;
                    $res3 = $res->res3;

                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no3,
                            'お勧め進路' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }

                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no3,
                            '説明概要' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no3,
                            '説明概要' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }
                }
            }
             else {
                $res = DB::table('work_result')->where('user_id', $item)->first();
                // dd($res);
                $user = DB::table('users')->where('id', $res->user_id)->first();

                $quizs = DB::table('work_question')->get();
                $quiz_array = [];
                foreach ($quizs as $quiz) {
                    $temp = [];
                    $quiz_key = $quiz->項目 . '-' . $quiz->提案NO;
                    $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
                    $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
                    $quiz_array = array_merge($quiz_array, $temp);
                }

                // dd($quiz_array['現状確認-2-1-2']);

                // dd($user->initName_f);

                $quiz1 = $res->quiz1;
                if ($quiz1 != '') {
                    $quiz1_array = explode(',', $quiz1);
                    $answer_str = '';
                    foreach ($quiz1_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no1 = $res->no1;
                    $res1 = $res->res1;

                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no1,
                            'お勧め進路' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }

                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no1,
                            '説明概要' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz1)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no1,
                            '説明概要' => $res1,
                            '回答日' => $res->created_at
                        ));
                    }
                }

                ////////2

                $quiz2 = $res->quiz2;
                if ($quiz2 != '') {
                    $quiz2_array = explode(',', $quiz2);
                    $answer_str = '';
                    foreach ($quiz2_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no2 = $res->no2;
                    $res2 = $res->res2;


                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no2,
                            'お勧め進路' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no2,
                            '説明概要' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz2)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no2,
                            '説明概要' => $res2,
                            '回答日' => $res->created_at
                        ));
                    }
                }

                //////3

                $quiz3 = $res->quiz3;
                if ($quiz3 != '') {
                    $quiz3_array = explode(',', $quiz3);
                    $answer_str = '';
                    foreach ($quiz3_array as $item) {
                        $item = trim($item);
                        $answer_str .= $quiz_array[$item] . PHP_EOL;
                    }

                    $no3 = $res->no3;
                    $res3 = $res->res3;

                    if ($type == 'recruiment') {
                        DB::table('quiz1s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            '提案№' => $no3,
                            'お勧め進路' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }

                    if ($type == 'sales') {
                        DB::table('quiz2s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            'ランク' => $no3,
                            '説明概要' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }
                    if ($type == 'management') {
                        DB::table('quiz3s')->insert(array(
                            '氏名' => $user->name,
                            '項目' => explode('-', $quiz3)[0],
                            '回答項目' => $answer_str,
                            '状況' => $no3,
                            '説明概要' => $res3,
                            '回答日' => $res->created_at
                        ));
                    }
                }
            }
        }

        $csv_str = $type == 'recruiment' ? '採用候補者データ.xlsx' : ($type == 'sales' ? '営業適性データ.xlsx' : '就業状況データ.xlsx');
        if ($type == 'recruiment') return Excel::download(new Quiz1Export, $csv_str);
        if ($type == 'sales') return Excel::download(new Quiz2Export, $csv_str);
        if ($type == 'management') return Excel::download(new Quiz3Export, $csv_str);
        if ($type == 'user') return Excel::download(new RecruimentExport, 'ユーザー管理(採用).xlsx');
        if ($type == 'sales_user') return Excel::download(new SalesExport, 'ユーザー管理(営業).xlsx');
        if ($type == 'management_user') return Excel::download(new RecruimentExport, 'ユーザー管理(管理).xlsx');
        if ($type == 'member_user') return Excel::download(new AdminExport, 'システム管理者.xlsx');
    }



    //admin user
    public function addUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $user = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomString),
            'pwd' => $randomString,
        ]);

        $users = User::paginate();
        return view('users.index', compact('users'));
    }

    public function delUser(Request $request)
    {
        $user_id = $request->user_id;
        User::where('id', $user_id)->delete();

        return $this->recruimentUser();
    }

    public function edituser(Request $request) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $id = $request->input('id');
        DB::table('users')->where('id', $id)->
        update([
            'role' => "user",
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomString),
            'pwd' => $request->pwd,
            'created_at' => date('Y-m-d h:i:s')
        ]);
        return $this->recruimentUser();
    }

    public function delResult(Request $request)
    {
        $result_id = $request->result_id;
        DB::table('quiz_result')->where('id', $result_id)->delete();
        return $this->managementResult();
    }

    public function career_question()
    {
        $resumes = DB::table('resume_question')->get();
        
        foreach($resumes as $key => $resume){
            if($resume->question_id == 10){
                unset($resumes[$key]);
            }
        }
        return view('resume.career_question', compact('resumes'));
    }

    public function resume()
    {
        $id = Auth::user()->id;
        $rows = DB::table('quiz_result')->where(array('user_id' => $id))->count();

        return view('resume.create_resume');
    }

    public function question_confirm(Request $request)
    {
        $id = Auth::user()->id;
        $data = $request->all();
        $result_data = array();
        $jobs = array();
        $result_datas = array();
        unset($data['_token']);
        foreach ($data as $job){
            if(explode('-', $job)[1] == 1){
                $question_id = explode('-', $job)[2];
                $job_name = DB::table('resume_question')->where('question_id',  $question_id)->value('job');
                $comment = DB::table('resume_question')->where('question_id',  $question_id)->value('comment');
                $url = DB::table('resume_question')->where('question_id',  $question_id)->value('url');
                array_push($result_data, $job_name, $comment, $url);
                array_push($jobs, $job_name);
                array_push($result_datas, $result_data);
                $result_data = array();
            }
        }
        $data = implode(',', $data);
        $rows = DB::table('resume_result')->where('user_id', $id)->count();
        $jobs = implode(', ', $jobs);
        
        if ($rows > 0) {
            DB::table('resume_result')->where('user_id', $id)->update(['updated_at' => date('Y-m-d h:i:s'), 'resume_content' => $data, 'job' => $jobs]);
        } else {
            DB::table('resume_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'resume_content' => $data, 'job' => $jobs]);
        }
        if(count($result_datas) == 9){
            $result_datas = DB::table('resume_question')->where('question_id', 10)->get();
            $identify = 1;
            return view('resume.create_resume', compact('result_datas', 'identify'));
        }
        else{
            $identify = 0;
            return view('resume.create_resume', compact('result_datas', 'identify'));
        }
    }

    public function question_resuming() {
        return view('resume.question_resuming');
    }

    public function view_movie() {
        $id = Auth::user()->id;
        $result_datas = [];
        $rows = DB::table('resume_result')->where('user_id', $id)->count();
        if($rows > 0){
            $datas = DB::table('resume_result')->where('user_id', $id)->select('video_urls','file_names', )->first();
            $video_urls = explode(',', $datas->video_urls);
            $file_names = explode(',', $datas->file_names);
            for($i = 0; $i < count($video_urls); $i++){
                $data = [
                    'video_url' => $video_urls[$i],
                    'file_name' => $file_names[$i],
                ];
                array_push($result_datas, $data);
            }
        }else{
            return back()->with('error', '');
        }
        return view('resume.view_movie', compact('result_datas') );
    }

    public function add_movie() {
        return view('resume.add_movie');
    }

    public function save_movie(Request $request) {

    // declare variables
    $id = Auth::user()->id;
    $rows = DB::table('resume_result')->where('user_id', $id)->count();
    $paths = [];
    $file_names = [];

    if ($request->hasFile('videos')) {
        $files = $request->file('videos');

        foreach ($files as $file) {
            // Check if the file is valid
            if ($file->isValid()) {
                // Define the path to store the file
                $directory = 'videos/' . Auth::id();
                $filePath = $directory . '/' . $file->getClientOriginalName();

                // Move the file to the designated directory
                $file->move(public_path($directory), $file->getClientOriginalName());

                // Collect file details
                $file_name = $file->getClientOriginalName();
                // Store file details in arrays
                array_push($paths, $filePath);
                array_push($file_names, $file_name);
            } else {
                // Handle invalid file error
                return response()->json(['error' => 'Invalid file uploaded.'], 400);
            }
        }
    } else {
        // Handle no file uploaded error
        return response()->json(['error' => 'No files were uploaded.'], 400);
    }


    $paths = implode(',', $paths);
    $file_names = implode(',', $file_names);
    // Save to the database
    if($rows > 0) {
        DB::table('resume_result')->where('user_id', $id)->update(['updated_at' => now(), 'video_urls' => $paths, 'file_names' => $file_names,]);
    } else {
        DB::table('resume_result')->insert(['user_id' => $id, 'created_at' => now(), 'video_urls' => $paths, 'file_names' => $file_names,]);
    }
    
    return redirect()->back()->with('success', 'Movies uploaded successfully.');
}


 public function resume_generator(Request $request)
{
    $id = Auth::user()->id;
    $rows = DB::table('resume_result')->where('user_id', $id)->count();
    // Data processing and validation
    $data = $request->validate([
        'select_job' => 'required|string|max:255',
        'experience_summary' => 'required|string|max:255',
        'experience_reason' => 'required|string|max:255',
        'future_plans' => 'required|string|max:255',
        'excel_experience' => 'required|string|max:255',
        'ppt_experience' => 'required|string|max:255',
        'leadership_experience' => 'required|string|max:255',
        'skillset' => 'required|string|max:255',
        'qualifications' => 'required|string|max:255',
        'job_start_date' => 'required|array',
        'job_start_date.*' => 'date',
        'job_end_date' => 'required|array',
        'job_end_date.*' => 'date|after_or_equal:job_start_date.*',
        'job_name' => 'required|array',
        'job_name.*' => 'string|max:255',
        'team_members_count' => 'required|array',
        'team_members_count.*' => 'integer|min:1',
        'job_role' => 'required|array',
        'job_role.*' => 'string|max:255',
        'job_details' => 'required|array',
        'job_details.*' => 'string|max:1000',
    ]);

    // Prepare the details array for further processing
    $details = [
        'username' => Auth::user()->initName_f . ' ' . Auth::user()->initName_l,
        'job_title' => $data['select_job'],
        'job_education' => $data['experience_summary'],
        'experience_reason' => $data['experience_reason'],
        'future_plans' => $data['future_plans'],
        'skills_experience' => [
            'excel' => $data['excel_experience'],
            'ppt' => $data['ppt_experience'],
            'leadership' => $data['leadership_experience'],
        ],
        'skillset' => $data['skillset'],
        'qualifications' => $data['qualifications'] ?? [],
        'job_history' => [],
    ];


    // Loop through job history entries
    foreach ($data['job_start_date'] as $index => $start_date) {
        $details['job_history'][] = [
            'start_date' => $start_date,
            'end_date' => $data['job_end_date'][$index],
            'job_name' => $data['job_name'][$index],
            'team_size' => $data['team_members_count'][$index],
            'role' => $data['job_role'][$index],
            'experience_details' => $data['job_details'][$index],
        ];
    }
    // Generate resume content from OpenAI
    try {
        $resumeContent = $this->openAIService->generateResume($details);
    } catch (\Exception $e) {
        // Handle error appropriately, e.g., log it or return an error message
        return back()->withErrors(['error' => 'Failed to generate resume. Please try again later.']);
    }
    $resumeContent = json_decode($resumeContent, true);
    // Insert or update the resume result in the database

    return view('resume.update_resume', compact('resumeContent'));
}

public function update_resume(Request $request) {
    $user_id =Auth::user()->id;
    $name = Auth::user()->name;
    $job_history = json_encode($request->job_history);
    DB::table('resume_result')->updateOrInsert(
        ['user_id' => $user_id], // Assuming one record for simplicity; adjust as needed
        [
            'job_title' => $request->job_title,
            'job_summary' => $request->job_summary,
            'skills_experience' => $request->skills_experience,
            'skillset' => $request->skillset,
            'qualifications' => $request->qualifications,
            'job_history' => $job_history,
        ]
    );
    $resume = [];
    $resume = [
        'job_title' => $request->job_title,
        'job_summary' => $request->job_summary,
        'skills_experience' => $request->skills_experience,
        'skillset' => $request->skillset,
        'qualifications' => $request->qualifications,
        'job_history' => $job_history,
    ];

    $pdf = PDF::loadView('resumepdf', ['resume' => $resume]);
    session()->flash('success', 'あなたの職務経歴書がデータベースに正確に保管されました。');
    return $pdf->download($name.'_経歴書.pdf');
}

    // work question 業務適性検査を受ける

    // resume Document save

    public function add_resumedocs(Request $request) {
    // Validate the request
    $request->validate([
        'resume_file' => 'nullable|file|mimes:doc,pdf,txt,docx|max:2048',
        'cv' => 'nullable|file|mimes:doc,pdf,txt,docx|max:2048',
    ]);

    $userId = Auth::id(); // Get the authenticated user's ID

    // Handle resume file upload
    if ($request->hasFile('resume_file')) {
        $resumeFile = $request->file('resume_file');
        $resumeFileName = $resumeFile->getClientOriginalName();
        $resumeDirectory = 'resumes/' . $userId;
        $resumeFilePath = $resumeDirectory . '/' . $resumeFileName;

        // Ensure the directory exists
        if (!file_exists(public_path($resumeDirectory))) {
            mkdir(public_path($resumeDirectory), 0755, true);
        }

        // Move the file to the designated directory
        $resumeFile->move(public_path($resumeDirectory), $resumeFileName);
        $resumeFileUrl = asset($resumeFilePath);

        // Save or update the resume URL in the database
        DB::table('resume_result')->updateOrInsert(
            ['user_id' => $userId],
            ['updated_at' => now(), 'resume_url' => $resumeFileUrl]
        );
    }

    // Handle CV file upload
    if ($request->hasFile('cv')) {
        $cvFile = $request->file('cv');
        $cvFileName = time() . '_cv_' . $cvFile->getClientOriginalName();
        $cvDirectory = 'resumes/' . $userId;
        $cvFilePath = $cvDirectory . '/' . $cvFileName;

        // Ensure the directory exists
        if (!file_exists(public_path($cvDirectory))) {
            mkdir(public_path($cvDirectory), 0755, true);
        }

        // Move the file to the designated directory
        $cvFile->move(public_path($cvDirectory), $cvFileName);
        $cvFileUrl = asset($cvFilePath);

        // Save or update the CV URL in the database
        DB::table('resume_result')->updateOrInsert(
            ['user_id' => $userId],
            ['updated_at' => now(), 'cv_url' => $cvFileUrl]
        );
    }

    return redirect()->back()->with('success', 'Files uploaded successfully!');
}

public function deleteMultiple(Request $request)
{
    // Retrieve the selected video URLs with user IDs
    $selectedVideos = $request->input('selected_videos');
    $selectedVideos = json_decode($selectedVideos); // Decode JSON and convert to associative array
    $results = [];

    // Build results array where each key is user ID and value is an array of video URLs
    foreach ($selectedVideos as $video) {
        $parts = explode(':', $video);
        if (count($parts) === 2) {
            $key = (string)$parts[0]; // User ID
            $value = (string)$parts[1]; // Video URL

            // Initialize the user's list if it doesn't exist
            if (!isset($results[$key])) {
                $results[$key] = [];
            }

            // Add video URL to the user's list (avoid duplicate entries if needed)
            if (!in_array($value, $results[$key])) {
                $results[$key][] = $value;
            }
        }
    }


    // Initialize counters
    $deletedCount = 0;
    $updatedCount = 0;
    foreach ($results as $userId => $videoUrls) {
        $videoUrlsInDb = DB::table('resume_result')->where('user_id', $userId)->value('video_urls');
        $videoUrlsArray = explode(',', $videoUrlsInDb);
        
        // Remove selected videos from the list
        $updatedVideoUrlsArray = array_diff($videoUrlsArray, $videoUrls);
        $updatedVideoUrls = implode(',', $updatedVideoUrlsArray);
        // Update the database
        DB::table('resume_result')->where('user_id', $userId)->update([
            'updated_at' => now(),
            'video_urls' => $updatedVideoUrls
        ]);

        // Delete the files from the server
        foreach ($videoUrls as $videoUrl) {
            $filePath = public_path($videoUrl);

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deletedCount++;
                } else {
                    // Log failure to delete file
                    Log::error('Failed to delete file: ' . $filePath);
                }
            } else {
                // Log file not found
                Log::warning('File not found: ' . $filePath);
            }
        }
        $updatedCount++;
    }

    // Return a JSON response with the number of deleted files and updated records
    return $this->manager_movie();
}

    public function recruiment() {
        $users = DB::table("users")->whereNotIn('role', ['admin', 'company'])->get();
        
        return view('company.recruiment', compact('users'));
    }

    public function recruimenting(Request $request) {
        $user_id = $request->input('user_id');
        DB::table('users')->where('id', $user_id)->update(['recruiment_state' => 'true', 'updated_at' => date('Y-m-d h:i:s')]);
        return $this->recruiment();
    }

public function sendEmail(Request $request)
{
    // Validate the request
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'content' => 'required|string',
    ]);


    $user = User::findOrFail($request->input('user_id'));
    $content = $request->input('content');
    $email = Auth::user()->email;
    
    
    try {
        // Send the email
        Mail::to($user->email)->send(new UserEmail($content, $user, $email));
        return redirect()->back()->with('success', 'Email sent successfully!');
    } catch (\Exception $e) {
        // Log the error or display it
        \Log::error('Email sending failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to send email.');
    }
}


    public function insert_manager(Request $request) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $name = $request->input('name');
        $email = $request->input('email');
        $existingUserByName = DB::table('users')->where('name', $name)->first();

        // Check if the email already exists
        $existingUserByEmail = DB::table('users')->where('email', $email)->first();

        // If either exists, return an error response
        if ($existingUserByName) {
            return redirect()->back()->withErrors(['name' => '名前は既に存在します。'])->withInput();
        }
        if ($existingUserByEmail) {
            return redirect()->back()->withErrors(['email' => 'メールアドレスは既に存在します。'])->withInput();
        }

        $user = User::insert([
            'role' => "admin",
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomString),
            'pwd' => $request->pwd,
            'created_at' => date('Y-m-d h:i:s')
        ]);
        return $this->memberUser();
    }

    public function edit_manager(Request $request) {
        // Validate the request data
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pwd' => 'required|string|max:255',
        ]);

        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $pwd = $request->input('pwd');

        // Check if the name or email is already taken by another user
        $existingUserByName = DB::table('users')->where('name', $name)->where('id', '<>', $id)->exists();
        $existingUserByEmail = DB::table('users')->where('email', $email)->where('id', '<>', $id)->exists();

        if ($existingUserByName) {
            return redirect()->back()->withErrors(['name' => 'The name is already taken.']);
        }

        if ($existingUserByEmail) {
            return redirect()->back()->withErrors(['email' => 'The email is already taken.']);
        }

        // Generate a random password and hash it
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Update the user in the database
        DB::table('users')->where('id', $id)->update([
            'role' => "admin",
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($randomString), // Only if you want to update the password
            'pwd' => $pwd,
            'updated_at' => now() // Use Laravel's current timestamp
        ]);

        // Redirect back to the user management page with a success message
        return redirect()->route('admin.member')->with('success', 'User updated successfully.');
    }

    public function delete_manager(Request $request) {
        // Get the ID from the request
        $id = $request->input('id');
        // Check if the user exists before attempting to delete
        $user = DB::table('users')->where('id', $id)->first();

        if ($user) {
            // Delete the user from the database
            DB::table('users')->where('id', $id)->delete();
            
            // Optionally, you can return a success message or redirect
            return redirect()->route('admin.member')->with('success', 'User deleted successfully.');
        } else {
            // Return an error message if the user was not found
            return redirect()->route('admin.member')->with('error', 'User not found.');
        }
    }

    public function del_resumeAndCv(Request $request)
    {
        $level = $request->input('level');
        $id = $request->input('result_id');
        $no_resume = '';

        if ($level == 'resume') {
            // Fetch the resume URL
            $resume_url = DB::table('resume_result')->where('user_id', $id)->value('resume_url');

            if ($resume_url) {
                // Update the database and set resume_url to null
                DB::table('resume_result')->where('user_id', $id)->update(['resume_url' => null]);

                // Define the file path and delete the file if it exists
                $filePath = public_path($resume_url);  // Adjust path if necessary
                if (file_exists($filePath)) {
                    unlink($filePath);
                    $no_resume = "経歴書は削除されました。";
                }

            } else {
                $no_resume = "保存されている経歴書がありません。";
            }
        } else {
            // Fetch the CV URL
            $cv_url = DB::table('resume_result')->where('user_id', $id)->value('cv_url');

            if ($cv_url) {
                // Update the database and set cv_url to null
                DB::table('resume_result')->where('user_id', $id)->update(['cv_url' => null]);

                // Define the file path and delete the file if it exists
                $filePath = public_path($cv_url);  // Adjust path if necessary
                if (file_exists($filePath)) {
                    unlink($filePath);
                    $no_resume = "履歴書が削除されました。";
                }
            } else {
                $no_resume = "保存されている履歴書がありません。";
            }
        }

        return back()->with('resume_error', $no_resume);
    }

    public function user_checkdelete(Request $request) 

    {
         // Retrieve the list of IDs
        $items = explode(',', $request->items);

        // Use whereIn to delete all users with the provided IDs
        foreach($items as $item){

            DB::table('users')->where('id', $item)->delete();
        }

        // Return with a success message
        return back()->with('checkeduserdelete', '選択されたユーザーは正常に削除されました。');
    }

}