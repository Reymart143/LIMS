@extends('layouts.app')
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                
                <div class="col-sm-12">
                    <div class="card">
                        
                        <div class="card-header d-flex justify-content-between">
                          
                        <div class="header-title">
                            <h4 class="card-title">CLIENTS LIST</h4>
                        </div>
                        <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" href="/create/clients" aria-label="Add Clients" title="Add Clients">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 12.5537C12.2546 12.5537 14.4626 10.3171 14.4626 7.52684C14.4626 4.73663 12.2546 2.5 9.5 2.5C6.74543 2.5 4.53737 4.73663 4.53737 7.52684C4.53737 10.3171 6.74543 12.5537 9.5 12.5537ZM9.5 15.0152C5.45422 15.0152 2 15.6621 2 18.2464C2 20.8298 5.4332 21.5 9.5 21.5C13.5448 21.5 17 20.8531 17 18.2687C17 15.6844 13.5668 15.0152 9.5 15.0152ZM19.8979 9.58786H21.101C21.5962 9.58786 22 9.99731 22 10.4995C22 11.0016 21.5962 11.4111 21.101 11.4111H19.8979V12.5884C19.8979 13.0906 19.4952 13.5 18.999 13.5C18.5038 13.5 18.1 13.0906 18.1 12.5884V11.4111H16.899C16.4027 11.4111 16 11.0016 16 10.4995C16 9.99731 16.4027 9.58786 16.899 9.58786H18.1V8.41162C18.1 7.90945 18.5038 7.5 18.999 7.5C19.4952 7.5 19.8979 7.90945 19.8979 8.41162V9.58786Z" fill="currentColor"></path></svg>                        
                            </a>
                        </div>
                        
                        <div class="card-body ">
                              <form action="{{ route('clients') }}" method="GET" class="form-inline d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Search Clients..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-danger mr-2 ml-2" style="margin-lefT:2mm">Search</button>
                                <a href="{{ route('clients') }}" class="btn btn-outline-secondary" style="margin-lefT:2mm">Clear</a>
                            </form>
                            <div class="table-responsive mt-3">
                                
                                <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="light">
                                            <th>Company Name</th>
                                            <th>Contact</th>
                                           
                                            <th>Status</th>
                                            <th>Join Date</th>
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                        <tr>
                                            <td>{{ $client->company_name }}</td>
                                            <td>{{ $client->contact_no ?? 'N/A' }}</td>
                                            {{-- <td>{{ $client->source_sample ?? 'N/A' }}</td>
                                            <td>{{ $client->sample_description ?? 'N/A' }}</td> --}}
                                            <td>
                                                @if($client->status == 0)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            {{-- <td>{{ $client->species ?? 'N/A' }}</td> --}}
                                            <td>
                                                {{ $client->date 
                                                    ? \Carbon\Carbon::parse($client->date)->format('F d, Y') 
                                                    : 'N/A' 
                                                }}
                                            </td>

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
                                                    
                                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Edit" href="{{ route('clients.edit', $client->id) }}" aria-label="Edit" data-bs-original-title="Edit">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                <form action="{{ route('clients.delete', $client->id) }}" method="POST" class="delete-form d-inline">
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
                        {{ $clients->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="viewClientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Client Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Company:</strong> <span id="m_company"></span></p>
                    <p><strong>Address:</strong> <span id="m_address"></span></p>
                    <p><strong>Contact:</strong> <span id="m_contact"></span></p>
                    <p><strong>Source Sample:</strong> <span id="m_source"></span></p>
                    <p><strong>Description:</strong> <span id="m_description"></span></p>
                    <p><strong>Sample Code:</strong> <span id="m_code"></span></p>
                    <p><strong>Analysis:</strong> <span id="m_analysis"></span></p>
                    <p><strong>Species:</strong> <span id="m_species"></span></p>
                    <p><strong>Date:</strong> <span id="m_date"></span></p>
                    <p><strong>Classification:</strong> <span id="m_classification"></span></p>
                </div>

            </div>
        </div>
    </div>
    <script> 
        $(document).on('click', '.view-client', function () {

            $('#m_company').text($(this).data('company') ?? 'N/A');
            $('#m_address').text($(this).data('address') ?? 'N/A');
            $('#m_contact').text($(this).data('contact') ?? 'N/A');
            $('#m_source').text($(this).data('source') ?? 'N/A');
            $('#m_description').text($(this).data('description') ?? 'N/A');
            $('#m_code').text($(this).data('code') ?? 'N/A');
            $('#m_analysis').text($(this).data('analysis') ?? 'N/A');
            $('#m_species').text($(this).data('species') ?? 'N/A');
            $('#m_classification').text($(this).data('classification') ?? 'N/A');

            // Format date
            let date = $(this).data('date');
            if (date) {
                let d = new Date(date);
                let options = { year: 'numeric', month: 'long', day: 'numeric' };
                $('#m_date').text(d.toLocaleDateString('en-US', options));
            } else {
                $('#m_date').text('N/A');
            }

        });
        </script>
--}}
@endsection