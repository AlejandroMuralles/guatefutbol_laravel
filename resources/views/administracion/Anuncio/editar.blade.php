@extends('layouts.admin')
@section('title') Editar Anuncio @endsection
@section('content')

	{!! Form::model($anuncio, ['route' => array('editar_anuncio', $anuncio->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	
        {!! Field::select('pantalla_app',$pantallas, null, ['data-required'=> 'true']) !!}
        {!! Field::select('anunciante', $anunciantes, null, ['data-required'=> 'true']) !!}
        {!! Field::text('nombre_anunciante', null, ['data-required'=> 'true']) !!}
        {!! Field::select('tipo', $tipos, null, ['data-required'=> 'true']) !!}		
        {!! Field::number('segundos_mostrandose', null, ['data-required'=> 'true']) !!}
        {!! Field::number('minutos_espera', null, ['data-required'=> 'true']) !!}
        {!! Field::text('link', null, ['data-required'=> 'false']) !!}
        {!! Field::file('imagen',null,['data-required'=>'false']) !!}
        {!! Field::select('estado',$estados, null, ['data-required'=> 'true']) !!}
        <br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('anuncios') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@endsection