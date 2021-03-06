@extends('layouts.admin')

@section('title') Agregar Evento {{$evento->nombre}} @stop

@section('content')

	{!! Form::open(['route' => array('agregar_evento_partido',$partido->id, $evento->id, $equipoId), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}

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

		{!! Field::number('minuto') !!}

		@if($evento->id != 12)
			{!! Field::text('fecha_tiempo',date('Y-m-d H:i:s')) !!}
		@endif

		@if($evento->id == 12)
			{!! Field::textarea('comentario') !!}
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
