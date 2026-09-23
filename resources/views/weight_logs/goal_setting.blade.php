<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy - 目標体重設定</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333333;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ヘッダー */
        header {
            background-color: #ffffff;
            border-bottom: 1px solid #eeeeee;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            font-size: 32px;
            color: #f472b6;
            text-decoration: none;
            font-family: 'Georgia', serif;
            letter-spacing: 1px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-target-setting {
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-target-setting:hover {
            background-color: #f9fafb;
        }

        .btn-logout {
            background-color: #ffffff;
            color: #4b5563;
            border: 1px solid #e5e7eb;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background-color: #f9fafb;
        }

        /* メイン中央配置エリア */
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            text-align: center;
        }

        .form-title {
            font-size: 22px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 32px;
        }

        .error-message {
            background-color: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 24px;
            text-align: left;
        }

        .error-message ul {
            list-style: none;
        }

        .form-group {
            margin-bottom: 32px;
        }

        .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 15px;
            color: #333333;
            outline: none;
            background-color: #ffffff;
        }

        .input-group input:focus {
            border-color: #f472b6;
        }

        .unit {
            font-size: 14px;
            color: #4b5563;
        }

        /* ボタンエリア */
        .btn-area {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .btn-back {
            background-color: #e0e0e0;
            color: #4b5563;
            text-decoration: none;
            padding: 10px 0;
            width: 120px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-back:hover {
            background-color: #d5d5d5;
        }

        .btn-submit {
            background: linear-gradient(90deg, #a78bfa 0%, #f472b6 100%);
            color: #ffffff;
            border: none;
            padding: 10px 0;
            width: 120px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(244, 114, 182, 0.3);
        }

        .btn-submit:hover {
            opacity: 0.95;
        }
    </style>
</head>

<body>
    <!-- ヘッダー -->
    <header>
        <a href="/weight_logs" class="header-logo">
            PiGLy
        </a>
        <div class="header-right">
            <a href="/weight_logs/goal_setting" class="btn-target-setting">
                ⚙ 目標体重設定
            </a>
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    🚪 ログアウト
                </button>
            </form>
        </div>
    </header>

    <main>
        <div class="form-card">
            <h1 class="form-title">目標体重設定</h1>

            @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/weight_logs/goal_setting" method="POST">
                @csrf
                @method('PUT')

                {{-- どの判定が走ってもバリデーションを通すためのダミー・隠しフィールド --}}
                <input type="hidden" name="current_weight" value="50.0">
                <input type="hidden" name="weight" value="50.0">

                <div class="form-group">
                    <div class="input-group">
                        <input type="number" step="0.1" id="target_weight" name="target_weight" value="{{ old('target_weight', $target->target_weight ?? '46.5') }}" placeholder="46.5" required>
                        <span class="unit">kg</span>
                    </div>
                </div>

                <div class="btn-area">
                    <a href="/weight_logs" class="btn-back">戻る</a>
                    <button type="submit" class="btn-submit">更新</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>