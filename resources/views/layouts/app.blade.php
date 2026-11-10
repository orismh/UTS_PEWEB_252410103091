<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Academic Task Tracker')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f5f6f8; color: #1f2937; }
        a { color: inherit; text-decoration: none; }
        .navbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 14px 24px; background: #111827; color: #fff; }
        .brand { font-size: 20px; font-weight: bold; }
        .nav-links a { margin-left: 16px; font-size: 14px; color: #d1d5db; }
        .nav-links a:hover { color: #fff; }
        .container { max-width: 1000px; margin: 28px auto; padding: 0 16px 40px; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
        h1 { font-size: 28px; margin: 0 0 10px; }
        h2 { font-size: 20px; margin: 0 0 14px; }
        p, .small { color: #6b7280; line-height: 1.6; }
        .stat { text-align: center; }
        .stat strong { display: block; font-size: 32px; margin-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { color: #6b7280; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: #e0e7ff; font-size: 12px; font-weight: bold; }
        .progress { width: 120px; height: 8px; background: #e5e7eb; border-radius: 999px; overflow: hidden; }
        .progress span { display: block; height: 100%; background: #2563eb; }
        .btn { display: inline-block; padding: 10px 16px; border: 0; border-radius: 8px; background: #2563eb; color: #fff; font-weight: bold; cursor: pointer; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        input, select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; margin: 6px 0 14px; }
        .table-input { margin: 0; min-height: 38px; }
        .status-select { margin: 0; min-height: 38px; }
        label { font-weight: bold; font-size: 14px; }
        .footer { text-align: center; color: #6b7280; font-size: 14px; padding: 24px; }
        @media (max-width: 700px) {
            .navbar { flex-direction: column; align-items: flex-start; }
            .grid, .grid-4 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('components.navbar', ['username' => $username ?? 'Tamu'])

    <main class="container">
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
