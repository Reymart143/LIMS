@extends('layouts.app')
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-success p-3">Update Clients Information</span></h4>
                     </div>
                  </div>
                  <div class="card-body">
                     
                     <form class="row g-3 needs-validation" action="{{ route('clients.update')}}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="client_id" name="client_id" value="{{ $client->id}}">
                         <div class="col-md-6 position-relative mb-2">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="{{ old('company_name', $client->company_name) }}" required>
                            <div class="invalid-tooltip">Please provide a company name.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        
                        <div class="col-md-6 position-relative mb-2">

                        <label for="address" class="form-label">Address / Coordinates</label>

                        <div class="input-group">
                            <input type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                value="{{ old('address', $client->address) }}"
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

                            let initialLat = 6.1164;
                            let initialLng = 125.1716;

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

                                // GET EXISTING VALUE FROM EDIT INPUT
                                let existing = $('#address').val();

                                if (existing && existing.includes(',')) {
                                    let coords = existing.split(',');

                                    let lat = parseFloat(coords[0]);
                                    let lng = parseFloat(coords[1]);

                                    if (!isNaN(lat) && !isNaN(lng)) {
                                        initialLat = lat;
                                        initialLng = lng;
                                    }
                                }

                                // INITIALIZE MAP ONLY ONCE
                                if (!map) {

                                    map = L.map('map', {
                                        center: [initialLat, initialLng],
                                        zoom: 16,
                                        layers: [satellite]
                                    });

                                    // LAYER CONTROL
                                    var baseLayers = {
                                        "Streets": streets,
                                        "Satellite": satellite
                                    };

                                    L.control.layers(baseLayers).addTo(map);

                                    // CLICK EVENT
                                    map.on('click', function(e) {
                                        let lat = e.latlng.lat;
                                        let lng = e.latlng.lng;

                                        placeMarker(lat, lng);
                                        updateCoordinates(lat, lng);
                                    });

                                } else {
                                    map.setView([initialLat, initialLng], 16);
                                }

                                // AUTO PLACE MARKER IF EDIT HAS VALUE
                                if (initialLat && initialLng) {
                                    placeMarker(initialLat, initialLng);
                                    updateCoordinates(initialLat, initialLng);
                                }

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

                            // UPDATE INPUT
                            function updateCoordinates(lat, lng)
                            {
                                $('#latText').text(lat.toFixed(6));
                                $('#lngText').text(lng.toFixed(6));

                                $('#address').val(
                                    lat.toFixed(6) + ',' + lng.toFixed(6)
                                );
                            }

                            // SEARCH
                            $('#searchLocationBtn').on('click', function () {
                                searchLocation();
                            });

                            $('#mapSearch').on('keypress', function (e) {
                                if (e.which === 13) {
                                    searchLocation();
                                }
                            });

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
                            <input type="text" class="form-control" id="contact_no" name="contact_no"
                                value="{{ old('contact_no', $client->contact_no) }}" required>
                            <div class="invalid-tooltip">Please provide a contact number</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>
                        <div class="col-md-6 position-relative mt-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $client->date) }}">
                            
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>
                     
                        <div class="col-12">
                            <a class="btn btn-secondary" href="{{ route('clients') }}">Cancel</a>
                            <button class="btn btn-primary" type="submit">Update Changes</button>
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