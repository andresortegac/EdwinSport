<?php
use App\Models\Event;

Event::create([
  'title'=>'Torneo Intercolegial de Fútbol',
  'sport'=>'futbol',
  'description'=>'... ',
  'start_at'=>'2026-01-12 09:00:00',
  'location'=>'Estadio Municipal',
  'category'=>'juvenil',
  'capacity'=>32,
  'price'=>0,
  'image'=>'events/futbol1.jpg',
  'status'=>'inscripciones'
]);
// repetir para otros deportes: futsal, baloncesto, ciclismo, natacion, patinaje
