<div>
    @if(request()->routeIs('login'))
        <img src={{ asset('images/brasao_capao_bonito.png') }} class="h-36" />
    @else
    <img src={{ asset('images/brasao_capao_bonito.png') }} class="h-14" />
    @endif
</div>

