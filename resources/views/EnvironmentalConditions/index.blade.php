@extends('layouts.app')

@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-warning p-3">LF 02-01 : ENVIRONMENTAL MONITORING LOGBOOK</span></h4>
                    </div>
                    <div class="d-flex gap-2">
                  <a class="btn btn-icon btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#downloadEnvironmentalModal" title="Download PDF"> <span class="btn-inner"> <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path> </svg> </span> </a> <div class="modal fade" id="downloadEnvironmentalModal" tabindex="-1" aria-labelledby="downloadEnvironmentalModalLabel" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <form action="{{ route('environmental.download.pdf') }}" method="GET" target="_blank"> <div class="modal-header"> <h5 class="modal-title" id="downloadEnvironmentalModalLabel">Download Environmental PDF</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body"> <label for="laboratory_name" class="form-label">Select Laboratory Name</label> <select name="laboratory_name" id="laboratory_name" class="form-control" required> <option value="">-- Select Laboratory --</option> @foreach($laboratories as $lab) <option value="{{ $lab->laboratory_name }}">{{ $lab->laboratory_name }}</option> @endforeach </select> <small class="text-muted"> All records with the selected laboratory name will be included in the PDF. </small> </div> <div class="modal-footer"> <button type="submit" class="btn btn-danger">Download PDF</button> </div> </form> </div> </div> </div>
                        <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" href="/environmental_plan/create" aria-label="Add Plan" title="Add Plan">
                        <svg width="32" height="32" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">

                            <path d="M80 20V70L35 145C29 155 36 168 48 168H152C164 168 171 155 165 145L120 70V20"
                                stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>

                            <path d="M70 20H130" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>

                            <path d="M55 125C70 118 82 130 100 130C118 130 130 118 145 125V145C145 149 142 152 138 152H62C58 152 55 149 55 145V125Z"
                                fill="currentColor" opacity="0.25"/>

                            <circle cx="88" cy="102" r="6" fill="currentColor"/>
                            <circle cx="112" cy="92" r="4" fill="currentColor"/>
                            <circle cx="100" cy="112" r="3" fill="currentColor"/>
                        </svg> 
                    </a>
                 </div>
                </div>

                <div class="card-body">
                  
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Area</th>
                                    <th>Laboratory</th>
                                    <th>Date</th>
                                    <th>Temp AM</th>
                                    <th>Temp PM</th>
                                    <th>Humidity AM</th>
                                    <th>Humidity PM</th>
                                    <th>Remarks</th>
                                    <th>Analyst</th>
                                    <th>Checked By</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($environmentals as $item)
                                    <tr>
                                        <td>{{ $item->area }}</td>
                                        <td>{{ $item->laboratory_name }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->temperature_am }}</td>
                                        <td>{{ $item->temperature_pm }}</td>
                                        <td>{{ $item->humidity_am }}</td>
                                        <td>{{ $item->humidity_pm }}</td>
                                        <td>{{ $item->remarks }}</td>
                                        <td>{{ $item->analyst }}</td>
                                        <td>{{ $item->checked_by }}</td>
                                        <td>
                                             <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Edit" href="{{ route('environmental.edit', $item->id) }}" aria-label="Edit" data-bs-original-title="Edit">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                     {{-- <a class="btn btn-sm btn-icon btn-success"
                                                            href="{{ route('rla.download.pdf', $item->id) }}" data-download
                                                            data-bs-toggle="tooltip"
                                                            title="Download PDF">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </a> --}}
                                                <form action="{{ route('environmental.delete', $item->id) }}" method="POST" class="delete-form d-inline">
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
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                          {{ $environmentals->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection