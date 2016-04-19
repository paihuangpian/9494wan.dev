<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Admin;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/admin';
    protected $redirectAfterLogout = '/admin';
    protected $guard = 'admin';
    protected $loginView = 'admin.login';
    protected $registerView = 'admin.register';

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|confirmed|min:6',
        ]);

    }

    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

    }

    protected function validateLogin(Request $request)
    {   
        $info = [
            'email.required' => '邮箱必须填写',
            'password.required' => '密码必须填写'
        ];
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ], $info);
    }
}
