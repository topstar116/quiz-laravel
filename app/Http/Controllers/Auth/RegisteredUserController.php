<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    public function sales_register()
    {
        return view('auth.sales');
    }

    public function management_register()
    {
        return view('auth.management');
    }

    public function member_register()
    {
        return view('auth.member');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if ($request->role == 'recruiment') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'pwd' => $request->password,
            ]);





        }else if ($request->role == 'member') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                // 'role' => $request->role,
                'role' => "pending",
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'pwd' => $request->password,
            ]);





        }else if($request->role == 'sales'){

            

            $request->validate([
                'company' => ['required', 'string', 'max:255'],
                'initName_f' => ['required', 'string', 'max:255'],
                'initName_l' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([

                'role' => $request->role,
                'company' => $request->company,
                'initName_f' => $request->initName_f,
                'initName_l' => $request->initName_l,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'pwd' => $request->password,

            ]);






        }else{

            $request->validate([
                'company' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([

                'role' => $request->role,
                'company' => $request->company,
                'pos' => $request->pos,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'fav_task' => $request->fav_task,
                'hop_content' => $request->hop_content,
                'knw_case' => $request->knw_case,
                'others' => $request->others,
                'password' => Hash::make($request->password),
                'pwd' => $request->password,
                
            ]);

        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
