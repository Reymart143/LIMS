@extends('layouts.app')
@section('content')
<style>
    #user-list-table {
    border-collapse: collapse;
    width: 100%;
}

#user-list-table th,
#user-list-table td {
    border: 1px solid #b7b9bd; /* light gray border */
    padding: 10px;
}

#user-list-table thead th {
    background-color: #f5f5f5;
    text-align: center;
    vertical-align: middle;
}
</style>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                
                <div class="col-sm-12">
                    <div class="card">
                        
                        <div class="card-header d-flex justify-content-between">
                          
                        <div class="header-title">
                            <h4 class="card-title"><span class="badge bg-warning p-3">LF 07-FIS-01 : SAMPLE STORAGE AND DISPOSAL LOGBOOK </span></h4>
                        </div>
                     
                         <div class="d-flex gap-2">
                            <a class="btn btn- btn-icon btn-danger"
                                href="{{ route('sampledisposal.download.pdf') }}" data-download
                                data-bs-toggle="tooltip"
                                title="Download PDF">
                                    <span class="btn-inner">
                                        <svg class="icon-25" width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                                <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" href="/create_sample_logbook" aria-label="Add Logbooks" title="Add Logbooks">
                                    <svg class="icon-25" width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.81 2H16.191C19.28 2 21 3.78 21 6.83V17.16C21 20.26 19.28 22 16.191 22H7.81C4.77 22 3 20.26 3 17.16V6.83C3 3.78 4.77 2 7.81 2ZM8.08 6.66V6.65H11.069C11.5 6.65 11.85 7 11.85 7.429C11.85 7.87 11.5 8.22 11.069 8.22H8.08C7.649 8.22 7.3 7.87 7.3 7.44C7.3 7.01 7.649 6.66 8.08 6.66ZM8.08 12.74H15.92C16.35 12.74 16.7 12.39 16.7 11.96C16.7 11.53 16.35 11.179 15.92 11.179H8.08C7.649 11.179 7.3 11.53 7.3 11.96C7.3 12.39 7.649 12.74 8.08 12.74ZM8.08 17.31H15.92C16.319 17.27 16.62 16.929 16.62 16.53C16.62 16.12 16.319 15.78 15.92 15.74H8.08C7.78 15.71 7.49 15.85 7.33 16.11C7.17 16.36 7.17 16.69 7.33 16.95C7.49 17.2 7.78 17.35 8.08 17.31Z" fill="currentColor"></path>                            </svg>                              </a>
                             </div>
                        </div>
                        
                        <div class="card-body ">
                            
                              {{-- <form action="{{ route('clients') }}" method="GET" class="form-inline d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Search Clients..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-danger mr-2 ml-2" style="margin-lefT:2mm">Search</button>
                                <a href="{{ route('clients') }}" class="btn btn-outline-secondary" style="margin-lefT:2mm">Clear</a>
                            </form> --}}
                            <div class="table-responsive mt-3">
                                
                                <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="light">
                                            <th rowspan="2" class="text-wrap">Laboratory Code</th>
                                            <th rowspan="2" class="text-wrap">Sample Description</th>
                                            
                                            <th colspan="3" class="text-center">DATE</th>
                                            
                                            <th rowspan="2" class="text-wrap">Date for Disposal</th>
                                            <th rowspan="2" class="text-wrap">Disposed By</th>
                                            <th rowspan="2" style="min-width: 100px">Action</th>
                                        </tr>
                                        <tr class="light">
                                            <th class="text-wrap">Received</th>
                                            <th class="text-wrap">Stored</th>
                                            <th class="text-wrap">Analyzed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($samples as $s)
                                        <tr>
                                            <td>{{ $s->lab_code }}</td>
                                            <td>{{ $s->sample_desc ?? 'N/A' }}</td>
                                           <td>
                                                {{ $s->date_received 
                                                    ? \Carbon\Carbon::parse($s->date_received)->format('F d, Y') 
                                                    : 'N/A' 
                                                }}
                                            </td>
                                            <td>
                                                {{ $s->date_stored 
                                                    ? \Carbon\Carbon::parse($s->date_stored)->format('F d, Y') 
                                                    : 'N/A' 
                                                }}
                                            </td>
                                          <td>
                                                {{ $s->date_analyzed 
                                                    ? \Carbon\Carbon::parse($s->date_analyzed)->format('F d, Y') 
                                                    : 'N/A' 
                                                }}
                                            </td>
                                            <td>
                                                {{ $s->date_disposal 
                                                    ? \Carbon\Carbon::parse($s->date_disposal)->format('F d, Y') 
                                                    : 'N/A' 
                                                }}
                                            </td>
                                            <td>{{ $s->disposed_by ?? 'N/A' }}</td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    
                                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Edit" href="{{ route('sample.edit', $s->id) }}" aria-label="Edit" data-bs-original-title="Edit">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                <form action="{{ route('sample.delete', $s->id) }}" method="POST" class="delete-form d-inline">
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
                        </div>
                    </div>
                </div>

                   <div class="card-body">
                        <div class="d-flex ">
                        {{ $samples->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection