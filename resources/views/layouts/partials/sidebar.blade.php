<aside class="sidebar">
    <ul class="sidebar__menu">
        @foreach($sidebarItems as $sidebarItem)
            <li class="sidebar__menu-item {{ Request::is($sidebarItem['prefix']) ? 'sidebar__menu-item--active' : '' }}">
                <a class="sidebar__menu-item-link" href="{{ $sidebarItem['url'] }}">
                    {{ $sidebarItem['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</aside>
