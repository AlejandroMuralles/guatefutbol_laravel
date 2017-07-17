@extends('layouts.admin')

@section('title') Agregar Liga @stop

@section('content')

	{!! Form::open(['route' => 'agregar_liga', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::text('orden', null, ['data-required'=> 'true']) !!}
		{!! Field::checkbox('mostrar_app') !!}
		{!! Field::select('estado',$estados,null,['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('ligas') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop