@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Importar Equipos</h1>

    <form action="{{ route('equipos.import.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label class="font-semibold">Subir Archivo Excel</label>
        <input type="file" name="file" class="border p-2 w-full mb-4" required>

        <label class="font-semibold">Equipos por grupo</label>
        <input type="number" name="group_size" value="4" class="border p-2 w-full mb-4" required>

        <button class="btn btn-success px-4 py-2 rounded">Importar y Generar Grupos</button>
    </form>
</div>
@endsection
