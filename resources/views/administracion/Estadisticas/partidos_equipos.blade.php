@extends('layouts.admin')

@section('title') Partidos por Equipo @stop

@section('content')
	
		{!! Field::select('equipo', $equipos, $equipo1Id, ['data-required'=> 'true', 'id'=>'equipo1Id']) !!}
		{!! Field::selectAll('rival', $equipos, $equipo2Id, ['data-required'=> 'true', 'id'=>'equipo2Id']) !!}
        <p>
            <a href="#" onclick="consultar(); return false;" class="btn btn-primary btn-flat">Buscar</a>
        </p>

        <hr>

        <div class="table-responsive">
        	<table class="table table-responsive">
        		<thead>
        			<tr>
        				<th>EQUIPO</th>
        				<th>JJ</th>
        				<th>JG</th>
        				<th>JE</th>
        				<th>JP</th>
        				<th>GF</th>
        				<th>GC</th>
        				<th>DIF</th>
        			</tr>
        		</thead>
        		@if($equipo1Id != 0 && $equipo2Id != 0 )
        		<tbody>
        			<tr>
        				<td>{{$estadisticas1->equipo->nombre}}</td>
        				<td>{{$estadisticas1->JJ}}</td>
        				<td>{{$estadisticas1->JG}}</td>
        				<td>{{$estadisticas1->JE}}</td>
        				<td>{{$estadisticas1->JP}}</td>
        				<td>{{$estadisticas1->GF}}</td>
        				<td>{{$estadisticas1->GC}}</td>
        				<td>{{$estadisticas1->GF - $estadisticas1->GC}}</td>
        			</tr>
        			<tr>
        				<td>{{$estadisticas2->equipo->nombre}}</td>
        				<td>{{$estadisticas2->JJ}}</td>
        				<td>{{$estadisticas2->JG}}</td>
        				<td>{{$estadisticas2->JE}}</td>
        				<td>{{$estadisticas2->JP}}</td>
        				<td>{{$estadisticas2->GF}}</td>
        				<td>{{$estadisticas2->GC}}</td>
        				<td>{{$estadisticas2->GF - $estadisticas2->GC}}</td>
        			</tr>
        		</tbody>
        		@endif
        	</table>
        </div>

        <div class="table-responsive">
        	<table class="table table-responsive">
        		<thead>
        			<th>CAMPEONATO</th>
                    <th>JORNADA</th>
        			<th>FECHA</th>
        			<th>HORA</th>
        			<th>LOCAL</th>
        			<th>RESULTADO</th>
        			<th>VISITA</th>        			
        		</thead>
        		<tbody>
        			@foreach($partidos as $partido)
						<tr>
                            <td>{{$partido->campeonato->nombre}}</td>
							<td>{{$partido->jornada->nombre}}</td>
							<td>{{date('d-m-Y',strtotime($partido->fecha))}}</td>
							<td>{{date('H:i',strtotime($partido->fecha))}}</td>
							<td>{{$partido->equipo_local->nombre}}</td>
							<td>
								<a href="{{route('ficha',$partido->id)}}" style="font-weight: bold;">{{$partido->goles_local}} - {{$partido->goles_visita}} </a></td>
							<td>{{$partido->equipo_visita->nombre}}</td>
						</tr>
					
        			@endforeach
        		</tbody>
        	</table>
        </div>

@stop
@section('js')
<script>
	function consultar()
	{
		var equipo1 = $('#equipo1Id').val();
		var equipo2 = $('#equipo2Id').val();
		if(equipo1 == '') equipo1 = 0;
		if(equipo2 == '') equipo2 = 0;
		var url = "{{route('inicio')}}/Estadisticas/PartidosXEquipo/{{$ligaId}}/"+equipo1+"/"+equipo2;
		window.location = url;
	}
</script>
@stop

