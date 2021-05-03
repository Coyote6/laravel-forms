<form {{ $attributes->merge([
	'class' => ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
]) }}>
	
	@error ('form')
		<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
	@enderror
	
	@foreach ($fields as $field)
		{{ $field->render() }}
	@endforeach
	
	<div class="actions flex items-center space-x-2.5">
		
		@foreach ($hidden_fields as $field)
			{{ $field->render() }}
		@endforeach
		
		@csrf
		@method($method)
		
	</div>
	
	@if ($has_confirm_field && $is_livewire_form)
		@push('scripts')
			<script>
				Livewire.on('updatedConfirmation', name => {
					var el = document.getElementById(name);
					var	val = el.value;
					@this.set(name, val);
				});
			</script>
		@endpush
	@endif

</form>