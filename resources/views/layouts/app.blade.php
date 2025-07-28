<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Store')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            background: #333;
            color: #fff;
            padding: 1rem 0;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        nav a {
            color: #fff;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 120px);
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    <li><a href="{{ route('orders.index') }}">Orders</a></li>
                    <li><a href="{{ route('moneybag.transactions') }}">Moneybag Transactions</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 E-Commerce Store. Powered by Moneybag Payment Gateway</p>
        </div>
    </footer>
</body>
</html>