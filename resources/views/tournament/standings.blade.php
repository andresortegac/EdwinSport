@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-6">
  <h2 class="text-2xl font-bold mb-4">Tabla de Posiciones</h2>

  @foreach($standings as $groupName => $rows)
    <div class="mb-6">
      <h3 class="font-semibold mb-2">{{ $groupName }}</h3>
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="text-left">
            <th>Equipo</th><th>PJ</th><th>G</th><th>E</th><th>P</th><th>GF</th><th>GC</th><th>DG</th><th>Pts</th>
          </tr>
        </thead>
        <tbody>
          @foreach($rows as $row)
            <tr>
              <td>{{ $row['team_name'] }}</td>
              <td>{{ $row['played'] }}</td><td>{{ $row['win'] }}</td><td>{{ $row['draw'] }}</td>
              <td>{{ $row['loss'] }}</td><td>{{ $row['gf'] }}</td><td>{{ $row['ga'] }}</td>
              <td>{{ $row['gd'] }}</td><td>{{ $row['pts'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endforeach
</div>
@endsection
