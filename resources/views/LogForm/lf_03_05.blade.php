@extends('layouts.app')
@section('content')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <div class="container-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                
                <div class="col-sm-12">
                    <div class="card">
                        
                        <div class="card-header d-flex justify-content-between">
                          
                        <div class="header-title">
                            <h4 class="card-title">EQUIPMENT USAGE AND MAINTENANCE LOGBOOK</h4>
                        </div>
                            
                           <div class="modal fade" id="qrModal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5>Scan Equipment</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <label>Select RLA</label>

                                            <select class="form-control mb-3" id="selected_rla">

                                                <option value="">Select RLA</option>
                                                        @php
                                                        $rla = DB::table('lf_06_02')
                                                            ->where('status',4)
                                                            ->orderByDesc('id')
                                                            ->get();
                                                        @endphp
                                                @foreach($rla as $item)

                                                <option
                                                    value="{{ $item->id }}"
                                                    data-rla="{{ $item->RLA_no }}"
                                                    data-lab="{{ $item->laboratory_code }}"
                                                    data-analysis="{{ $item->analysis_requested }}">

                                                    {{ $item->RLA_no }}

                                                </option>

                                                @endforeach

                                            </select>

                                            <div id="reader"></div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <script>
                                let scanner = null;

                                $("#selected_rla").change(function () {

                                    if ($(this).val() == "")
                                        return;

                                    if (scanner != null) {
                                        scanner.clear().catch(() => {});
                                    }

                                    Swal.fire({
                                        title: 'Opening Camera...',
                                        text: 'Please wait.',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    scanner = new Html5QrcodeScanner(
                                        "reader",
                                        {
                                            fps: 10,
                                            qrbox: {
                                                width: 280,
                                                height: 280
                                            },
                                            rememberLastUsedCamera: true,
                                            supportedScanTypes: [
                                                Html5QrcodeScanType.SCAN_TYPE_CAMERA
                                            ]
                                        },
                                        false
                                    );

                                    scanner.render(onScanSuccess);

                                    setTimeout(() => {
                                        Swal.close();
                                    }, 800);

                                });


                                function onScanSuccess(decodedText) {

                                    scanner.clear();

                                    let option = $("#selected_rla option:selected");

                                    // Swal.fire({
                                    //     title: "QR Code Detected",
                                    //     text: "Saving record...",
                                    //     icon: "success",
                                    //     timer: 1000,
                                    //     showConfirmButton: false
                                    // });

                                    $.ajax({

                                        url: "{{ route('equipment.scan') }}",

                                        type: "POST",

                                        data: {

                                            _token: "{{ csrf_token() }}",

                                            qr: decodedText,

                                            rla: option.data("rla"),

                                            laboratory_code: option.data("lab"),

                                            analysis: option.data("analysis")

                                        },

                                        success: function (res) {

                                            Swal.fire({
                                                icon: "success",
                                                title: "Success",
                                                text: res.message,
                                                timer: 1800,
                                                showConfirmButton: false
                                            });

                                            $("#selected_rla").val("");

                                            $("#qrModal").modal("hide");

                                        },

                                        error: function (xhr) {

                                            Swal.fire({
                                                icon: "error",
                                                title: "Oops!",
                                                text: xhr.responseJSON?.message ?? "Something went wrong."
                                            });

                                        }

                                    });

                                }
                            </script>
                            <style>
                                #reader__dashboard_section_csr,
                                    #reader__dashboard_section_swaplink,
                                    #reader__dashboard_section button {
                                        display: none !important;
                                    }

                                    #reader {
                                        border: none !important;
                                        box-shadow: none !important;
                                    }

                                    #reader video {
                                        border-radius: 15px;
                                        border: 3px solid #0d6efd;
                                    }

                                    #reader img {
                                        border-radius: 15px;
                                    }

                                    #reader__scan_region {
                                        border: none !important;
                                    }
                            </style>
                            <a class="btn btn-sm btn-icon btn-success" style="margin-left:770px"
                                data-bs-toggle="modal"
                                data-bs-target="#qrModal"
                                title="Scan Equipment">
                                SCAN
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" viewBox="0 0 30 30">
                                 <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACqUlEQVR4AcyXyctOURzHH0OmXmMKOztDJGRhXFiwpEQZwkq9CxQWhIxhIVKElMiUDP8AZUHGjFmRmQxlhUSKz+f0nqfzep577+a63rfv5/x+55x7fr97znPvPeftXPtPf2li/WXcx234At8TvuGfgi6QpYl0vIB0nP572k7CCKjLZFa6UlyAwzABWqBHQi/8BTAFsrSejqGQjtMfTNtCuAszISgmXkNtNuTpB52vIEtPsjra2ntiz8BAqJm4E85KiPqNcw62wpY2NmGnwkvI0lo6WiGO0e6i/hyi+uMshpB4CI7LgQk6SDkPTLYZK97EHfw8/aTzEHh9ZB31SeAzggkaZ+mMu+skXEv8MtyPBEl/hpDPxLS3k0vdrqGESkPMZolLyFMcolnihrsrDlN4RUNME79j2BtQvjL3dErmZhLvhr6JfRp98pbT4NfnKbZsrSLgUpgLeyG8Ttq3FPvhPvwLObnjBD4PYdmdsZ8xXyGXuAqOkbzFxCdwJsPYilhCnlYTp18V2irRVxO7Obj+fp+rYCNTO2Lihzg+cX6fq2A7+X6ZGFsbT7EPnD2mdLkrbSOqO5h7dHid3OQv07gCLoIPGaZUHSDaBtgJ2pB4EJV+oNybh+mUTBoz+HGpS85THK5DJc47SRZPpfkVDTGd8d8fkFmM9bfGlKLhREmPtiGfiT/R8Qyi3EE8ip6mwbO0+Fm1naZMDaBnN3h9xE3hFm3dIOq6jom1OywSfKXmU/csLYvwz8JIyJJJV9Pp9ZE51PtA1Gscbyq8Tvi1oxR7IE8uf++cC/rm9Nn1gcKfsb7U1IO82+l4LvED7OOER/iek1023KbyKHuJnnSc/lXaHDsKa1xMrT7jUKG4Av674VKPxo+MwfesjMmUR9gZ9MYx0U6jzbGfsXX9AQAA//8C8GoTAAAABklEQVQDANfVrj3uT8DjAAAAAElFTkSuQmCC" x="0" y="0" width="30" height="30"/>
                              </svg>
                            </a>
                            <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#addEquipmentModal"  data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add Equipment" title="Add Equipment">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 12.5537C12.2546 12.5537 14.4626 10.3171 14.4626 7.52684C14.4626 4.73663 12.2546 2.5 9.5 2.5C6.74543 2.5 4.53737 4.73663 4.53737 7.52684C4.53737 10.3171 6.74543 12.5537 9.5 12.5537ZM9.5 15.0152C5.45422 15.0152 2 15.6621 2 18.2464C2 20.8298 5.4332 21.5 9.5 21.5C13.5448 21.5 17 20.8531 17 18.2687C17 15.6844 13.5668 15.0152 9.5 15.0152ZM19.8979 9.58786H21.101C21.5962 9.58786 22 9.99731 22 10.4995C22 11.0016 21.5962 11.4111 21.101 11.4111H19.8979V12.5884C19.8979 13.0906 19.4952 13.5 18.999 13.5C18.5038 13.5 18.1 13.0906 18.1 12.5884V11.4111H16.899C16.4027 11.4111 16 11.0016 16 10.4995C16 9.99731 16.4027 9.58786 16.899 9.58786H18.1V8.41162C18.1 7.90945 18.5038 7.5 18.999 7.5C19.4952 7.5 19.8979 7.90945 19.8979 8.41162V9.58786Z" fill="currentColor"></path></svg>                        
                            </a>
                            
                            {{-- modal for add equipments --}}
                            <div class="modal fade" id="addEquipmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3 needs-validation" action="{{ route('lf_03_05.store')}}" method="POST" novalidate>
                                            @csrf
                                            <div class="col-md-6 position-relative  mb-2">
                                                <label for="equipment" class="form-label">Equipment</label>
                                                <input type="text" class="form-control" id="equipment" required name="equipment">
                                                <div class="invalid-tooltip">
                                                    Please provide a Equipment.
                                                </div>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                            </div>

                                            <div class="col-md-6 position-relative mb-2">
                                                <label for="equipment_no" class="form-label">Equipment No.</label>
                                                <input type="text" class="form-control" id="equipment_no" required name="equipment_no">
                                                <div class="invalid-tooltip">
                                                    Please provide a Equipment No.
                                                </div>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                            </div>

                                            <div class="col-md-6 position-relative mt-4 mb-2">
                                                <label for="model" class="form-label">Brand/Model</label>
                                                <input type="text" class="form-control" id="model" required name="model">
                                                <div class="invalid-tooltip">
                                                    Please provide a Brand/Model
                                                </div>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                            </div>

                                            <div class="col-md-6 position-relative mt-4 mb-2">
                                                <label for="location" class="form-label">Location</label>
                                                <input type="text" class="form-control" id="location" required name="location">
                                                <div class="invalid-tooltip">
                                                    Please provide a location.
                                                </div>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                            </div>
                                                <div class="col-md-6 position-relative mt-4 mb-2">
                                                    <label for="month" class="form-label">Month</label>
                                                    <input type="month" class="form-control" id="month" required>
                                                </div>

                                                <div class="col-md-6 position-relative mt-4 mb-2">
                                                    <label for="year" class="form-label">Year</label>
                                                    <input type="number" class="form-control" id="year" readonly placeholder="YYYY">
                                                </div>

                                                <!-- Hidden inputs for actual submission -->
                                                <input type="hidden" name="month" id="month_db">
                                                <input type="hidden" name="year" id="year_db">

                                                

                                                <script>
                                                const monthInput = document.getElementById('month');
                                                const yearInput = document.getElementById('year');
                                                const monthDbInput = document.getElementById('month_db');
                                                const yearDbInput = document.getElementById('year_db');

                                                monthInput.addEventListener('input', () => {
                                                    if (monthInput.value) {
                                                        const [year, month] = monthInput.value.split('-');
                                                        yearInput.value = year;       // display only
                                                        monthDbInput.value = month;   // submit month only
                                                        yearDbInput.value = year;     // submit year
                                                    } else {
                                                        yearInput.value = '';
                                                        monthDbInput.value = '';
                                                        yearDbInput.value = '';
                                                    }
                                                });
                                                </script>


                                            <div class="col-12 mt-4">
                                                <button class="btn btn-success" type="submit">Submit</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    
                                    </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="table-responsive mt-3">
                                <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="light">
                                            <th>Equipment </th>
                                            <th>Equipment No.</th>
                                            <th>Brand Model</th>
                                            <th>Location</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($equipments as $equipment)
                                        <tr>
                                            <td>{{ $equipment->equipment }}</td>
                                            <td>{{ $equipment->equipment_no ?? 'N/A' }}</td>
                                            <td>{{ $equipment->model ?? 'N/A' }}</td>
                                            <td>{{ $equipment->location ?? 'N/A' }}</td>
                                           @php
                                                $months = [
                                                    '01'=>'January','02'=>'February','03'=>'March','04'=>'April',
                                                    '05'=>'May','06'=>'June','07'=>'July','08'=>'August',
                                                    '09'=>'September','10'=>'October','11'=>'November','12'=>'December'
                                                ];
                                            @endphp

                                            <td>{{ $equipment->month ? $months[$equipment->month] : 'N/A' }}</td>


                                            <td>{{ $equipment->year ?? 'N/A' }}</td>
                                            

                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    {{-- <a class="btn btn-sm btn-icon btn-success view-client"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewClientModal"
                                                        data-id="{{ $client->id }}"
                                                        data-company="{{ $client->company_name }}"
                                                        data-address="{{ $client->address }}"
                                                        data-contact="{{ $client->contact_no }}"
                                                        data-source="{{ $client->source_sample }}"
                                                        data-description="{{ $client->sample_description }}"
                                                        data-code="{{ $client->sample_code }}"
                                                        data-analysis="{{ $client->analysis_requested }}"
                                                        data-species="{{ $client->species }}"
                                                        data-date="{{ $client->date }}"
                                                        data-classification="{{ $client->classification }}"
                                                        title="View Details">

                                                           <span class="btn-inner">
                                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                            </span>
                                                        </a> --}}
                                                    
                                                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Edit" href="{{ route('equipments_book.index', $equipment->id) }}" aria-label="Logs" data-bs-original-title="Logs">
                                                        <span class="btn-inner">
                                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.81 2H16.191C19.28 2 21 3.78 21 6.83V17.16C21 20.26 19.28 22 16.191 22H7.81C4.77 22 3 20.26 3 17.16V6.83C3 3.78 4.77 2 7.81 2ZM8.08 6.66V6.65H11.069C11.5 6.65 11.85 7 11.85 7.429C11.85 7.87 11.5 8.22 11.069 8.22H8.08C7.649 8.22 7.3 7.87 7.3 7.44C7.3 7.01 7.649 6.66 8.08 6.66ZM8.08 12.74H15.92C16.35 12.74 16.7 12.39 16.7 11.96C16.7 11.53 16.35 11.179 15.92 11.179H8.08C7.649 11.179 7.3 11.53 7.3 11.96C7.3 12.39 7.649 12.74 8.08 12.74ZM8.08 17.31H15.92C16.319 17.27 16.62 16.929 16.62 16.53C16.62 16.12 16.319 15.78 15.92 15.74H8.08C7.78 15.71 7.49 15.85 7.33 16.11C7.17 16.36 7.17 16.69 7.33 16.95C7.49 17.2 7.78 17.35 8.08 17.31Z" fill="currentColor"></path>                            </svg>                        
                                                        </span>
                                                    </a>
                                                <form action="{{ route('clients.delete', $equipment->id) }}" method="POST" class="delete-form d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="#" 
                                                    class="btn btn-sm btn-icon btn-danger delete-button" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Delete" 
                                                    aria-label="Delete"
                                                    >
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </form>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        document.querySelectorAll('.delete-button').forEach(function(button) {
                                                            button.addEventListener('click', function(e) {
                                                                e.preventDefault();

                                                                Swal.fire({
                                                                    title: 'Are you sure?',
                                                                    text: 'You will not be able to recover this data!',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#d33',
                                                                    cancelButtonColor: '#3085d6',
                                                                    confirmButtonText: 'Yes, delete it!',
                                                                    reverseButtons: true,
                                                                    buttonsStyling: false,
                                                                    customClass: {
                                                                        confirmButton: 'btn btn-primary mx-2', 
                                                                        cancelButton: 'btn btn-danger mx-2'    
                                                                    }
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        button.closest('.delete-form').submit();
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    });
                                                    </script>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                              <div class="card-body">
                                    <div class="d-flex ">
                                    {{ $equipments->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection