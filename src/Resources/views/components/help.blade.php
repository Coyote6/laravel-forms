@if ($text)
	<div x-data="{show:false}" class="relative ml-2"  @mouseover="show = true" @mouseout="show = false">
		<x-forms-icon.help />
		<div x-show="show" {{ $attributes->merge([
			'class' => "text-cool-gray-700 text-sm absolute z-10 bg-white px-3 py-2 rounded-md shadow-md border-cool-gray-300 border border-1 w-60"
		]) }}>{{ $text }}</div>
	</div>
@endif