<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        return redirect('/user/'.$user->unique_link);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'phonenumber' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'phonenumber' => $data['phonenumber'],
            'unique_link' => Str::random(32),
            'link_expires_at' => Carbon::now()->addDays(7),
        ]);
    }
}
