<!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="app-assets/images/backgrounds/02.jpg">
        
        <div class="navigation-background"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a href="{{ route('home') }}"><i class="ft-home"></i>
                    <span class="menu-title" data-i18n="">Dashboard</span> 
                </li>
                <li class=" nav-item"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Products</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{ route('product.create') }}">Add New </a>
                        </li>
                        <li><a class="menu-item" href="{{ route('product.index') }}">List </a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="ft-edit"></i><span class="menu-title" data-i18n="">Standards</span></a>
                            <ul class="menu-content">
                                <li class=""><a class="menu-item" href="{{ route('standards.create') }}">Add</a>
                                </li>
                                <li><a class="menu-item" href="{{ route('standards.index') }}">List</a>
                                </li>
                            </ul>  
                </li>
                
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
