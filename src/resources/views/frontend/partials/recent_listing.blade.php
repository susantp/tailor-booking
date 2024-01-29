<div class="widget">
    <h2 class="widgettitle">Recent Listings</h2>
    <div class="cards-small-wrapper">
        @forelse ($recent_listings as $value)
        <?php $acc_url = get_accommodation_url($value->name,$value->id, $value->type); ?>
        <div class="card-small">
            <div class="card-small-image">
                <a href="{{url($acc_url)}}" style="background-image: url({{asset('assets/')}}/{{$value->cover_image}});"></a>
            </div>
            <div class="card-small-content">
                <h3><a href="{{url($acc_url)}}">{{$value->name}}</a></h3>		
                <!--<h4><a href="detail.php">{{$value->name}}</a></h4>-->
            </div>
        </div>
        @empty
        <p>No Listings found.</p>
        @endforelse
    </div>
</div>