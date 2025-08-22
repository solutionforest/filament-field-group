@props(['label' => '', 'icon' => null])

<div style="display: flex; align-items: center; gap: 0.5rem;">
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