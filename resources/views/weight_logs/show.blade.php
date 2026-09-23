<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Log詳細</title>
    <style>
        /* 全体・背景 */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif;
            color: #333333;
        }

        /* ヘッダーエリア */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 40px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-logo {
            font-size: 28px;
            font-weight: bold;
            color: #d8b4fe;
            text-decoration: none;
            font-family: serif;
        }

        .header-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-header {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            color: #374151;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
        }

        /* メインコンテンツ（中央寄せ） */
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        /* カードデザイン */
        .card {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 28px;
            color: #1f2937;
        }

        /* フォーム要素 */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            color: #4b5563;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            color: #374151;
            box-sizing: border-box;
            outline: none;
        }

        .form-control:focus {
            border-color: #c084fc;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .unit {
            position: absolute;
            right: 12px;
            color: #6b7280;
            font-size: 13px;
        }

        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        /* ボタンエリア */
        .button-area {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 32px;
            position: relative;
        }

        /* 戻るボタン */
        .btn-back {
            display: inline-block;
            width: 120px;
            padding: 10px 0;
            background-color: #e5e7eb;
            color: #4b5563;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        /* 更新ボタン */
        .btn-update {
            width: 140px;
            padding: 10px 0;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #a78bfa, #f472b6);
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        /* ゴミ箱ボタン */
        .btn-delete {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: 0;
        }
    </style>
</head>

<body>

    <!-- ヘッダーエリア -->
    <header class="header">
        <a href="/weight_logs" class="header-logo">PiGLy</a>
        <div class="header-buttons">
            <a href="{{ route('weight_logs.goal_setting') }}" class="btn-header">
                ⚙️ 目標体重設定
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-header">
                    🚪 ログアウト
                </button>
            </form>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="main-container">
        <div class="card">
            <h1 class="card-title">Weight Log</h1>

            {{-- 更新用フォーム --}}
            <form action="/weight_logs/{{ $weightLog->id }}" method="POST">
                @csrf
                @method('PUT')

                <!-- 日付 -->
                <div class="form-group">
                    <label for="date" class="form-label">日付</label>
                    <div class="input-wrapper">
                        <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $weightLog->date) }}">
                    </div>
                    @error('date')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 体重 -->
                <div class="form-group">
                    <label for="weight" class="form-label">体重</label>
                    <div class="input-wrapper">
                        <input type="number" step="0.1" id="weight" name="weight" class="form-control" value="{{ old('weight', $weightLog->weight) }}">
                        <span class="unit">kg</span>
                    </div>
                    @error('weight')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 摂取カロリー -->
                <div class="form-group">
                    <label for="calories" class="form-label">摂取カロリー</label>
                    <div class="input-wrapper">
                        <input type="number" id="calories" name="calories" class="form-control" value="{{ old('calories', $weightLog->calories) }}">
                        <span class="unit">cal</span>
                    </div>
                    @error('calories')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 運動時間 -->
                <div class="form-group">
                    <label for="exercise_time" class="form-label">運動時間</label>
                    <div class="input-wrapper">
                        <input type="time" id="exercise_time" name="exercise_time" class="form-control" value="{{ old('exercise_time', $weightLog->exercise_time) }}">
                    </div>
                    @error('exercise_time')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 運動内容 -->
                <div class="form-group">
                    <label for="exercise_content" class="form-label">運動内容</label>
                    <div class="input-wrapper">
                        <textarea id="exercise_content" name="exercise_content" class="form-control" placeholder="運動内容を追加">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
                    </div>
                    @error('exercise_content')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ボタンエリア -->
                <div class="button-area">
                    <a href="/weight_logs" class="btn-back">戻る</a>
                    <button type="submit" class="btn-update">更新</button>
                    <button type="button" class="btn-delete" onclick="if(confirm('本当に削除しますか？')) { document.getElementById('delete-form').submit(); }">
                        <!-- 赤いゴミ箱アイコン -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#f43f5e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- 削除用フォーム（非表示） --}}
            <form id="delete-form" action="/weight_logs/{{ $weightLog->id }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </main>
</body>

</html>