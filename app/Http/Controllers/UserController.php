<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //регистрация
    public function registration(Request $request) {
        $valid = Validator::make($request->all(), [
            'fio' => ['required', 'regex:/[А-Яа-яЁё]/u'],
            'email' => ['email:rfc, dnc', 'required', 'unique:users'],
            'phone' => ['digits: 11', 'required', 'unique:users'],
            'password' => ['required', 'confirmed', 'regex:/[0-9A-Za-z]/u', 'min: 3', 'max: 20'],
            'birthday'=>['date', 'nullable'],
            'rule' => ['required'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $user = new User();
        $user->fio = $request->fio;
        if($request->birthday) {
            $user->birthday = $request->birthday;
        }
        $user->email = $request->email;
        $user->password = md5($request->password);
        $user->phone = $request->phone;
        $user->save();
        return response()->json('Вы успешно зарегистрированы', 200);
    }

    //авторизация
    public function auth(Request $request) {
        $valid = Validator::make($request->all(), [
            'email' => ['email:rfc, dnc', 'required'],
            'password' => ['required'],
        ]);
        if($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $user = User::query()->where('email', $request->email)
                ->where('password', md5($request->password))->first();
        if ($user) {
            Auth::login($user);
            return response()->json('Вход в аккаунт выполнен успешно', 200);    
        } else {
            return response()->json('Неверный логин или пароль', 401);
        }
    }

    //выход
    public function exit() {
        Auth::logout();
        return redirect()->route('welcome');
    }

    //получить информацию о пользователе для профиля
    public function getUserInf() {
        $user = Auth::user();
        return response()->json($user);
    }

    //редактировать информацию о пользователе
    public function editUserInf(Request $request) {
        $valid = Validator::make($request->all(), [
            'fio' => ['required', 'regex:/[А-Яа-яЁё]/u'],
            'email' => ['email:rfc, dnc', 'required', Rule::unique('users')->ignore(auth()->id())],
            'phone' => ['digits: 11', 'required', Rule::unique('users')->ignore(auth()->id())],
            'password' => ['confirmed', 'regex:/[0-9A-Za-z]/u', 'min: 3', 'max: 20', 'nullable'],
            'birthday'=>['date', 'nullable'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $user = User::query()->where('id', $request->id)->first();
        $user->fio = $request->fio;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->password) {
            $user->password = md5($request->password);
        }
        $user->birthday = $request->birthday;
        $user->update();
        return response()->json('Изменения сохранены');
    }

    // удалить свой аккаунт
    public function delete_my_accaunt() {
        $user = User::query()->where('id', Auth::id())->first();
        $user->delete();
        return redirect()->route('welcome');
    }
}
