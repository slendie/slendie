                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="@route('home')">Home</a></li>
                        @if( auth() )
                        <li class="nav-item"><a class="nav-link" href="@route('admin')">Admin</a></li>
                        @else
                        <li class="nav-item"><a class="nav-link" href="@route('auth.login')">Login</a></li>
                        @endif
                        
                    </ul>
                </div>
