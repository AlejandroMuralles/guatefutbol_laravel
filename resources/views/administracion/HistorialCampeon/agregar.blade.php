@extends('layouts.admin')

@section('title') Agregar Campeon @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::open(['route' => 'agregar_historial_campeon', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('campeonato', null, ['data-required'=> 'true']) !!}
		{!! Field::text('entrenador_campeon', null, ['data-required'=> 'true']) !!}
		{!! Field::text('equipo_campeon', null, ['data-required'=> 'true']) !!}
		{!! Field::text('veces_entrenador', null, ['data-required'=> 'true']) !!}
		{!! Field::text('veces_equipo', null, ['data-required'=> 'true']) !!}
		{!! Field::text('fecha', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
		{!! Field::text('equipo_subcampeon', null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('historial_campeones') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>
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
    
});

</script>
@stop