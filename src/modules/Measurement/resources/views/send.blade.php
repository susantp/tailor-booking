@foreach ($data as $key => $value)
    <p>{{title_case(str_replace('_', ' ', $key))}}: {{$value}}</p>
@endforeach