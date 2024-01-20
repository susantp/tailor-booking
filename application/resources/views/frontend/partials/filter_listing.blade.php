<div class="page-header page-header-small">
    <h3>Filter Listing</h3>
</div>
<div class="filter filter-white checkbox-light">
    <form method="get" action="{{url('/listing/search')}}">
        <?php
        $popular = is_array($search_type) && in_array('popular', $search_type) ? 'checked' : '';
        $featured = is_array($search_type) && in_array('featured', $search_type) ? 'checked' : '';
        $recent = is_array($search_type) && in_array('recent', $search_type) ? 'checked' : '';
        ?>
        <h2>Attributes</h2>
        <div class="checkbox">
            <label><input name='type[]' type="checkbox" {{$recent}} value="recent"> Recent</label>
        </div>
        <div class="checkbox">
            <label><input name='type[]' type="checkbox" {{$featured}} value="featured"> Featured</label>
        </div>
        <div class="checkbox">
            <label><input name='type[]' type="checkbox" {{$popular}} value="popular"> Popular</label>
        </div>
        <div class="form-group">
            <label>keyword</label>
            <input type="text" class="form-control required" name="key" value="{{$key}}">
        </div>		
    </form>
</div>