<div class="event-card h-100">
    <div class="event-image-wrap">
        <img
            src="{{ $event->image ? asset('storage/'.$event->image) : asset('img/slider/slider0.png') }}"
            class="event-image"
            alt="{{ $event->title }}"
        >
        <span class="event-category">{{ ucfirst(str_replace('_', ' ', $event->category ?? 'general')) }}</span>
    </div>

    <div class="event-body d-flex flex-column">
        <h3 class="event-title">{{ $event->title }}</h3>

        <p class="event-meta">
            <i class="bi bi-calendar-event"></i>
            {{ optional($event->start_at)->format('d M Y H:i') ?: 'Fecha por confirmar' }}
        </p>

        <p class="event-meta">
            <i class="bi bi-geo-alt"></i>
            {{ $event->location ?: 'Ubicacion por confirmar' }}
        </p>

        <p class="event-desc">
            {{ \Illuminate\Support\Str::limit($event->description, 130) }}
        </p>

        <div class="mt-auto d-flex gap-2">
            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-brand btn-sm">Ver mas</a>
            <a href="{{ route('contactenos') }}" class="btn btn-brand btn-sm">Inscribirme</a>
        </div>
    </div>
</div>
