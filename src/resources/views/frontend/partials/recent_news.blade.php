<div class="widget">
    <h2 class="widgettitle">Recent News</h2>
    <div class="cards-small-wrapper">
        @forelse ($recent_news as $value)
        <?php $news_url = url('news/' . $value->slug) ?>
        <div class="card-small">
            <div class="card-small-image">
                <a href="{{url($news_url)}}" style="background-image: url({{asset('assets/')}}/{{$value->image}});"></a>
            </div>
            <div class="card-small-content">
                <h3><a href="{{url($news_url)}}">{{$value->title}}</a></h3>		
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>