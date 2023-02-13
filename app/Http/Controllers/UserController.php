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
            $quizs = DB::table('recruiment_quiz_table')->where('項目','職種適正')->get();        
            $項目 = '職種適正';    
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目','PJ適性')->get();
            $項目 = 'PJ適性';    
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目','仕事内容')->get();
            $項目 = '仕事内容';    
        }
        return view('quiz.quiz', compact('quizs','項目'));
  }

    public function viewQuiz2()
    {   
        $項目 = '';
        if (auth()->user()->role == "recruiment") {
            $quizs = DB::table('recruiment_quiz_table')->where('項目','企業適正')->get();
            $項目 = '企業適正';    
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目','コミュニケーション')->get();
            $項目 = 'コミュニケーション';    
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目','人間関係')->get();
            $項目 = '人間関係';    
        }
        return view('quiz.quiz2', compact('quizs','項目'));
    }

    public function viewQuiz3()
    {
        if (auth()->user()->role == "recruiment") {
            $quizs = DB::table('recruiment_quiz_table')->where('項目','現状確認')->get();
            $項目 = '現状確認';    
        } else if (auth()->user()->role == "sales") {
            $quizs = DB::table('sales_quiz_table')->where('項目','リーダー適性')->get();
            $項目 = 'リーダー適性';    
        } else {
            $quizs = DB::table('management_quiz_table')->where('項目','業務負担')->get();
            $項目 = '業務負担';    
        }
        return view('quiz.quiz3', compact('quizs','項目'));
    }

    public function viewExpress()
    {
        return view('quiz.express');
    }

    public function viewResult()
    {   
        DB::table('users')->where('id', auth()->user()->id)->update(['status'=> 1]);
        return view('quiz.result');
    }

    ////////////////////////////////////////////////////////////////
















    ////////////////////////// admin ///////////////////////////////
    public function recruimentUser()
    {
        $users = User::paginate();

        return view('quiz.admin.recruiment_user', compact('users'));
    }

    public function salesUser()
    {
        $users = User::paginate();

        return view('quiz.admin.sales_user', compact('users'));
    }

    public function managementUser()
    {
        $users = User::paginate();

        return view('quiz.admin.management_user', compact('users'));
    }

    public function recruimentQuiz()
    {
        $quizs = DB::table('recruiment_quiz_table')->get();

        return view('quiz.admin.recruiment_quiz', compact('quizs'));
    }

    public function salesQuiz()
    {
        $quizs = DB::table('sales_quiz_table')->get();

        return view('quiz.admin.sales_quiz', compact('quizs'));
    }

    public function managementQuiz()
    {
        $quizs = DB::table('management_quiz_table')->get();
        $users = User::paginate();

        return view('quiz.admin.management_quiz', compact('quizs'));
    }


    /////////////////////////////////////////////////////

    public function addRecruimentQuiz(Request $request)
    {
        if ($request->level == "recruiment") {
            $data = array(
                '項目' => $request->input('項目'),
                '提案NO' => $request->input('no'),
                '回答項目' => $request->input('回答項目1') . "," . $request->input('回答項目2')
            );

            $res = DB::table('recruiment_quiz_table')->insert($data);
            return $this->recruimentQuiz();
        } else if ($request->level == "sales") {
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


    public function delRecruimentQuiz(Request $request)
    {
        if ($request->level == "recruiment") {
            
            $quiz_id = $request->quiz_id;
            $res = DB::table('recruiment_quiz_table')->where('id', $quiz_id)->delete();
            return $this->recruimentQuiz();

        }else if ($request->level == "sales") {
            
            $quiz_id = $request->quiz_id;
            $res = DB::table('sales_quiz_table')->where('id', $quiz_id)->delete();
            return $this->salesQuiz();
            
        }else {
            $quiz_id = $request->quiz_id;
            $res = DB::table('management_quiz_table')->where('id', $quiz_id)->delete();
            return $this->managementQuiz();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////






































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

        $users = User::paginate();
        return view('users.index', compact('users'));
    }
}
