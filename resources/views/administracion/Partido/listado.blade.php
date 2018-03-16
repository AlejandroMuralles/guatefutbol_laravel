@extends('layouts.admin')

@section('title') Partidos del Campeonato {{$campeonato->nombre}}@stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="row">
	<div class="col-lg-4">
		{!! Field::select('jornada',$jornadas,null,['id'=>'jornada']) !!}
	</div>
</div>


<div class="table-responsive">
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>FECHA</th>
				<th>HORA</th>
				<th>LOCAL</th>
				<th></th>
				<th>VISITA</th>
				<th>JORNADA</th>
				<th>ESTADIO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($partidos as $partido)
			<tr class="{{$partido->jornada_id}}">
				<td>{{date('d-m-Y', strtotime($partido->fecha))}}</td>
				<td>{{date('H:i', strtotime($partido->fecha))}}</td>
				<td>{{$partido->equipo_local->nombre}}</td>
				<td>{{$partido->goles_local}} - {{$partido->goles_visita}} </td>
				<td>{{$partido->equipo_visita->nombre}}</td>
				<td>{{$partido->jornada->nombre}}</td>
				<td>{{$partido->estadio->nombre}}</td>
				<td>
					<a href="{{route('editar_partido_campeonato',$partido->id)}}" class="btn btn-warning btn-flat btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="showEliminar({{$partido->id}},'{{$partido->equipo_local->nombre}} vs {{$partido->equipo_visita->nombre}}'); return false;"
						class="btn btn-danger btn-flat btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar">
						<i class="fa fa-times"></i>
					</a>
					<!--<a href="{{route('monitorear',$partido->id)}}" class="btn bg-navy btn-flat btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Monitorear">
						<i class="fa fa-gear"></i>
					</a>-->
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">
		Regresar
	</a>
</div>
<div class="modal modal-flex fade" id="modalEliminarPartido" tabindex="-1" role="dialog" aria-labelledby="flexModalLabel" aria-hidden="true">
    <div class="modal-dialog">
			{!! Form::open(['route' => 'eliminar_partido_campeonato', 'method' => 'DELETE', 'id' => 'form', 'class'=>'validate-form']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Eliminar Partido</h4>
            </div>
            <div class="modal-body">
            	<span id="txtEliminarP"></span>
							<input type="hidden" name="id_eliminar" id="id_eliminar" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		/*$('table').dataTable({
   			"bSort" : true
   		});*/

   		$('#jornada').on('change',function()
   		{
   			if($(this).val()==''){
   				$('tr').show()
   			}
   			else{
   				$('tbody tr').hide()
   				$('tbody tr.'+$(this).val()).show();
   			}
   		});

	});

</script>
<script>
	function showEliminar(id, partido)
	{
		$('#id_eliminar').val(id);
		$('#txtEliminarP').text('¿Seguro que desea eliminar el partido ' + partido);
		$('#modalEliminarPartido').modal('show');
	}
</script>
@stop
