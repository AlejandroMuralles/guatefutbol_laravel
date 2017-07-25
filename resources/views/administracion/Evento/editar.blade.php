@extends('layouts.admin')
@section('title') Editar Evento @stop
@section('content')
	{!! Form::model($evento, ['route' => array('editar_evento', $evento->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form','files'=>'true']) !!}	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::file('imagen') !!}
		{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		<br/>
        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('eventos') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@stop