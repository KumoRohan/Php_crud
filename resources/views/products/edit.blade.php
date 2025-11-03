<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ $product->name }}" required><br><br>

        <label>Price (Rs):</label><br>
        <input type="number" name="price" value="{{ $product->price }}" required><br><br>

        <label>Description</label><br>
        <input type="text" name="description" value="{{ $product->description }}" required><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" value="{{ $product->stock }}" required><br><br>
        

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('products.index') }}">Back</a>

</body>
</html>
