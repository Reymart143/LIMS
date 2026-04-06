@extends('layouts.app')
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><span class="badge bg-warning p-3">LABORATORY RECORD LIST</span></h4>
                         
                        </div>
                        {{-- <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" href="/create/clients" aria-label="Add Clients" title="Add Clients">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 12.5537C12.2546 12.5537 14.4626 10.3171 14.4626 7.52684C14.4626 4.73663 12.2546 2.5 9.5 2.5C6.74543 2.5 4.53737 4.73663 4.53737 7.52684C4.53737 10.3171 6.74543 12.5537 9.5 12.5537ZM9.5 15.0152C5.45422 15.0152 2 15.6621 2 18.2464C2 20.8298 5.4332 21.5 9.5 21.5C13.5448 21.5 17 20.8531 17 18.2687C17 15.6844 13.5668 15.0152 9.5 15.0152ZM19.8979 9.58786H21.101C21.5962 9.58786 22 9.99731 22 10.4995C22 11.0016 21.5962 11.4111 21.101 11.4111H19.8979V12.5884C19.8979 13.0906 19.4952 13.5 18.999 13.5C18.5038 13.5 18.1 13.0906 18.1 12.5884V11.4111H16.899C16.4027 11.4111 16 11.0016 16 10.4995C16 9.99731 16.4027 9.58786 16.899 9.58786H18.1V8.41162C18.1 7.90945 18.5038 7.5 18.999 7.5C19.4952 7.5 19.8979 7.90945 19.8979 8.41162V9.58786Z" fill="currentColor"></path></svg>                        
                            </a> --}}
                        </div>
                        <div class="card-body ">
                            <input type="text" id="searchInput" style="width: 50%"  placeholder="Search Document Code or Title" class="form-control mb-3">
                            

                            <div class="table-responsive">
                                
                                <table id="documentsTable" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="light">
                                            <th>Document Code</th>
                                            <th>Title</th>
                                            <th>Document Type</th>
                                            <th>Revision No.</th>
                                            <th>Date Adopted</th>
                                            {{-- <th>Page No.</th> --}}
                                            
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>LF 00-01</td>
                                            <td>CROSS-REFERENCE OF QUALITY MANUAL SYSTEM TO PNS 1SO/IEC 17025:2017</td>
                                            <td>Laboratory Record</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>
                                            {{-- <td>Page 1</td> --}}
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR00-01.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR00-01.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LR-01-01</td>
                                            <td>ORGANOGRAMM</td>
                                            <td>Laboratory Record</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>
                                            {{-- <td>Page 1</td> --}}
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR01-01,Organogramm.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR01-01,Organogramm.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>LR-01-02</td>
                                            <td>SUCCESSION PLAN</td>
                                            <td>Laboratory Record</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>
                                            {{-- <td>Page 1</td> --}}
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR01-02,SuccessionPlan.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR01-02,SuccessionPlan.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LR 01-03</td>
                                            <td>LIST OF AUTHORIZED PERSONNEL </td>
                                            <td>Laboratory Record</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>

                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR01-03,ListofAuthorizedPersonnel.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR01-03,ListofAuthorizedPersonnel.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LR 01-04</td>
                                            <td>PERSONNEL COMPETENCE ASSESSMENT  RECORD </td>
                                            <td>Laboratory Record</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>

                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR01-04CompetenceAssessment Record_2019.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR01-04CompetenceAssessment Record_2019.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LR W02-03</td>
                                            <td>PERSONNEL COMPETENCE ASSESSMENT  RECORD </td>
                                            <td>Laboratory Record</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>
                                            
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR01-04,.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR01-04,.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LR 02-01</td>
                                            <td>LAYOUT OF BFAR LABORATORIES </td>
                                            <td>Quality Manual</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>
                                            
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR02-01LayoutofBFARLaboratories.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR02-01LayoutofBFARLaboratories.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LR 06-01</td>
                                            <td>SAMPLE RECEIVING AND RELEASING LOGBOOK </td>
                                            <td>Laboratory Records</td>
                                            <td>0</td>
                                            <td>13 , Aug 2019
                                            </td>
                                          
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary"
                                                    onclick="openPDF('{{ asset('LR/LR06-01.pdf') }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPdfModal"
                                                    title="View Details">
                                                         <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" fill="currentColor"></path><circle cx="12" cy="12" r="5" fill="#918F98"></circle>                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                </mask>                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white" fill-opacity="0.6"></circle></svg>                                                              
                                                        </span>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-success"
                                                        href="{{ asset('LR/LR06-01.pdf') }}"
                                                        download
                                                        data-bs-toggle="tooltip"
                                                        title="Download">

                                                        <span class="btn-inner">
                                                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path></svg>                        
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-3 p-2">
                                    <div id="pagination"></div>
                                </div>
                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const table = document.getElementById('documentsTable');
                                        const tbody = table.querySelector('tbody');
                                        const rows = Array.from(tbody.querySelectorAll('tr'));
                                        const searchInput = document.getElementById('searchInput');

                                        let currentPage = 1;
                                        const rowsPerPage = 10;

                                        function filteredRows() {
                                            const filter = searchInput.value.toLowerCase();
                                            return rows.filter(row => {
                                                const code = row.cells[0].textContent.toLowerCase();
                                                const title = row.cells[1].textContent.toLowerCase();
                                                return code.includes(filter) || title.includes(filter);
                                            });
                                        }

                                        function renderTable(filtered) {
                                            tbody.innerHTML = '';

                                            if(filtered.length === 0) {
                                                const tr = document.createElement('tr');
                                                const td = document.createElement('td');
                                                td.colSpan = table.querySelectorAll('th').length; 
                                                td.className = 'text-center text-muted';
                                                td.textContent = 'No matching documents found';
                                                tr.appendChild(td);
                                                tbody.appendChild(tr);

                                                document.getElementById('pagination').innerHTML = ''; 
                                                return;
                                            }

                                            const start = (currentPage - 1) * rowsPerPage;
                                            const end = start + rowsPerPage;
                                            filtered.slice(start, end).forEach(row => tbody.appendChild(row));
                                            renderPagination(filtered.length);
                                        }

                                        function renderPagination(totalRows) {
                                            const paginationContainer = document.getElementById('pagination');
                                            paginationContainer.innerHTML = '';

                                            const totalPages = Math.ceil(totalRows / rowsPerPage);
                                            if(totalPages <= 1) return;

                                            const ul = document.createElement('ul');
                                            ul.className = 'flex-wrap pagination pagination';

                                            const prevLi = document.createElement('li');
                                            prevLi.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
                                            const prevLink = document.createElement('a');
                                            prevLink.className = 'page-link';
                                            prevLink.href = '#';
                                            prevLink.textContent = 'Previous';
                                            prevLink.addEventListener('click', (e) => {
                                                e.preventDefault();
                                                if(currentPage > 1) {
                                                    currentPage--;
                                                    renderTable(filteredRows());
                                                }
                                            });
                                            prevLi.appendChild(prevLink);
                                            ul.appendChild(prevLi);

                                            for(let i = 1; i <= totalPages; i++) {
                                                const li = document.createElement('li');
                                                li.className = 'page-item' + (i === currentPage ? ' active' : '');
                                                const link = document.createElement('a');
                                                link.className = 'page-link';
                                                link.href = '#';
                                                link.textContent = i;
                                                link.addEventListener('click', (e) => {
                                                    e.preventDefault();
                                                    currentPage = i;
                                                    renderTable(filteredRows());
                                                });
                                                li.appendChild(link);
                                                ul.appendChild(li);
                                            }

                                            const nextLi = document.createElement('li');
                                            nextLi.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
                                            const nextLink = document.createElement('a');
                                            nextLink.className = 'page-link';
                                            nextLink.href = '#';
                                            nextLink.textContent = 'Next';
                                            nextLink.addEventListener('click', (e) => {
                                                e.preventDefault();
                                                if(currentPage < totalPages) {
                                                    currentPage++;
                                                    renderTable(filteredRows());
                                                }
                                            });
                                            nextLi.appendChild(nextLink);
                                            ul.appendChild(nextLi);

                                            paginationContainer.appendChild(ul);
                                        }

                                        searchInput.addEventListener('input', () => {
                                            currentPage = 1;
                                            renderTable(filteredRows());
                                        });

                                        renderTable(rows); 
                                    });
                                    </script>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="modal fade" id="viewPdfModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewPdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                   
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfViewer"
                                    src=""
                                    width="100%"
                                    height="700px"
                                    style="border: none;">
                            </iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                       
                    </div>
                    </div>
                </div>
            </div>
            <script>
            function openPDF(url) {
                document.getElementById("pdfViewer").src = url;
            }
            document.getElementById('viewPdfModal').addEventListener('hidden.bs.modal', function () {
                document.getElementById("pdfViewer").src = "";
            });
            </script>


    </div>

    

@endsection