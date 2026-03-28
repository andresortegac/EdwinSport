<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo - {{ $equipo->nombre_equipo }}</title>
        <link rel="stylesheet" href="{{ asset('CSS/views/equipos/edit-planilla.css') }}">
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
                                    <form method="POST" action="{{ route('equipos.jugadores.destroy', [$equipo->id, $jugador->id]) }}" data-delete-player-form>
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
<script src="{{ asset('js/views/equipos/edit-planilla.js') }}"></script>
</body>
</html>

