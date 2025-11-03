<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>

    <h1>Add New Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Price (Rs):</label><br>
        <input type="number" name="price" required><br><br>

        <label>Description:</label><br>
        <input type="text" name="description" required><br><br>

        <button type="submit">Save</button>
    </form>

    <br>
    <a href="{{ route('products.index') }}">Back</a>

</body>
</html>
