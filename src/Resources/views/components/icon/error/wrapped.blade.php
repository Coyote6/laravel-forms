@props([
	'display' => false,
	'containerAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag()
])


@if ($display)
	<div {{ $containerAttributes }}>
		{{ $slot }}
		<x-forms-icon.error :attributes="$attributes" :display="$display" />
	</div>
@endif
