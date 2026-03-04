<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planilla equipo - {{ $equipo->nombre_equipo }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 14px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111827;
        }

        .sheet {
            border: 1px solid #1f2937;
        }

        .header {
            background: #1f4e78;
            color: #fff;
            text-align: center;
            border-bottom: 1px solid #0f2f4d;
            padding: 7px 8px;
        }

        .header .main {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .header .sub {
            font-size: 11px;
            margin-top: 2px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #111827;
            padding: 4px 5px;
            vertical-align: middle;
        }

        .lbl {
            background: #e5e7eb;
            font-weight: 700;
            width: 10%;
        }

        .sec-title {
            background: #e5e7eb;
            text-align: center;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .thead th {
            background: #e5e7eb;
            text-align: center;
            font-weight: 700;
            font-size: 9.5px;
        }

        .center {
            text-align: center;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .mt8 {
            margin-top: 8px;
        }

        .note {
            font-size: 9px;
            line-height: 1.35;
            min-height: 44px;
        }

        .signature {
            margin-top: 12px;
            text-align: center;
            font-weight: 700;
            border-top: 1px solid #111827;
            padding-top: 4px;
        }
    </style>
</head>
<body>
@php
    $jugadores = ($equipo->participantes ?? collect())->values();
@endphp

<div class="sheet">
    <div class="header">
        <div class="main">PLANILLA OFICIAL DE INSCRIPCION TORNEO</div>
        <div class="sub">FUTBOL SALA MASCULINO</div>
    </div>

    <table>
        <tr>
            <td class="lbl">NOMBRE EQUIPO</td>
            <td colspan="3" class="uppercase">{{ $equipo->nombre_equipo }}</td>
            <td class="lbl">NIT</td>
            <td>{{ $equipo->nit }}</td>
            <td class="lbl">TELEFONO</td>
            <td>{{ $equipo->telefono_equipo }}</td>
        </tr>
        <tr>
            <td class="lbl">DIRECCION</td>
            <td colspan="3" class="uppercase">{{ $equipo->direccion }}</td>
            <td class="lbl">VALOR</td>
            <td colspan="3">$ {{ number_format((float) ($equipo->valor_inscripcion ?? 0), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="lbl">E-MAIL</td>
            <td colspan="7">{{ $equipo->email_equipo }}</td>
        </tr>
    </table>

    <table class="mt8">
        <thead class="thead">
        <tr>
            <th style="width: 4%;">N</th>
            <th style="width: 34%;">NOMBRE Y APELLIDO DEL JUG.</th>
            <th style="width: 9%;">N CAMISA</th>
            <th style="width: 12%;">N CELULAR</th>
            <th style="width: 14%;">N DOCUMENTO</th>
            <th style="width: 8%;">EDAD</th>
            <th style="width: 13%;">E-MAIL</th>
            <th style="width: 10%;">DIVISION</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 1; $i <= 20; $i++)
            @php
                $jugador = $jugadores[$i - 1] ?? null;
            @endphp
            <tr>
                <td class="center">{{ $i }}</td>
                <td class="uppercase">{{ $jugador?->nombre ?? '' }}</td>
                <td class="center">{{ $jugador?->numero_camisa ?? '' }}</td>
                <td class="center">{{ $jugador?->telefono ?? '' }}</td>
                <td class="center"></td>
                <td class="center">{{ $jugador?->edad ?? '' }}</td>
                <td class="center">{{ $jugador?->email ?? '' }}</td>
                <td class="center">{{ $jugador?->division ?? '' }}</td>
            </tr>
        @endfor
        </tbody>
    </table>

    <table class="mt8">
        <tr><td colspan="8" class="sec-title">DATOS DEL DELEGADO DEL EQUIPO</td></tr>
        <tr>
            <td class="lbl">NOMBRE</td>
            <td colspan="3">{{ $equipo->nombre_dt }}</td>
            <td class="lbl">E-MAIL</td>
            <td colspan="3">{{ $equipo->email_equipo }}</td>
        </tr>
        <tr>
            <td class="lbl">CELULAR</td>
            <td colspan="7">{{ $equipo->telefono_equipo }}</td>
        </tr>
    </table>

    <table class="mt8">
        <tr><td colspan="8" class="sec-title">DATOS DEL ENTRENADOR (CUANDO APLIQUE)</td></tr>
        <tr>
            <td class="lbl">NOMBRE</td>
            <td colspan="3">{{ $equipo->nombre_dt }}</td>
            <td class="lbl">E-MAIL</td>
            <td colspan="3">{{ $equipo->email_equipo }}</td>
        </tr>
        <tr>
            <td class="lbl">CELULAR</td>
            <td colspan="7">{{ $equipo->telefono_equipo }}</td>
        </tr>
    </table>

    <table class="mt8">
        <tr>
            <td class="note">
                LOS PARTICIPANTES DE CADA EQUIPO NO DEBEN ESTAR INSCRITOS EN OTROS EQUIPOS.
                PARTICIPAN BAJO SU PROPIA RESPONSABILIDAD.
            </td>
        </tr>
    </table>

    <div class="signature">FIRMA ORGANIZADOR</div>
</div>
</body>
</html>
