@props([
	'display' => false,
	'errorAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'containerAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
])

@if ($display)
	<div {{ $containerAttributes }}>
		<div {{ $errorAttributes }}>{{ $slot }}</div>
	</div>
@endif
