<div class="header-wrapper">
    <div class="header">
        <div class="header-inner">
            <div class="header-top">
                <div class="container">
                    <a href="{{url('')}}"><img src="{{asset('assets/frontend/img/logo.png')}}" alt="" class="header-top-logo"></a>
                    <div class="nav-primary-wrapper collapse navbar-toggleable-sm">
                        <ul class="nav nav-pills nav-right">
                            <li class="nav-item"><a  class="nav-link "  href="{{ url('') }}"> Home</a></li>
                            {{-- LEVEL 0--}}
                            @foreach($main_menu as $item)
                            <?php $menu_data = check_menu_links($item, ''); ?>
                            <?php $sub = $item->children->count() ? 'has-submenu' : ''; ?>
                            <li class="nav-item <?php echo $sub ?>">
                                <a  class="nav-link " {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
                                    <img src="{{ $menu_data['menu_icon'] }}" alt=""> 
                                    {{ $item->name }}
                                </a>
                                {{-- LEVEL 1--}}
                                @if($item->children->count())
                                <ul  class="submenu">
                                    @foreach($item['children'] as $child)
                                    <?php $menu_data = check_menu_links($child, $item['slug']); ?>
                                    <li>
                                        <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
                                            <img src="{{ $menu_data['menu_icon'] }}" alt=""> 
                                            {{ $child->name }}
                                        </a>
                                        {{-- LEVEL 2--}}
                                        @if($child->children->count())
                                        <ul>
                                            @foreach($child['children'] as $childd)
                                            <?php $menu_data = check_menu_links($childd, $item['slug'] . '/' . $child['slug']); ?>
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
                    </div>
                    <button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="collapse" data-target=".nav-primary-wrapper">
                        <i class="md-icon">menu</i>
                    </button>						
                </div>
            </div>
            @if(!isset($is_home))
            @include('frontend.partials.looking_for')
            @endif
        </div>
    </div>
</div>