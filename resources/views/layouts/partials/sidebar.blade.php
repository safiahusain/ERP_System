@php
    $data = App\Helper\AuthHelper::createMenu();
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @foreach($data->menu as $menu)
            @include('layouts.partials.menu-item', ['item' => $menu])
        @endforeach
    </ul>
</nav>
