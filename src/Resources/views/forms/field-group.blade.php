<div {{ $form_item_attributes }}>
{{ $label }}
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
	<x-forms-icon.error.wrapped
		:display="$display_error_icon"
		:containerAttributes="$error_icon_container_attributes->merge(['class'=>'items-start mt-1'])"
		:attributes="$error_icon_attributes"
	></x-forms-icon.error.wrapped>
	<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
	<div {{ $field_container_attributes }}>
		<div {{ $attributes }}>
			@foreach ($fields as $field)
				{!! $field->render() !!}
			@endforeach
		</div>
	</div>
</div>