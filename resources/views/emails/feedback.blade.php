<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <title>Сообщение с персонального сайта: {{$pickedProject}} / От: {{$messageEmail}}</title>
</head>
<body>
    <div class="white-bg" style="background-color:rgba(235, 235, 235, 0.3);">
        <h3>Заказ: {{$pickedProject}}</h3>
        <br>
        <h3>От: {{$messageEmail}}</h3>
        <br>
        <hr>
        <div>{!!$messageText!!}</div>
        <hr>
        <br>
        <h5>{{$date}}</h5>
    </div>
</body>
</html>