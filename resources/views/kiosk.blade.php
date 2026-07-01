    <!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> BFAR KIOSK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

  </head>
  <body class="">

<script>
document.addEventListener('DOMContentLoaded', function () {

    const fullscreenBtn = document.getElementById('fullscreen-btn');

    function enterFullscreen() {
        let elem = document.documentElement;
        if (elem.requestFullscreen) return elem.requestFullscreen();
        if (elem.webkitRequestFullscreen) return elem.webkitRequestFullscreen();
    }

    function exitFullscreen() {
        if (document.exitFullscreen) return document.exitFullscreen();
        if (document.webkitExitFullscreen) return document.webkitExitFullscreen();
    }

    /* ===============================
       BUTTON — USER GESTURE (REQUIRED)
    =============================== */
    fullscreenBtn.addEventListener('click', function (e) {
        e.preventDefault();

        if (!document.fullscreenElement) {
            enterFullscreen().then(() => {
                localStorage.setItem('fullscreen', 'true');
            }).catch(() => {});
        } else {
            exitFullscreen();
            localStorage.setItem('fullscreen', 'false');
        }
    });

    /* ===============================
       RESTORE AFTER PRINT / RELOAD
       (Only works AFTER initial click)
    =============================== */
    function restoreFullscreen() {
        if (
            localStorage.getItem('fullscreen') === 'true' &&
            !document.fullscreenElement
        ) {
            // requires prior user interaction
            enterFullscreen().catch(() => {});
        }
    }

    window.addEventListener('afterprint', restoreFullscreen);
    window.addEventListener('focus', restoreFullscreen);

});
</script>


    {{-- <button id="fullscreen-btn"
    class="btn btn-dark position-fixed"
    style="top:20px; right:20px; z-index:9999;">
    <i class="fa-solid fa-expand"></i>
</button>
<script>
$('#fullscreen-btn').on('click', function () {
    let elem = document.documentElement;

    if (!document.fullscreenElement) {
        elem.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
});
</script>

    <script>
function openFullscreen() {
    let elem = document.documentElement;

    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { 
        elem.msRequestFullscreen();
    }
}

document.addEventListener('click', function once() {
    openFullscreen();
    document.removeEventListener('click', once);
});
</script> --}}
<style>
    
    /* html, body {
    width: 100%;
    height: 100%;
    overflow: hidden;
} */


</style>
    <style>
    body {
        background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'><path fill='%23008000' fill-opacity='1' d='M0,64L60,101.3C120,139,240,213,360,250.7C480,288,600,288,720,250.7C840,213,960,139,1080,117.3C1200,96,1320,128,1380,144L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z'></path></svg>")
                    no-repeat bottom center;
        background-size: cover;
    }
</style>
    <div class="app-wrapper">
        {{-- <main class="app-main">
            <div class="app-content d-flex justify-content-center align-items-center mt-4" style="height: 80vh;">
              
                <div class="card shadow now-serving-card clickable-card p-4" 
                    style="width: 420px; height: auto; cursor: pointer;">
                    
                  <div class="card-body d-flex justify-content-center align-items-center flex-column p-3">
                            
                            <button id="priority-button" 
                                    class="btn btn-success fs-4 py-4 px-4 w-100 text-center" 
                                    style="font-weight: bold;">
                                Get Your Priority Number
                            </button>

                        </div>
                        <div class="real-printer mt-3 p-3" style="width:100%;">

                            <div class="printer-head" 
                                style="width:100%; height:40px; background:#f8f8f8; border-radius:4px;">
                            </div>

                            <div class="paper-output mt-2" id="paper-output"
                                style="width:91.1%; height:0; overflow:hidden; background:white; border:1px solid #818181; border-radius:4px; transition: height 1s;">
                                
                                <div class="paper-content p-3">
                                    <h2 id="printed-number" class="text-center"></h2>
                                </div>
                            </div>

                        </div>

                </div>

            </div>
        </main> --}}
        <a class="nav-link" href="#" role="button" id="fullscreen-btn">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
       <main class="app-main">
            <div class="app-content d-flex flex-column align-items-center" style="height: 80vh; margin-top:6%">
                {{-- <div class="mb-5">
                    <img
                        src="{{ asset('adminlte/assets/img/logo.jpg')}}"
                        alt="Logo"
                        style="max-width:200px; display:block;"
                    />
                </div> --}}

            <div class="kiosk-layout mt-5">

                <!-- LEFT: BUTTONS -->
                <div class="kiosk-container ">
                    <div class="kiosk-row" style="margin-left:31%; margin-top:7%">
                        <a href="/kiosk-form" class="kiosk-btn kiosk-bills">
                            <i class="fas fa-credit-card"></i>
                            <span style="color:blue">FORM</span>
                        </a>

                        <a href="/arta.create" class="kiosk-btn kiosk-concern">
                            <i class="fas fa-headset"></i>
                            <span style="color:green">SURVEY</span>
                        </a>
                    </div>

             
                </div>

                <!-- RIGHT: VIDEO -->
                <div class="kiosk-video">
                    <video autoplay muted loop playsinline>
                        <source src="{{ asset('videos/kiosk.mp4') }}" type="video/mp4">
                    </video>
                </div>

            </div>



            </div>
        </main>
       <style>
        
        .kiosk-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .kiosk-row {
            display: flex;
            gap: 40px;
        }

        @media (max-width: 768px) {
            .kiosk-row {
                flex-direction: column;
                align-items: center;

            }

            .kiosk-btn {
                width: 90%;
                max-width: 320px;
                height: 220px;
                font-size: 26px;
            }

            .kiosk-btn i {
                font-size: 60px;
            }
        }
        .kiosk-btn {
            width: 320px;
            height: 260px;
            border-radius: 24px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            text-decoration: none;
            background: #ffffff;
            color: #000000;                 
            font-size: 32px;
            font-weight: 800;

            border: 4px solid #666666;  
            box-shadow: 0 12px 30px rgba(37, 37, 37, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kiosk-btn i {
            font-size: 80px;
            margin-bottom: 16px;
            color: #000;                   
            
            border: 3px solid #1d1c1c;     
            border-radius: 16px;
            padding: 16px 20px;
        }

        .kiosk-btn:hover {
            transform: scale(1.06);
            box-shadow: 0 18px 40px rgba(0,0,0,0.35);
        }

        .kiosk-bills,
        .kiosk-concern {
            background: #ffffff;
        }

        @media (max-width: 1024px) {
            .kiosk-btn {
                width: 260px;
                height: 220px;
                font-size: 26px;
            }

            .kiosk-btn i {
                font-size: 64px;
                padding: 12px 16px;
            }
        }
        </style>

       


      {{-- <footer class="app-footer">
       <div class="float-end d-none d-sm-inline"> All rights reserved.</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
            &copy; 2025 MKWD
          <a href="https://adminlte.io" class="text-decoration-none">   Designed by OBX SOLUTION TECHNOLOGY INC.</a>
        </strong>
      </footer>
      --}}
    </div>
  
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>

  </body>
</html>
