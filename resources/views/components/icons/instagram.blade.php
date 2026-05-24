@props(['class' => 'w-5 h-5'])
<svg {{ $attributes->merge(['class'=>$class]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <rect x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>
    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="white"/>
    <path d="M17.5 6.5h.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
</svg>
