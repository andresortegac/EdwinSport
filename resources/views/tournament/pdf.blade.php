<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Torneo Navideño</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
        }
        h1,h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .group-box {
            border: 1px solid #333;
            padding: 10px;
            margin-bottom: 15px;
        }
        ul { margin: 0; padding-left: 20px; }
    </style>
</head>

<body>

    <h1>Torneo Navideño- {{ $n }} Equipos</h1>
    <h2>Formato: {{ ucfirst($style) }} | Modo: {{ ucfirst($mode) }}</h2>

    @foreach($groups as $groupName => $teams)
        <div class="group-box">
            <h3>{{ $groupName }}</h3>
            <ul>
            @foreach($teams as $team)
                <li>{{ $team }}</li>
            @endforeach
            </ul>
        </div>
    @endforeach

</body>
</html>
