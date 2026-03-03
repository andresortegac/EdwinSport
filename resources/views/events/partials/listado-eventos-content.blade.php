<style>
/* ===============================
   LISTADO DE EVENTOS - PANEL MODERNO
   =============================== */

.event-list-shell {
    width: 100%;
}

.event-list-header {
    margin-bottom: 1.25rem;
    border: 1px solid rgba(148, 163, 184, 0.35);
    border-radius: 1rem;
    padding: 1rem 1.1rem;
    background: linear-gradient(120deg, rgba(15, 23, 42, 0.95), rgba(15, 118, 110, 0.18));
}

.event-list-title {
    margin: 0;
    font-family: Oswald, Inter, sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.4px;
    color: #f8fafc;
}

.event-list-subtitle {
    margin: 0.35rem 0 0 0;
    font-size: 0.95rem;
    color: #cbd5e1;
}

.event-grid {
    row-gap: 1.1rem;
}

.event-card {
    border: 1px solid rgba(148, 163, 184, 0.4);
    border-radius: 1rem;
    overflow: hidden;
    background: linear-gradient(170deg, rgba(15, 23, 42, 0.98), rgba(2, 6, 23, 1));
    box-shadow: 0 12px 28px rgba(2, 6, 23, 0.45);
    color: #e2e8f0;
    transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
}

.event-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 34px rgba(2, 6, 23, 0.6);
    border-color: rgba(20, 184, 166, 0.75);
}

.event-image-wrap {
    position: relative;
    height: 185px;
    background: #0f172a;
}

.event-image-wrap img {
    width: 100%;
    height: 185px;
    object-fit: cover;
    display: block;
}

.event-image-fallback {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #94a3b8;
    background: linear-gradient(140deg, #111827, #1e293b);
}

.event-image-wrap.is-broken .event-image-fallback {
    display: flex;
}

.event-card-body {
    padding: 1rem 1rem 1.1rem 1rem;
}

.event-title {
    margin: 0 0 0.45rem 0;
    color: #f8fafc;
    font-family: Oswald, Inter, sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.25;
}

.event-description {
    margin: 0 0 0.9rem 0;
    min-height: 48px;
    color: #cbd5e1;
    line-height: 1.45;
}

.event-meta {
    display: grid;
    gap: 0.35rem;
    margin-bottom: 0.85rem;
}

.event-meta p {
    margin: 0;
    color: #dbeafe;
    font-size: 0.9rem;
}

.event-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    padding: 0.28rem 0.75rem;
    font-size: 0.72rem;
    letter-spacing: 0.5px;
    font-weight: 800;
    text-transform: uppercase;
    border: 1px solid transparent;
}

.event-status.is-active {
    color: #052e16;
    background: #86efac;
    border-color: #4ade80;
}

.event-status.is-inactive {
    color: #111827;
    background: #d1d5db;
    border-color: #9ca3af;
}

.event-status.is-closed {
    color: #450a0a;
    background: #fca5a5;
    border-color: #f87171;
}

.event-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 0.95rem;
}

.event-actions a,
.event-actions button {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 0 0.95rem !important;
    border-radius: 0.7rem !important;
    font-size: 0.84rem;
    font-weight: 700;
    border: 0;
    cursor: pointer;
    transition: transform 0.14s ease, filter 0.14s ease;
}

.event-actions .btn-editar-evento {
    background: #f59e0b !important;
    color: #111827 !important;
}

.event-actions .btn-eliminar-evento {
    background: #ef4444 !important;
    color: #ffffff !important;
}

.event-actions a:hover,
.event-actions button:hover {
    transform: translateY(-1px);
    filter: brightness(1.04);
}

.event-actions form {
    margin: 0;
}
</style>

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
