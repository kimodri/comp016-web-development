<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Calculate Page</h1>
    <p>Sum: {{ $sum }}</p>
    <p>Difference: {{ $difference }}</p>
    <p>Product: {{ $product }}</p>
    <p>Results: {{$sum . $difference . $product}}</p>
</body>
</html>