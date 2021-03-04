<form {!! $attributes !!}>
	{!! $fields !!}
	<div class="actions">
		{!! $hidden_fields !!}
		@csrf
		@method($method)
		@if ($has_confirm_field)
			@push('scripts')
				<script>
					Livewire.on('updatedConfirmation', name => {
						var el = document.getElementById(name);
						var	val = el.value;
						console.log(val);
						@this.set(name, val);
					});
				</script>
				@endpush
			@endif
	</div>
</form>