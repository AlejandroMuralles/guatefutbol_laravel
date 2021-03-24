@extends('layouts.admin')
@section('title') Agregar Campeonato a Tabla Acumulada - {{$tablaAcumuladaLiga->descripcion}} @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
	{!! Form::open(['route' => ['agregar_tabla_acumulada_liga_detalle',$tablaAcumuladaLiga->id], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		{!! Field::select('campeonato_id', $campeonatos, null, ['data-required'=> 'true', 'id' => 'campeonato']) !!}
		<br/>
        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('tablas_acumuladas_ligas_detalle',$tablaAcumuladaLiga->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script>
	$(function(){
		$('#campeonato').select2();
	});
</script>
@endsection