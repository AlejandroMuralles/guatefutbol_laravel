@extends('layouts.admin')
@section('title') Agregar Tabla Acumulada - {{$liga->nombre}} @endsection
@section('css')
<link href="{{ asset('assets/admin/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
	{!! Form::open(['route' => ['agregar_tabla_acumulada_liga',$liga->id], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		{!! Field::text('descripcion', null, ['data-required'=> 'true']) !!}
		<hr>
		<h4>Campeonatos <a href="#" onclick="agregarCampeonato(); return false;" class="btn btn-primary fa fa-plus"></a></h4>
		<hr>
		<div class="table-responsive">
			<table id="campeonatos" class="table">
				<thead>
					<tr>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<br/>
        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('tablas_acumuladas_ligas',$liga->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script>
	var campeonatos = '';
	var filasActuales = 0;
	$(function(){

		campeonatos += '<option value="">Seleccione</option>';
    	@foreach($campeonatos as $campeonato)
		campeonatos += '<option value="{{$campeonato->id}}">{{$campeonato->nombre}}</option>';
    	@endforeach


	});

	function agregarCampeonato()
    {
    	filasActuales++;
    	var html = '<tr class="campeonato">';
    	html += '<td><select name=campeonatos['+filasActuales+'][id] class="form-control materia" data-required="true" id="campeonato'+filasActuales+'">' + campeonatos + '</select></td>';
        html += '<td><a href="#" class="btn btn-danger btn-sm btn-flat fa fa-times delete"></a></td>'
    	html += '</tr>';
    	$('#campeonatos tr:last').after(html);
    	$("select.buscar-select").select2();
        $(".delete").on('click', function(e) {
            var whichtr = $(this).closest("tr");
            whichtr.remove();      
        });
    }
</script>
@endsection