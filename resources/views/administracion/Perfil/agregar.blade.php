@extends('layouts.admin')

@section('title') Agregar Perfil @stop

@section('content')

	{!! Form::open(['route' => 'agregar_perfil', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre') !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('perfiles') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop