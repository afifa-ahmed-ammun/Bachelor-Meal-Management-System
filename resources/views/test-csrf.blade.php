<!DOCTYPE html>
<html>
<head>
    <title>CSRF Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>CSRF Test</h1>
    <p>CSRF Token: {{ csrf_token() }}</p>
    
    <form action="/test-csrf" method="POST">
        @csrf
        <button type="submit">Test CSRF</button>
    </form>
</body>
</html>
