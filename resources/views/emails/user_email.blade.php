<!DOCTYPE html>
<html>

<head>
    <title>新着メール</title>
</head>

<body>
    <h1>{{ $email }}から新しいメールが届きました。</h1>
    <p>メールアドレス: {{ $email }}</p>
    <p>メール内容: {{ $content }}</p>
</body>

</html>
