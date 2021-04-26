@props([
	'containerAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'reverse' => false
])

<div {{ $containerAttributes }}>
	
	@if ($reverse)
		{{ $slot }}
	@endif
	
	<x-forms-input.only {{ $attributes }} />
	
	@if (!$reverse)
		{{ $slot }}
	@endif
	
</div>
