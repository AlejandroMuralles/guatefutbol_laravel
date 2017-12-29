@extends('layouts.publico')

@section('css')
<link href="{{ asset('assets/public/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')

<div class="portlet portlet-default">
	<div class="portlet-heading">
		@if($configuracion->parametro3)
		<div class="portlet-title" style="float: right;">
			<h4><i class="fa fa-refresh"></i> <span id="txtActualizar"></span></h4>
		</div>
		@endif
		<div class="portlet-title">
			<h4>Tabla de Guardametas - {{$campeonato->nombre}} </h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-lg-6">
				{!! Field::select('campeonato',$campeonatos,$campeonato->id) !!}
			</div>
		</div>
		<center>
			<a href="{{route('posiciones',[$campeonato->liga_id,$campeonato->id])}}" class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Posiciones</a>
			<a href="{{route('goleadores',[$campeonato->liga_id,$campeonato->id])}}" class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Goleadores</a>
			@if($campeonato->liga_id == 21)
			<a href="{{route('campeones',[$campeonato->liga_id,$campeonato->id])}}" class="btn btn-gray btn-sm gray-gradient round-border">Campeones</a>
			@endif
		</center>
		<br/><br/>
		<div class="table-responsive">
			<table class="table watermark">
				<thead>
					<tr class="text-center">
						<th class="text-center gray-gradient">GUARDAMETA</th>
						<th class="text-center gray-gradient">EDAD</th>
						<th class="text-center gray-gradient">EQUIPO</th>
						<th class="text-center gray-gradient">PROMEDIO</th>
						<th class="text-center gray-gradient">GC</th>
						<th class="text-center gray-gradient">JJ</th>
						<th class="text-center gray-gradient">MJ</th>
						<th class="text-center gray-gradient">%</th>
					</tr>
				</thead>
				<tbody>
					@foreach($porteros as $portero)
					<tr>
						<td>{{$portero->persona}}</td>
						<td class="text-center">{{$portero->edad}}</td>
						<td class="text-center">{{$portero->equipo}}</td>
						<td class="text-center">{{number_format((float)$portero->promedio, 2, '.', '')}}</td>
						<td class="text-center">{{$portero->goles}}</td>
						<td class="text-center">{{number_format((float)$portero->partidosJugados, 2, '.', '')}}</td>
						<td class="text-center">{{$portero->minutos_jugados}}</td>
						<td class="text-center">{{number_format((float)$portero->porcentaje, 2, '.', '')}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/public/js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/public/js/plugins/datatables/datatables-bs3.js') }}" type="text/javascript"></script>
<script>
	var segundos = 0;

	$(function(){

		@if($configuracion->parametro3)
			segundos = {{$configuracion->parametro1}};
 			actualizar();
		@endif

		$('.table').dataTable({
			"bSort" : false,
			"bPaginate": false,
			"bFilter": false,
			"bInfo": false,
   			"iDisplayLength" : 20,
		});

		$('select').on('change', function () {
          var url = '{{route("inicio")}}/porteros/{{$campeonato->liga_id}}/'+ $(this).val();
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });

	})

	function actualizar(){
    	if(segundos > 0){
    		segundos = segundos - 1;
    		$('#txtActualizar').text(segundos);
    		setTimeout("actualizar()",1000)
        }
        else{
        	window.location.reload();
        }
    }
</script>

@stop
