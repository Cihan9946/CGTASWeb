<li class="nav-item dropdown">
    @foreach($menu->getSubmenus as $submenu)
    <a class="nav-link dropdown-toggle" href="@if($menu->getPage) {{ route('page', $menu->getPage->id) }} @endif" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ $menu->name }} </a>
    <ul class="dropdown-menu">
            @if($submenu->getSubmenus->count() > 0)
                @include('Submenu', ['menu' => $submenu])
            @else
                <li><a class="dropdown-item" href="">{{ $submenu->name }}</a></li>
            @endif
        @endforeach
    </ul>
</li>
