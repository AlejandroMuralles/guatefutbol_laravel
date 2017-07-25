@extends('layouts.admin')

@section('title') Editar Persona @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::model($persona, ['route' => array('editar_persona', $persona->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('primer_nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::text('segundo_nombre') !!}
		{!! Field::text('primer_apellido', null, ['data-required'=> 'true']) !!}
		{!! Field::text('segundo_apellido') !!}
		{!! Field::text('fecha_nacimiento', null, ['data-required'=> 'true', 'class'=>'fecha']) !!}
		{!! Field::select('pais_id',$paises, null, ['data-required'=> 'true']) !!}
		{!! Field::select('departamento_id',$departamentos) !!}
		{!! Field::select('rol',$roles, null, ['data-required'=> 'true']) !!}
		{!! Field::checkbox('portero',null,null,null,$persona->portero) !!}
		{!! Field::select('estado',$estados, null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('personas') }}" class="btn btn-danger btn-flat">Cancelar</a>
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