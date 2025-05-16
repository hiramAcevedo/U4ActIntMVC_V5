@props(['header' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden']) }}>
    @if ($header)
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-4">
        {{ $slot }}
    </div>
    
    @if ($footer)
        <div class="p-4 bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endif
</div> 