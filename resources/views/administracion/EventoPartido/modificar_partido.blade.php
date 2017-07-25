@extends('layouts.admin')

@section('title') Modificar Partido - {{$partido->equipo_local->nombre}} {{$partido->goles_local}} - {{$partido->goles_visita}} {{$partido->equipo_visita->nombre}} @stop

@section('content')

	{!! Form::model($partido, ['route' => array('modificar_partido',$partido->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('goles_local') !!}
		{!! Field::text('goles_visita') !!}
		{!! Field::text('descripcion_penales') !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,0]) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop