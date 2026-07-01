
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>LIMS </title>
      <link rel="shortcut icon" href="assets/images/bfarlogo.png">
      <link rel="stylesheet" href="/assets/css/core/libs.min.css">
      <link rel="stylesheet" href="/assets/css/hope-ui.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/custom.min.css?v=4.0.0">
      <link rel="stylesheet" href="/assets/css/customizer.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
       <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>
        <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <style>
        body.modal-open {
            overflow: hidden;
        }
        body.modal-open::before {
            content: "";
            position: fixed;
            inset: 0;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            background: rgba(0,0,0,0.3);
            z-index: 1040; 
        }
      </style>
  </head>
  <body class="  ">
    <!-- loader Start -->
    {{-- <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body">
          </div>
      </div> 
    </div> --}}

<div id="globalLoader" style="display:none;">
    <div class="loader-box">
        <div class="spinner"></div>
        <div class="loader-text">Generating file, please wait...</div>
    </div>
</div>
<style>
    #globalLoader {
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.75);
        z-index: 999999;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .loader-box {
        text-align: center;
        padding: 20px 30px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .spinner {
        width: 55px;
        height: 55px;
        border: 6px solid #ddd;
        border-top: 6px solid #164931;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 12px;
    }

    .loader-text {
        font-size: 15px;
        font-weight: 500;
        color: #333;
    }

    body.loading {
        overflow: hidden;
        pointer-events: none;
    }

    body.loading #globalLoader {
        pointer-events: all;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        function showLoader() {
            const loader = document.getElementById('globalLoader');
            if (loader) {
                loader.style.display = 'flex';
                document.body.classList.add('loading');
            }
        }

        function hideLoader() {
            const loader = document.getElementById('globalLoader');
            if (loader) {
                loader.style.display = 'none';
                document.body.classList.remove('loading');
            }
        }

        async function downloadFile(url) {
            try {
                showLoader();

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to download file.');
                }

                const blob = await response.blob();

                let filename = 'downloaded-file';
                const disposition = response.headers.get('Content-Disposition');

                if (disposition && disposition.includes('filename=')) {
                    const match = disposition.match(/filename\*?=(?:UTF-8'')?["']?([^"';]+)["']?/i);
                    if (match && match[1]) {
                        filename = decodeURIComponent(match[1]);
                    }
                }

                const blobUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(blobUrl);

            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Download Failed',
                    text: 'No data to download.',
                    confirmButtonColor: '#dc3545'
                });
            } finally {
                hideLoader();
            }
        }

        document.addEventListener('click', function (e) {
            const target = e.target.closest('[data-download]');
            if (!target) return;

            e.preventDefault();

            const url = target.getAttribute('href') || target.dataset.url;
            if (!url) return;

            downloadFile(url);
        });
    });
</script>
 <main class="main-content">
          <div class="position-relative iq-banner">
   
