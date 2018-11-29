@extends('layouts.admin')
@section('title') Editar Descuento de Puntos - {{$descuentoPuntos->campeonato->liga->nombre}} @endsection
@section('content')
	{!! Form::model($descuentoPuntos,['route' => ['editar_descuento_puntos',$descuentoPuntos->id], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}	
		{!! Field::text('campeonato', $descuentoPuntos->campeonato->nombre, ['disabled']) !!}
		{!! Field::text('equipo', $descuentoPuntos->equipo->nombre, ['disabled']) !!}
		{!! Field::select('tipo',$tipos, null, ['data-required'=> 'true']) !!}
		{!! Field::number('puntos', null, ['data-required'=> 'true']) !!}
		<br/>
		<p>
			<input type="submit" value="Editar" class="btn btn-primary btn-flat">
			<a href="{{ route('descuento_puntos',$descuentoPuntos->campeonato->liga_id) }}" class="btn btn-danger btn-flat">Cancelar</a>
		</p>
	{!! Form::close() !!}
@endsection