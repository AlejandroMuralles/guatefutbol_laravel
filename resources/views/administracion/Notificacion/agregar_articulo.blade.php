@extends('layouts.admin')
@section('title') Agregar Notificacion Link @endsection
@section('content')
<div class="box box-primary">
	{!! Form::open(['route' => 'agregar_notificacion_articulo', 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<div class="box-body">
		{!! Field::text('mensaje', null, ['data-required'=> 'true']) !!}
		{!! Field::text('tipo', 'link', ['data-required'=> 'true','disabled'=>'true']) !!}
		{!! Field::text('link', null, ['data-required'=> 'true']) !!}
		<input type="hidden" name="tipo" value="link">
	</div>
	<div class="box-footer">
		<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
    <a href="{{ route('notificaciones') }}" class="btn btn-danger btn-flat">Cancelar</a>
	</div>
	{!! Form::close() !!}
</div>
@endsection
