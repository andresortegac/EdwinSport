<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planilla equipo - {{ $equipo->nombre_equipo }} (Excel)</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        .title-main {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
        }

        .sub-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
        }

        .no-border td,
        .no-border th {
            border: none;
        }

        .small {
            font-size: 9px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .upper {
            text-transform: uppercase;
        }

        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }

        .firma {
            margin-top: 40px;
            text-align: center;
        }

        .firma span {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 3px;
            min-width: 200px;
        }
    </style>
</head>
<body>

    {{-- ENCABEZADO --}}
    <div class="title-main">PLANILLA OFICIAL DE INSCRIPCIÓN TORNEO</div>
    <div class="sub-title">FÚTBOL SALA MASCULINO</div>

    {{-- DATOS DEL EQUIPO / NIT / TELÉFONO / VALOR --}}
    <table class="mt-10">
        <tr>
            <td style="width: 15%; font-weight:bold;">NOMBRE EQUIPO</td>
            <td style="width: 35%;">
                {{ mb_strtoupper($equipo->nombre_equipo) }}
            </td>
            <td style="width: 10%; font-weight:bold;">NIT</td>
            <td style="width: 15%;">
                {{ $equipo->nit }}
            </td>
            <td style="width: 10%; font-weight:bold;">TELÉFONO</td>
            <td style="width: 15%;">
                {{ $equipo->telefono_equipo }}
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">DIRECCIÓN</td>
            <td>
                {{ mb_strtoupper($equipo->direccion) }}
            </td>
            <td style="font-weight:bold;">VALOR</td>
            <td colspan="3">
                $ {{ number_format($equipo->valor_inscripcion, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">E-MAIL</td>
            <td colspan="5">
                {{ $equipo->email_equipo }}
            </td>
        </tr>
    </table>

    {{-- TABLA JUGADORES (12 FILAS) --}}
    @php
        $jugadores = $equipo->participantes ?? collect();
    @endphp

    <table class="mt-10">
        <thead>
            <tr>
                <th style="width: 4%;">N°</th>
                <th>NOMBRE Y APELLIDO DEL JUGADOR</th>
                <th style="width: 10%;">N° DE LA CAMISA</th>
                <th style="width: 15%;">N° DE CELULAR</th>
                <th style="width: 18%;">N° DOCUMENTO DE IDENTIDAD</th>
                <th style="width: 8%;">EDAD</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 12; $i++)
                @php
                    $jug = $jugadores[$i-1] ?? null;
                @endphp
                <tr>
                    <td class="center">{{ $i }}</td>
                    <td class="upper">
                        {{ $jug?->nombre ?? '' }}
                    </td>
                    <td class="center">
                        {{ $jug?->numero_camisa ?? '' }}
                    </td>
                    <td class="center">
                        {{ $jug?->telefono ?? '' }}
                    </td>
                    <td class="center">
                        {{-- Si tu modelo tiene documento, colócalo aquí, ej: --}}
                        {{-- {{ $jug?->documento ?? '' }} --}}
                    </td>
                    <td class="center">
                        {{ $jug?->edad ?? '' }}
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- DATOS DEL DELEGADO DEL EQUIPO --}}
    <table class="mt-10">
        <tr>
            <td colspan="4" class="center" style="font-weight:bold;">
                DATOS DEL DELEGADO DEL EQUIPO
            </td>
        </tr>
        <tr>
            <td style="width: 5%;" class="center">1</td>
            <td style="width: 45%;">
                {{ mb_strtoupper($equipo->nombre_dt) }}
            </td>
            <td style="width: 15%; font-weight:bold;">E-MAIL</td>
            <td style="width: 35%;">
                {{ $equipo->email_equipo }}
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="font-weight:bold;">CELULAR N°</td>
            <td>
                {{ $equipo->telefono_equipo }}
            </td>
        </tr>
    </table>

    {{-- DATOS DEL ENTRENADOR --}}
    <table class="mt-10">
        <tr>
            <td colspan="4" class="center" style="font-weight:bold;">
                DATOS DEL ENTRENADOR (Cuando aplique)
            </td>
        </tr>
        <tr>
            <td style="width: 5%;" class="center">1</td>
            <td style="width: 45%;">
                {{ mb_strtoupper($equipo->nombre_dt) }}
            </td>
            <td style="width: 15%; font-weight:bold;">E-MAIL</td>
            <td style="width: 35%;">
                {{ $equipo->email_equipo }}
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="font-weight:bold;">CELULAR N°</td>
            <td>
                {{ $equipo->telefono_equipo }}
            </td>
        </tr>
    </table>

    {{-- TEXTO INFORMATIVO --}}
    <table class="mt-20">
        <tr>
            <td class="small" style="text-align:justify;">
                LOS PARTICIPANTES DE CADA EQUIPO NO DEBEN ESTAR INSCRITOS EN OTROS EQUIPOS
                QUE SE RELACIONEN CON LA ACTIVIDAD QUE SE ESTÁ LLEVANDO A CABO. RECUERDEN
                QUE LOS EQUIPOS DEBEN TENER SU COLOR GRUPAL QUE SE PUEDAN IDENTIFICAR.
                <br>
                "PARTICIPAN BAJO SU PROPIA RESPONSABILIDAD".
            </td>
        </tr>
    </table>

    {{-- FIRMA ORGANIZADOR --}}
    <div class="firma">
        <span>Firma Organizador</span>
    </div>

</body>
</html>
