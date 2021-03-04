@if ($display_form_item)<div {!! $form_item_attributes !!}>@endif
	@if ($label && $display_label) 
		@if ($display_label_container)<div {!! $label_container_attributes !!}>@endif
			<label {!! $label_attributes !!}>{{ $label }} @if ($display_colon_tag)<span {!! $colon_tag_attributes !!}>:</span>@endif @if ($display_required_tag)<span {!! $required_tag_attributes !!}>*</span>@endif</label>
		@if ($display_label_container)</div>@endif
	@endif
	@if ($display_field_container)<div {!! $field_container_attributes !!}>@endif
		<button {!! $attributes !!}>{!! $content !!}</button>
		@include ('laravel-forms::forms.error-icon')
	@if ($display_field_container)</div>@endif
	@if ($has_error)
		@if ($display_error_message_container)<div {!! $error_message_container_attributes !!}>@endif
			<div {!! $error_message_attributes !!}>{{ $message }}</div>
		@if ($display_error_message_container)</div>@endif
	@endif
@if ($display_form_item)</div>@endif