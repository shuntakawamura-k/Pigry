<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    // 体重ログ一覧・トップ画面（検索機能付き）
    public function index(Request $request)
    {
        $query = WeightLog::where('user_id', Auth::id());

        // 開始日の絞り込み
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        // 終了日の絞り込み
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // 検索条件を保持したままページネーション
        $weightLogs = $query->orderBy('date', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // 目標体重の取得
        $targetWeight = WeightTarget::where('user_id', Auth::id())->value('target_weight') ?? 0;

        // 最新の体重ログを取得（一番新しい日付のデータ）
        $latestLog = WeightLog::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->first();

        $latestWeight = $latestLog ? $latestLog->weight : 0;

        // 差分計算（目標体重 - 最新体重）
        // 例: 80kg - 100kg = -20.0kg（あと20kg減量が必要）
        $diff = $targetWeight - $latestWeight;

        if ($diff > 0) {
            $targetDiff = '+' . number_format($diff, 1);
        } else {
            $targetDiff = number_format($diff, 1);
        }

        return view('weight_logs.index', compact('weightLogs', 'targetWeight', 'latestWeight', 'targetDiff'));
    }

    // ログ追加画面表示
    public function create()
    {
        return view('weight_logs.create');
    }

    // ログ追加の保存処理
    public function store(Request $request)
    {
        // バリデーション実行（ルールと日本語メッセージを指定）
        $request->validate($this->rules(), $this->messages());

        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('weight_logs.index');
    }

    // ログ詳細画面表示
    public function show($id)
    {
        $weightLog = WeightLog::where('user_id', Auth::id())->findOrFail($id);
        return view('weight_logs.show', compact('weightLog'));
    }

    // ログ更新処理
    public function update(Request $request, $id)
    {
        $weightLog = WeightLog::where('user_id', Auth::id())->findOrFail($id);

        // バリデーション実行（ルールと日本語メッセージを指定）
        $request->validate($this->rules(), $this->messages());

        $weightLog->update($request->only([
            'date',
            'weight',
            'calories',
            'exercise_time',
            'exercise_content'
        ]));

        return redirect()->route('weight_logs.index');
    }

    // ログ削除処理
    public function destroy($id)
    {
        $weightLog = WeightLog::where('user_id', Auth::id())->findOrFail($id);
        $weightLog->delete();

        return redirect()->route('weight_logs.index');
    }

    // 目標体重設定画面表示
    public function showGoalSetting()
    {
        $target = WeightTarget::where('user_id', Auth::id())->first();
        return view('weight_logs.goal_setting', compact('target'));
    }

    // 目標体重の更新処理
    public function updateGoalSetting(Request $request)
    {
        $request->validate([
            'target_weight' => 'required|numeric|between:0,999.9',
        ]);

        WeightTarget::updateOrCreate(
            ['user_id' => Auth::id()],
            ['target_weight' => $request->target_weight]
        );

        return redirect()->route('weight_logs.index');
    }

    // バリデーションルール定義
    private function rules()
    {
        return [
            'date' => ['required', 'date'],
            'weight' => [
                'required',
                'numeric',
                'max:9999.9', // 4桁までの数字（10000未満）のチェック
                'regex:/^\d{1,4}(\.\d{1})?$/' // 整数部4桁以内・小数点以下1桁のチェック
            ],
            'calories' => ['required', 'integer'],
            'exercise_time' => ['required'],
            'exercise_content' => ['nullable', 'max:120'],
        ];
    }

    // バリデーションエラーメッセージ定義
    private function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '4桁までの数字で入力してください',
            'weight.max' => '4桁までの数字で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}
