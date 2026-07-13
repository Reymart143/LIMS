    @if(session('success') && !request()->routeIs('equipments.*'))
      <div class="mb-3 alert alert-left alert-success alert-dismissible fade show auto-dismiss"
         role="alert"
         style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
         <i class="bi bi-check-circle-fill me-2" style="font-size: 20px;"></i>
         <span>{{ session('success') }}</span>

         <button type="button" class="btn-close btn-close-white"
                  data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif


    @if(session('error') && !request()->routeIs('equipments.*'))
      <div class="mb-3 alert alert-bottom alert-danger alert-dismissible fade show auto-dismiss"
         role="alert"
         style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
          <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 20px;"></i>
         <span>{{ session('error') }}</span>

         <button type="button" class="btn-close btn-close-white"
                  data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <script>
      setTimeout(function () {
         document.querySelectorAll('.auto-dismiss').forEach(function(alert) {
            alert.classList.remove('show'); 
            setTimeout(() => alert.remove(), 500);
         });
      }, 4000);
      </script>

 <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
          <div class="container-fluid navbar-inner">
            <a href="../dashboard/index.html" class="navbar-brand">
                
                  <div class="logo-main">
                    <div class="logo-normal" >
                        <img src="{{url('assets/images/bfarlogo.png')}}" 
                            alt="BFAR Logo" 
                            class="img-fluid" style="width: 90px;margin-left:5mm">
                    </div>
                    <div class="logo-mini" >
                        <img src="{{url('assets/images/bfarlogo.png')}}" 
                            alt="BFAR Logo" 
                            class="img-fluid" style="width: 90px;margin-left:5mm">
                    </div>
                </div>
                <!--logo End-->
                
                
                
              <div class="text-center">
                    <h4 class="logo-title mb-1">BFAR</h4>
                    <span class="badge bg-primary p-2" style="margin-left:5mm">Region XII</span>
                </div>

            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                 <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
                </i>
            </div>
            {{-- <div class="input-group search-input">
              <span class="input-group-text" id="search-input">
                <svg class="icon-18" width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </span>
              <input type="search" class="form-control" placeholder="Search...">
            </div> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                  <span class="mt-2 navbar-toggler-bar bar1"></span>
                  <span class="navbar-toggler-bar bar2"></span>
                  <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                
                <li class="nav-item dropdown">
                  <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="../assets/images/avatars/01.png" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../assets/images/avatars/avtar_1.png" alt="User-Profile" class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../assets/images/avatars/avtar_2.png" alt="User-Profile" class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../assets/images/avatars/avtar_4.png" alt="User-Profile" class="theme-color-green-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../assets/images/avatars/avtar_5.png" alt="User-Profile" class="theme-color-yellow-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../assets/images/avatars/avtar_3.png" alt="User-Profile" class="theme-color-pink-img img-fluid avatar avatar-50 avatar-rounded"> --}}
                    <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/01.png') }}" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                              <img src="{{ Auth::user()->image ? asset( Auth::user()->image) : asset('../../assets/images/avatars/avtar_1.png') }}" alt="User-Profile"class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                              <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_2.png') }}" alt="User-Profile" class="theme-color-blue-img img-fluid rounded-pill avatar-50" id="profileImages">
                              <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_4.png') }}" alt="User-Profile" class="theme-color-green-img img-fluid rounded-pill avatar-50" id="profileImages">
                              <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_5.png') }}"  alt="User-Profile" class="theme-color-yellow-img img-fluid rounded-pill avatar-50" id="profileImages">
                              <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_3.png') }}" alt="User-Profile" class="theme-color-pink-img img-fluid rounded-pill avatar-50" id="profileImages">
                    <div class="caption ms-3 d-none d-md-block ">
                        <h6 class="mb-0 caption-title">{{ Auth::user()->f_name}} {{ Auth::user()->m_name}}. {{ Auth::user()->l_name}}</h6>
                        <p class="mb-0 caption-sub-title">Defaul Position</p>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    {{-- <li><a class="dropdown-item" href="../dashboard/app/user-privacy-setting.html">Privacy Setting</a></li> --}}
                    <li><hr class="dropdown-divider"></li>
                    <li>
                    <button id="logoutBtn" class="dropdown-item">Logout</button></li>
                    
                       <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    
                    <script>
                        document.getElementById('logoutBtn').addEventListener('click', function (e) {
                            e.preventDefault();
                    
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You will be logged out.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, logout',
                                cancelButtonText: 'Cancel',
                                reverseButtons: true,
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-success mx-2', 
                                    cancelButton: 'btn btn-danger mx-2'    
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('logoutForm').submit();
                                }
                            });
                        });
                    </script>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>          <!-- Nav Header Component Start -->
          <div class="iq-navbar-header" style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              <div>
                                  <h1>LIMS</h1>
                                  <p>Laboratory Information Management System</p>
                              </div>
                              <div>
                                  {{-- <a href="" class="btn btn-link btn-soft-light">
                                      <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z" fill="currentColor"></path>
                                          <path opacity="0.4" d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z" fill="currentColor"></path>
                                      </svg>
                                      Announcements
                                  </a> --}}
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="iq-header-img">
                  <img src="{{url('assets/images/dashboard/top-header.png')}}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="{{url('assets/images/dashboard/top-header1.png')}}" alt="header" class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="{{url('assets/images/dashboard/top-header2.png')}}" alt="header" class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="{{url('assets/images/dashboard/top-header3.png')}}" alt="header" class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="{{url('assets/images/dashboard/top-header4.png')}}" alt="header" class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
                  <img src="{{url('assets/images/dashboard/top-header5.png')}}" alt="header" class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
              </div>
          </div>          <!-- Nav Header Component End -->
        <!--Nav End-->
      </div>