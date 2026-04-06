@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="conatiner-fluid content-inner mt-n5 py-0">
      <div>
         <div class="row">
            <div class="col-xl-3 col-lg-4">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     {{-- <div class="header-title">
                        <h4 class="card-title">Add New User</h4>
                     </div> --}}
                  </div>
                  <div class="card-body">
                     
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id}}">
                        <div class="form-group">
                           <div class="profile-img-edit position-relative">
                              <img src="{{ $user->image ? asset($user->image) : asset('assets/images/avatars/12.jpg') }}" alt="profile-pic" class="theme-color-default-img profile-pic rounded avatar-130" id="profileImage">
                              {{-- <img src="../../assets/images/avatars/avtar_1.png" alt="profile-pic" class="theme-color-purple-img profile-pic rounded avatar-100" id="profileImage">
                              <img src="../../assets/images/avatars/avtar_2.png" alt="profile-pic" class="theme-color-blue-img profile-pic rounded avatar-100" id="profileImage">
                              <img src="../../assets/images/avatars/avtar_4.png" alt="profile-pic" class="theme-color-green-img profile-pic rounded avatar-100" id="profileImage">
                              <img src="../../assets/images/avatars/avtar_5.png" alt="profile-pic" class="theme-color-yellow-img profile-pic rounded avatar-100" id="profileImage">
                              <img src="../../assets/images/avatars/avtar_3.png" alt="profile-pic" class="theme-color-pink-img profile-pic rounded avatar-100" id="profileImage"> --}}
                               
                            <input type="file" id="image" name="image" style="display: none;" accept="image/png, image/gif, image/jpeg">
    
                              {{-- <div class="upload-icone bg-primary upload-image-btn" onclick="uploadImage()">
                                 <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                    <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"></path>
                                 </svg>
                                 <input class="file-upload" type="file" accept="image/*">
                              </div> --}}
                           </div>
                           {{-- <div class="img-extension mt-3">
                              <div class="d-inline-block align-items-center">
                                 <span>Only</span>
                                 <a href="javascript:void();">.jpg</a>
                                 <a href="javascript:void();">.png</a>
                                 <a href="javascript:void();">.jpeg</a>
                                 <span>allowed</span>
                              </div>
                           </div> --}}
                        </div>
                        <script>
                                
                                function uploadImage() {
                                    document.getElementById('image').click();
                                }

                                document.addEventListener('DOMContentLoaded', function() {
                                    const imageInput = document.getElementById('image');
                                    const avatarImage = document.getElementById('profileImage');

                                    imageInput.addEventListener('change', function(event) {
                                        const selectedImage = event.target.files[0];
                                        if (selectedImage) {
                                            avatarImage.src = URL.createObjectURL(selectedImage);
                                        }
                                    });
                                });
                            </script>
                        <div class="form-group">
                           <label class="form-label">Position:</label>
                          <h4 class="card-title">
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
                          </h4>
                        </div>
                       <div class="form-group">
                            <label class="form-label">Email Address:</label>
                            <h6>{{ $user->email ?? 'N/A' }}</h6>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone Number:</label>
                            <h6>{{ $user->phone_no ?? 'N/A' }}</h6>
                        </div>

                       
                  </div>
               </div>
            </div>
            <div class="col-xl-9 col-lg-8">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <span class="badge bg-primary fs-5 mb-2">Profile Information</span>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="info-box p-3 border rounded">
                        <label class="form-label text-muted">First Name</label>
                        <h5 class="fw-semibold mb-0">{{ $user->f_name ?? 'N/A' }}</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 border rounded">
                        <label class="form-label text-muted">Middle Name</label>
                        <h5 class="fw-semibold mb-0">{{ $user->m_name ?? 'N/A' }}</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 border rounded">
                        <label class="form-label text-muted">Last Name</label>
                        <h5 class="fw-semibold mb-0">{{ $user->l_name ?? 'N/A' }}</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box p-3 border rounded">
                        <label class="form-label text-muted">Location</label>
                        <h5 class="fw-semibold mb-0">{{ $user->location ?? 'N/A' }}</h5>
                    </div>
                </div>
            </div>

            <hr>

            <span class="badge bg-success fs-5 mb-2">Account Information</span>
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="info-box p-3 border rounded">
                        <label class="form-label text-muted">User Name</label>
                        <h5 class="fw-semibold mb-0">{{ $user->username ?? 'N/A' }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-box {
        background-color: #f9f9f9;
    }
    .info-box label {
        font-size: 0.875rem;
    }
    .info-box h5 {
        margin-top: 0.25rem;
    }
</style>

         </div>
      </div>
    </div>
    @endsection