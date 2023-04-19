@if(count($errors) > 0)
    @foreach( $errors->all() as $message )
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>{{ $message }}</span>
        </div>
    @endforeach
@endif