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
		:helpText="($label) ? $help_text : false"
	></x-forms-label>
	<div {{ $field_container_attributes }}>
		<x-forms-button {{ $attributes }}>
			{!! $content !!}
		</x-forms-button>
		<x-forms-icon.error.wrapped :display="$display_error_icon" :containerAttributes="$error_icon_container_attributes" :attributes="$error_icon_attributes"></x-forms-icon.error.wrapped>
		@if (!$label && $help_text)
			<x-forms-help :text="$help_text" class="left-5 top-0"></x-forms-help>
		@endif
	</div>
	<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
</div>
