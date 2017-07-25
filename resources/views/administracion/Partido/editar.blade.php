@extends('layouts.admin')

@section('title') Editar Partido @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::model($partido, ['route' => array('editar_partido_campeonato',$partido->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::select('equipo_local_id',$equipos, null, ['data-required'=> 'true']) !!}
		{!! Field::select('equipo_visita_id',$equipos, null, ['data-required'=> 'true']) !!}
		{!! Field::select('arbitro_central_id',$arbitros) !!}
		{!! Field::text('fecha', date('Y-m-d',strtotime($partido->fecha)), ['data-required'=> 'true', 'class'=>'fecha']) !!}
		<label for="">Hora</label>
		<div class="input-group">
			<div class="bootstrap-timepicker">
                <input name="hora" value="{{date('H:i',strtotime($partido->fecha))}}"  type="text" class="form-control hora">
            </div>
    		<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
    	</div>
    	<br/>
		{!! Field::select('jornada_id',$jornadas, null, ['data-required'=> 'true']) !!}
		{!! Field::select('estadio_id',$estadios) !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos',$partido->campeonato->liga_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>
<script>
	
$(function()
{
	$('.fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });

    $('.hora').timepicker({
    	showMeridian : false
    });
    
});

</script>
@stop