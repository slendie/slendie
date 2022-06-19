            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">{{ env('APP_TITLE') }}</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="@route('admin')">Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="@route('tasks.index')">Tasks</a>
                </div>
            </div>
