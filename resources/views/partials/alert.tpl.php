                    @if( has_toasts() )
                    @foreach( toasts() as $toast )
                    <div class="alert alert-{{ $toast['level'] }}" role="alert">
                    {{ $toast['message'] }}
                    </div>
                    @endforeach
                    @endif
                    @include('partials.form_errors')
