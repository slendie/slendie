                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link @is_route('/', 'active')" @is_route('', 'aria-current="page"') href="@route('home')">Home</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/about', 'active')" @is_route('/about', 'aria-current="page"') href="@route('about')">About</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/contact', 'active')" @is_route('/contact', 'aria-current="page"') href="@route('contact')">Contact</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/blog', 'active')" @is_route('/blog', 'aria-current="page"') href="@route('blog')">Blog</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/admin', 'active')" @is_route('/admin', 'aria-current="page"') href="@route('admin')">Admin</a></li>
                    </ul>
                </div>
