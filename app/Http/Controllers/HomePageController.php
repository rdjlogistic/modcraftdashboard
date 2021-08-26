<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Category;
use App\Price;
use Mail;
use Hash;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\User;

class HomePageController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function table(Request $request)
    {
        $companies = Company::filterByRequest($request)->paginate(9);

        return view('mainTable.search', compact('companies'));
    }

    public function category(Category $category)
    {
        $companies = Company::join('category_company', 'companies.id', '=', 'category_company.company_id')
            ->where('category_id', $category->id)
            ->paginate(9);

        return view('mainTable.category', compact('companies', 'category'));
    }

    public function price(Price $price)
    {
        $companies = Company::join('company_price', 'companies.id', '=', 'company_price.company_id')
            ->where('price_id', $price->id)
            ->paginate(9);

        return view('mainTable.price', compact('companies', 'price'));
    }

    public function company(Company $company)
    {
        return view('mainTable.company', compact('company'));
    }
    public function forgotPassword(Request $request)
    {
        $token = Str::random(64);

        DB::table('password_resets')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => Carbon::now()
            ]);


        Mail::send('email.reset-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email)->subject('Reset password link');
            $message->from('divyesh@logisticinfotech.co.in', 'Reset Password');
        });
        return back()->with('message', 'We have e-mailed your password reset link!');

        //echo "Basic Email Sent. Check your inbox.";
    }
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
        $updatePassword = DB::table('password_resets')
                              ->where('email', '=', $request->email)
                              ->where('token', '=', $request->token)
                              ->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}
