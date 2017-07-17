<div class="form-group">
	{!! Form::label($name, $label) !!}
	{!! $control !!}
	@if($error)
		<div class="callout callout-danger" style="padding: 5px 15px"><!-- DANGER -->
			<strong>{{$error}}</strong>
		</div>
	@endif
</div>