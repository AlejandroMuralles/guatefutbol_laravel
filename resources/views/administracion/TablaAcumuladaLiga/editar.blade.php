@extends('layouts.admin')
@section('title') Editar Tabla Acumulada - {{$tablaAcumuladaLiga->descripcion}} @endsection
@section('content')
	{!! Form::model($tablaAcumuladaLiga,['route' => ['editar_tabla_acumulada_liga',$tablaAcumuladaLiga->id], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
		<br/>
        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('tablas_acumuladas_ligas',$tablaAcumuladaLiga->liga_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@endsection