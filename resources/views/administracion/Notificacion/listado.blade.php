@extends('layouts.admin')
@section('title') Notificaciones @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="table-responsive">
			<a href="{{route('agregar_notificacion_articulo')}}" class="btn btn-primary btn-flat">Agregar Ver Articulo</a>

			<div class="btn-group">
				<button type="button" class="btn btn-info">Agregar Ver Tabla Posiciones</button>
				<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu" role="menu">
					@foreach($ligas as $liga)
					<li><a href="{{route('agregar_notificacion_tabla_posiciones',$liga->id)}}" style="color: black;">{{$liga->descripcion}}</a></li>
					@endforeach
				</ul>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-warning">Agregar Ver Calendario</button>
				<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu" role="menu">
					@foreach($ligas as $liga)
					<li><a href="{{route('agregar_notificacion_calendario',$liga->id)}}" style="color: black;">{{$liga->descripcion}}</a></li>
					@endforeach
				</ul>
			</div>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>MENSAJE</th>
						<th>TIPO</th>
						<th>USUARIOS</th>
						<th>DATA</th>
						<th>FECHA</th>
					</tr>
				</thead>
				<tbody>
					@foreach($notificaciones as $notificacion)
					<tr>
						<td>{{$notificacion->mensaje}}</td>
						<td>{{$notificacion->tipo}}</td>
						<td>{{$notificacion->cantidad_usuarios}}</td>
						<td>{{$notificacion->data}}</td>
						<td>{{date('d-m-Y H:i',strtotime($notificacion->created_at))}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('.table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@endsection
