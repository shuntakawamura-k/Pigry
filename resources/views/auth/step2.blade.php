<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy - 新規会員登録 STEP2</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, "Hiragino Mincho ProN", "Yu Mincho", serif;
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 35%, #f472b6 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* ロゴ部分 (PiGLy) */
        .logo-title {
            font-size: 42px;
            color: #f472b6;
            margin-bottom: 8px;
            font-family: 'Georgia', serif;
            letter-spacing: 1px;
        }

        /* サブタイトル (新規会員登録) */
        .subtitle {
            font-size: 20px;
            color: #4b5563;
            margin-bottom: 12px;
            font-weight: normal;
            letter-spacing: 2px;
        }

        /* STEP表示 */
        .step-indicator {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 32px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            color: #374151;
            outline: none;
            background-color: #ffffff;
        }

        .input-group input::placeholder {
            color: #d1d5db;
        }

        .input-group input:focus {
            border-color: #f472b6;
        }

        .unit {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
        }

        /* 入力欄下の赤文字エラーメッセージ */
        .error-text {
            color: #e11d48;
            font-size: 12px;
            margin-top: 4px;
            font-family: sans-serif;
            line-height: 1.4;
        }

        /* 「アカウント作成」ボタン */
        .btn-submit {
            width: 180px;
            background: linear-gradient(90deg, #a78bfa 0%, #f472b6 100%);
            color: #ffffff;
            border: none;
            padding: 12px 0;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin: 24px auto 0 auto;
            display: block;
            box-shadow: 0 4px 10px rgba(244, 114, 182, 0.3);
            font-family: sans-serif;
        }

        .btn-submit:hover {
            opacity: 0.95;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <div class="logo-title">PiGLy</div>
        <div class="subtitle">新規会員登録</div>
        <div class="step-indicator">STEP2 体重データの入力</div>

        <form action="/register/step2" method="POST" novalidate>
            @csrf

            <!-- 現在の体重 -->
            <div class="form-group">
                <label for="current_weight">現在の体重</label>
                <div class="input-group">
                    <input type="number" step="0.1" id="current_weight" name="current_weight" value="{{ old('current_weight') }}" placeholder="現在の体重を入力">
                    <span class="unit">kg</span>
                </div>
                @error('current_weight')
                <p class="error-text">現在の体重を入力してください</p>
                <p class="error-text">4桁までの数字で入力してください</p>
                <p class="error-text">小数点は1桁で入力してください</p>
                @enderror
            </div>

            <!-- 目標の体重 -->
            <div class="form-group">
                <label for="target_weight">目標の体重</label>
                <div class="input-group">
                    <input type="number" step="0.1" id="target_weight" name="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
                    <span class="unit">kg</span>
                </div>
                @error('target_weight')
                <p class="error-text">目標の体重を入力してください</p>
                <p class="error-text">4桁までの数字で入力してください</p>
                <p class="error-text">小数点は1桁で入力してください</p>
                @enderror
            </div>

            <button type="submit" class="btn-submit">アカウント作成</button>
        </form>
    </div>
</body>

</html>