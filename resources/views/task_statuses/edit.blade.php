<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Статусы</title>
</head>

<body>
    <h1>Статусы</h1>
    <ul>
        @foreach ($statuses as $status)
        <li>{{ $status->name }}</li>
        @endforeach
    </ul>
</body>

</html>