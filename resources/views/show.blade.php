<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="text-align: center; padding-top: 50px; font-family: sans-serif">
    <h1>{{ $product->name }}</h1>

    <a rel="ar" href="{{ asset( $product->usdz_url) }}">
        <img src="{{asset( $product->image_url ) }}" alt="{{ $product->name }}" width="300" style="border-radius: 20px;">
    </a>

    <p style="margin-top: 20px;">📱 Scannez avec un iPhone/iPad pour voir en AR</p>

    <h4>Hello</h4>
</body>
</html>
