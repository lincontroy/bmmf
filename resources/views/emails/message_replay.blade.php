<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Support Reply</title>
</head>

<body>
    <h1>{{ $query['subject'] }}</h1>

    <h2>Admin Reply : {{ $query['message'] }}</h2>
    <p>Thanks for your messages</p>
    <p>Please respond to the sender at your earliest convenience.</p>
    <p>Best regards, {{ config('app.name') }}</p>
</body>

</html>
