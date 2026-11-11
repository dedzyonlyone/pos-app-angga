<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') — {{ \App\Models\Setting::get('store_name', 'POS App') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --pos-primary: #0f4c5c;
            --pos-primary-light: #e8f1f3;
            --pos-primary-dark: #0b3a47;
            --bs-primary: var(--pos-primary);
            --bs-primary-rgb: 15, 76, 92;
        }
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #0f4c5c 0%, #0b3a47 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            padding: 2rem;
        }
        .auth-brand {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .auth-brand i {
            font-size: 2.2rem;
            color: var(--pos-primary);
            background: var(--pos-primary-light);
            padding: 0.5rem 0.8rem;
            border-radius: 0.8rem;
        }
        .auth-brand h1 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0.75rem 0 0.15rem;
            color: #212529;
        }
        .auth-brand p {
            font-size: 0.85rem;
            color: #6c757d;
            margin: 0;
        }
        .btn-primary {
            --bs-btn-bg: var(--pos-primary);
            --bs-btn-border-color: var(--pos-primary);
            --bs-btn-hover-bg: var(--pos-primary-dark);
            --bs-btn-hover-border-color: var(--pos-primary-dark);
            padding: 0.6rem;
            font-weight: 600;
        }
        .form-control { padding: 0.6rem 0.75rem; border-radius: 0.5rem; }
        .demo-hint {
            font-size: 0.75rem;
            color: #6c757d;
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            margin-top: 1rem;
            text-align: center;
        }
        .invalid-feedback { font-size: 0.8rem; }
    </style>
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>