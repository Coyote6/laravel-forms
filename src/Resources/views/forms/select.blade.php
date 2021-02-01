<div class="form-item form-item--{{ $type }}{{ $errors->has($name) ? ' has-error' : '' }}">
	@if ($label) 
		<div class="label-container label-container--{{ $type }}">
			<label for="{{ $id }}" class="label">{{ $label }}:</label>
		</div>
	@endif
	<div class="input-container input-container--{{ $type }}">
		<select {!! $attributes !!}>
			@foreach ($options as $option)
				{{ $option->render() }}
			@endforeach
		</select>
	</div>
	@error ($name)
		<div class="error error-message">{{ $message }}</div>
	@enderror
</div>