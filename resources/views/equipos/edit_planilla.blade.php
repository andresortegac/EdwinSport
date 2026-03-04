<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo - {{ $equipo->nombre_equipo }}</title>
    <style>
        :root {
            --bg: #f1f5f9;
            --sheet: #ffffff;
            --line: #111827;
            --soft-line: #d1d5db;
            --head: #1f4e78;
            --subhead: #e5e7eb;
            --text: #111827;
            --ok: #166534;
            --danger: #b91c1c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: radial-gradient(circle at top right, #dbeafe 0, var(--bg) 40%);
            font-family: Calibri, "Segoe UI", Arial, sans-serif;
            color: var(--text);
        }

        .wrap {
            max-width: 1100px;
            margin: 26px auto;
            padding: 0 16px;
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .btn {
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #0f172a;
            border-radius: 10px;
            padding: 9px 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #f8fafc;
        }

        .sheet {
            background: var(--sheet);
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .sheet-head {
            background: var(--head);
            color: #fff;
            text-align: center;
            padding: 16px 10px;
            border-bottom: 1px solid #0f2f4d;
        }

        .sheet-head h1 {
            margin: 0;
            font-size: 23px;
            letter-spacing: 0.4px;
        }

        .sheet-head p {
            margin: 6px 0 0;
            font-size: 14px;
            opacity: 0.95;
        }

        .team-box {
            display: grid;
            grid-template-columns: 180px 1fr;
            border-bottom: 1px solid var(--soft-line);
        }

        .team-box .label {
            background: var(--subhead);
            border-right: 1px solid var(--soft-line);
            padding: 10px 12px;
            font-weight: 700;
        }

        .team-box .value {
            padding: 10px 12px;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .msg {
            margin: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .msg.ok {
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            color: var(--ok);
        }

        .msg.err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--danger);
        }

        .table-wrap {
            overflow-x: auto;
            padding: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th, td {
            border: 1px solid var(--line);
            padding: 7px 8px;
            font-size: 14px;
        }

        th {
            background: var(--subhead);
            text-align: center;
            font-weight: 700;
        }

        td.center {
            text-align: center;
        }

        .name-input {
            width: 100%;
            border: 1px solid #94a3b8;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .actions {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        .name-form {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .new-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1.2fr;
            gap: 6px;
            align-items: center;
        }

        .btn-sm {
            border: none;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-save {
            background: #2563eb;
            color: #fff;
        }

        .btn-del {
            background: #dc2626;
            color: #fff;
        }

        .btn-add {
            background: #16a34a;
            color: #fff;
        }

        .mini-input {
            width: 100%;
            border: 1px solid #94a3b8;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 12px;
        }

        .empty-cell {
            color: #94a3b8;
            text-align: center;
        }

        @media (max-width: 768px) {
            .team-box {
                grid-template-columns: 1fr;
            }
            .team-box .label {
                border-right: 0;
                border-bottom: 1px solid var(--soft-line);
            }
            .new-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="toolbar">
        <a href="{{ route('participantes.index') }}" class="btn">Volver a Registro</a>
        <a href="{{ route('participantes.planilla.excel', ['equipo_id' => $equipo->id]) }}" class="btn">Descargar Excel</a>
    </div>

    <div class="sheet">
        <div class="sheet-head">
            <h1>PLANILLA DE EDICION DE EQUIPO</h1>
            <p>Gestion rapida de jugadores: agregar, cambiar nombre o eliminar</p>
        </div>

        @if(session('success'))
            <div class="msg ok">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="msg err">{{ $errors->first() }}</div>
        @endif

        <div class="team-box">
            <div class="label">NOMBRE DEL EQUIPO</div>
            <div class="value">{{ $equipo->nombre_equipo }}</div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th style="width: 6%;">N</th>
                    <th style="width: 38%;">NOMBRE DEL JUGADOR</th>
                    <th style="width: 10%;">N CAMISA</th>
                    <th style="width: 12%;">EDAD</th>
                    <th style="width: 12%;">DIVISION</th>
                    <th style="width: 15%;">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 1; $i <= 20; $i++)
                    @php
                        $jugador = $equipo->participantes[$i - 1] ?? null;
                    @endphp
                    <tr>
                        <td class="center">{{ $i }}</td>
                        @if($jugador)
                            <td>
                                <form method="POST" action="{{ route('equipos.jugadores.update', [$equipo->id, $jugador->id]) }}" class="name-form">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        type="text"
                                        name="nombre"
                                        class="name-input"
                                        value="{{ old('nombre', $jugador->nombre) }}"
                                        required
                                    >
                                    <button type="submit" class="btn-sm btn-save">Guardar Nombre</button>
                                </form>
                            </td>
                            <td class="center">{{ $jugador->numero_camisa ?: '-' }}</td>
                            <td class="center">{{ $jugador->edad ?: '-' }}</td>
                            <td class="center">{{ $jugador->division ?: '-' }}</td>
                            <td>
                                <div class="actions">
                                    <form method="POST" action="{{ route('equipos.jugadores.destroy', [$equipo->id, $jugador->id]) }}" onsubmit="return confirm('¿Eliminar este jugador del equipo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-del">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        @else
                            <td colspan="5">
                                <form method="POST" action="{{ route('equipos.jugadores.store', $equipo->id) }}" class="new-form">
                                    @csrf
                                    <input
                                        type="text"
                                        name="nombre"
                                        class="name-input"
                                        placeholder="Nombre del jugador"
                                        required
                                    >
                                    <input
                                        type="text"
                                        name="numero_camisa"
                                        class="mini-input"
                                        placeholder="N camisa"
                                    >
                                    <input
                                        type="number"
                                        name="edad"
                                        min="1"
                                        max="120"
                                        class="mini-input"
                                        placeholder="Edad"
                                    >
                                    <input
                                        type="text"
                                        name="division"
                                        class="mini-input"
                                        placeholder="Division"
                                    >
                                    <button type="submit" class="btn-sm btn-add">Agregar jugador</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
