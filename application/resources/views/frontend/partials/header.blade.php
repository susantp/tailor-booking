<header class="header-site">
      <div class="header-top">
         <div class="container">
            <div class="header-address">
               <ul>
                  <li>Phone: <a href="tel:{{ $settings->phone }} ">{{ $settings->phone }}</a></li>
                  <li class="email"> <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                  <li><a href="{{ $settings->facebook }}" target="_blank"><img src="{{asset('assets/')}}/frontend/images/facebook.png" alt=""></a></li>
               </ul>
            </div>
         </div>
      </div>
      <nav class="navbar navbar-expand-lg">
         <div class="container">
            <a class="navbar-brand" href="{{ url('') }}">
               <img src="{{asset('assets/')}}/frontend/images/logo.png" alt="Scott Ferguson Formalwear - Suit Hire and Suit Sales Adelaide">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav"
               aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggle-icon"></span>
               <span class="navbar-toggle-icon"></span>
               <span class="navbar-toggle-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-home"><a href="{{ url('') }}"> Home</a></li>
                  {{-- LEVEL 0--}}
                  @foreach($main_menu as $item)
                     <?php $menu_data = check_menu_links($item, ''); ?>
                     <?php $sub = $item->children->count() ||$item->id==2 ||$item->id==3 ? 'dropdown' : ''; ?>
                     <?php $dropdown_toggle  = $item->children->count() ||$item->id==2 ||$item->id==3 ? 'dropdown-toggle ' : ''; ?>
                     <li class="nav-item <?php echo $sub ?>">
                        <a  class="{{ $dropdown_toggle}}" {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
                           {{ $item->name }}
                        </a>
                        {{-- LEVEL 1--}}
                        @if($item->id==2 )
                              <ul  class="dropdown-menu">
                                 @foreach($hire as $hr)
                                    <li>
                                       <a href="{{url('/hire/')}}/{{ $hr->category_slug }}">
                                          {{ $hr->category_name }}
                                       </a>
                                    </li>
                                 @endforeach
                              </ul>
                        @elseif($item->id==3 )
                           <ul  class="dropdown-menu">
                              @foreach($retail as $hr)
                                 <li>
                                    <a href="{{url('/retail/')}}/{{ $hr->category_slug }}">
                                       {{ $hr->category_name }}
                                    </a>
                                 </li>
                              @endforeach
                           </ul>
                        @else
                           @if($item->children->count())
                              <ul  class="dropdown-menu">
                                 @foreach($item['children'] as $child)
                                    <?php $menu_data = check_menu_links($child, $item['slug']); ?>
                                    <li>
                                       <a {{ $menu_data['target'] }} href="{{ $menu_data['page_url'] }}">
                                          {{ $child->name }}
                                       </a>
                                    </li>
                                 @endforeach
                              </ul>
                           @endif
                           @endif

                     </li>
                     </li>
                  @endforeach
               </ul>

            </div>
         </div>
      </nav>
      <!-- end nav  -->
   </header>
   <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0" nonce="bjQ3KKHb"></script>