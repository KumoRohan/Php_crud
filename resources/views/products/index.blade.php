<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .success {
            color: green;
            padding: 10px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 8px 16px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-logout {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>Products</h1>
            <p>Welcome, {{ auth()->user()->name }}!</p>
        </div>
        <div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a><br><br>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price (Rs)</th>
            <th>Description</th>    
            <th>Stock</th>
            <th>Actions</th>
        </tr>

        @forelse($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">Edit</a>

                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">No products found. Add your first product!</td>
        </tr>
        @endforelse

    </table>

    @yield('content')
</body>
</html>