@extends('layouts.admin')

@section('title') Editar Perfil @stop

@section('content')

	{!! Form::model($perfil, ['route' => array('editar_perfil', $perfil->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre') !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('perfiles') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop