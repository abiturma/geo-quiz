<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{mix('app.css')}}">
    <title>Flaggen | Quiz</title>
</head>

<body class="bg-gray-100 h-full">
    <div id="app" class="h-full">
        <app-container :questions="{{$questions->toJson()}}"></app-container>
    </div>
<script type="text/javascript" src="{{mix('app.js')}}"></script>
</body>

</html>

