    <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                @if (Auth::user()->avatar)   
                <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->avatar) }}" style="width:40px; height: 35px;">    
            @else
                <img class="img-profile rounded-circle" src="{{ asset('assets/img/default-pfp.png') }}">
            @endif

            </div>

                @auth
                @if (auth()->user()->hasRole('admin'))
                 <div class="sidebar-brand-text mx-3"> Hi Admin {{ Auth::user()->fname }} !</div>
                @endif
                @endauth
                @auth
                @if (auth()->user()->hasRole('coach'))
                 <div class="sidebar-brand-text mx-3"> Hi Coach {{ Auth::user()->fname }} !</div>
                @endif
                @endauth
                @auth
                @if (auth()->user()->hasRole('user'))
                 <div class="sidebar-brand-text mx-3"> Hi!  {{ Auth::user()->fname }} !</div>
                @endif
                @endauth

            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
                            
                    
            <!-- Nav Item - Dashboard -->
             @auth
                @if (auth()->user()->hasRole('admin'))   
                <li class="nav-item {{ Route::is('admin.index') ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('admin.index') }}"><i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                   Dashboard</a>
            </li>
             @endif
            @endauth

             @auth
                @if (auth()->user()->hasRole('coach'))   
                <li class="nav-item {{ Route::is('coach.index') ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('coach.index') }}"><i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                   Dashboard
                    </a>
                     
            </li>
             @endif
            @endauth

            @auth
                @if (auth()->user()->hasRole('user'))   
                <li class="nav-item {{ Route::is('user.index') ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('user.index') }}"><i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                   Dashboard
                    </a>
            </li>
             @endif
            @endauth

            <!-- Divider -->
            <hr class="sidebar-divider">
            @auth
            @if (auth()->user()->hasRole('coach')) 
            <!-- Heading -->
            <div class="sidebar-heading">
             <h6 style="color: white;">Sports</h6>
            </div>
             @endif
            @endauth
            <!-- Nav Item - Pages Collapse Menu -->
               
                <!-- list of sport -->
                @auth
                @if (auth()->user()->hasRole('coach')) 
                    @php
                        // Get the current user's ID
                        $userID = auth()->user()->id;
                        
                        // Fetch all coach entries associated with the user ID
                        $coaches = App\Models\Coach::where('user_id', $userID)->get();
                        
                        // Extract sport IDs from coach entries
                        $sportIds = $coaches->pluck('sport_id')->toArray();
                        
                        // Fetch sports using the extracted sport IDs
                        $sports = App\Models\Sport::whereIn('id', $sportIds)->get();
                    @endphp
         @foreach ($sports as $sport)
            <li class="nav-item {{ Route::is('class-page') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('class-page', ['sport_id' => $sport->id]) }}"
                        aria-expanded="true" aria-controls="collapseTwo">
                         <i class="fas fa-running fa-sm fa-fw mr-2 text-gray-400"></i> {{ $sport->name }}
                    </a>
                </li> @endforeach
            {{--<li class="nav-item">
                <a class="nav-link collapsed" href="javascript:void(0);" onclick="toggleCollapse('collapseTwoz')"
                    aria-expanded="false" aria-controls="collapseTwoz">
                    <i class="fas fa-fw fa-running"></i>
                    <span>Sports</span>
                </a>
                <div id="collapseTwoz" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-green py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List:</h6>
                       
                            <a class="collapse-item" href="{{ route('class-page', ['sport_id' => $sport->id]) }}" style="color:white;">
                                <i class="fas fa-running"></i>
                                <span>{{ $sport->name }}</span>
                            </a>
                       
                    </div>
                </div>
            </li>--}}
         @endif
        @endauth

               <!-- list of sport for athlete -->
        @auth
        @if (auth()->user()->hasRole('user')) 
        @php
            // Get the current user's ID
            $userID = auth()->user()->id;
            
            // Fetch all athlete entries associated with the user ID
            $athletes = App\Models\Athlete::where('user_id', $userID)->get();
            
            // Extract coach IDs from athlete entries
            $coachIDs = $athletes->pluck('coach_id')->toArray();
            
            // Fetch coaches using the extracted coach IDs
            $coaches = App\Models\Coach::whereIn('id', $coachIDs)->get();
            
            // Extract sport IDs from coach entries
            $sportIds = $coaches->pluck('sport_id')->toArray();
            
            // Fetch sports using the extracted sport IDs
            $sports = App\Models\Sport::whereIn('id', $sportIds)->get();
        @endphp
        @if (!$sports->isEmpty())
            @foreach ($sports as $sport)
                <li class="nav-item {{ Route::is('class-page') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('class-page', ['sport_id' => $sport->id]) }}"
                        aria-expanded="true" aria-controls="collapseTwo">
                         <i class="fas fa-running fa-sm fa-fw mr-2 text-gray-400"></i> {{ $sport->name }}
                    </a>
                </li>
            @endforeach
        @endif
    @endif
@endauth
            
    
              <!-- Divider -->
            <hr class="sidebar-divider">
             <!-- Heading -->
               <div class="sidebar-heading">
             <h6 style="color: white;">Utilities</h6>
                </div>
                
                <!--ADD COACH -->
                 @auth
                @if (auth()->user()->hasRole('admin'))
                <li class="nav-item {{ Route::is('coachz.index') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('coachz.index') }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Add  Coaches
                    </a>
                </li>
                @endif
                @endauth
                  <!--ADD ATHLETE -->
                 @auth
                @if (auth()->user()->hasRole('admin'))
                <li class="nav-item {{ Route::is('athlete.index') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('athlete.index') }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                       <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Athletes
                    </a>
                </li>
                @endif
                @endauth
                          
                
           <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Se</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-green py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li>-->

           @auth
        @if (auth()->user()->hasRole('user'))
        @php
            $user = auth()->user();
            $userID = $user->id;
            $athlete = App\Models\Athlete::where('user_id', $userID)->first(); // Execute the query
            if ($athlete) {
                $coachID = $athlete->coach_id;
                $coach = App\Models\Coach::where('id', $coachID)->first(); // Execute the query
                if ($coach) {
                    $sportID = $coach->sport_id;
                    $sport = App\Models\Sport::find($sportID);
                }
            }
        @endphp

            @if (isset($sport))
                <li class="nav-item {{ Route::is('event.index') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('event.index', ['sport_id' => $sport->id]) }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                       <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400"></i>  Calendar
                    </a>
                </li>
            @endif
        @endif
    @endauth

            @auth
             @if (auth()->user()->hasRole('admin'))
            <li class="nav-item {{ Route::is('event.adminindex') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('event.adminindex') }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                       <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400"></i>  Calendar
                    </a>
                </li>
                @endif @endauth
           
                @auth
             @if (auth()->user()->hasRole('coach'))
            <li class="nav-item {{ Route::is('coach.profile') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('coach.profile') }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                       <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>  Coach Profile
                    </a>
                </li>
                @endif @endauth
             <li class="nav-item">
                <a class="nav-link" href="/chats"
                    aria-expanded="true" aria-controls="collapseTwo">
                   <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>  Messenger
                </a>
            </li>
               
            <!-- Nav Item - Utilities Collapse Menu -->
          {{--  <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>--}}
          
           

              <!-- Divider -->
            <hr class="sidebar-divider">
             <!-- Heading -->
             <div class="sidebar-heading">
             <h6 style="color: white;">System</h6>
                </div>
             @auth
                @if (auth()->user()->hasRole('admin'))
                  <!--user log -->
               <li class="nav-item {{ Route::is('logs.admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('logs.admin')}}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Users Log
                </a>
            </li>
                @endif
                @endauth
             @auth
                @if (auth()->user()->hasRole('coach'))
                  <!--Activity log -->
               <li class="nav-item {{ Route::is('logs.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('logs.index')}}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                </a>
            </li>
                @endif
                @endauth
            @auth
                @if (auth()->user()->hasRole('user'))
                 <!--Activity log -->
               <li class="nav-item {{ Route::is('logs.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('logs.index')}}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                </a>
            </li>
                @endif
                @endauth
             @auth
                @if (auth()->user()->hasRole('user'))
                  <!--My Profile -->
                <li class="nav-item {{ Route::is('my-profile') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('my-profile', ['id' => auth()->user()->id]) }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                       <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> My Profile
                    </a>
                </li>
                @endif
                @endauth
                @auth
                @if (auth()->user()->hasRole('admin'))
                  <!--ADD ADMIN -->
                <li class="nav-item {{ Route::is('contact-us.admin') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('contact-us.admin') }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i> Contact Us
                    </a>
                </li>
                 <li class="nav-item {{ Route::is('add.adminindex') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="{{ route('add.adminindex') }}"  
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i> Add  Admin
                    </a>
                </li>
                @endif
                @endauth
            {{--<li class="nav-item {{ Route::is('profile.edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                   Settings
                </a>
            </li>--}}

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> -->

        </ul>
        <!-- End of Sidebar -->