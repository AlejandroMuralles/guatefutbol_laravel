@extends('layouts.admin')

@section('title') Editar Usuario @stop

@section('content')

	{!! Form::model($usuario, ['route' => array('editar_usuario',$usuario->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('username', $usuario->username, ['disabled']) !!}

		{!! Field::password('password') !!}

		{!! Field::password('password_confirmation') !!}

		{!! Field::select('perfil_id', $perfiles) !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('usuarios') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop