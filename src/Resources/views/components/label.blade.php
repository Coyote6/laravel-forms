@props([
	'text' => false,
	'reversed' => false,
	'colon' => false,
	'required' => false,
	'textAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'colonAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'requiredAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'containerAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'suffix' => false,
	'helpText' => false
])

@if ($slot != '' || $text || $suffix || $helpText)
	<div {{ $containerAttributes->merge([
		'class' => 'flex justify-between'
	]) }}>
		<x-forms-label.only
			:attributes="$attributes"
			:text="$text"
			:reversed="$reversed"
			:colon="$colon"
			:required="$required"
			:textAttributes="$textAttributes"
			:colonAttributes="$colonAttributes"
			:requiredAttributes="$requiredAttributes"
			:suffix="$suffix"
		>{!! $slot !!}</x-forms-label.only>
		<x-forms-help :text="$helpText" class="right-5 top-0"></x-forms-help>
	</div>
@endif

