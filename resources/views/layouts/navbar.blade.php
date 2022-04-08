<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
<!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- <notification v-bind:jabatans="jabatans"></notification> -->
        
        @php 
            $book = \App\Booking::where('status', '=', 'baru')->get();
        @endphp
        <li class="nav-item dropdown" id="markasread">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                
                <span class="badge badge-warning navbar-badge" id="">{{ $book->count() }}</span>
                
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                @foreach($book as $row)
                    @if($book)
                    <a class="dropdown-item" >
                    <i class="fas fa-envelope mr-2"></i>
                          Booking Baru ID : {{ $row->id }}
                    </a>
                    @else
                    <a class="dropdown-item" >
                        No Notification
                    </a>
                    @endif
                @endforeach
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i> Logout
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                </form>
            </a>
        </li>
    </ul>
</nav>

<!-- END HEADER DESKTOP-->
