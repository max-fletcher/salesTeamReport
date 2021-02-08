<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/calls/index') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    
                    {{-- @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif --}}
                @else
                    {{-- See All Representatives/List of All Representatives --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('calls.index') }}"> Summary of Calls </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""> Create Call Entry </a>
                    </li>                        
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('representatives.index') }}"> See All Representatives </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('representatives.create') }}"> Create Representatives </a>
                    </li> --}}

                    @if (!Auth::user()->isAdmin)                     
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Representatives
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">                                
                                <a class="dropdown-item" href="{{ route('representatives.index') }}"> See All Representatives </a>                                                               
                                <a class="dropdown-item" href="{{ route('calls.display_for_user', auth()->user()->representative_id) }}"> Your Call Entries </a>                                
                            </div>
                        </li>                                     
                    @endif  

                    @if (Auth::user()->isAdmin)                     
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Representatives
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">                                
                                <a class="dropdown-item" href="{{ route('representatives.index') }}"> See All Representatives </a>                                                               
                                <a class="dropdown-item" href="{{ route('representatives.create') }}"> Create Representatives </a>
                                <a class="dropdown-item" href="{{ route('calls.display_for_user', auth()->user()->representative_id) }}"> Your Call Entries </a>                                
                            </div>
                        </li>                        
                    @endif  

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Calls
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('calls.index') }}"> Summary of Calls </a>
                            <a class="dropdown-item" href="{{ route('calls.create') }}"> Create Call Entry </a>
                            <a class="dropdown-item" href="{{ route('calls.generate_summary_with_users') }}"> Generate Summary Of Calls(With Users)</a>
                            <a class="dropdown-item" href="{{ route('calls.generate_summary_without_users') }}"> Generate Summary Of Calls(Without Users)</a>
                            <a class="dropdown-item" href="{{ route('calls.find_total_for_each_user') }}"> Total Calls for Each User </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">                                
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>                                                                                      
                @endguest
            </ul>
        </div>
    </div>
</nav>