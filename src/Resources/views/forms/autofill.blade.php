<div {{ $form_item_attributes }}>
	<x-forms-label 
		:text="$label" 
		:attributes="$label_attributes"
		:textAttributes="$label_text_attributes"
		:colon="$display_colon_tag" 
		:colonAttributes="$colon_tag_attributes"
		:required="$display_required_tag" 
		:requiredAttributes="$required_tag_attributes"
		:containerAttributes="$label_container_attributes"
		:helpText="$help_text"
	></x-forms-label>
	
	<div>
		@if (count ($selected) > 0)
			<ul class="flex justify-start flex-wrap">
				@foreach ($selected as $id => $name)
					<li class="text-cool-gray-800 bg-cool-gray-300 border border-cool-gray-800 rounded-md px-2 py-1 my-2 mr-2 last:mr-0">
						<span>{{ $name }}</span>
						<span class="text-red-500 inline-block pl-2" wire:click="{{ $remove_method }}('{{$id}}')">
							<svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							<span class="sr-only">Remove</span>
						</span>
					</li>
				@endforeach
			</ul>
		@endif
	</div>
	
	<x-forms-input 
		:attributes="$attributes" 
		:containerAttributes="$field_container_attributes" 
		@focus="showSuggestions = true;"
		wire:loading.class="border-green-300 focus:border-green-300 focus:shadow-outline-green"
		wire:loading.class.remove="border-blue-300 focus:border-blue-300 focus:shadow-outline-blue"
	>
		<x-forms-icon.error.wrapped :display="$display_error_icon" :containerAttributes="$error_icon_container_attributes" :attributes="$error_icon_attributes"></x-forms-icon.error.wrapped>
		<div x-show="showSuggestions" class="relative" @hover="showSuggestions=true">
			<div class="w-full absolute z-10 -mt-1">
				@if ($suggestion_count > 0)
					<ul class="bg-white rounded-b-md border border-cool-gray-300 mb-2">
						@foreach ($suggestions as $id => $name)
							<li class="px-4 py-4 hover:bg-cool-gray-300 cursor-pointer" wire:click="{{ $selected_method }}('{{ $id }}', '{{ $name }}')" @click="showSuggestions = false">{{ $name }}</li>
						@endforeach
						@if ($all_suggestions_count > 50) 
							<li class="px-4 py-4">{{ $more_results_message }}</li>
						@endif

					</ul>
				@elseif (!is_null ($search) && $search != '' && $sameSearch && count ($selected) > 0)
					<p class="bg-white text-green-500 px-4 py-4 rounded-b-md border border-cool-gray-300">{{ $no_more_current_results_message }}</p>
				@elseif (!is_null ($search) && $search != '')
					<p class="bg-white text-red-500 px-4 py-4 rounded-b-md border border-cool-gray-300">{{ $no_search_results_message }}</p>
				@elseif (count ($selected) > 0)
					<p class="bg-white text-green-500 px-4 py-4 rounded-b-md border border-cool-gray-300">{{ $no_more_results_message }}</p>)
				@else
					<p class="bg-white text-red-500 px-4 py-4 rounded-b-md border border-cool-gray-300">{{ $no_results_message }}</p>
				@endif
			</div>
		</div>
	</x-forms-input>

	<div x-data="{lwAlert:false}">
		<p x-show="lwAlert" class="text-red-500">This field requires Livewire to run.</p>
	</div>

	@if ($selectionsAllowed !== 0 && count ($selected) >= $selectionsAllowed)
		<div class="text-xs text-green-500 block mt-2">{{ $max_selections_message }}</div>
	@endif	
		
	<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
</div>