<!-- resources/views/emails/welcome.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Welcome to {{ config('app.name') }}. We're glad to have you with us.</p>
</body>
</html>
