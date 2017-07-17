@extends('layouts.admin')

@section('title') Agregar Campeonato @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::open(['route' => ['agregar_campeonato',$ligaId], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::select('liga_id',$ligas,$ligaId, null, ['data-required'=> 'true']) !!}
		{!! Field::text('fecha_inicio', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
		{!! Field::text('fecha_fin', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
		{!! Field::text('hashtag') !!}
		{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		{!! Field::checkbox('actual') !!}
		{!! Field::checkbox('mostrar_app') !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos',$ligaId) }}" class="btn btn-danger btn-flat">Cancelar</a>
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