<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UKMC Smart Todo')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        :root {
            --brand-1: #1d4ed8;
            --brand-2: #6d28d9;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(37,99,235,.10), transparent 32%),
                radial-gradient(circle at bottom right, rgba(109,40,217,.10), transparent 32%),
                #f5f7fb;
        }

        .brand-gradient {
            background: linear-gradient(135deg, var(--brand-1), var(--brand-2));
        }

        .card-modern {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(15,23,42,.08);
        }

        .form-control {
            border-radius: 14px;
            padding: .85rem 1rem;
        }

        .btn {
            border-radius: 14px;
            font-weight: 600;
        }

        .todo-done {
            text-decoration: line-through;
            opacity: .65;
        }

        .app-shell {
            max-width: 1120px;
        }
    </style>
</head>
<body>

    @yield('content')

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
