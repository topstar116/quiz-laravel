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
        $rows = DB::table('quiz_result')->where(['user_id' => $id, 'quiz3' => null])->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id, 'quiz3' => null])->orderBy('id', 'desc')->take(1)->update(['quiz3' => $quiz_result]);
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

    public function viewQuiz1_s(Request $request)
    {


        $quizs = DB::table('sales_quiz_table')->where('項目', 'PJ適性')->get();
        $項目 = 'PJ適性';

        return view('quiz.quiz1_s', compact('quizs', '項目'));
    }


    public function viewQuiz2_s(Request $request)
    {

        $quizs = DB::table('sales_quiz_table')->where('項目', 'コミュニケーション')->get();
        $項目 = 'コミュニケーション';

        return view('quiz.quiz2_s', compact('quizs', '項目'));
    }

    public function viewQuiz3_s(Request $request)
    {

        $quizs = DB::table('sales_quiz_table')->where('項目', 'リーダー適性')->get();
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
                $url = 'https://engineer-match-recommend-result.com/web/';

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

		//9,"人と相談しながら問題解決することが好きだ"で分岐
                else if (str_contains($str, '職種適正-9-1')) {
                    $sub_type = 5;
                    $sub_title = 'WEB開発エンジニア';
                }

		//9,"黙々と指示された作業をすることが好きだ"で分岐
                else if (str_contains($str, '職種適正-9-2')) {
                    $sub_type = 6;
                    $sub_title = 'テスター';
                }

                //except
                if (str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                    $url = 'https://engineer-match-recommend-result.com/sales/';
                }
            }

            //右はSier、左はWEBに分岐
            if (str_contains($str, '職種適正-1-2')) {
                $type = 'Sier';
                $url = 'https://engineer-match-recommend-result.com/sier/';
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
		
		//9,"人と相談しながら問題解決することが好きだ"で分岐
                else if (str_contains($str, '職種適正-9-1')) {
                    $sub_type = 2;
                    $sub_title = '技術リーダー';
                }
		
		//9,"黙々と指示された作業をすることが好きだ"で分岐
                else if (str_contains($str, '職種適正-9-2')) {
                    $sub_type = 3;
                    $sub_title = 'メンバーエンジニア';
                }

                //except
                if (str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                    $url = 'https://engineer-match-recommend-result.com/sales/';
                }
            }



            //右はSES、左は事業会社に分岐
            if (str_contains($str, '企業適正-1-1')) {
                $type = '事業会社';
                $url = 'https://engineer-match-recommend-result.com/ic/';

                //№1が左の場合、左は1で右は2
                if (str_contains($str, '企業適正-4-1')) {
                    $sub_type = 1;
                    $sub_title = 'システム企業';
                } else if (str_contains($str, '企業適正-4-2')) {
                    $sub_type = 2;
                    $sub_title = 'WEB企業';
                }
            }

            //右はSES、左は事業会社に分岐
            if (str_contains($str, '企業適正-1-2')) {
                $type = 'SES';
                $url = 'https://engineer-match-recommend-result.com/ses/';
		
		//3、社長が近い距離の会社で働きたい0分岐
                if (str_contains($str, '企業適正-3-1')) {
                    $sub_type = 4;
                    $sub_title = '小規模SES';
                } 

		//5、自社の先輩達に囲まれて教育されたい1分岐
                else if (str_contains($str, '企業適正-5-2')) {
                    $sub_type = 3;
                    $sub_title = '中堅以上SES';
                } 		

                //№1が右の場合、左は3で右は4
                else if (str_contains($str, '企業適正-7-1')) {
                    $sub_type = 3;
                    $sub_title = '中堅以上SES';
                } 
		else if (str_contains($str, '企業適正-7-2')) {
                    $sub_type = 4;
                    $sub_title = '小規模SES';
                }
            }



            //全部左あれば1、一つでも右あれば次ページに遷移
            if (str_contains($str, '現状確認-1-1-1') && str_contains($str, '現状確認-1-2-1') && str_contains($str, '現状確認-1-3-1')) {

                $type = '';
                $sub_type = 1;
                $sub_title = 'PMO';
                $url = 'https://engineer-match-recommend-result.com/cs/';
            }

            //全部左あれば2、一つでも右あれば次ページに遷移
            else if (str_contains($str, '現状確認-2-1-1') && str_contains($str, '現状確認-2-2-1') && str_contains($str, '現状確認-2-3-1')) {

                $type = '';
                $sub_type = 2;
                $sub_title = '開発・テスト';
                $url = 'https://engineer-match-recommend-result.com/cs/';
            }

            //全部左あれば3、一つでも右あれば4
            else if (str_contains($str, '現状確認-3-1-1') && str_contains($str, '現状確認-3-2-1') && str_contains($str, '現状確認-3-3-1')) {

                $type = '';
                $sub_type = 3;
                $sub_title = 'インフラ';
                $url = 'https://engineer-match-recommend-result.com/cs/';
            } else if (str_contains($str, '現状確認')) {

                $type = '';
                $sub_type = 4;
                $sub_title = 'IT研修受講';
                $url = 'https://engineer-match-recommend-result.com/cs/';
            }
        } elseif ($level == "sales") {


            if (str_contains($str, 'PJ適性-1-1')) $count++;
            if (str_contains($str, 'PJ適性-2-1')) $count++;
            if (str_contains($str, 'PJ適性-3-1')) $count++;
            if (str_contains($str, 'PJ適性-4-1')) $count++;
            if (str_contains($str, 'PJ適性-5-1')) $count++;
            if (str_contains($str, 'PJ適性-6-1')) $count++;
            if (str_contains($str, 'PJ適性-7-1')) $count++;
            if (str_contains($str, 'PJ適性-8-1')) $count++;
            if (str_contains($str, 'PJ適性-9-1')) $count++;
            if (str_contains($str, 'PJ適性-10-1')) $count++;

            if (str_contains($str, 'コミュニケーション-1-1')) $count++;
            if (str_contains($str, 'コミュニケーション-2-1')) $count++;
            if (str_contains($str, 'コミュニケーション-3-1')) $count++;
            if (str_contains($str, 'コミュニケーション-4-1')) $count++;
            if (str_contains($str, 'コミュニケーション-5-1')) $count++;
            if (str_contains($str, 'コミュニケーション-6-1')) $count++;
            if (str_contains($str, 'コミュニケーション-7-1')) $count++;
            if (str_contains($str, 'コミュニケーション-8-1')) $count++;
            if (str_contains($str, 'コミュニケーション-9-1')) $count++;
            if (str_contains($str, 'コミュニケーション-10-1')) $count++;

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
                $sub_title = 'どんな現場でも活躍してもらえそうです！';
            } elseif ($count >= 4 and $count < 8) {
                $sub_type = 'B';
                $sub_title = '現場によって合う合わないが分かれそうです！';
            } else {
                $sub_type = 'C';
                $sub_title = '現場によっては少し不安な面があります！';
            }
        } else {

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
                $sub_title = '順調です！引き続き活躍していきしょう！';
            } else if ($count == 3 || $count == 4) {

                $sub_type = '〇';
                $sub_title = '少し気になることがあれば営業担当に相談しましょう！';
            } else {

                $sub_type = '△';
                $sub_title = '営業担当にいち早く電話して相談しましょう！';
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

        DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result, 'type' => 'recruiment']);

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'recruiment');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

        $next = 2;

        return view('quiz.result', compact('result', 'next'));
    }

    public function viewResult2(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where(['user_id' => $id, 'quiz2' => null])->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id, 'quiz2' => null])->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result, 'type' => 'recruiment']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'recruiment');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

        $next = 3;

        return view('quiz.result', compact('result', 'next'));
    }


    public function viewResult1_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result, 'type' => 'sales']);

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'sales');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

        $next = 2;

        return view('quiz.result_s', compact('result', 'next'));
    }

    public function viewResult2_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where(['user_id' => $id, 'quiz2' => null])->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id, 'quiz2' => null])->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result, 'type' => 'sales']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'sales');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

        $next = 3;

        return view('quiz.result_s', compact('result', 'next'));
    }

    public function viewResult3_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where(['user_id' => $id, 'quiz3' => null])->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id, 'quiz3' => null])->orderBy('id', 'desc')->take(1)->update(['quiz3' => $quiz_result]);
        } else {
            DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz3' => $quiz_result, 'type' => 'sales']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'sales');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no3' => $result['sub_type'], 'res3' => $result['sub_title']]);

        $next = 1;

        return view('quiz.result_s', compact('result', 'next'));
    }



    public function viewResult1_m(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result, 'type' => 'management']);

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

        $next = 2;

        return view('quiz.result_m', compact('result', 'next'));
    }

    public function viewResult2_m(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        $rows = DB::table('quiz_result')->where(['user_id' => $id, 'quiz2' => null])->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id, 'quiz2' => null])->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result, 'type' => 'management']);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

        $next = 3;

        return view('quiz.result_m', compact('result', 'next'));
    }
    public function viewResult3_m(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);

        $rows = DB::table('quiz_result')->where(['user_id' => $id, 'quiz3' => null])->count();
        if ($rows > 0) {
            DB::table('quiz_result')->where(['user_id' => $id, 'quiz3' => null])->orderBy('id', 'desc')->take(1)->update(['quiz3' => $quiz_result]);
        } else {
            DB::table('quiz_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz3' => $quiz_result, 'type' => 'management']);
        }
        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('quiz_result')->where(array('user_id' => $id))->update(['no3' => $result['sub_type'], 'res3' => $result['sub_title']]);

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




    //admin quiz
    public function recruimentQuiz()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $quizs = DB::table('recruiment_quiz_table') -> orderBy('項目', 'desc') -> get();
        $page = "recruimentQuiz";
        return view('quiz.admin.recruiment_quiz', compact('quizs', 'page'));
    }

    public function salesQuiz()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $quizs = DB::table('sales_quiz_table') -> orderBy('項目', 'desc') -> get();
        $page = "salesQuiz";
        return view('quiz.admin.sales_quiz', compact('quizs', 'page'));
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
        // dd($resumingquizs);
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

            $res = DB::table('sales_quiz_table')->insert($data);
            return $this->salesQuiz();
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

            $res = DB::table('sales_quiz_table')->where('id', $request->input('id'))->update($data);
            return $this->salesQuiz();
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
            $res = DB::table('sales_quiz_table')->where('id', $id)->delete();
            return $this->salesQuiz();
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
        if (Auth::user()->status == '0')
            return view('pending');

        $results = DB::table('quiz_result')->where('type', 'recruiment')
            ->join('users', 'quiz_result.user_id', '=', 'users.id')
            ->select('quiz_result.*', 'users.name')
            ->get();

        $page = "recruimentResult";

        return view('quiz.admin.recruiment_result', compact('results', 'page'));
    }

    public function salesResult()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $results = DB::table('quiz_result')->where('type', 'sales')
            ->join('users', 'quiz_result.user_id', '=', 'users.id')
            ->select('quiz_result.*', 'users.initName_f', 'users.initName_l')
            ->get();

        $page = "salesResult";
        return view('quiz.admin.sales_result', compact('results', 'page'));
    }

    public function managementResult()
    {
        if (Auth::user()->status == '0')
            return view('pending');

        $results = DB::table('quiz_result')->where('type', 'management')
            ->join('users', 'quiz_result.user_id', '=', 'users.id')
            ->select('quiz_result.*', 'users.name')
            ->get();

        $page = "managementResult";
        return view('quiz.admin.management_result', compact('results', 'page'));
    }
    public function resumingResult()
    {
        $results = DB::table('resume_result')
            ->join('users', 'resume_result.user_id', '=', 'users.id')
            ->select('resume_result.*', 'users.initName_f', 'users.initName_l', 'users.role')
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

        Quiz1::getQuery()->delete();
        Quiz2::getQuery()->delete();
        Quiz3::getQuery()->delete();
        Man1::getQuery()->delete();


        $type = $request->type;

        // dd($type);

        $items = explode(',', $request->items);

        foreach ($items as $item) {


            $user = DB::table('users')->where('id', $item)->first();

            if ($type == 'recruiment_user') {
                DB::table('man1s')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd
                ));
            }else if ($type == 'sales_user') {
                DB::table('man1s')->insert(array(
                    '会社名' => $user->company,
                    'イニシャル名字' => $user->initName_f,
                    'イニシャル名前' => $user->initName_l,            
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd
                ));
            }else if ($type == 'management_user') {
                DB::table('man1s')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd
                ));
            }else if ($type == 'member_user') {
                DB::table('man1s')->insert(array(
                    '名前' => $user->name,
                    'メールアドレス' => $user->email,
                    'パスワード' => $user->pwd,
                    'ステータス' => $user->status == 0 ? '申請中' : 'システム管理者'
                ));
            } else {
                
                $res = DB::table('quiz_result')->where('id', $item)->first();
                $user = DB::table('users')->where('id', $res->user_id)->first();

                $quizs = DB::table($type . '_quiz_table')->get();
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
                            '氏名' => $user->initName_f . ' ' . $user->initName_l,
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
                            '氏名' => $user->initName_f . ' ' . $user->initName_l,
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
                            '氏名' => $user->initName_f . ' ' . $user->initName_l,
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
        if ($type == 'recruiment_user') return Excel::download(new RecruimentExport, 'ユーザー管理(採用).xlsx');
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

        if ($request->input('level') == "recruiment") {
            return $this->recruimentUser();
        } else if ($request->input('level') == "sales") {

            return $this->salesUser();
        } else {

            return $this->managementUser();
        }
    }

    public function delResult(Request $request)
    {
        $result_id = $request->result_id;
        DB::table('quiz_result')->where('id', $result_id)->delete();

        if ($request->input('level') == "recruiment") {
            return $this->recruimentResult();
        } else if ($request->input('level') == "sales") {

            return $this->salesResult();
        } else {

            return $this->managementResult();
        }
    }

        public function resume_question()
    {
        $resumes = DB::table('resume_question')->get();

        return view('resume.resume_question', compact('resumes'));
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
        return view('resume.create_resume', compact('result_datas'));
    }

    public function resume_generator(Request $request) {

        // Handle video file if uploaded
        $id = Auth::user()->id;
        $rows = DB::table('resume_result')->where('user_id', $id)->count();
        $paths = array();
        
        $directory = 'videos/' . Auth::id();
        $files = glob($directory . '/*');  // Get all files in the directory

        // Loop through the files and delete each one
        
        $deleted_directorys = Storage::disk('public')->files($directory);

        foreach($deleted_directorys as $deleted_file){
            Storage::disk('public')->delete($deleted_file);
        }

        // $existingFiles = Storage::disk('public')->files($directory);
        // dd($existingFiles);

        // if (count($existingFiles) >= 5) {
        //     return back()->with('error', '');
        // }
        // foreach ($existingFiles as $file) {
        //     File::delete($file);
        // }

        $request->validate([
            'video' => 'file|mimes:mp4,avi,mkv,mov,ogg|max:2000000',
        ]);

        // dd($existingFiles);

        if ($request->hasFile('videos')) {
            $files = $request->file('videos');
            foreach ($files as $file) {

                // $path = Storage::putFile($directory, $file);

                // Create the full path where the file will be stored
                $filePath = $directory . '/' . $file->getClientOriginalName();
                
                // Move the file to the public directory
                $file->move(public_path($directory), $file->getClientOriginalName());
                array_push($paths, $filePath);
                $filePath = array();
            }
        }
        $paths = implode(',', $paths);

        //data process
       $data = $request->validate([
            'select_job' => 'required|string|max:255',
            'experience' => 'required|string|max:1000',
            'available_skill' => 'required|string|max:1000',
            'resume' => 'required|string|max:1000',
        ]);

        // Prepare the details for OpenAI
        $details = [
            'job_title' => $data['select_job'],
            'job_summary' => $data['experience'],
            'skills_experience' => $data['available_skill'],
            'job_history' => $data['resume'],
        ];

        // Generate resume content from OpenAI
        $resumeContent = $this->openAIService->generateResume($details);
        if ($rows > 0) {
            DB::table('resume_result')->where('user_id', $id)->update(['updated_at' => date('Y-m-d h:i:s'), 'video_urls' => $paths, 'building_code' => $resumeContent ]);
        } else {
            DB::table('resume_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'video_urls' => $paths, 'building_code' => $resumeContent]);
        }
        

        // Return the result to the view
        return view('result.resume_result', [
            'resumeContent' => $resumeContent,
        ]);
    }
}