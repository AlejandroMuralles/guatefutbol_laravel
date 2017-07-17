@extends('layouts.admin')

@section('title') Agregar Partido @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/select2/select2.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::open(['route' => array('agregar_partido_campeonato',$campeonato->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::select('equipo_local_id',$equipos, null, ['data-required'=> 'true']) !!}
		{!! Field::select('equipo_visita_id',$equipos, null, ['data-required'=> 'true']) !!}
		{!! Field::select('arbitro_central_id',$arbitros, null, ['class'=>'buscar-select']) !!}
		{!! Field::text('fecha', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
		<label for="hora">Hora</label>
		<div class="input-group" style="width: 250px">
			<div class="bootstrap-timepicker">
                <input name="hora"  type="text" class="form-control hora" value="">
            </div>
    		<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
    	</div>
    	<br/>
		{!! Field::select('jornada_id',$jornadas, null, ['data-required'=> 'true']) !!}
		{!! Field::select('estadio_id',$estadios) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos',$campeonato->liga_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.js') }}"></script>
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

    $('.buscar-select').select2();
    
});

</script>
@stop