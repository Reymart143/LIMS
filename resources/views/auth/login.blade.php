<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>LIMS LOGIN</title>
      
      <!-- Favicon -->
       <link rel="shortcut icon" href="/assets/images/bfarlogo.png">
      <link rel="stylesheet" href="/assets/css/core/libs.min.css">
      <link rel="stylesheet" href="/assets/css/hope-ui.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/custom.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/customizer.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  </head>
     @if(session('success'))
      <div class="mb-3 alert alert-left alert-success alert-dismissible fade show auto-dismiss"
         role="alert"
         style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
         <i class="bi bi-check-circle-fill me-2" style="font-size: 20px;"></i>
         <span>{{ session('success') }}</span>

         <button type="button" class="btn-close btn-close-white"
                  data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif


      @if(session('error'))
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
  <body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
   

    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body">
          </div>
      </div>    
   </div>
      <div class="wrapper">
      <section class="login-content">
         <div class="row m-0 align-items-center bg-white vh-100">            
            <div class="col-md-6">
               <div class="row justify-content-center">
                  <div class="col-md-10">
                     <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                        <div class="card-body" style="margin-top:-30%">
                           <a href="https://r12.bfar.da.gov.ph/" target="_blank" class="navbar-brand d-flex align-items-center mb-3">
                              
                              <!--Logo start-->
                             
                              <!--logo End-->
                              
                              
                         
                           <div class="ms-2 text-center w-80">
                                <img src="../assets/images/bfarlogo.png" 
                            alt="BFAR Logo" 
                            class="img-fluid" style="width: 30%">
                              
                                 <h6 class="mb-0">Republic of the Philippines</h6>
                                 <h6 class="mb-0">Department of Agriculture</h6>
                                 <h6 class="mb-0">BUREAU OF FISHERIES AND AQUATIC RESOURCES</h6>
                                 <h5 class="fw-bold mb-0">REGIONAL FISHERIES LABORATORY XII</h5>
                                 <h6 class="mb-0">J. Catolico St., Lagao, General Santos City</h6>
                           </div>
                           </a>
                           <div class="border-box p-4" style="border: 2px solid #6f768d86; border-radius: 12px; background-color: #fafafa;">

                           
                           <h3 class="mb-3 mt-3 text-center text-primary">LOGIN PORTAL</h3>
                           
                              <form action="{{ route('login-user')}}" method="POST">
                                 @csrf
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="form-group">
                                          <label for="text" class="form-label">Username</label>
                                          <input type="text" class="form-control" id="username" name="username" aria-describedby="username" placeholder="Enter Username" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="form-group">
                                          <label for="password" class="form-label">Password</label>
                                          <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="Enter Password" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 d-flex justify-content-between">
                                       {{-- <div class="form-check mb-3">
                                          <input type="checkbox" class="form-check-input" id="customCheck1">
                                          <label class="form-check-label" for="customCheck1">Remember Me</label>
                                       </div> --}}
                                       {{-- <a href="recoverpw.html">Forgot Password?</a> --}}
                                    </div>
                                 </div>
                                 <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                 </div>
                              </div>
                              {{-- <p class="text-center my-3">or sign in with other accounts?</p>
                              <div class="d-flex justify-content-center">
                                 <ul class="list-group list-group-horizontal list-group-flush">
                                    <li class="list-group-item border-0 pb-0">
                                       <a href="#"><img src="../../assets/images/brands/fb.svg" alt="fb"></a>
                                    </li>
                                    <li class="list-group-item border-0 pb-0">
                                       <a href="#"><img src="../../assets/images/brands/gm.svg" alt="gm"></a>
                                    </li>
                                    <li class="list-group-item border-0 pb-0">
                                       <a href="#"><img src="../../assets/images/brands/im.svg" alt="im"></a>
                                    </li>
                                    <li class="list-group-item border-0 pb-0">
                                       <a href="#"><img src="../../assets/images/brands/li.svg" alt="li"></a>
                                    </li>
                                 </ul>
                              </div>
                              <p class="mt-3 text-center">
                                 Don’t have an account? <a href="sign-up.html" class="text-underline">Click here to sign up.</a>
                              </p> --}}
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sign-bg">
                  {{-- <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g opacity="0.05">
                     <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"/>
                     <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"/>
                     <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"/>
                     <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"/>
                     </g>
                  </svg> --}}

               </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="../../assets/images/bg.jpg" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
            {{-- <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 position-relative overflow-hidden">
               <img src="../../assets/images/bg.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="images">
               <div class="overlay position-absolute top-0 start-0 w-100 h-100"></div>
            </div>

            <style>
            .overlay {
               background-color: rgba(138, 143, 148, 0.267); /* Blue with 40% opacity */
            }
        
            </style> --}}
            
         </div>
      </section>
      </div>
    <script src="/assets/js/core/libs.min.js"></script>
    <script src="/assets/js/plugins/fslightbox.js"></script>
    <script src="/assets/js/hope-ui.js" defer></script>
    
    
  </body>
</html>