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


class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }








    ////////////////////// QUIZ ///////////////////////////////////

    public function viewQuiz()
    {
        if (auth()->user()->role == "recruiment") {
            $quizs = DB::table('recruiment_quiz_table')->where('項目', '職種適正')->get();
            $項目 = '職種適正';
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目', 'PJ適性')->get();
            $項目 = 'PJ適性';
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目', '仕事内容')->get();
            $項目 = '仕事内容';
        }
        return view('quiz.quiz', compact('quizs', '項目'));
    }

    public function viewQuiz1(Request $request)
    {
        if (auth()->user()->role == "recruiment") {
            $quizs = DB::table('recruiment_quiz_table')->where('項目', '職種適正')->get();
            $項目 = '職種適正';
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目', 'PJ適性')->get();
            $項目 = 'PJ適性';
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目', '仕事内容')->get();
            $項目 = '仕事内容';
        }
        return view('quiz.quiz1', compact('quizs', '項目'));
    }

    public function viewQuiz2(Request $request)
    {
        // $id = Auth::user()->id;
        // $quiz_result = $request->all();
        // unset($quiz_result['_token']);
        // $quiz_result = implode(",", $quiz_result);
        // $rows = DB::table('quiz_result')->where('user_id', $id)->count();

        // if ($rows < 1) {
        //     DB::table('quiz_result')->insert(['user_id' => $id, 'quiz' => $quiz_result]);
        // }

        $項目 = '';
        if (auth()->user()->role == "recruiment") {
            $quizs = DB::table('recruiment_quiz_table')->where('項目', '企業適正')->get();
            $項目 = '企業適正';
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目', 'コミュニケーション')->get();
            $項目 = 'コミュニケーション';
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目', '人間関係')->get();
            $項目 = '人間関係';
        }
        return view('quiz.quiz2', compact('quizs', '項目'));
    }

    public function viewQuiz3(Request $request)
    {
        // $id = Auth::user()->id;
        // $quiz_result = $request->all();
        // unset($quiz_result['_token']);
        // $quiz_result = implode(",", $quiz_result);
        // DB::table('quiz_result')->where('user_id', $id)->update(['quiz2' => $quiz_result]);



        if (auth()->user()->role == "recruiment") {
            $quizs = DB::table('recruiment_quiz_table')->where('項目', '現状確認')->get();
            $項目 = '現状確認';
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目', 'リーダー適性')->get();
            $項目 = 'リーダー適性';
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目', '業務負担')->get();
            $項目 = '業務負担';
        }
        return view('quiz.quiz3', compact('quizs', '項目'));
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
        $rows = DB::table('quiz_result')->where(array('user_id'=> $id))->count();

        if ($rows < 1) {
            DB::table('quiz_result')->insert(['user_id' => $id, 'quiz3' => $quiz_result]);
        }else{
            DB::table('quiz_result')->where(array('user_id'=> $id))->update(['quiz3' => $quiz_result]);
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
        $rows = DB::table('quiz_result')->where(array('user_id'=> $id))->count();
        $sql = 'CONCAT(quiz3,", '.$quiz_result.'")';
        DB::table('quiz_result')->where(array('user_id'=> $id))->update(['quiz3' => DB::raw($sql)]);

        
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
        $rows = DB::table('quiz_result')->where(array('user_id'=> $id))->count();
        $sql = 'CONCAT(quiz3,", '.$quiz_result.'")';
        DB::table('quiz_result')->where(array('user_id'=> $id))->update(['quiz3' => DB::raw($sql)]);

        $quiz_result = DB::table('quiz_result')->where('user_id', $id)->get('quiz3');

        $quiz_result = $quiz_result[0]->quiz3;

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result);

        return view('quiz.result3', compact('result'));
    }




















    public function viewExpress(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        DB::table('quiz_result')->where('user_id', $id)->update(['quiz3' => $quiz_result]);

        return view('quiz.express');

    }


    public function viewResult(Request $request)
    {
        // $id = Auth::user()->id;
        // $quiz_result = $request->all();
        // unset($quiz_result['_token']);
        // $quiz_result = implode(",", $quiz_result);
        // DB::table('quiz_result')->where('user_id', $id)->update(['quiz3' => $quiz_result]);



        DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);
        return view('quiz.result');
    }














    public function checkResult($str){

        $type = '';
        $sub_type = '';
        $sub_title = '';
        $url = '';

        if (auth()->user()->role == "recruiment") {
         
            //右はSier、左はWEBに分岐
            if(str_contains($str, '職種適正-1-1')) {
                $type = 'WEB'; 
                $url = 'https://result.engineermatch.net/web/';

                //№1が左の場合、右であれば6
                if(str_contains($str, '職種適正-6-2')) {
                    $sub_type = 6;
                    $sub_title = 'テスター';
                }

                //左であればその他7
                else if(str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                }

                //№1が左の場合、左であれば4
                else if(str_contains($str, '職種適正-8-1')) {
                    $sub_type = 4;
                    $sub_title = '開発ディレクター';
                }

                //№1が左の場合、右であれば5
                else if(str_contains($str, '職種適正-8-2')) {
                    $sub_type = 5;
                    $sub_title = 'WEB開発エンジニア';
                }

                //except
                if(str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                    $url = 'https://result.engineermatch.net/sales/';
                }

            }
            
            //右はSier、左はWEBに分岐
            if(str_contains($str, '職種適正-1-2')) {
                $type = 'Sier'; 
                $url = 'https://result.engineermatch.net/sier/';
                //№1が右の場合、右であれば3
                if(str_contains($str, '職種適正-6-2')) {
                    $sub_type = 3;
                    $sub_title = 'メンバーエンジニア';
                }

                //左であればその他7
                else if(str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                }

                //№1が右の場合、左であれば1
                else if(str_contains($str, '職種適正-8-1')) {
                    $sub_type = 1;
                    $sub_title = 'ITコンサルタント';
                }

                //№1が右の場合、右であれば2
                else if(str_contains($str, '職種適正-8-2')) {
                    $sub_type = 2;
                    $sub_title = '技術リーダー';
                }

                //except
                if(str_contains($str, '職種適正-7-1')) {
                    $type = 'その他';
                    $sub_type = 7;
                    $sub_title = '営業';
                    $url = 'https://result.engineermatch.net/sales/';
                }

            }













            //右はSES、左は事業会社に分岐
            if(str_contains($str, '企業適正-1-1')){
                $type = '事業会社';
                $url = 'https://result.engineermatch.net/mc/';

                //№1が左の場合、左は1で右は2
                if(str_contains($str, '企業適正-4-1')){
                    $sub_type = 1;    
                    $sub_title = 'WEB企業';
                }

                else if(str_contains($str, '企業適正-4-2')){
                    $sub_type = 2;    
                    $sub_title = 'SaaS';
                }

            }

            //右はSES、左は事業会社に分岐
            if(str_contains($str, '企業適正-1-2')){
                $type = 'SES';
                $url = 'https://result.engineermatch.net/ses/';

                //№1が右の場合、左は3で右は4
                if(str_contains($str, '企業適正-7-1')){
                    $sub_type = 3;    
                    $sub_title = '中堅以上SES';
                }

                else if(str_contains($str, '企業適正-7-2')){
                    $sub_type = 4;    
                    $sub_title = '小規模SES';
                }
                
            }








            //全部左あれば1、一つでも右あれば次ページに遷移
            if(str_contains($str, '現状確認-1-1-1') && str_contains($str, '現状確認-1-2-1') && str_contains($str, '現状確認-1-3-1')){

                $type = '';
                $sub_type = 1;               
                $sub_title = 'PMO';
                $url = 'https://result.engineermatch.net/status/';
                
            }

            //全部左あれば2、一つでも右あれば次ページに遷移
            else if(str_contains($str, '現状確認-2-1-1') && str_contains($str, '現状確認-2-2-1') && str_contains($str, '現状確認-2-3-1')){
                
                $type = '';
                $sub_type = 2;
                $sub_title = '開発・テスト';
                $url = 'https://result.engineermatch.net/status/';
            }

            //全部左あれば3、一つでも右あれば4
            else if(str_contains($str, '現状確認-3-1-1') && str_contains($str, '現状確認-3-2-1') && str_contains($str, '現状確認-3-3-1')){
                
                $type = '';
                $sub_type = 3;
                $sub_title = 'インフラ';
                $url = 'https://result.engineermatch.net/status/';

            }else if(str_contains($str, '現状確認')){
                
                $type = '';
                $sub_type = 4;
                $sub_title = 'IT研修受講';
                $url = 'https://result.engineermatch.net/status/';
            }

            




        } else if (auth()->user()->role == "sales") {
         
        } else {
         
        }


        return array(
            'type' => $type,
            'sub_type' => $sub_type,
            'sub_title' => $sub_title,
            'url' => $url,
        );

    }





















    public function viewResult1(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where('user_id', $id)->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where('user_id', $id)->update(['quiz1' => $quiz_result]);
        }else{
            DB::table('quiz_result')->insert(['user_id' => $id, 'quiz1' => $quiz_result]);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);
        
        $result = $this->checkResult($quiz_result);
        return view('quiz.result', compact('result'));

    }

    public function viewResult2(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where('user_id', $id)->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where('user_id', $id)->update(['quiz2' => $quiz_result]);
        }else{
            DB::table('quiz_result')->insert(['user_id' => $id, 'quiz2' => $quiz_result]);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result);

        return view('quiz.result', compact('result'));
    }

    public function viewResult3(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('quiz_result')->where('user_id', $id)->count();

        if ($rows > 0) {
            DB::table('quiz_result')->where('user_id', $id)->update(['quiz3' => $quiz_result]);
        }else{
            DB::table('quiz_result')->insert(['user_id' => $id, 'quiz3' => $quiz_result]);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result);

        return view('quiz.result', compact('result'));
    }

    ////////////////////////////////////////////////////////////////
















    ////////////////////////// admin ///////////////////////////////
    public function recruimentUser()
    {
        $users = User::paginate();
        $page = "recruimentUser";
        return view('quiz.admin.recruiment_user', compact('users', 'page'));
    }

    public function salesUser()
    {
        $users = User::paginate();
        $page = "salesUser";
        return view('quiz.admin.sales_user', compact('users', 'page'));
    }

    public function managementUser()
    {
        $users = User::paginate();
        $page = "managementUser";
        return view('quiz.admin.management_user', compact('users', 'page'));
    }

    public function recruimentQuiz()
    {
        $quizs = DB::table('recruiment_quiz_table')->get();
        $page = "recruimentQuiz";
        return view('quiz.admin.recruiment_quiz', compact('quizs', 'page'));
    }

    public function salesQuiz()
    {
        $quizs = DB::table('sales_quiz_table')->get();
        $page = "salesQuiz";
        return view('quiz.admin.sales_quiz', compact('quizs', 'page'));
    }

    public function managementQuiz()
    {
        $quizs = DB::table('management_quiz_table')->get();
        $users = User::paginate();
        $page = "managementQuiz";
        return view('quiz.admin.management_quiz', compact('quizs', 'page'));
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



}
