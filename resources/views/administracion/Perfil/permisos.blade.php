@extends('layouts.admin')

@section('title') Editar Permisos - {{$perfil->nombre}} @stop

@section('header') Editar Permisos - {{$perfil->nombre}} @stop

@section('content')

	{!! Form::open(['route' => array('permisos', $perfil->id), 'method' => 'POST', 'role' => 'form', 'class' => 'validate-form']) !!}
		<div class="row">
			<div class="col-lg-12">
				<h3 class="title">Modulos Públicos</h3>
				<div class="ribbon bg-red"></div>
				<br/>
				<div class="row">
					<div class="col-lg-3">
						<ul id="myStacked" class="nav nav-pills nav-stacked">
							@foreach($modulosPublicos as $modulo)
								<li>
									<a href="#{{$modulo->modulo->id}}" data-toggle="tab">
										{{$modulo->modulo->nombre}}
									</a>
                            	</li>
							@endforeach
                        </ul>
                    </div>
                    <div class="col-lg-9">
                    	<div id="myStackedContent" class="tab-content">
                    		@foreach($modulosPublicos as $modulo)
								<div class="tab-pane fade" id="{{$modulo->modulo->id}}">
									<table class="table table-responsive">
										<thead>
											<tr>
												<th>NOMBRE</th>
												<th>
													<input type="checkbox" id="seleccionar-{{$modulo->modulo->id}}">
												</th>
											</tr>
										</thead>
										<tbody>
											@foreach($modulo->vistas as $vista)
											<tr>
												<td style="text-align: left">
													{{$vista->nombre}}
												</td>
												<td style="text-align: content: '';">
													<input type="hidden" name="vistas[{{$vista->id}}][id]" value="{{$vista->id}}">
													<input type="checkbox" name="vistas[{{$vista->id}}][checked]" {{$vista->checked}}>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
                                </div>
                    		@endforeach
                        </div>
                    </div>
                </div>
                <h3 class="title">Modulos de Administración</h3>
				<div class="ribbon bg-red"></div>
				<br/>
                <div class="row">
					<div class="col-lg-3">
						<ul id="myStacked2" class="nav nav-pills nav-stacked">
							@foreach($modulosAdmin as $modulo)
								<li>
									<a href="#{{$modulo->modulo->id}}" data-toggle="tab">
										{{$modulo->modulo->nombre}}
									</a>
                            	</li>
							@endforeach
                        </ul>
                    </div>
                    <div class="col-lg-9">
                    	<div id="myStackedContent2" class="tab-content">
                    		@foreach($modulosAdmin as $modulo)
								<div class="tab-pane fade" id="{{$modulo->modulo->id}}">
									<table class="table table-responsive">
										<thead>
											<tr>
												<th>NOMBRE</th>
												<th>
													<input type="checkbox" id="seleccionar-{{$modulo->modulo->id}}">
												</th>
											</tr>
										</thead>
										<tbody>
											@foreach($modulo->vistas as $vista)
											<tr>
												<td style="text-align: left">
													{{$vista->nombre}}
												</td>
												<td style="text-align: content: '';">
													<input type="hidden" name="vistas[{{$vista->id}}][id]" value="{{$vista->id}}">
													<input type="checkbox" name="vistas[{{$vista->id}}][checked]" {{$vista->checked}}>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
                                </div>
                    		@endforeach
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<br/>

        <p style="text-align: right">
            <input type="submit" value="Enviar" class="btn btn-primary btn-flat">
            <a href="{{ route('perfiles') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

    {!! Form::close() !!}
			
@stop

@section('js')
<script>
    $(function(){

	    $("#myStacked li:eq(0)").addClass("active");
	    $("#myStackedContent div:eq(0)").addClass("in");
	    $("#myStackedContent div:eq(0)").addClass("active");

	    $("#myStacked2 li:eq(0)").addClass("active");
	    $("#myStackedContent2 div:eq(0)").addClass("in");
	    $("#myStackedContent2 div:eq(0)").addClass("active");

	    @foreach($modulosPublicos as $modulo)
	    	$('#seleccionar-{{$modulo->modulo->id}}').click(function(e){
	    		var vistas= $(e.target).closest('table');
	    		$('td input:checkbox', vistas).prop('checked',this.checked);
			});
	    @endforeach
	    @foreach($modulosAdmin as $modulo)
	    	$('#seleccionar-{{$modulo->modulo->id}}').click(function(e){
	    		var vistas= $(e.target).closest('table');
	    		$('td input:checkbox', vistas).prop('checked',this.checked);
			});
	    @endforeach

    });
</script>
@stop