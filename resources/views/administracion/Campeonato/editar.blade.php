@extends('layouts.admin')

@section('title') Editar Campeonato @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::model($campeonato, ['route' => array('editar_campeonato', $campeonato->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}

		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::select('liga_id',$ligas, null, ['data-required'=> 'true']) !!}
		{!! Field::text('fecha_inicio', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
		{!! Field::text('fecha_fin', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
        {!! Field::text('hashtag', null, ['data-required'=> 'true']) !!}
        <h3>Menu de Aplicación Movil</h3>
        <div class="row">
            <div class="col-lg-3">{{Field::checkbox('menu_app_calendario')}}</div>
            <div class="col-lg-3">{{Field::checkbox('menu_app_posiciones')}}</div>
            <div class="col-lg-3">{{Field::checkbox('menu_app_tala_acumulada')}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3">{{Field::checkbox('menu_app_goleadores')}}</div>
            <div class="col-lg-3">{{Field::checkbox('menu_app_porteros')}}</div>
            <div class="col-lg-3">{{Field::checkbox('menu_app_plantilla')}}</div>
        </div>
		{!! Field::checkbox('actual') !!}
		{!! Field::checkbox('mostrar_app') !!}
        {!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}
		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos',$campeonato->liga_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
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
