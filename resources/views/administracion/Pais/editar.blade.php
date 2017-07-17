@extends('layouts.admin')

@section('title') Editar Pais @stop

@section('content')

	{!! Form::model($pais, ['route' => array('editar_pais', $pais->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('paises') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop