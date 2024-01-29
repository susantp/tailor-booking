<p>Welcome to the future.</p>
<p>Menu rendering.</p>
<ul>
    <li><a href="{{ url('') }}"> Home</a></li>
    {{-- LEVEL 0--}}
    @foreach($main_menu as $item)
    <?php $menu_data = check_menu_links($item,''); ?>
    <li>
        <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
            <img src="{{ $menu_data['menu_icon'] }}" alt=""> 
            {{ $item->name }}
        </a>
        {{-- LEVEL 1--}}
        @if($item->children->count())
        <ul>
            @foreach($item['children'] as $child)
            <?php $menu_data = check_menu_links($child,$item['slug']); ?>
            <li>
                <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
                    <img src="{{ $menu_data['menu_icon'] }}" alt=""> 
                    {{ $child->name }}
                </a>
                {{-- LEVEL 2--}}
                @if($child->children->count())
                <ul>
                    @foreach($child['children'] as $childd)
                    <?php $menu_data = check_menu_links($childd,$item['slug'].'/'.$child['slug']); ?>
                    <li>
                        <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
                            <img src="{{ $menu_data['menu_icon'] }}" alt=""> 
                            {{ $childd->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
        @endif
    </li>
</li>
@endforeach
</ul>