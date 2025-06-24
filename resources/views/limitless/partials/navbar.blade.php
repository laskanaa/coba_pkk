 <!-- Main navbar -->
 <div class="navbar navbar-expand-md navbar-dark">
     <div class="navbar-brand">
         <a href="pkk.wonosobokab.go.id" class="d-inline-block">
             <img src="/images/logopkk.png" alt="" style="height: 30px">
         </a>
     </div>

     <div class="d-md-none">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
             <i class="icon-tree5"></i>
         </button>
         <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
             <i class="icon-paragraph-justify3"></i>
         </button>
     </div>

     <div class="collapse navbar-collapse" id="navbar-mobile">
         <ul class="navbar-nav">
             <li class="nav-item">
                 <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                     <i class="icon-paragraph-justify3"></i>
                 </a>
             </li>
         </ul>

         <span class="navbar-text ml-md-3 mr-md-auto">
             <span class="badge bg-success">Online</span>
         </span>

         <ul class="navbar-nav">
             <li class="nav-item dropdown dropdown-user">
                 <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                     {{-- You might want to add an actual user avatar here --}}
                     <img src="{{ asset('limitless/global_assets/images/placeholders/placeholder.jpg') }}"
                         class="rounded-circle" alt="" style="height: 30px;">
                     <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                 </a>

                 <div class="dropdown-menu dropdown-menu-right">
                     {{-- Add links for profile or settings if needed --}}
                     {{-- <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a> --}}
                     {{-- <div class="dropdown-divider"></div> --}}
                     {{-- <a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a> --}}
                     <a class="dropdown-item" href="#"
                         onclick="event.preventDefault(); document.getElementById('logout').submit();">
                         <i class="icon-switch2 mr-2"></i> Logout
                     </a>
                 </div>
             </li>
         </ul>
     </div>
 </div>
 <!-- /main navbar -->
