@extends('layouts.admin')
@section('title') Estadísticas de Jugadores - {{$liga->nombre}} @if($campeonato) - {{$campeonato->nombre}} @endif @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
    th,td{ text-align: center; }
    .col{width: 100px !important;}
    .sorting_desc:after,.sorting_asc:after{ color: red; }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4">
        {!! Field::selectAll('campeonato',$campeonatos,$campeonatoId,['id'=>'campeonato']) !!}
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table id="table" class="table table-responsive">
			<thead>
				<tr>
                    <th class="col">POS</th>
					<th>JUGADOR</th>
					<th class="col">AP</th>
					<th class="col">MJ</th>
					<th class="col">G</th>
					<th class="col">A</th>
					<th class="col">AA</th>
					<th class="col">R</th>					
					<th class="col">GANADOS</th>
					<th class="col">EMPATADOS</th>
					<th class="col">PERDIDOS</th>
				</tr>
            </thead>
            <tbody>
                @foreach($jugadores as $jugador)
                    <tr>
                        <td class="col"></td>
                        <td>{{$jugador->nombre_completo_apellidos}}</td>
                        <td class="col">{{$jugador->apariciones}}</td>
                        <td class="col">{{$jugador->minutos_jugados}}</td>
                        <td class="col">{{$jugador->goles + 0}}</td>
                        <td class="col">{{$jugador->amarillas - $jugador->dobles_amarillas}}</td>
                        <td class="col">{{$jugador->dobles_amarillas + 0}}</td>
                        <td class="col">{{$jugador->rojas + 0}}</td>
                        <td class="col">{{$jugador->ganados + 0}}</td>
                        <td class="col">{{$jugador->empatados + 0}}</td>
                        <td class="col">{{$jugador->perdidos + 0}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')

<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		var t = $('#table').DataTable({
   			"bSort" : true,
            "iDisplayLength" : 20,
		    "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
            "aaSorting" : [[4, 'desc']],
   		});

           t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            $('#campeonato').on('change',function(){
                var campeonato = $(this).val();
                window.location.href = "{{route('inicio')}}/Estadisticas/Jugadores/{{$ligaId}}/" + campeonato;
            });

    });
    

</script>
@endsection