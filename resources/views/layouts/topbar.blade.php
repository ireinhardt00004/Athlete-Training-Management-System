  <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow mx-1" wire:poll>
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:click="$refresh"><i class="fas fa-bell fa-fw" style="font-size: 25px;"></i>
                    @livewire('notification-badge')
            </a>
            
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h5 style="background-color: blue; color: white;">
                    Notifications
                </h5>
                    @livewire('notification-panel')
            </div>
        </li>
            <!-- Nav Item - Messages -->
         <li class="nav-item dropdown no-arrow mx-1" wire:poll>
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:click="$refresh">  <i class="fas fa-envelope fa-fw" style="font-size: 25px;"></i>
                   <!-- Counter - Messages -->
                @livewire('unseen-messages-counter')
            </a>
                  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h5 style="background-color: blue; color: white;">
                    Message Center
                </h5>
                    @livewire('message-panel')
            </div>
                  
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mr-2 d-none d-lg-inline text-gray-800 small" style="color: black; font-size: 19px;"><b>{{ Auth::user()->fname }} {{ Auth::user()->lname }}</b></span>
                            @if (Auth::user()->avatar)
                                <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->avatar) }}">

                            @else
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('img/undraw_profile.svg') }}">
                            @endif
                    </a>
                <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                         @auth
                        @if (auth()->user()->hasRole('user'))
                         <a class="dropdown-item" href="{{ route('my-profile', ['id' => auth()->user()->id]) }}"style="color: black; font-size: 15px;"><i class="fas fa-user fa-sm fa-fw mr-2 text-black-800"></i>
                                 Profile
                         </a>
                        @endauth @endif
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"style="color: black; font-size: 15px;"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-black-800"></i>
                                Settings
                        </a>
                        @auth
                        @if (auth()->user()->hasRole('admin'))
                        <a class="dropdown-item" href="{{ route('clearCache') }}" style="color: black; font-size: 15px;"><i class="fas fa-trash fa-sm fa-fw mr-2 text-black-800"></i>
                                Clear Cache
                        </a>
                        @endauth @endif
                                
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" style="color: black; font-size: 15px;">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-800"></i>
                                Logout
                         </a>
                    </div>
                 </li>
            </ul>
        </nav>
<!-- End of Topbar -->

   <!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: black;">Are you sure you want to log out?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <h5 style="color: black;">Logging out will end your current session.</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
