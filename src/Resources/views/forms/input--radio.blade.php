@if ($display_form_item)<div {!! $form_item_attributes !!}>@endif
	@if ($display_label_container)<div {!! $label_container_attributes !!}>@endif
		<label {!! $label_attributes !!}>
			@if ($display_field_container)<div {!! $field_container_attributes !!}>@endif
				<input {!! $attributes !!} />
				@include ('laravel-forms::forms.error-icon')
			@if ($display_field_container)</div>@endif
			@if ($label && $display_label)
				@if ($display_label_text)<span {!! $label_text_attributes !!}>@endif
					@if ($display_colon_tag)<span {!! $colon_tag_attributes !!}>:</span>@endif {{ $label }} @if ($display_required_tag)<span {!! $required_tag_attributes !!}>*</span>@endif
				@if ($display_label_text)</span>@endif
			@endif
		</label>
@if ($display_form_item)</div>@endif