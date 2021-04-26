<div {{ $form_item_attributes->merge([
    'class' => 'flex items-center'
]) }}>
	
	<div x-data="{ focused: false }" class="py-2">

    	<x-forms-input.only
    		@focus="focused = true"
        	@blur="focused = false"
        	{{ $attributes->merge([
            	'class' => 'sr-only' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')
            ]) }} />
			
		<x-forms-label.only
			:text="$label"
			:textAttributes="$label_text_attributes"
			:colon="$display_colon_tag" 
			:colonAttributes="$colon_tag_attributes"
			:required="$display_required_tag" 
			:requiredAttributes="$required_tag_attributes"
			:attributes="$label_attributes"
			
		></x-forms-label.only>

	</div>
	
	@if ($help_text)
		<div class="relative self-start">
			<x-forms-help :text="$help_text" class="left-5 top-0"></x-forms-help>
		</div>
	@endif
	
	<div class="flex items-center mx-2 relative space-x-2">
		<x-forms-icon.error :display="$display_error_icon" :attributes="$error_icon_attributes"></x-forms-icon.error>
		<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
	</div>
	
</div>