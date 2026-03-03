@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('events.partials.listado-eventos-content', ['eventos' => $eventos])
</div>
@endsection
