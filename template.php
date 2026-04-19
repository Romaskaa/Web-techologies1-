<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageName ?></title>
    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #eef2ff 0%, #f4f6fb 100%);
            color: #1f2937;
        }

        .card {
            max-width: 640px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.23);
        }

        h1 {
            margin: 0 0 12px;
            font-size: 24px;
        }

        .time {
            color: #2563eb;
            font-weight: 600;
        }
        
    </style>
</head>
<body>
    <main class="card">
        <h1>Добро пожаловать, <?= $username ?>!</h1>
        <p>
            Сейчас <?= $year ?> год, <span class="time"><?= $currentTime ?></span>.
        </p>
    </main>
</body>
</html>