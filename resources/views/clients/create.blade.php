@extends('layouts.app')
@section('content')
   
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-success p-3">Clients Information</span></h4>
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

                    {{-- Address Field --}}
                      {{-- ADDRESS --}}
                        <div class="col-md-6 position-relative mb-2">

                            <label for="address" class="form-label">Address / Coordinates</label>

                            <div class="input-group">
                                <input type="text"
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    placeholder="Select or search location from map"
                                    readonly
                                    required>

                                <button type="button"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#mapModal">
                                    <i class="bi bi-geo-alt-fill"></i> See Maps
                                </button>
                            </div>

                            <div class="invalid-tooltip">
                                Please select location
                            </div>

                            <div class="valid-tooltip">
                                Looks good!
                            </div>

                        </div>


                        {{-- MAP MODAL --}}
                        <div class="modal fade" id="mapModal" tabindex="-1">

                            <div class="modal-dialog modal-xl modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Select Location</h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        {{-- SEARCH LOCATION --}}
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control"
                                                id="mapSearch"
                                                placeholder="Search location, address, or plus code...">

                                            <button type="button"
                                                    class="btn btn-primary"
                                                    id="searchLocationBtn">
                                                <i class="bi bi-search"></i> Search
                                            </button>
                                        </div>

                                        {{-- MAP --}}
                                        <div id="map"
                                            style="height:500px; width:100%; border-radius:10px;">
                                        </div>

                                        {{-- COORDINATES DISPLAY --}}
                                        <div class="mt-3">
                                            <div class="alert alert-info mb-0">
                                                <strong>Latitude:</strong>
                                                <span id="latText">-</span>

                                                &nbsp;&nbsp;&nbsp;

                                                <strong>Longitude:</strong>
                                                <span id="lngText">-</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-success"
                                                data-bs-dismiss="modal">
                                            Use Location
                                        </button>
                                    </div>

                                </div>

                            </div>

                        </div>




                        <script>
                            var base_url = window.location.origin;

                            let map;
                            let marker;
                            let kmlLayer;

                            var mbAttr =
                                'Powered by: OBX SOLUTIONS TECHNOLOGY INC. &copy; Map data &copy; OpenStreetMap contributors';

                            var streets = L.tileLayer(
                                'http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
                                {
                                    maxZoom: 20,
                                    subdomains:['mt0','mt1','mt2','mt3'],
                                    attribution: mbAttr
                                }
                            );

                            var satellite = L.tileLayer(
                                'http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
                                {
                                    maxZoom: 20,
                                    subdomains:['mt0','mt1','mt2','mt3'],
                                    attribution: mbAttr
                                }
                            );


                            // OPEN MODAL
                            document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {

                                // INITIALIZE MAP ONCE ONLY
                                if (!map) {

                                    try {
                                        map = L.map('map', {
                                            center: [6.1164, 125.1716],
                                            zoom: 12,
                                            layers: [satellite]
                                        });
                                    } catch(e) {
                                        map = L.map('map', {
                                            center: [125.1716, 125.1716],
                                            zoom: 10,
                                            layers: [satellite]
                                        });
                                    }

                                    // OPTIONAL TILE
                                    L.tileLayer(
                                        'http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png',
                                        {
                                            subdomains: ['otile1','otile2','otile3','otile4']
                                        }
                                    ).addTo(map);

                                    // LAYER CONTROL
                                    var baseLayers = {
                                        "Streets": streets,
                                        "Satellite": satellite
                                    };

                                    L.control.layers(baseLayers).addTo(map);


                                    // CLICK MAP TO PLOT
                                    map.on('click', function(e) {
                                        let lat = e.latlng.lat;
                                        let lng = e.latlng.lng;

                                        placeMarker(lat, lng);
                                        updateCoordinates(lat, lng);
                                    });
                                }

                                // FIX MAP DISPLAY INSIDE MODAL
                                setTimeout(function () {
                                    map.invalidateSize();
                                }, 300);

                            });


                            // PLACE MARKER
                            function placeMarker(lat, lng)
                            {
                                if (marker) {
                                    marker.setLatLng([lat, lng]);
                                } else {
                                    marker = L.marker([lat, lng], {
                                        draggable: true
                                    }).addTo(map);

                                    marker.on('dragend', function() {
                                        let position = marker.getLatLng();

                                        updateCoordinates(position.lat, position.lng);
                                    });
                                }
                            }


                            // UPDATE ADDRESS INPUT WITH LAT,LNG
                            function updateCoordinates(lat, lng)
                            {
                                $('#latText').text(lat.toFixed(6));
                                $('#lngText').text(lng.toFixed(6));

                                $('#address').val(
                                    lat.toFixed(6) + ',' + lng.toFixed(6)
                                );

                                console.log('Latitude:', lat);
                                console.log('Longitude:', lng);
                            }


                            // SEARCH BUTTON CLICK
                            $('#searchLocationBtn').on('click', function () {
                                searchLocation();
                            });


                            // ENTER KEY SEARCH
                            $('#mapSearch').on('keypress', function (e) {
                                if (e.which === 13) {
                                    searchLocation();
                                }
                            });


                            // SEARCH LOCATION FUNCTION
                            function searchLocation()
                            {
                                let searchValue = $('#mapSearch').val();

                                if (!searchValue) {
                                    alert('Please enter location');
                                    return;
                                }

                                $.ajax({
                                    url: 'https://nominatim.openstreetmap.org/search',
                                    type: 'GET',
                                    data: {
                                        q: searchValue,
                                        format: 'json',
                                        limit: 1,
                                        countrycodes: 'ph'
                                    },
                                    success: function (response) {

                                        if (response.length === 0) {
                                            alert('Location not found');
                                            return;
                                        }

                                        let lat = parseFloat(response[0].lat);
                                        let lng = parseFloat(response[0].lon);

                                        map.setView([lat, lng], 18);

                                        placeMarker(lat, lng);
                                        updateCoordinates(lat, lng);
                                    },
                                    error: function () {
                                        alert('Error searching location');
                                    }
                                });
                            }
                        </script>
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
                        <div class="col-md-6 position-relative mt-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                            
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>
                        {{-- <div class="col-md-6 position-relative mt-4 mb-2">
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
                        </div> --}}

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
@endsection