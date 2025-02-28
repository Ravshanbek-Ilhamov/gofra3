<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('Login.login');
    }
    public function check(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return view('Layout.main');
        } else {
            return redirect()->back();
        }
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Foydalanuvchini tizimdan chiqarish

        $request->session()->invalidate(); // Sessiyani bekor qilish
        $request->session()->regenerateToken(); // CSRF tokenni yangilash

        return redirect()->route('login'); // Login sahifasiga yo‘naltirish
    }
}
