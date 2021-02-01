<div class="form-item form-item--{{ $type }}">
	@if ($label) 
		<div class="label-container label-container--{{ $type }}">
			<label for="{{ $id }}" class="label">{{ $label }}:</label>
		</div>
	@endif
	<div class="input-container input-container--{{ $type }}">
		<textarea {!! $attributes !!}>{{ $value }}</textarea>
	</div>
	@error ($name)
		<div class="error error-message">{{ $message }}</div>
	@enderror
</div>