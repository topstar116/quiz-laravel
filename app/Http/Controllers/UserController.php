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

use Carbon\Carbon;




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
                $sub_title = '就業前にご自身の仕事ぶりを相談しましょう！';
            } else if ($count == 3 || $count == 4) {
                $sub_type = '〇';
                $sub_title = '少し気になることがあれば就業前に相談しましょう！';
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
        $rows = DB::table('work_result')->where(['user_id' => $id])->count();
        if($rows > 0) {
            DB::table('work_result')->update(['updated_at' => date('Y-m-d h:i:s'), 'quiz1' => $quiz_result]);
        }else{
            DB::table('work_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result]);
        }
        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, "work");

        DB::table('work_result')->where(array('user_id' => $id))->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

        $next = 2;

        return view('quiz.result_s', compact('result', 'next'));
    }

    public function viewResult2_s(Request $request)
    {
        $id = Auth::user()->id;
        $quiz_result = $request->all();
        unset($quiz_result['_token']);
        $quiz_result = implode(",", $quiz_result);
        $rows = DB::table('work_result')->where(['user_id' => $id])->count();

        if ($rows > 0) {
            DB::table('work_result')->where(['user_id' => $id])->orderBy('id', 'desc')->take(1)->update(['quiz2' => $quiz_result]);
        } else {
            DB::table('work_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz2' => $quiz_result]);
        }

        // DB::table('users')->where('user_id', auth()->user()->id)->update(['status' => 1]);

        $result = $this->checkResult($quiz_result, "work");

        DB::table('work_result')->where(array('user_id' => $id))->update(['no2' => $result['sub_type'], 'res2' => $result['sub_title']]);

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
        $rows = DB::table('work_second_result')->where(['user_id' => $id])->count();

        if($rows > 0) {
            DB::table('work_second_result')->update(['updated_at' => date('Y-m-d h:i:s'), 'quiz1' => $quiz_result]);
        }
        else{
            DB::table('work_second_result')->insert(['created_at' => date('Y-m-d h:i:s'), 'user_id' => $id, 'quiz1' => $quiz_result]);
        }

        $result = $this->checkResult($quiz_result, 'management');

        DB::table('work_second_result')->where(array('user_id' => $id))->update(['no1' => $result['sub_type'], 'res1' => $result['sub_title']]);

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
        $email_data = DB::table('email')->get();
        $email_data = $email_data[0];
        if($user == "admin"){
            return view('manager.email', compact('email_data','page'));
        }
    }

    public function save_email(Request $request) {
        $identifynumber = $request->emailnumber;
        if($identifynumber == "one"){
            $content = DB::table('email')->select('contentOne')->first();
            if($content) {
                DB::table('email')->update(['updated_at' => date('Y-m-d h:i:s'), 'contentOne' => $request->input('contentOne')]);
            }else{
                DB::table('email')->insert(['created_at' => date('Y-m-d h:i:s'), 'contentOne' => $request->input('contentOne')]);
            }
        }
        if($identifynumber == "two"){
            $content = DB::table('email')->select('contentTwo')->first();
            if($content) {
                DB::table('email')->update(['updated_at' => date('Y-m-d h:i:s'), 'contentTwo' => $request->input('contentTwo')]);
            }else{
                DB::table('email')->insert(['created_at' => date('Y-m-d h:i:s'), 'contentTwo' => $request->input('contentTwo')]);
            }
        }
        return $this->email();
    }

    public function manager_movie() {
        $page = "movie";
        
        $results = DB::table('resume_result')
            ->join('users', 'resume_result.user_id', '=', 'users.id')
            ->select('resume_result.video_urls', 'resume_result.docs_url', 'users.initName_f', 'users.initName_l')
            ->get();
        
        // Transform the video URLs and include docs_url in the data structure
        $results->transform(function ($item) {
            $item->video_urls = $item->video_urls ? explode(',', $item->video_urls) : [];
            return $item;
        });

        // Create an associative array with combined first and last names as keys
        $videoUrls = $results->mapWithKeys(function ($item) {
            $key = $item->initName_f . $item->initName_l; // Combine first and last names
            $value = [
                'videos' => $item->video_urls,  // Get the video URLs
                'docs_url' => $item->docs_url   // Get the docs URL
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

            $res = DB::table('work_question')->insert($data);
            return $this->workQuiz();
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

            $res = DB::table('work_question')->insert($data);
            return $this->workQuiz();
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

            $res = DB::table('work_question')->where('id', $request->input('id'))->update($data);
            return $this->workQuiz();
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

            $res = DB::table('work_question')->where('id', $request->input('id'))->update($data);
            return $this->workQuiz();
        }
    }


    public function delQuiz(Request $request)
    {
        if ($request->input('level') == "recruiment") {

            $id = $request->id;
            $res = DB::table('work_question')->where('id', $id)->delete();
            return $this->workQuiz();
        } else if ($request->input('level') == "sales") {

            $id = $request->id;
            $res = DB::table('work_question')->where('id', $id)->delete();
            return $this->workQuiz();
        } else {
            $id = $request->id;
            $res = DB::table('work_question')->where('id', $id)->delete();
            return $this->workQuiz();
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

    public function workResult()
    {
        $id = Auth::user()->id;
        if (Auth::user()->status == '0')
            return view('pending');

        $results = DB::table('work_result')
            ->join('users', 'work_result.user_id', '=', 'users.id')
            ->select('work_result.*', 'users.initName_f', 'users.initName_l')
            ->get();

        $page = "workResult";
        return view('work.work_result', compact('results', 'page'));
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

    public function work_pdf(Request $request) {
        $data = $request->all();

        $quizs = DB::table('resume_result')->get();
        $quiz_array = explode(',', $quizs->resume_content);
        dd($quiz_array);
        foreach ($quizs as $quiz) {
            $temp = [];
            $quiz_key = $quiz->job;
            $temp[$quiz_key . '-1'] = explode(',', $quiz->回答項目)[0];
            $temp[$quiz_key . '-2'] = explode(',', $quiz->回答項目)[1];
            $quiz_array = array_merge($quiz_array, $temp);
        }

        // dd($quiz_array);

        $content = [
            'name' => $data['name'],
            'quiz_array' => $quiz_array,
            'created_at' => $data['created_at'],
        ];

        $pdf = PDF::loadView('work_pdf', $content);

        $pdf_str = $type == $data->user . '_業務適性回答データ.pdf';

        return $pdf->download($data['name'] . $pdf_str);
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
        'skills' => 'nullable|array',
        'skills.*' => 'string|max:255',
        'qualifications' => 'nullable|array',
        'qualifications.*' => 'string|max:255',
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
        'job_summary' => $data['experience_summary'],
        'experience_reason' => $data['experience_reason'],
        'future_plans' => $data['future_plans'],
        'skills_experience' => [
            'excel' => $data['excel_experience'],
            'ppt' => $data['ppt_experience'],
            'leadership' => $data['leadership_experience'],
        ],
        'skills' => $data['skills'] ?? [],
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

    // Insert or update the resume result in the database
    $timestamp = Carbon::now();
    if ($rows > 0) {
        DB::table('resume_result')->where('user_id', $id)->update([
            'updated_at' => $timestamp,
            'building_code' => $resumeContent,
        ]);
    } else {
        DB::table('resume_result')->insert([
            'created_at' => $timestamp,
            'user_id' => $id,
            'building_code' => $resumeContent,
        ]);
    }
    // Return the result to the view
    return view('result.resume_result', [
        'resumeContent' => $resumeContent,
    ]);
}

    // work question 業務適性検査を受ける

    // resume Document save

    public function add_resumedocs(Request $request) {
        // Validate the request
        

        // Check if a file was uploaded
        if ($request->hasFile('resume_file')) {
            $file = $request->file('resume_file');
            $userId = Auth::id(); // Get the authenticated user's ID

            // Create a unique name for the file
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Define the path to store the file in a user-specific directory
            $directory = 'resumes/' . $userId;
            $filePath = $directory . '/' . $fileName;

            // Ensure the directory exists
            if (!file_exists(public_path($directory))) {
                mkdir(public_path($directory), 0755, true);
            }

            // Move the file to the designated directory
            $file->move(public_path($directory), $fileName);

            // Create the URL for the uploaded file
            $fileUrl = asset($filePath);

            // Example of saving file URL to the database
            // Check if a record for the user already exists
            $recordExists = DB::table('resume_result')->where('user_id', $userId)->exists();

            if ($recordExists) {
                DB::table('resume_result')->where('user_id', $userId)->update([
                    'updated_at' => now(),
                    'docs_url' => $fileUrl,
                ]);
            } else {
                DB::table('resume_result')->insert([
                    'user_id' => $userId,
                    'created_at' => now(),
                    'docs_url' => $fileUrl,
                ]);
            }

            return redirect()->back()->with('success', 'File uploaded successfully!');
        }
        

        return redirect()->back()->with('error', 'File upload failed.');
    }

    
}