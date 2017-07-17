@extends('layouts.admin')

@section('title') Agregar Personas a Equipo de Campeonato @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<h3>Campeonato {{$campeonatoEquipo->campeonato->nombre}} - {{$campeonatoEquipo->equipo->nombre}}</h3>
<div class="table-responsive">
	{!! Form::open(['route' => array('agregar_personas_equipo',$campeonatoEquipo->id), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
	<table class="table table-bordered">
		<thead>
			<tr>
				<th></th>
				<th>NOMBRE</th>		
				<th>ROL</th>		
			</tr>
		</thead>
		<tbody>
			@foreach($personas as $persona)
			<tr>
				<td>
					<input type="checkbox" name="personas[{{$persona->id}}][seleccionado]" value="{{$persona->id}}">
					<input type="hidden" name="personas[{{$persona->id}}][id]" value="{{$persona->id}}">
				</td>
				<td>{{$persona->nombreCompleto}}</td>
				<td>{{$persona->descripcion_rol}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
	<a href="{{route('editar_equipos_campeonato',$campeonatoEquipo->campeonato->id)}}" class="btn btn-danger btn-flat">
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
   		var personas = $('.table').dataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});

   		$('#form').on('submit', function(e){
   			//alert('submit');
			var form = this;
	      	// Iterate over all checkboxes in the table
	      	personas.$('input[type="checkbox"]').each(function(){
         	// If checkbox doesn't exist in DOM
     			if(!$.contains(document, this)){
	            	// If checkbox is checked
	            	if(this.checked){
	            		//alert(this.name);
	            		//alert(this.value);
	               	// Create a hidden element 
	               		$(form).append(
	                  	$('<input>')
	                     	.attr('type', 'hidden')
	                     	.attr('name', this.name)
	                     	.val('on')
	               		);
	               		$(form).append(
	                  	$('<input>')
	                     	.attr('type', 'hidden')
	                     	.attr('name', 'personas['+this.value+'][id]')
	                     	.val(this.value)
	               		);

	            	}
	         	} 
	      	});
	   	});
	});
</script>
@stop