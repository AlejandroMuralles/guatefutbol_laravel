@extends('layouts.admin')

@section('title') Personas @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
tfoot input {
    width: 100%;
    padding: 3px;
    box-sizing: border-box;
}
tfoot.search {
    display: table-header-group;
}
</style>
@stop


@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_persona')}}" class="btn bg-navy">Agregar</a>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE COMPLETO</th>
				<th>ROL</th>
				<th>FECHA NACIMIENTO</th>
				<th>PAIS</th>
				<th>DEPARTAMENTO</th>
				<th></th>
			</tr>
		</thead>
		<tfoot class="search">
			<tr>
				<th class="searchField">NOMBRE COMPLETO</th>
				<th class="searchField">ROL</th>
				<th class="searchField">FECHA NACIMIENTO</th>
				<th class="searchField">PAIS</th>
				<th class="searchField">DEPARTAMENTO</th>
				<th></th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($personas as $persona)
			<tr>
				<td>{{$persona->nombreCompleto}}</td>
				<td>{{$persona->descripcion_rol}}</td>
				<td>{{date('d/m/Y',strtotime($persona->fecha_nacimiento))}}</td>
				<td>{{$persona->pais->nombre}}</td>
				<td>@if(!is_null($persona->departamento)) {{$persona->departamento->nombre}} @endif</td>
				<td>
					<a href="{{route('editar_persona',$persona->id)}}" class="btn btn-warning btn-flat btn-xs">
						Editar
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
	    // Setup - add a text input to each footer cell
	    $('.table tfoot th.searchField').each( function () {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
	    } );
	 
	    // DataTable
	    var table = $('.table').DataTable();
	 
	    // Apply the search
	    table.columns().every( function () {
	        var that = this;
	 
	        $( 'input', this.footer() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	} );
</script>
@stop