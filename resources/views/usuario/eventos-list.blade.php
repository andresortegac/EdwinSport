<div class="mt-4">
    <h3 class="text-xl font-semibold mb-3">Eventos creados</h3>

    @if($eventos->count() > 0)
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Título</th>
                    <th class="border px-4 py-2">Fecha</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventos as $evento)
                <tr>
                    <td class="border px-4 py-2">{{ $evento->titulo }}</td>
                    <td class="border px-4 py-2">{{ $evento->fecha }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('eventos.edit', $evento->id) }}" class="text-blue-600">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500">No tienes eventos creados aún.</p>
    @endif
</div>
