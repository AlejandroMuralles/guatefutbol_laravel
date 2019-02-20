@extends('layouts.admin')
@section('title') Listado de Anuncios @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="table-responsive">
	<a href="{{route('agregar_anuncio')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="table" class="table table-bordered">
		<thead>
			<tr>
                <th>PANTALLA APP</th>
                <th>ANUNCIANTE</th>
                <th>NOMBRE ANUNCIANTE</th>
				<th>TIPO</th>
				<th>SEGUNDOS MOSTRANDOSE</th>
                <th>MINUTOS ESPERA</th>
                <th>IMAGEN</th>
                <th>LINK</th>
                <th>ESTADO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($anuncios as $anuncio)
			<tr>
                <td>{{$anuncio->descripcion_pantalla_app}}</td>
                <td>{{$anuncio->descripcion_anunciante}}</td>
                <td>{{$anuncio->nombre_anunciante}}</td>
                <td>{{$anuncio->descripcion_tipo}}</td>
                <td>{{$anuncio->segundos_mostrandose}}</td>
                <td>{{$anuncio->minutos_espera}}</td>
                <td><img src="{{$anuncio->imagen}}" style="width: 25px; height: 25px"></td>
                <td>{{$anuncio->link}}</td>
                <td>{{$anuncio->descripcion_estado}}</td>
				<td>
					<a href="{{route('editar_anuncio',$anuncio->id)}}" class="btn btn-warning btn-flat btn-xs">
						Editar
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('#table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@endsection