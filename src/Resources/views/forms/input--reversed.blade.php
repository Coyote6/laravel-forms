<div class="form-item form-item--{{ $type }}">
	<div class="input-container input-container--{{ $type }}">
		<input {!! $attributes !!} />
	</div>
	@if ($label) 
		<div class="label-container label-container--{{ $type }}">
			<label for="{{ $id }}" class="label">{{ $label }}</label>
		</div>
	@endif
	@if ($type != 'radio')
		@error ($name)
			<div class="error error-message">{{ $message }}</div>
		@enderror
	@endif
</div>