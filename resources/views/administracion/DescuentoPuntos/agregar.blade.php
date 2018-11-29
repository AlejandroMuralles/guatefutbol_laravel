@extends('layouts.admin')
@section('title') Agregar Descuento de Puntos - {{$liga->nombre}} @endsection
@section('content')
	{!! Form::open(['route' => ['agregar_descuento_puntos',$liga->id,$campeonatoId], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::select('campeonato_id',$campeonatos, $campeonatoId, ['data-required'=> 'true','id'=>'campeonato']) !!}
		{!! Field::select('equipo_id',$equipos, null, ['data-required'=> 'true']) !!}
		{!! Field::select('tipo',$tipos, null, ['data-required'=> 'true']) !!}
		{!! Field::number('puntos', null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('descuento_puntos',$liga->id) }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@endsection
@section('js')
<script>
	$(function(){
		$('#campeonato').on('change',function(){
			var campeonato = $(this).val();
			if(campeonato == '') campeonato = 0;
			window.location.href = "{{route('inicio')}}/Descuento-Puntos/agregar/{{$liga->id}}/"+campeonato;
		})
	})
</script>
@endsection
