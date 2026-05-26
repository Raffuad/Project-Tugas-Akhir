@props(['active', 'href'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 font-bold transition-all duration-200'
            : 'flex items-center px-4 py-2 transition-all duration-200';

$style = ($active ?? false)
    ? 'background:rgba(45,168,74,0.18);color:#6ee89a;border-left:3px solid #2da84a;'
    : 'color:rgba(203,213,225,0.75);border-left:3px solid transparent;';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} style="{{ $style }}"
   onmouseover="this.style.background='rgba(255,255,255,0.07)';this.style.color='#fff';"
   onmouseout="this.style.cssText='{{ $style }}'">
    {{ $slot }}
</a>


