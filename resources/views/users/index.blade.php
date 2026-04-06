@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="conatiner-fluid content-inner ">
     <form action="{{ route('users/index') }}" method="GET" class="form-inline d-flex">
        <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-danger mr-2 ml-2" style="margin-lefT:2mm">Search</button>
        <a href="{{ route('users/index') }}" class="btn btn-outline-secondary" style="margin-lefT:2mm">Clear</a>
    </form>
    <div class="row mt-3">
        
        @foreach ($users as $user)
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                            <div class=" flex-column align-items-center justify-content-center">
                                 <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" href="{{ route('users.details', $user->id) }}" aria-label="View Details" data-bs-original-title="View Details">
                                    <span class="btn-inner">
                                         <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                    </span>
                                 </a>
                                 <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="Edit" href="{{ route('users.edit', $user->id) }}" aria-label="Edit" data-bs-original-title="Edit">
                                    <span class="btn-inner">
                                       <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                       </svg>
                                    </span>
                                 </a>
                                    <form action="{{ route('users.delete', $user->id) }}" method="POST" class="delete-form d-inline">
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
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ $user->image ? asset( $user->image) : asset('../../assets/images/avatars/01.png') }}" 
                                        alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100 profileImages">

                                    <img src="{{ $user->image ? asset($user->image) : asset('../../assets/images/avatars/avtar_1.png') }}" 
                                        alt="User-Profile" class="theme-color-purple-img img-fluid rounded-pill avatar-100 profileImages">

                                    <img src="{{ $user->image ? asset($user->image) : asset('../../assets/images/avatars/avtar_2.png') }}" 
                                        alt="User-Profile" class="theme-color-blue-img img-fluid rounded-pill avatar-100 profileImages">

                                    <img src="{{ $user->image ? asset($user->image) : asset('../../assets/images/avatars/avtar_4.png') }}" 
                                        alt="User-Profile" class="theme-color-green-img img-fluid rounded-pill avatar-100 profileImages">

                                    <img src="{{ $user->image ? asset($user->image) : asset('../../assets/images/avatars/avtar_5.png') }}" 
                                        alt="User-Profile" class="theme-color-yellow-img img-fluid rounded-pill avatar-100 profileImages">

                                    <img src="{{ $user->image ? asset($user->image) : asset('../../assets/images/avatars/avtar_3.png') }}" 
                                        alt="User-Profile" class="theme-color-pink-img img-fluid rounded-pill avatar-100 profileImages">
                            </div>


                           <div class="border bg-danger-subtle rounded p-3">
                                <div class="text-center">
                                    <span class="text-success">
                                        <i class="fa fa-user"></i> 
                                        {{ $user->l_name }} {{ $user->f_name }} {{ $user->m_name }}
                                    </span>

                                    <br>

                                    <small class="text-muted">
                                        @php
                                            $roles = [
                                                0 => 'Laboratory Manager',
                                                1 => 'Quality Assurance Manager',
                                                2 => 'Purchase Supply Officer / Laboratory Analyst - Fish Health Unit',
                                                3 => 'Laboratory Analyst - Microbiology Unit',
                                                4 => 'Laboratory Analyst - Fish Health Unit',
                                                5 => 'Customer Service Officer',
                                                6 => 'Utility',
                                            ];
                                        @endphp

                                        {{ $roles[$user->role] ?? 'N/A' }}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                 @endforeach
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center">
                            <a class="btn btn-lg btn-icon btn-primary mt-5 mb-5 p-4" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" 
                            href="{{ route('users/create')}}" 
                            aria-label="Add New User" 
                            data-bs-original-title="Add New User">
                                <span class="btn-inner">
                                    <svg class="icon-40" width="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </a>  
                            
                        </div>
                         
                    </div>
                    
                </div>
                
                <div class="card-body">
                    <div class="d-flex ">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
       </div>
    
</div>
@endsection