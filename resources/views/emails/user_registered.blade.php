<!DOCTYPE html>
<html>

<head>
    <title>新規ユーザ登録</title>
</head>

<body>
    <h1>新しいユーザが登録されました</h1>
    <p>ユーザ名: {{ $user->name }}</p>
    <p>メールアドレス: {{ $user->email }}</p>
</body>

</html>
