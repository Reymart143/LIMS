 <!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>LIMS </title>
       <link rel="shortcut icon" href="/assets/images/bfarlogo.png">
      <link rel="stylesheet" href="/assets/css/core/libs.min.css">
      <link rel="stylesheet" href="/assets/css/hope-ui.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/custom.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/customizer.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
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
  <body class="  ">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body">
          </div>
      </div> 
    </div>
     <main class="main-content">
          <div class="position-relative iq-banner">
            <!-- HEADER -->
            <div class="bg-white border-bottom mb-3 p-3">
                <div class="d-flex align-items-center">
                    
                    <!-- LOGO -->
                    <div style="width: 120px;">
                        <img src="../assets/images/bfarlogo.png" 
                            alt="BFAR Logo" 
                            class="img-fluid">
                    </div>

                    <!-- TEXT -->
                    <div class="ms-3 text-center w-100">
                        <h6 class="mb-0">Republic of the Philippines</h6>
                        <h6 class="mb-0">Department of Agriculture</h6>
                        <h6 class="mb-0">BUREAU OF FISHERIES AND AQUATIC RESOURCES</h6>
                        <h5 class="fw-bold mb-0">REGIONAL FISHERIES LABORATORY XII</h5>
                        <h6 class="mb-0">J. Catolico St., Lagao, General Santos City</h6>
                    </div>

                </div>
            </div>

            <div class="conatiner-fluid content-inner " style="margin-top:-2%">
             <div>
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-success p-3">Personal Information</span></h4>
                     </div>
                  </div>
                  <div class="card-body">
                     
                     <form class="row g-3 needs-validation" action="{{ route('clients.store')}}" method="POST" novalidate>
                        @csrf
                        <div class="col-md-6 position-relative  mb-2">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" required name="company_name">
                            <div class="invalid-tooltip">
                                Please provide a company name.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" required name="address">
                            <div class="invalid-tooltip">
                                Please provide a address
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="contact_no" class="form-label">Contact No.</label>
                            <input type="text" class="form-control" id="contact_no" required name="contact_no">
                            <div class="invalid-tooltip">
                                Please provide a contact number
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="source_sample" class="form-label">Source Sample</label>
                            <input type="text" class="form-control" id="source_sample" required name="source_sample">
                            <div class="invalid-tooltip">
                                Please provide a source sample.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="sample_description" class="form-label">Sample Description</label>
                            <input type="text" class="form-control" id="sample_description" required name="sample_description">
                            <div class="invalid-tooltip">
                                Please provide a sample description.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="sample_code" class="form-label">Sample Code</label>
                            <input type="text" class="form-control" id="sample_code" required name="sample_code">
                            <div class="invalid-tooltip">
                                Please provide a sample code.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="analysis_requested" class="form-label">Analysis Requested</label>
                            <input type="text" class="form-control" id="analysis_requested" required name="analysis_requested">
                            <div class="invalid-tooltip">
                                Please provide a analysis requested.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="species" class="form-label">Species</label>
                            <input type="text" class="form-control" id="species" required name="species">
                            <div class="invalid-tooltip">
                                Please provide a species.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                            
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4">
                            <label for="classification" class="form-label">Classification</label>
                            <input type="text" class="form-control" id="classification" required name="classification">
                            <div class="invalid-tooltip">
                                Please provide a classification.
                            </div>  
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                             <a class="btn btn-secondary" type="submit" href="/clients">Cancel</a>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        
                    </form>

                    <script>
            
                    (() => {
                        'use strict'

                        const forms = document.querySelectorAll('.needs-validation')

                        Array.from(forms).forEach(form => {
                            form.addEventListener('submit', event => {
                                if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                }
                                form.classList.add('was-validated')
                            }, false)

                            
                            form.querySelectorAll('input, select').forEach(input => {
                                input.addEventListener('input', () => {
                                    if (input.checkValidity()) {
                                        input.classList.add('is-valid')
                                        input.classList.remove('is-invalid')
                                    } else {
                                        input.classList.remove('is-valid')
                                    }
                                })
                            })
                        })
                    })();
                    </script>

                  </div>
               </div>
             </div>
        </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js/core/libs.min.js"></script>
    <script src="/assets/js/core/external.min.js"></script>
    <script src="/assets/js/charts/widgetcharts.js"></script>
    <script src="/assets/js/charts/vectore-chart.js"></script>
    <script src="/assets/js/charts/dashboard.js" ></script>
    <script src="/assets/js/plugins/fslightbox.js"></script>
    <script src="/assets/js/plugins/setting.js"></script>
    <script src="/assets/js/plugins/slider-tabs.js"></script>
    <script src="/assets/js/plugins/form-wizard.js"></script>
    <script src="/assets/vendor/aos/dist/aos.js"></script>
    <script src="/assets/js/hope-ui.js" defer></script>
  </body>
</html>
    