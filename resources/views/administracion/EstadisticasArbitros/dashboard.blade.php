@extends('layouts.admin')

@section('title') Dashboard Estadísticas de Arbitros @stop

@section('content')

<a href="{{route('estadistica_arbitro_campeonato',[$ligaId,0,0])}}" class="btn btn-primary">Arbitros por Campeonato</a>

@stop