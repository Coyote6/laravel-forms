@props([
	'containerAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
])

<div {{ $containerAttributes }}>
	<textarea {{ $attributes->merge([
		'class' => ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
	]) }}>{{ $slot }}</textarea>
</div>