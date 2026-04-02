@php
    $isActive = false;

    // ✅ Check self route (for single menu like dashboard)
    if (!empty($item['route']) && request()->routeIs($item['route'])) {
        $isActive = true;
    }

    // ✅ Check children routes
    if (!empty($item['children'])) {
        foreach ($item['children'] as $child) {
            if (request()->routeIs($child['route'])) {
                $isActive = true;
                break;
            }
        }
    }

    // ✅ Default Icon (you can later make dynamic)
    $icon = $item['icon'] ?? 'mdi mdi-view-dashboard';
@endphp

<li class="nav-item {{ $isActive ? 'active' : '' }}">

    @if(empty($item['children']))

        {{-- ✅ Simple menu --}}
        <a class="nav-link {{ $isActive ? 'active' : '' }}"
           href="{{ isset($item['route']) ? route($item['route']) : '#' }}">

            <i class="menu-icon {{ $icon }}"></i>
            <span class="menu-title">{{ ucfirst($item['name']) }}</span>
        </a>

    @else

        {{-- ✅ Parent menu --}}
        <a class="nav-link menu-toggle {{ $isActive ? 'active' : '' }}"
           href="#menu-{{ $item['id'] }}"
           data-bs-toggle="collapse"
           aria-expanded="{{ $isActive ? 'true' : 'false' }}">

            <i class="menu-icon {{ $icon }}"></i>
            <span class="menu-title">{{ ucfirst($item['name']) }}</span>
            <i class="menu-arrow"></i>
        </a>

        {{-- ✅ Submenu --}}
        <div class="collapse {{ $isActive ? 'show' : '' }}" id="menu-{{ $item['id'] }}">
            <ul class="nav flex-column sub-menu">
                @foreach($item['children'] as $child)
                    @include('layouts.partials.menu-item', ['item' => $child])
                @endforeach
            </ul>
        </div>

    @endif

</li>
