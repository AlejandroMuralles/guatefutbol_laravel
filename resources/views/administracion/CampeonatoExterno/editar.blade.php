@extends('layouts.admin')
@section('title') Editar Campeonato Externo @stop
@section('content')
	{!! Form::model($campeonatoExterno, ['route' => array('editar_campeonato_externo', $campeonatoExterno->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
        {!! Field::text('nombre_liga', null, ['data-required'=> 'true']) !!}
        {!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
        {!! Field::text('link', null, ['data-required'=> 'true']) !!}
		{!! Field::select('estado',$estados,null,['data-required'=> 'true']) !!}
		<br/>
        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos_externos') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@stop