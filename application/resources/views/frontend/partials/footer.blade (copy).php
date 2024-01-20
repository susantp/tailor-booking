<div class="footer-wrapper">
    <div class="footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-2 col-md-offset-1">
                        <div class="widget right-border">
                            <h2 class="widgettitle">Links</h2>
                            <ul class="nav nav-stacked">
                                @forelse ($footer_1 as $value)
                                <?php $menu_data = check_menu_links($value); ?>
                                <li class="nav-item"> 
                                    <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}"  class="nav-link">
                                        {{ $value->name }}
                                    </a>
                                </li>
                                @empty
                                <p>No Menu found.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-md-offset-1">
                        <div class="widget right-border">
                            <h2 class="widgettitle">&nbsp;</h2>
                            <ul class="nav nav-stacked">
                                @forelse ($footer_2 as $value)
                                <?php $menu_data = check_menu_links($value); ?>
                                <li class="nav-item"> 
                                    <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}"  class="nav-link">
                                        {{ $value->name }}
                                    </a>
                                </li>
                                @empty
                                <p>No Menu found.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-md-offset-1">
                        <div class="widget right-border">
                            <h2 class="widgettitle">&nbsp;</h2>
                            <ul class="nav nav-stacked">
                                @forelse ($footer_3 as $value)
                                <?php $menu_data = check_menu_links($value); ?>
                                <li class="nav-item"> 
                                    <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}"  class="nav-link">
                                        {{ $value->name }}
                                    </a>
                                </li>
                                @empty
                                <p>No Menu found.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>			
                    <div class="col-xs-12 col-sm-12 col-md-2 col-md-offset-1">
                        <div class="widget">
                            <h2 class="widgettitle">&nbsp;</h2>
                            <ul class="nav nav-stacked">
                                @forelse ($footer_4 as $value)
                                <?php $menu_data = check_menu_links($value); ?>
                                <li class="nav-item"> 
                                    <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}"  class="nav-link">
                                        {{ $value->name }}
                                    </a>
                                </li>
                                @empty
                                <p>No Menu found.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>		
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-left">
                    Powered by: <a href="#">Karma Tech Solutions</a>
                </div>
                <div class="footer-bottom-right">
                    Copyright &copy; {{ date('Y') }} All rights reserved.
                </div>		
            </div>
        </div>
    </div>
</div>