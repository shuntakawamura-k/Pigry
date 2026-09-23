<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Logを追加</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 32px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .modal-title {
            font-size: 22px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .label-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        /* 必須バッジ */
        .badge-required {
            background-color: #f87171;
            color: #ffffff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* 入力欄と単位のラップ */
        .input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            outline: none;
            background-color: #ffffff;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #f472b6;
        }

        .form-control::placeholder {
            color: #d1d5db;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .unit {
            font-size: 14px;
            color: #4b5563;
            white-space: nowrap;
        }

        /* エラーテキスト */
        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        /* ボタンエリア */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 32px;
        }

        .btn {
            width: 140px;
            padding: 10px 0;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            display: inline-block;
            transition: opacity 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* 戻るボタン */
        .btn-back {
            background-color: #e5e7eb;
            color: #4b5563;
        }

        /* 登録ボタン */
        .btn-submit {
            background: linear-gradient(90deg, #a78bfa 0%, #f472b6 100%);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(244, 114, 182, 0.25);
        }
    </style>
</head>

<body>
    <div class="modal-card">
        <h1 class="modal-title">Weight Logを追加</h1>

        <form action="{{ route('weight_logs.store') }}" method="POST" novalidate>
            @csrf

            <!-- 日付 -->
            <div class="form-group">
                <div class="label-container">
                    <label for="date" class="form-label">日付</label>
                    <span class="badge-required">必須</span>
                </div>
                <div class="input-wrapper">
                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                </div>
                @error('date')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <!-- 体重 -->
            <div class="form-group">
                <div class="label-container">
                    <label for="weight" class="form-label">体重</label>
                    <span class="badge-required">必須</span>
                </div>
                <div class="input-wrapper">
                    <input type="number" step="0.1" id="weight" name="weight" class="form-control" placeholder="50.0" value="{{ old('weight') }}">
                    <span class="unit">kg</span>
                </div>
                @error('weight')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <!-- 摂取カロリー -->
            <div class="form-group">
                <div class="label-container">
                    <label for="calories" class="form-label">摂取カロリー</label>
                    <span class="badge-required">必須</span>
                </div>
                <div class="input-wrapper">
                    <input type="number" id="calories" name="calories" class="form-control" placeholder="1200" value="{{ old('calories') }}">
                    <span class="unit">cal</span>
                </div>
                @error('calories')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <!-- 運動時間 -->
            <div class="form-group">
                <div class="label-container">
                    <label for="exercise_time" class="form-label">運動時間</label>
                    <span class="badge-required">必須</span>
                </div>
                <div class="input-wrapper">
                    <input type="time" id="exercise_time" name="exercise_time" class="form-control" value="{{ old('exercise_time', '00:00') }}">
                </div>
                @error('exercise_time')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <!-- 運動内容 -->
            <div class="form-group">
                <div class="label-container">
                    <label for="exercise_content" class="form-label">運動内容</label>
                </div>
                <div class="input-wrapper">
                    <textarea id="exercise_content" name="exercise_content" class="form-control" placeholder="運動内容を入力">{{ old('exercise_content') }}</textarea>
                </div>
                @error('exercise_content')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <!-- ボタンエリア -->
            <div class="button-group">
                <a href="{{ route('weight_logs.index') }}" class="btn btn-back">戻る</a>
                <button type="submit" class="btn btn-submit">登録</button>
            </div>
        </form>
    </div>
</body>

</html>