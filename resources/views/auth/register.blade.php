<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy - 新規会員登録</title>
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

        .logo-title {
            font-size: 42px;
            color: #f472b6;
            margin-bottom: 8px;
            font-family: 'Georgia', serif;
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 20px;
            color: #4b5563;
            margin-bottom: 12px;
            font-weight: normal;
            letter-spacing: 2px;
        }

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

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            color: #374151;
            outline: none;
            background-color: #ffffff;
        }

        .form-group input::placeholder {
            color: #d1d5db;
        }

        .form-group input:focus {
            border-color: #f472b6;
        }

        .error-text {
            color: #e11d48;
            font-size: 12px;
            margin-top: 6px;
            font-family: sans-serif;
            line-height: 1.4;
        }

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

        .footer-link {
            margin-top: 24px;
            font-size: 13px;
            font-family: sans-serif;
        }

        .footer-link a {
            color: #60a5fa;
            text-decoration: underline;
        }

        .footer-link a:hover {
            color: #3b82f6;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <div class="logo-title">PiGLy</div>
        <div class="subtitle">新規会員登録</div>
        <div class="step-indicator">STEP1 アカウント情報の登録</div>

        <form action="{{ route('register.step1') }}" method="POST">
            @csrf

            <!-- お名前 -->
            <div class="form-group">
                <label for="name" class="form-label">お名前</label>
                <div class="input-wrapper">
                    <input type="text" id="name" name="name" class="form-control" placeholder="名前を入力" value="{{ old('name') }}">
                </div>
                @if ($errors->has('name'))
                <p class="error-text">お名前を入力してください</p>
                <p class="error-text">お名前は文字列で入力してください</p>
                @endif
            </div>

            <!-- メールアドレス -->
            <div class="form-group">
                <label for="email" class="form-label">メールアドレス</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-control" placeholder="メールアドレスを入力" value="{{ old('email') }}">
                </div>
                @if ($errors->has('email'))
                <p class="error-text">メールアドレスを入力してください</p>
                <p class="error-text">メールアドレスは「ユーザー名＠ドメイン」形式で入力してください</p>
                @endif
            </div>

            <!-- パスワード -->
            <div class="form-group">
                <label for="password" class="form-label">パスワード</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="パスワードを入力">
                </div>
                @if ($errors->has('password'))
                <p class="error-text">パスワードを入力してください</p>
                @endif
            </div>

            <button type="submit" class="btn-submit">次に進む</button>
        </form>

        <div class="footer-link">
            <a href="/login">ログインはこちら</a>
        </div>
    </div>
</body>

</html>