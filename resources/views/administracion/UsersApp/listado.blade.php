@extends('layouts.admin')
@section('title') Usuarios App @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="table-responsive">
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>UUID</th>
                <th>PLATAFORMA</th>
                <th>FABRICANTE</th>
                <th>MODELO</th>
                <th>NOTIFICACIONES</th>
                <th>ONE SIGNAL ID</th>
                <th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->uuid}}</td>
                <td>{{$user->plataforma}}</td>
                <td>{{$user->fabricante}}</td>
                <td>{{$user->modelo}}</td>
                <td>{!!$user->descripcion_notificaciones!!}</td>
                <td>{{$user->one_signal_id}}</td>
                <td>
                    <a href="{{route('notificaciones_equipo',$user->id)}}" class="btn btn-warning btn-flat btn-xs" data-toggle="tooltip" 
                        data-placement="top" title="" data-original-title="Notificaciones Equipo">
                        <i class="fa fa-bell"></i>
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
   		$('#table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop