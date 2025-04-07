<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $user = auth()->user();

        if($user) return view('pages.admin');

        return view('pages.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $v = validator($request->all(), [
            "email" => "required|email|max:255",
            "password" => "required|string|max:255"
        ]);

        if ($v->fails()) return back()->withInput()->withErrors($v->errors());

        if(!auth()->attempt($v->validated()))
        {
            return back()->withErrors(['error' => "Не верная почта или пароль"]);
        }

        $user = auth()->user();
        if($user->role !== 'ADMIN')
        {
            auth()->logout();
            return back()->withErrors(['error' => "Вы не админ"]);
        }

        return back();
    }

    public function logout()
    {
        auth()->logout();

        return back();
    }
}
