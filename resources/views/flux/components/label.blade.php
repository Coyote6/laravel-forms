
@blaze

<flux:label {{ $attributes }}>
    {!! $content !!}
    @if ($isRequired && $displayRequiredTag)
        <span class="text-red-500">&nbsp;*</span>
    @endif
</flux:label>
 