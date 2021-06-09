@extends('layouts.admin')
@section('title') Agregar Versión @stop
@section('content')
	{!! Form::open(['route' => 'agregar_version', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		{!! Field::number('android', null, ['data-required'=> 'true']) !!}
		{!! Field::number('ios', null, ['data-required'=> 'true']) !!}
		<br/>
        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('ver_version') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@stop