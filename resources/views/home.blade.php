 <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                                
                                
       ОК                         
                                
                                
                                
                                
                                
                           
                                
                                
{ "response": {
        "success": true,
        "user": {
            "id": {{ Auth::user()->id}},
            "category_id": {{Auth::user()->category_id}},
            "token":{{Auth::user()->token}}
           
        }
    }

}

