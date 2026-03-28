<link rel="stylesheet" href="{{ asset('CSS/views/events/listado-content.css') }}">
<div class="event-list-shell">
    <section class="event-list-header">
        <h2 class="event-list-title">Listado de eventos</h2>
        <p class="event-list-subtitle">Administra tus eventos, edita su informaci&oacute;n o elim&iacute;nalos.</p>
    </section>

    <div class="row event-grid">
        @forelse ($eventos as $evento)
            <div class="col-md-6 col-xl-4">
                <article
                    class="event-card"
                    data-url="{{ route('competicion', $evento->id) }}"
                    onclick="goToEvento(this, event)">

                    @if($evento->image)
                        @php
                            $imageUrl = \Illuminate\Support\Str::startsWith($evento->image, ['http://', 'https://'])
                                ? $evento->image
                                : route('events.media', ['path' => ltrim($evento->image, '/')]);
                        @endphp
                        <div class="event-image-wrap">
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $evento->title }}"
                                 onerror="this.closest('.event-image-wrap').classList.add('is-broken'); this.remove();">
                            <div class="event-image-fallback">Sin imagen</div>
                        </div>
                    @else
                        <div class="event-image-wrap is-broken">
                            <div class="event-image-fallback">Sin imagen</div>
                        </div>
                    @endif

                    <div class="event-card-body">
                        <h3 class="event-title">{{ $evento->title }}</h3>

                        <p class="event-description">{{ Str::limit($evento->description, 90) }}</p>

                        <div class="event-meta">
                            <p><strong>Categor&iacute;a:</strong> {{ ucfirst($evento->category) }}</p>
                            <p><strong>Ubicaci&oacute;n:</strong> {{ $evento->location }}</p>
                            <p>
                                <strong>Inicio:</strong>
                                {{ \Carbon\Carbon::parse($evento->start_at)->format('d/m/Y H:i') }}
                                <br>
                                <strong>Final:</strong>
                                {{ $evento->end_at ? \Carbon\Carbon::parse($evento->end_at)->format('d/m/Y H:i') : 'No definido' }}
                            </p>
                        </div>

                        <span class="event-status
                            @if($evento->status === 'activo') is-active
                            @elseif($evento->status === 'inactivo') is-inactive
                            @else is-closed @endif">
                            {{ strtoupper($evento->status) }}
                        </span>

                        <div class="event-actions">
                            <a href="{{ route('editar-evento.edit', $evento->id) }}"
                               class="btn btn-sm btn-editar-evento"
                               data-id="{{ $evento->id }}"
                               onclick="event.stopPropagation();">
                                Editar
                            </a>

                            <form action="{{ route('eliminar-evento.destroy', $evento->id) }}"
                                  method="POST"
                                  onsubmit="event.stopPropagation(); return confirm('&iquest;Seguro que deseas eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-eliminar-evento" onclick="event.stopPropagation();">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12 text-center mt-4">
                <h4 class="mb-2">No hay eventos registrados.</h4>
                <p class="text-muted mb-0">Crea tu primer evento desde el bot&oacute;n "Crear evento".</p>
            </div>
        @endforelse
    </div>
</div>

<script>
function goToEvento(element, ev) {
    if (ev) ev.stopPropagation();
    window.location.href = element.getAttribute('data-url');
}
</script>

