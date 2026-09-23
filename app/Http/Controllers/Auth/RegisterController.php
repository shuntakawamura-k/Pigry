<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Step 1: 会員登録画面表示
    public function showStep1()
    {
        return view('auth.register');
    }

    // Step 1: ユーザー情報の入力値をセッションに保存
    public function postStep1(Request $request)
    {
        // バリデーション実行
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ], [
            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前は文字列で入力してください',
            'name.max' => 'お名前は255文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名＠ドメイン」形式で入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',
            'password.required' => 'パスワードを入力してください',
        ]);

        // 入力値をセッションに保持してSTEP2画面へリダイレクト
        $request->session()->put('register_data', $request->only('name', 'email', 'password'));

        return redirect()->route('register.step2');
    }

    // Step 2 画面の表示メソッド
    public function showStep2(Request $request)
    {
        // Step 1のセッション情報がない場合は Step 1 へ押し戻す
        if (!$request->session()->has('register_data')) {
            return redirect()->route('register.step1');
        }

        return view('auth.step2');
    }

    // Step 2: ユーザー作成 ＆ 初期体重 ＆ 目標体重の保存処理
    public function postStep2(Request $request)
    {
        // セッションから Step 1 のデータの取得確認
        $registerData = $request->session()->get('register_data');
        if (!$registerData) {
            return redirect()->route('register.step1');
        }

        // バリデーション
        $request->validate([
            'current_weight' => 'required|numeric',
            'target_weight' => 'required|numeric',
        ]);

        // 1. ユーザーの新規作成
        $user = User::create([
            'name' => $registerData['name'],
            'email' => $registerData['email'],
            'password' => Hash::make($registerData['password']),
        ]);

        // 2. 現在の体重を「初日の体重ログ」として保存
        WeightLog::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'weight' => $request->current_weight,
            'calories' => 0,
            'exercise_time' => '00:00:00',
            'exercise_content' => '',
        ]);

        // 3. 目標体重の保存
        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $request->target_weight,
        ]);

        // 4. セッションの登録データをクリア
        $request->session()->forget('register_data');

        // 5. 新規作成したユーザーでログイン状態にする
        Auth::login($user);

        // 管理画面へリダイレクト
        return redirect()->route('weight_logs.index');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
