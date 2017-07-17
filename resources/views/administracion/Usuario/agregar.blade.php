@extends('layouts.admin')

@section('title') Agregar Usuario @stop

@section('content')

	{!! Form::open(['route' => 'agregar_usuario', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('username') !!}

		{!! Field::password('password') !!}

		{!! Field::password('password_confirmation') !!}

		{!! Field::select('perfil_id', $perfiles) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('usuarios') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop