@extends('layouts.admin')

@section('title') Editar Tabla Acumulada - {{$liga->nombre}} @stop

@section('content')

	{!! Form::model($tablaAcumulada,['route' => ['editar_tabla_acumulada',$tablaAcumulada->id], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::select('campeonato1_id',$campeonatos, null, ['data-required'=> 'true']) !!}
		{!! Field::select('campeonato2_id',$campeonatos, null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('tablas_acumuladas',$liga->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop