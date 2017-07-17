@extends('layouts.admin')

@section('title') Editar Jornada @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/select2/select2.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::open(['route' => array('editar_jornada_campeonato',$campeonato->id, $jornadaId), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		
		{!! Field::select('jornada',$jornadas,$jornadaId,['id'=>'jornada_id']) !!}


		@if(isset($partidos))

			<div class="table-responsive">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>FECHA</th>
							<th>HORA</th>
							<th>LOCAL</th>
							<th>VISITA</th>
							<th>ARBITRO</th>
							<th>ESTADIO</th>
						</tr>
					</thead>
					<tbody>
						@foreach($partidos as $partido)
						<tr>
							<td>
								<input type="hidden" name="partidos[{{$partido->id}}][id]" value="{{$partido->id}}">
								<input type="text" name="partidos[{{$partido->id}}][fecha]" 
										value="{{date('Y-m-d',strtotime($partido->fecha))}}" class="form-control fecha" >
							</td>
							<td>
								<div class="input-group" style="width: 250px">
									<div class="bootstrap-timepicker">
			                            <input name="partidos[{{$partido->id}}][hora]"  type="text" class="form-control hora"
			                            		value="{{date('H:i', strtotime($partido->fecha))}}">
			                        </div>
	                        		<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
	                        	</div>
							</td>
							<td>{{$partido->equipo_local->nombre}}</td>
							<td>{{$partido->equipo_visita->nombre}}</td>							
							<td>
								<select name="partidos[{{$partido->id}}][arbitro_id]" class="form-control buscar-select">
									<option value="">Seleccione un arbitro</option>
									@foreach($arbitros as $arbitro)
										@if($arbitro->id == $partido->arbitro_central_id)
											<option value="{{$arbitro->id}}" selected="selected">{{$arbitro->nombreCompletoApellidos}}</option>
										@else
											<option value="{{$arbitro->id}}">{{$arbitro->nombreCompletoApellidos}}</option>
										@endif
									@endforeach

								</select>
							</td>
							<td>
								<select name="partidos[{{$partido->id}}][estadio_id]" class="form-control">
									<option value="">Seleccione un Estadio</option>
									@foreach($estadios as $estadio)
										@if($estadio->id == $partido->estadio_id)
											<option value="{{$estadio->id}}" selected="selected">{{$estadio->nombre}}</option>
										@else
											<option value="{{$estadio->id}}">{{$estadio->nombre}}</option>
										@endif
									@endforeach

								</select>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		@endif

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos',$campeonato->liga_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.js') }}"></script>
<script>
	
$(function()
{
	$('#jornada_id').on('change',function()
	{
		var ruta = '{{route("inicio")}}/Partido/editar-jornada/{{$campeonato->id}}/' + $('#jornada_id').val();
		window.location.href = ruta;
	})

	$('.fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });
    // Time Picker
    $('.hora').timepicker({
    	showMeridian : false
    });

    $('.buscar-select').select2();

});

</script>
@stop