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
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->uuid}}</td>
                <td>{{$user->plataforma}}</td>
                <td>{{$user->fabricante}}</td>
                <td>{{$user->modelo}}</td>
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