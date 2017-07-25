@extends('layouts.admin')

@section('title') Agregar Departamento @stop

@section('content')

	{!! Form::open(['route' => 'agregar_departamento', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::select('pais_id',$paises, null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('departamentos') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop