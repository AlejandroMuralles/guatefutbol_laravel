@extends('layouts.admin')

@section('title') Eventos @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<h2>
	{{$partido->equipo_local->nombre}} 
	{{$partido->goles_local}} - {{$partido->goles_visita}} 
	@if(!is_null($partido->descripcion_penales)) ({{$partido->descripcion_penales}}) @endif
	{{$partido->equipo_visita->nombre}} 
</h2>
<div class="table-responsive">
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>EVENTO</th>
				<th>MINUTO</th>
				<th>COMENTARIO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($eventos as $evento)
			<tr>
				<td><img src="{{$evento->evento->imagen}}" alt="" height="25px"></td>
				<td>{{$evento->minuto}}</td>
				<td>{{$evento->comentario}}</td>
				<td>
					<a href="{{route($evento->evento->ruta_editar,$evento->id)}}" class="btn btn-warning btn-flat btn-xs">
						<i class="fa fa-edit"></i>
					</a>
					<a href="#" onclick="eliminarEvento({{$evento->id}}, 'Eliminar evento {{$evento->evento->nombre}}'); return false;" class="btn btn-danger btn-flat btn-xs">
						<i class="fa fa-times"></i>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{ route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,0]) }}" class="btn btn-danger btn-flat">Cancelar</a>
</div>
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        {!! Form::open(['route' => array('eliminar_evento',0), 'method' => 'DELETE', 'role' => 'form', 'class'=>'validate-form', 'id'=>'form_eliminar_evento']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Eliminar Evento</h4>
            </div>
            <div class="modal-body">
                <p class="justify">¿Esta seguro que desea eliminar este evento?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Eliminar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div><!-- /.modal -->

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	function eliminarEvento(id,title)
    {
        var ruta = "{{route('inicio')}}" + "/Eliminar-Evento/" + id;
        $('#form_eliminar_evento').attr('action',ruta);
        $('.modal-title').text(title);
        $('#con-close-modal').modal('show');
    }
</script>
@stop
