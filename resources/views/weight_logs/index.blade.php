<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy - 体重管理</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f3f4f6;
            color: #374151;
        }

        /* ヘッダー */
        .header {
            background-color: #ffffff;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-size: 28px;
            color: #f472b6;
            font-family: 'Georgia', serif;
        }

        .header-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-header {
            background-color: #e5e7eb;
            color: #374151;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .container {
            max-width: 1000px;
            margin: 32px auto;
            padding: 0 16px;
        }

        /* 上部カード（目標体重・目標まで・最新体重） */
        .target-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 24px 40px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .target-item,
        .target-diff-box {
            text-align: left;
        }

        .target-label,
        .target-diff-box .label {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .target-val,
        .target-diff-box .value {
            font-size: 32px;
            font-weight: bold;
            color: #1f2937;
        }

        .target-unit,
        .target-diff-box {
            font-size: 16px;
            font-weight: normal;
            color: #4b5563;
        }

        .target-diff-box .value {
            color: #1f2937;
        }

        /* 検索・一覧エリア */
        .main-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 12px;
        }

        .search-inputs {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .input-date {
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .btn-search {
            background-color: #e5e7eb;
            color: #374151;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-add {
            background: linear-gradient(90deg, #a78bfa 0%, #f472b6 100%);
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(244, 114, 182, 0.3);
        }

        /* テーブル */
        .weight-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .weight-table th {
            padding: 12px 16px;
            font-size: 14px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .weight-table td {
            padding: 16px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }

        .btn-edit {
            color: #a78bfa;
            text-decoration: none;
            font-size: 18px;
        }

        /* モーダル背景 */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        /* モーダルカード */
        .modal-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 32px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-title {
            font-size: 22px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 24px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
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

        .badge-required {
            background-color: #f87171;
            color: #ffffff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
        }

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
        }

        .form-control:focus {
            border-color: #f472b6;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .unit {
            font-size: 14px;
            color: #4b5563;
            white-space: nowrap;
        }

        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 32px;
        }

        .btn-modal {
            width: 140px;
            padding: 10px 0;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            background-color: #e5e7eb;
            color: #4b5563;
        }

        .btn-submit {
            background: linear-gradient(90deg, #a78bfa 0%, #f472b6 100%);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(244, 114, 182, 0.25);
        }

        /* ページネーション */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
            list-style: none;
            padding: 0;
        }

        .pagination a,
        .pagination span {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 28px;
            height: 28px;
            border-radius: 4px;
            font-size: 14px;
            color: #6b7280;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .pagination a:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .pagination .active span,
        .pagination .active a {
            background-color: #c084fc;
            color: #ffffff;
            font-weight: bold;
        }

        .pagination .disabled {
            color: #d1d5db;
            cursor: default;
        }
    </style>
</head>

<body>
    <!-- ヘッダー -->
    <header class="header">
        <div class="logo">PiGLy</div>
        <div class="header-buttons">
            <a href="{{ route('weight_logs.goal_setting') }}" class="btn-header">⚙ 目標体重設定</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-header">🚪 ログアウト</button>
            </form>
        </div>
    </header>

    <div class="container">
        <!-- 上部カード（目標体重・目標まで・最新体重） -->
        <div class="target-card">
            <div class="target-item">
                <span class="target-label">目標体重</span>
                <div class="target-val">
                    {{ isset($targetWeight) ? number_format($targetWeight, 1) : '-' }} <span class="target-unit">kg</span>
                </div>
            </div>

            <div style="border-right: 1px solid #e5e7eb; height: 40px;"></div>

            <!-- 目標まで -->
            <div class="target-diff-box">
                <span class="label">目標まで</span>
                <span class="value">{{ $targetDiff }}</span> kg
            </div>

            <div style="border-right: 1px solid #e5e7eb; height: 40px;"></div>

            <div class="target-item">
                <span class="target-label">最新体重</span>
                <div class="target-val">
                    {{ isset($latestWeight) ? number_format($latestWeight, 1) : '-' }} <span class="target-unit">kg</span>
                </div>
            </div>
        </div>

        <!-- 検索バー ＆ 一覧テーブル -->
        <div class="main-card">
            <div class="search-bar">
                <form action="{{ route('weight_logs.index') }}" method="GET" class="search-inputs">
                    <input type="date" name="start_date" class="input-date" value="{{ request('start_date') }}">
                    <span>〜</span>
                    <input type="date" name="end_date" class="input-date" value="{{ request('end_date') }}">
                    <button type="submit" class="btn-search">検索</button>
                </form>
                <button type="button" class="btn-add" onclick="openModal()">データ追加</button>
            </div>

            <!-- 体重ログテーブル -->
            <table class="weight-table">
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>体重</th>
                        <th>食事カロリー</th>
                        <th>運動時間</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($weightLogs ?? [] as $log)
                    <tr>
                        <td>{{ $log->date }}</td>
                        <td>{{ $log->weight }}kg</td>
                        <td>{{ $log->calories }}cal</td>
                        <td>{{ $log->exercise_time }}</td>
                        <td><a href="{{ route('weight_logs.show', $log->id) }}" class="btn-edit">✏️</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td>2023/11/19</td>
                        <td>46.5kg</td>
                        <td>1200cal</td>
                        <td>00:15</td>
                        <td><a href="#" class="btn-edit">✏️</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- ページネーション（Laravelの動的リンク使用時） -->
            @if(isset($weightLogs) && method_exists($weightLogs, 'links'))
            <div class="pagination-container">
                {{ $weightLogs->links('pagination::bootstrap-4') }}
            </div>
            @else
            <!-- ページネーション (デザイン固定表示) -->
            <ul class="pagination">
                <li class="disabled"><span>&lt;</span></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&gt;</a></li>
            </ul>
            @endif
        </div>
    </div>

    <!-- モーダル本体 -->
    <div id="weightModal" class="modal-overlay">
        <div class="modal-card">
            <h2 class="modal-title">Weight Logを追加</h2>

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
                    @if ($errors->has('weight'))
                    <p class="error-text">体重を入力してください</p>
                    <p class="error-text">4桁までの数字で入力してください</p>
                    <p class="error-text">小数点は1桁で入力してください</p>
                    @endif
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
                    @if ($errors->has('calories'))
                    <p class="error-text">摂取カロリーを入力してください</p>
                    <p class="error-text">数字で入力してください</p>
                    @endif
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
                        <textarea id="exercise_content" name="exercise_content" class="form-control" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                    </div>
                    @error('exercise_content')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ボタンエリア -->
                <div class="button-group">
                    <button type="button" class="btn-modal btn-back" onclick="closeModal()">戻る</button>
                    <button type="submit" class="btn-modal btn-submit">登録</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('weightModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('weightModal').style.display = 'none';
        }

        <?php if (isset($errors) && $errors->any()): ?>
            openModal();
        <?php endif; ?>
    </script>
</body>

</html>