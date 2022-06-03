<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>

@{{ name }}

{{--<form action="{{ route('account.store') }}" method="POST">--}}
{{--    @csrf--}}
{{--    <button type="submit">Submit</button>--}}
{{--</form>--}}

<form action="{{ route('order.ship') }}" method="POST">
    @csrf
    <input name="order_id" type="hidden" value="1">
    <button type="submit">Submit</button>
</form>

</body>
</html>
