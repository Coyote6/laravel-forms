

<div 
	{{ $form_item_attributes->merge([
    	'class' => 'flex items-center'
	]) }}
	
>
	<div
		x-data="{
			removeImg (id) {
				var input = document.querySelector('input[name=\'{{ $name }}Remove[' + id + ']\']');
				input.value = 1;
				var img = document.querySelector('img[id=\'{{ $name }}Img[' + id + ']\']');
				img.remove();
				var imgButton = document.querySelector('input[name=\'{{ $name }}RemoveButton[' + id + ']\']');
				imgButton.remove();
			}
		}"
	>
		<div>
			@if (!$multifile)
			
				<div>
					@if (!empty ($previews) && is_array ($previews))
						<ul>
							@foreach ($previews as $k => $v)
								<li>
									@if ($v['url']) 
										<a target="_blank" href="{{ $v['url'] }}">
											<img src="{{ $v['preview'] }}" alt="{{ $v['filename'] }} image preview" id="{{ $name }}Img[{{ $k }}]"/>
											@if ($displayFilename)
												<span>{{ $v['filename'] }}</span>
											@endif
										</a>
									@else
										<img src="{{ $v['preview'] }}" alt="{{ $v['filename'] }} image preview" id="{{ $name }}Img[{{ $k }}]"/>
										@if ($displayFilename)
											<span>{{ $v['filename'] }}</span>
										@endif
									@endif
									@if ($livewireModel)
										<x-forms-input.only class="button bg-gray-200 px-3 py-1 rounded cursor-pointer hover:bg-gray-300" type="button" value="Remove" wire:click="removeFile('{{ $livewireModel }}', '{{ $k }}')"/>
									@else
										<x-forms-input.only class="button bg-gray-200 px-3 py-1 rounded cursor-pointer hover:bg-gray-300" type="button" name="{{ $name }}RemoveButton[{{ $k }}]" value="Remove" @click="removeImg({{ $k }})"/>
								        <x-forms-input.only type="hidden" name="{{ $name }}Remove[{{ $k }}]" value="" />
							        @endif
								</li>
							@endforeach
						</ul>
					@endif
				</div>				
	
			@endif
	
			@if ($showUploader)
				<div @class([
					'py-2',
					'hidden' => (!$showUploader)
				])
				wire:loading.class="opacity-50" wire:loading.min.500ms
				>

			    	@if ($livewireModel)
				    	<x-forms-input.only
				    		@focus="focused = true"
				        	@blur="focused = false"
				        	{{ $attributes->merge([
				            	'class' => 'sr-only' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')
				            ]) }} />
							
						<x-forms-label.only
							:text="$label"
							:textAttributes="$label_text_attributes"
							:colon="$display_colon_tag" 
							:colonAttributes="$colon_tag_attributes"
							:required="$display_required_tag" 
							:requiredAttributes="$required_tag_attributes"
							:attributes="$label_attributes"
						></x-forms-label.only>
						<div wire:loading wire:target="{{ $livewireModel }}" class="px-2">Uploading...</div>
					@else
					
						<x-forms-input.only
				        	{{ $attributes->merge([
				            	'class' => ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')
				            ]) }} />
							
					@endif
			
				</div>
			@endif
			
		</div>
		
		@if ($help_text && $showUploader)
			<div class="relative self-start">
				<x-forms-help :text="$help_text" class="left-5 top-0"></x-forms-help>
			</div>
		@endif
		
		<div class="flex items-center mx-2 relative space-x-2">
			<x-forms-icon.error :display="$display_error_icon" :attributes="$error_icon_attributes"></x-forms-icon.error>
			<x-forms-error :display='$has_error' :errorAttributes='$error_message_attributes' :container_attributes='$error_message_container_attributes'>{{ $message }}</x-forms-error>
		</div>
		
		<div>
			@if ($multifile && is_array ($previews))
				<ul>
					@foreach ($previews as $k => $v)
						<li>
							@if ($v['url']) 
								<a target="_blank" href="{{ $v['url'] }}">
									<img src="{{ $v['preview'] }}" alt="{{ $v['filename'] }} image preview" id="{{ $name }}Img[{{ $k }}]"/>
									@if ($displayFilename)
										<span>{{ $v['filename'] }}</span>
									@endif
								</a>
							@else
								<img src="{{ $v['preview'] }}" alt="{{ $v['filename'] }} image preview" id="{{ $name }}Img[{{ $k }}]"/>
								@if ($displayFilename)
									<span>{{ $v['filename'] }}</span>
								@endif
							@endif
							@if ($livewireModel)
								<x-forms-input.only class="button bg-gray-200 px-3 py-1 rounded cursor-pointer hover:bg-gray-300" type="button" value="Remove" wire:click="removeFile('{{ $livewireModel }}', '{{ $k }}')"/>
							@else
								<x-forms-input.only class="button bg-gray-200 px-3 py-1 rounded cursor-pointer hover:bg-gray-300" type="button" name="{{ $name }}RemoveButton[{{ $k }}]" value="Remove" @click="removeImg({{ $k }})"/>
						        <x-forms-input.only type="hidden" name="{{ $name }}Remove[{{ $k }}]" value="" />
					        @endif
						</li>
					@endforeach
				</ul>
			@endif
		</div>
	</div>
</div>
