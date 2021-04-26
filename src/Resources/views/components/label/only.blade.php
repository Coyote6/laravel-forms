@props([
	'text' => false,
	'reversed' => false,
	'colon' => false,
	'required' => false,
	'textAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'colonAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'requiredAttributes' => new \Coyote6\LaravelForms\Form\AttributeBag(),
	'suffix' => false
])

@if ($slot != '' || $text || $suffix)
	<label
		{{ $attributes->merge([
	        'class' => ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
	    ]) }}
	>
		{{ $slot }}
		
		@if ($text)
			@if ($reversed)
			
				<span {{ $text_attributes }}>
					@if ($colon)
						<span {{ $colon_attributes }}>:</span>
					@endif 
					{!! $text !!} 
					@if ($required)
						<span {{ $required_attributes }}>*</span>
					@endif
				</span>
				
			@else 
			
				<span {{ $textAttributes }}>
					{!! $text !!} 
					@if ($required)
						<span {{ $requiredAttributes }}>*</span>
					@endif
					@if ($colon)
						<span {{ $colonAttributes }}>:</span>
					@endif 
				</span>
				
			@endif
		@endif
		
		{{ $suffix }}
		
	</label>
@endif
