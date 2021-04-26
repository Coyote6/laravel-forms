<input {{ $attributes->merge([
	'class' => $attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''
]) }} />	
