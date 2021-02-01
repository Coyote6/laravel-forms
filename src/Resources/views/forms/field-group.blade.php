<div id="{{ $id }}--fieldgroup" class="field-group field-group--{{ $type }} form-item form-item--{{ $type }}">
	@if ($label) 
		<div class="label-container label-container--{{ $type }}">
			<label for="{{ $id }}" class="label">{{ $label }}:</label>
		</div>
	@endif
	@error ($name)
		<div class="error error-message">{{ $message }}</div>
	@enderror
	<div id="{{ $id }}" class="input-container input-container--{{ $type }}">
		{!! $content !!}
	</div>
</div>