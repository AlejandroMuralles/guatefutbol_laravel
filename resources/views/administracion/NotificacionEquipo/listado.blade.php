@extends('layouts.admin')
@section('title') Notificaciones por Equipo - {{$userApp->uuid}} @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="table-responsive">
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>EQUIPO</th>
			</tr>
		</thead>
		<tbody>
			@foreach($notificaciones as $notificacion)
			<tr>
				<td>
                    <img src="{{$notificacion->equipo->logo}}" height="35px">
                    {{$notificacion->equipo->nombre}}
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
   		$('#table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop