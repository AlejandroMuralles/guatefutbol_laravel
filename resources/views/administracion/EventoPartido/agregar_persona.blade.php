@extends('layouts.admin')

@section('title') Agregar Evento {{$evento->nombre}} - {{$equipo->nombre}} @stop

@section('content')

	{!! Form::open(['route' => array('agregar_evento_persona',$partido->id,$evento->id,$equipo->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}

		@if(auth()->user()->username != 'alessandro')
			<div class="form-group">
				<label for="facebook">Facebook</label>
				<input name="facebook" type="checkbox">
			</div>
			<div class="form-group">
				<label for="twitter">Twitter</label>
				<input name="twitter" type="checkbox">
			</div>
		@endif
		{!! Field::number('minuto', null, ['data-required'=>'true']) !!}

		@if($evento->id == 9)
			{!! Field::select('jugador_entra',$jugadoresBanca, null, ['data-required'=>'true']) !!}
			{!! Field::select('jugador_sale',$jugadores, null, ['data-required'=>'true']) !!}
		@else
			@if($evento->id == 6 || $evento->id == 7 || $evento->id == 8)
				{!! Field::select('jugador1_id',$jugadores, null, ['data-required'=>'false']) !!}
				{!! Field::select('portero_encaja_gol',$jugadoresContrarios, null, ['data-required'=>'false']) !!}
			@else
				{!! Field::select('jugador1_id',$jugadores, null, ['data-required'=>'true']) !!}
			@endif
		@endif

		@if($evento->id == 11)
			{!! Field::checkbox('doble_amarilla') !!}
		@endif


		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
           <a href="{{ route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipoId]) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop
@section('js')

<script>
	
$(function(){
	$('input[name="facebook"').attr('checked','checked');
})

</script>

@stop