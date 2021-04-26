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
	<div {{ $field_container_attributes }}>
		<select {!! $attributes !!}>
			@foreach ($options as $option)
				{!! $option !!}
			@endforeach
		</select>
		<x-forms-icon.error.wrapped :display="$display_error_icon" :containerAttributes="$error_icon_container_attributes" :attributes="$error_icon_attributes"></x-forms-icon.error.wrapped>
	</div>
	<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
	<script>
		// Must shutoff for 'selected' for Livewire
		//
		// @see https://github.com/livewire/livewire/issues/998
		// @see https://github.com/livewire/livewire/issues/860
		//
		var options = document.getElementById('{{ $id }}').getElementsByTagName('option');
		for (var i=0;i<options.length;i++) {
			options[i].removeAttribute('selected');
		}
	</script>
</div>

