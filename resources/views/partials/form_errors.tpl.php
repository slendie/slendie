                    @if( has_errors() )
                    <div class="alert alert-danger" role="alert">
                    @foreach( errors() as $error )
                    <span class="text-danger">{{ $error }}</span><br>
                    @endforeach
                    </div>
                    @endif
