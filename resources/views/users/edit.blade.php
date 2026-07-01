@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="conatiner-fluid content-inner mt-n5 py-0">
      <div>
         <div class="row">
            <div class="col-xl-3 col-lg-4">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Update  User</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id}}">
                        <div class="form-group">
                           <div class="profile-img-edit position-relative">
                              <img src="{{ $user->image ? asset($user->image) : asset('assets/images/avatars/12.jpg') }}" alt="profile-pic" class="theme-color-default-img profile-pic rounded avatar-100" id="profileImage">
                                 {{-- <img src="../../assets/images/avatars/avtar_1.png" alt="profile-pic" class="theme-color-purple-img profile-pic rounded avatar-100" id="profileImage">
                                 <img src="../../assets/images/avatars/avtar_2.png" alt="profile-pic" class="theme-color-blue-img profile-pic rounded avatar-100" id="profileImage">
                                 <img src="../../assets/images/avatars/avtar_4.png" alt="profile-pic" class="theme-color-green-img profile-pic rounded avatar-100" id="profileImage">
                                 <img src="../../assets/images/avatars/avtar_5.png" alt="profile-pic" class="theme-color-yellow-img profile-pic rounded avatar-100" id="profileImage">
                              <img src="../../assets/images/avatars/avtar_3.png" alt="profile-pic" class="theme-color-pink-img profile-pic rounded avatar-100" id="profileImage"> --}}
                               
                            <input type="file" id="image" name="image" style="display: none;" accept="image/png, image/gif, image/jpeg">
    
                              <div class="upload-icone bg-primary upload-image-btn" onclick="uploadImage()">
                                 <svg class="upload-button icon-14" width="14" viewBox="0 0 24 24">
                                    <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"></path>
                                 </svg>
                                 <input class="file-upload" type="file" accept="image/*">
                              </div>
                           </div>
                           <div class="img-extension mt-3">
                              <div class="d-inline-block align-items-center">
                                 <span>Only</span>
                                 <a href="javascript:void();">.jpg</a>
                                 <a href="javascript:void();">.png</a>
                                 <a href="javascript:void();">.jpeg</a>
                                 <span>allowed</span>
                              </div>
                           </div>
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
                           <label class="form-label">User Role:</label>
                          <select name="role" id="role" class="selectpicker form-control" required>
                            <option value="">Select</option>
                                 <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Laboratory Manager</option>
                                 <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Quality Assurance Manager</option>
                                 <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Purchase Supply Officer / Laboratory Analyst - Fish Health Unit</option>
                                 <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Laboratory Analyst - Microbiology Unit</option>
                                 <option value="4" {{ $user->role == 4 ? 'selected' : '' }}>Laboratory Analyst - Fish Health Unit</option>
                                 <option value="5" {{ $user->role == 5 ? 'selected' : '' }}>Customer Service Officer</option>
                                 <option value="6" {{ $user->role == 6 ? 'selected' : '' }}>Utility</option>
                                 <option value="6" {{ $user->role == 7 ? 'selected' : '' }}>Laboratory Analyst - Chemistry Unit </option>
                               

                            </select>
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="furl">Email Address: (Optional)</label>
                           <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="turl">Phone Number: (Optional)</label>
                           <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Phoner Number" value="{{ old('phone_no', $user->phone_no) }}">
                        </div>
                       
                  </div>
               </div>
            </div>
            <div class="col-xl-9 col-lg-8">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Profile Information</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="new-user-info">
                       
                           <div class="row">
                              <div class="form-group col-md-4">
                                 <label class="form-label" for="fname">First Name:</label>
                                 <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" value="{{ old('f_name', $user->f_name) }}">
                              </div>
                              <div class="form-group col-md-4">
                                 <label class="form-label" for="lname">Middle Name:</label>
                                 <input type="text" class="form-control" id="m_name" name="m_name" placeholder="Middle Name" value="{{ old('m_name', $user->m_name) }}">
                              </div>
                              <div class="form-group col-md-4">
                                 <label class="form-label" for="lname">Last Name:</label>
                                 <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name" value="{{ old('l_name', $user->l_name) }}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="add1">Location:</label>
                                 <input type="text" class="form-control" id="location" name="location" placeholder="Street Address 1" value="{{ old('location', $user->location) }}">
                              </div>
                              
                           </div>
                           <hr>
                           <h5 class="mb-3">Security</h5>
                           <div class="row">
                              <div class="form-group col-md-12">
                                 <label class="form-label" for="uname">User Name:</label>
                                 <input type="text" class="form-control" id="username" name="username" placeholder="User Name" value="{{ old('username', $user->username) }}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="pass">New Password:</label>
                                 <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="rpass">Repeat Password:</label>
                                 <input type="password" class="form-control" id="rpass" name="rpass" placeholder="Repeat Password ">
                              </div>
                              {{-- <script>
                                 $(document).ready(function () {

                                    function validateForm() {
                                       let password = $('#password').val();
                                       let confirmPassword = $('#rpass').val();

                                       let role = $('#role').val();
                                       let fname = $('#f_name').val();
                                       let lname = $('#l_name').val();
                                       let username = $('#username').val();

                                       let isValid = true;

                                       if (role === '' || fname === '' || lname === '' || username === '') {
                                             isValid = false;
                                       }

                                       if (confirmPassword.length > 0) {
                                             if (password !== confirmPassword) {
                                                $('#rpass').addClass('is-invalid');
                                                isValid = false;
                                             } else {
                                                $('#rpass').removeClass('is-invalid');
                                             }
                                       } else {
                                             $('#rpass').removeClass('is-invalid');
                                             isValid = false;
                                       }

                                       if (password === '') {
                                             isValid = false;
                                       }

                                       if (isValid) {
                                             $('#saveBtn').removeClass('disabled-btn').data('valid', true);
                                       } else {
                                             $('#saveBtn').addClass('disabled-btn').data('valid', false);
                                       }
                                    }

                                    $('#password, #rpass, #role, #f_name, #l_name, #username').on('keyup change', function () {
                                       validateForm();
                                    });

                                 });
                                 </script> --}}



{{-- 
                        <style>
                        .disabled-btn {
                           opacity: 0.6;
                           cursor: not-allowed;
                        }
                        </style> --}}


                           </div>
                           {{-- <div class="checkbox">
                              <label class="form-label"><input class="form-check-input me-2" type="checkbox" value="" id="flexCheckChecked">Enable Two-Factor-Authentication</label>
                           </div> --}}
                               
                                    <button 
                                       type="submit" 
                                       id="saveBtn" 
                                       class="btn btn-primary float-right disabled-btn"
                                    >
                                       Update Changes
                                    </button>
                               


                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
    @endsection