@props(['label' => '', 'icon' => null])

<div class="flex items-center gap-2">
    @if (filled($icon))
        <x-filament::icon
            :icon="$icon"
            :alias="$icon"
            class="h-5 w-5"
        />
    @else
        <div class="h-5 w-5"></div>
    @endif
    <span>
        {{ $label }}
    </span>
</div>