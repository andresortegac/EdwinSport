
<div class="card h-100">
  <img src="{{ asset($event->image ? 'img/'.$event->image : 'img/default-event.jpg') }}" class="card-img-top" alt="{{ $event->title }}">
  <div class="card-body d-flex flex-column">
    <h5 class="card-title">{{ $event->title }}</h5>
    <p class="card-text small text-muted">{{ $event->start_at->format('d M, Y H:i') }} • {{ $event->location }}</p>
    <p class="card-text">{{ Str::limit($event->description, 120) }}</p>
    <div class="mt-auto">
      <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm">Ver más</a>
      <a href="#" class="btn btn-success btn-sm">Inscribirme</a>
    </div>
  </div>
</div>
