<div {{ $form_item_attributes }}>
	<x-forms-label 
		:text="$label" 
		:attributes="$label_attributes"
		:textAttributes="$label_text_attributes"
		:colon="$display_colon_tag" 
		:colonAttributes="$colon_tag_attributes"
		:required="$display_required_tag" 
		:requiredAttributes="$required_tag_attributes"
		:containerAttributes="$label_container_attributes"
		:helpText="$help_text"
	></x-forms-label>
	<x-forms-input :attributes="$attributes" :containerAttributes="$field_container_attributes">
		<x-forms-icon.error.wrapped :display="$display_error_icon" :containerAttributes="$error_icon_container_attributes" :attributes="$error_icon_attributes"></x-forms-icon.error.wrapped>
	</x-forms-input>
	<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
	@push('scripts')
		<script>
		    var picker = new Pikaday({ 
			    field: document.getElementById('{{ $name }}'),
			    format: '{{ $format }}',
			});
		</script>
	@endpush
</div>
