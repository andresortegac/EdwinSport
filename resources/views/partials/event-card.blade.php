<div class="event-card h-100">
    @php
        $imageUrl = null;
        if (!empty($event->image)) {
            $imageUrl = \Illuminate\Support\Str::startsWith($event->image, ['http://', 'https://'])
                ? $event->image
                : route('events.media', ['path' => ltrim($event->image, '/')]);
        }
        $fallbackImage = asset('img/slider/slider0.png');
    @endphp

    <div class="event-image-wrap">
        <img
            src="{{ $imageUrl ?: $fallbackImage }}"
            class="event-image"
            alt="{{ $event->title }}"
            loading="lazy"
            onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
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
