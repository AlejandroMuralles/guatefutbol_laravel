@extends('layouts.admin')
@section('title') Agregar Notificacion Calendario @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => ['agregar_notificacion_calendario',$liga->id], 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<div class="box-body">
		{!! Field::text('mensaje', $liga->descripcion.': Consulta los resultados de la jornada ', ['data-required'=> 'true']) !!}
		{!! Field::text('tipo', 'calendario', ['data-required'=> 'true','disabled'=>'true']) !!}
		<input type="hidden" name="tipo" value="calendario">
	</div>
	<div class="box-footer">
		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
    <a href="{{ route('notificaciones') }}" class="btn btn-danger btn-flat">Cancelar</a>
	</div>
	{!! Form::close() !!}
</div>
@endsection
