<nav class="site-navbar ms-auto">

<ul class="primary-menu">
    @php
        $primary_menus = App\Models\Primary_menu::where("is_published",1)
        ->where('menu_id',2)
        ->orderBy("no","ASC")
        ->get();
        $submenus = App\Models\Submenu::where("is_published",1)
        ->get();
    @endphp
    @foreach ($primary_menus as $primary_menu)
        <li>
        @php
            if ($primary_menu->route) {
                $href = route($primary_menu->route);
            } elseif ($primary_menu->external_url) {
                $href = $primary_menu->external_url;
            } else {
                $href = '#';
            }
        @endphp
            <a href="{{ $href }}" target="{{ $primary_menu->external_url ? '_blank' : '_self' }}">{{$primary_menu->name}}</a>

            @php
                $filtered_submenus = $submenus->filter(function($submenu) use ($primary_menu) {
                    return $submenu->primary_menu->id == $primary_menu->id;
                });
            @endphp

            @if ($filtered_submenus->isNotEmpty())
                <ul class="submenu">
                    @foreach ($filtered_submenus as $submenu)
                    @php
                        if ($submenu->route) {
                            $href = route($submenu->route);
                        } elseif ($submenu->external_url) {
                            $href = $submenu->external_url;
                        } else {
                            $href = '#';
                        }
                    @endphp
                        <li><a href="{{ $href }}" target="{{ $submenu->external_url ? '_blank' : '_self' }}">{{$submenu->name}}</a></li>
                    @endforeach
                </ul>
            @endif

        </li>
    @endforeach

<a href="#" class="nav-close"><i class="fal fa-times"></i></a>
</nav>