<div class="card h-100">
    {{-- Imagen del evento --}}
    <img
        src="{{ $event->image ? asset('storage/'.$event->image) : asset('img/default-event.jpg') }}"
        class="card-img-top"
        alt="{{ $event->title }}"
    >

    <div class="card-body d-flex flex-column">
        {{-- Título --}}
        <h5 class="card-title">{{ $event->title }}</h5>

        {{-- Fecha y lugar --}}
        <p class="card-text small text-muted">
            {{ optional($event->start_at)->format('d M, Y H:i') }} • {{ $event->location }}
        </p>

        {{-- Descripción corta --}}
        <p class="card-text">
            {{ \Illuminate\Support\Str::limit($event->description, 120) }}
        </p>

        {{-- Botones (solo lectura para el público) --}}
        <div class="mt-auto">
            <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm">Ver más</a>
            <a href="#" class="btn btn-success btn-sm">Inscribirme</a>
        </div>
    </div>
</div>
