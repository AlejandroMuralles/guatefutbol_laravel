@extends('layouts.admin')

@section('title') Agregar Jornada @stop

@section('css')
<link href="{{ asset('assets/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
@stop

@section('content')

	{!! Form::open(['route' => array('agregar_jornada_campeonato', $campeonato->id, $numeroPartidos), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		
		{!! Field::select('numero_partidos',[1=>1,2=>2,3=>3,4=>4,5=>5,6=>6], $numeroPartidos,['id'=>'numeroPartidos','data-required'=>'true']) !!}

		{!! Field::select('jornada_id',$jornadas, null, ['data-required'=>'true']) !!}

		

		<div class="row">
			<div class="col-lg-6">
				{!! Field::text('fecha',date('Y-m-d'),['class'=>'fecha'] ) !!}
			</div>
			<div class="col-lg-6">
				<label for="hora">Hora</label>
				<div class="input-group" style="width: 250px">
					<div class="bootstrap-timepicker">
		                <input name="hora"  type="text" class="form-control hora" value="{{ date('0:0') }}">
		            </div>
		    		<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
		    	</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				
				<div class="table-responsive">
					<table class="table table-responsive">
						
						<tr>
							<th>LOCAL</th>
							<th>VISITA</th>
							<th>ESTADIO</th>
						</tr>

						@for ($i = 0; $i < $numeroPartidos; $i++)
				    
						<tr>
							<td>
								<select name="partidos[{{$i}}][local]" class="form-control" data-required="true">
									<option value="">Seleccione</option>
									@foreach($equipos as $equipo)
									<option value="{{$equipo->id}}">{{$equipo->nombre}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="partidos[{{$i}}][visita]" class="form-control" data-required="true">
									<option value="">Seleccione</option>
									@foreach($equipos as $equipo)
									<option value="{{$equipo->id}}">{{$equipo->nombre}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="partidos[{{$i}}][estadio]" class="form-control" data-required="true">
									<option value="">Seleccione</option>
									@foreach($estadios as $estadio)
										@if($estadio->id == 41)
										<option value="{{$estadio->id}}" selected>{{$estadio->nombre}}</option>
										@else
										<option value="{{$estadio->id}}">{{$estadio->nombre}}</option>
										@endif
									@endforeach
								</select>
							</td>
						</tr>

						@endfor

					</table>
				</div>

				

			</div>
		</div>

		

    	<br/>

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
<script>
	
$(function()
{
	$('#numeroPartidos').on('change',function()
	{
		var numero = $('#numeroPartidos').val();
		if($('#numeroPartidos').val() == '')
			numero = 0;

		var ruta = '{{route("inicio")}}/Partido/agregar-jornada/{{$campeonato->id}}/' + numero;
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

});

</script>
@stop