{{-- Updated tournament/show.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center">
            Torneo — {{ \$n }} equipos — Estilo {{ ucfirst(\$style) }}
        </h1>

        @if(\$mode == 'navidad')
            <div class="text-center mb-4 text-red-500 font-bold text-lg">🎄 Modo Navideño Activado 🎄</div>
        @elseif(\$mode == 'champions')
            <div class="text-center mb-4 text-blue-400 font-bold text-lg">⭐ Modo Champions League ⭐</div>
        @endif

        <div class="grid grid-cols-3 gap-6 mb-10">
            <div class="col-span-2">
                <div class="grid grid-cols-2 gap-4">
                    @foreach(\$groups as \$groupName => \$members)
                        <div class="rounded-2xl shadow-lg p-4 
                            @if(\$style=='champions') bg-gradient-to-br from-blue-900 to-blue-800 text-white border border-yellow-400 @endif
                            @if(\$style=='navidad') bg-red-700 text-white border-2 border-green-400 @endif
                            @if(\$style=='modern') bg-slate-900 text-white @endif">

                            <div class="text-yellow-300 font-semibold mb-3">{{ \$groupName }}</div>

                            <ul class="space-y-2">
                                @foreach(\$members as \$idx => \$team)
                                <li class="bg-white/10 p-2 rounded-lg flex justify-between">
                                    <span>{{ \$idx+1 }}. {{ \$team }}</span>
                                    <span class="text-xs text-gray-300">-</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="rounded-2xl p-4 shadow-lg bg-slate-900 text-white">
                    <div class="text-yellow-300 font-semibold mb-3">Cuadro Eliminatorio</div>

                    @if(!\$bracket)
                        <p class="text-gray-300 text-sm">Se necesitan 8 grupos para generar un cuadro de 16.</p>
                    @else
                        @foreach(\$bracket as \$i => \$match)
                            <div class="bg-white/10 p-2 mb-2 rounded-lg flex justify-between">
                                <span>Partido {{ \$i+1 }}</span>
                                <span>{{ \$match[0] }} vs {{ \$match[1] }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <button onclick="window.print()" class="mt-4 w-full bg-yellow-400 text-black py-2 rounded-lg font-bold">Imprimir</button>
            </div>
        </div>

        <div class="text-xs text-gray-400">El orden en grupos es aleatorio según sorteo. Los estilos cambian según la selección en la vista previa.</div>
    </div>
</div>
@endsection