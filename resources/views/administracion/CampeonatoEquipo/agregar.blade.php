@extends('layouts.admin')

@section('title') Agregar Equipos a Campeonato @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<h3>Campeonato {{$campeonato->nombre}}</h3>
<a href="{{route('trasladar_equipos_campeonato', [$campeonato->id, 0])}}" class="btn btn-info btn-flat btn-xs">
	<i class="fa fa-edit"></i> Trasladar Equipos
</a>
<br/><br/>
<div class="table-responsive">
	{!! Form::open(['route' => array('agregar_equipo_campeonato',$campeonato->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="15px"></th>
				<th>NOMBRE</th>				
			</tr>
		</thead>
		<tbody>
			@foreach($equipos as $equipo)
			<tr>
				<td>
					<input type="checkbox" id="{{$equipo->id}}" name="equipos[{{$equipo->id}}][seleccionado]">
					<input type="hidden" name="equipos[{{$equipo->id}}][id]" value="{{$equipo->id}}">
				</td>
				<td>{{$equipo->nombre}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
	<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">
		Regresar
	</a>
	{!! Form::close() !!}
</div>

@stop
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		var table = $('table').DataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});

   		$('#form').on('submit', function(e){
     		var form = this;
			// Iterate over all checkboxes in the table
			table.$('input[type="checkbox"]').each(function(){
			 	// If checkbox doesn't exist in DOM
		 		if(!$.contains(document, this)){
			    	// If checkbox is checked
			    	if(this.checked){
			    		var id = this.id;
			       		// Create a hidden element 
			       		$('#form').append(
			          		$('<input>')
			             	.attr('type', 'hidden')
			             	.attr('name', this.name)
			             	.val(this.value)
		       			);
		       			$('#form').append(
		       				$('<input>')
			             	.attr('type', 'hidden')
			             	.attr('name', 'equipos['+id+'][id]')
			             	.val(id)
		       			);
			    	}
			 	} 
			});
			//alert('hola');
			//e.preventDefault();

   		});

	});


</script>
@stop