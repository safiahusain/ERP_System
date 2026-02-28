<li class="nav-item">

    @if(empty($item['children']))

        {{-- Simple menu --}}
        <a class="nav-link" href="{{ route($item['route']) }}">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">{{ ucfirst($item['name']) }}</span>
        </a>

    @else

        {{-- Parent menu --}}
        <a class="nav-link"
        data-toggle="collapse"
        href="#menu-{{ $item['id'] }}"
        aria-expanded="false">

            <i class="menu-icon typcn typcn-folder"></i>
            <span class="menu-title">{{ ucfirst($item['name']) }}</span>
            <i class="menu-arrow"></i>
        </a>

        <div class="collapse" id="menu-{{ $item['id'] }}">
            <ul class="nav flex-column sub-menu">
                @foreach($item['children'] as $child)
                    @include('layouts.partials.menu-item', ['item' => $child])
                @endforeach
            </ul>
        </div>

    @endif

</li>
