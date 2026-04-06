
@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
      <div class="conatiner-fluid content-inner mt-n5 py-0">
      <div class="row">
          <div class="col-lg-12">
             <div class="card">
                  <div class="card-body">
                     <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex flex-wrap align-items-center">
                   <form action="{{ route('user/upload/update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="profilepic_id" id="profilepic_id" value="{{ Auth::user()->id }}">

    <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/01.png') }}"
             alt="User-Profile" class="profileImages theme-color-default-img img-fluid rounded-pill avatar-100">
        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_1.png') }}"
             alt="User-Profile" class="profileImages theme-color-purple-img img-fluid rounded-pill avatar-100">
        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_2.png') }}"
             alt="User-Profile" class="profileImages theme-color-blue-img img-fluid rounded-pill avatar-100">
        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_4.png') }}"
             alt="User-Profile" class="profileImages theme-color-green-img img-fluid rounded-pill avatar-100">
        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_5.png') }}"
             alt="User-Profile" class="profileImages theme-color-yellow-img img-fluid rounded-pill avatar-100">
        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('../../assets/images/avatars/avtar_3.png') }}"
             alt="User-Profile" class="profileImages theme-color-pink-img img-fluid rounded-pill avatar-100">
    </div>

    <input type="file" id="image" name="image" style="display: none;" accept="image/png, image/gif, image/jpeg">

    <button type="button" class="btn btn-primary upload-image-btn" style="padding:1mm;margin-left:50%;margin-top:-50%"
            onclick="uploadImage()">
        <svg class="icon-20" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M17.44 6.2364C17.48 6.30633 17.55 6.35627 17.64 6.35627C20.04 6.35627 22 8.3141 22 10.7114V16.6448C22 19.0422 20.04 21 17.64 21H6.36C3.95 21 2 19.0422 2 16.6448V10.7114C2 8.3141 3.95 6.35627 6.36 6.35627C6.44 6.35627 6.52 6.31632 6.55 6.2364L6.61 6.11654C6.64448 6.04397 6.67987 5.96943 6.71579 5.89376C6.97161 5.35492 7.25463 4.75879 7.43 4.40844C7.89 3.50943 8.67 3.00999 9.64 3H14.35C15.32 3.00999 16.11 3.50943 16.57 4.40844C16.7275 4.72308 16.9674 5.2299 17.1987 5.71839C17.2464 5.81921 17.2938 5.91924 17.34 6.01665L17.44 6.2364ZM16.71 10.0721C16.71 10.5716 17.11 10.9711 17.61 10.9711C18.11 10.9711 18.52 10.5716 18.52 10.0721C18.52 9.5727 18.11 9.16315 17.61 9.16315C17.11 9.16315 16.71 9.5727 16.71 10.0721ZM10.27 11.6204C10.74 11.1509 11.35 10.9012 12 10.9012C12.65 10.9012 13.26 11.1509 13.72 11.6104C14.18 12.0699 14.43 12.6792 14.43 13.3285C14.42 14.667 13.34 15.7558 12 15.7558C11.35 15.7558 10.74 15.5061 10.28 15.0466C9.82 14.5871 9.57 13.9778 9.57 13.3285V13.3185C9.56 12.6892 9.81 12.0799 10.27 11.6204ZM14.77 16.1054C14.06 16.8147 13.08 17.2542 12 17.2542C10.95 17.2542 9.97 16.8446 9.22 16.1054C8.48 15.3563 8.07 14.3774 8.07 13.3285C8.06 12.2897 8.47 11.3108 9.21 10.5616C9.96 9.81243 10.95 9.40289 12 9.40289C13.05 9.40289 14.04 9.81243 14.78 10.5516C15.52 11.3008 15.93 12.2897 15.93 13.3285C15.92 14.4173 15.48 15.3962 14.77 16.1054Z"
                  fill="currentColor"></path>
        </svg>
    </button>

    <script>
        function uploadImage() {
            document.getElementById('image').click();
        }

        document.getElementById('image').addEventListener('change', function(event) {
            const selectedImage = event.target.files[0];
            if (selectedImage) {
                const avatarImages = document.querySelectorAll('.profileImages');
                avatarImages.forEach(img => {
                    img.src = URL.createObjectURL(selectedImage);
                });
            }
        });
    </script>

    <br>

    <button type="submit" class="btn btn-primary" style="padding:1mm;margin-left:-15%;font-size:3mm">
        <svg class="icon-20" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M11.7281 21.9137C11.8388 21.9715 11.9627 22.0009 12.0865 22C12.2103 21.999 12.3331 21.9686 12.4449 21.9097L16.0128 20.0025C17.0245 19.4631 17.8168 18.8601 18.435 18.1579C19.779 16.6282 20.5129 14.6758 20.4998 12.6626L20.4575 6.02198C20.4535 5.25711 19.9511 4.57461 19.2082 4.32652L12.5707 2.09956C12.1711 1.96424 11.7331 1.96718 11.3405 2.10643L4.72824 4.41281C3.9893 4.67071 3.496 5.35811 3.50002 6.12397L3.54231 12.7597C3.5554 14.7758 4.31448 16.7194 5.68062 18.2335C6.3048 18.9258 7.10415 19.52 8.12699 20.0505L11.7281 21.9137ZM10.7836 14.1089C10.9326 14.2521 11.1259 14.3227 11.3192 14.3207C11.5125 14.3198 11.7047 14.2472 11.8517 14.1021L15.7508 10.2581C16.0438 9.96882 16.0408 9.50401 15.7448 9.21866C15.4478 8.9333 14.9696 8.93526 14.6766 9.22454L11.3081 12.5449L9.92885 11.2191C9.63186 10.9337 9.15467 10.9367 8.8607 11.226C8.56774 11.5152 8.57076 11.98 8.86775 12.2654L10.7836 14.1089Z"
                  fill="currentColor"></path>
        </svg> Save Profile Picture
    </button>
</form>

                         <script>
                                    $(document).ready(function () {
                                        $('[data-toggle="tooltip"]').tooltip({
                                            template: '<div class="tooltip larger-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
                                            html: true
                                        });
                                    });
                                </script>
                                
                                <style>
                                    .larger-tooltip .tooltip-inner {
                                        max-width: 300px; 
                                        font-size: 16px; 
                                    }
                                </style>
                        <script>
                            function profile_modal(){
                                $('#updateImageModal').appendTo('body').modal('show');
                                $('#updateImageModal').modal('show');
                                $('[data-toggle="popover"]').popover();

                                $(document).ready(function() {

                                    $('.profile-btn').on('click', function(e) {
                                        e.preventDefault();
                                        alert('da');
                                        $('#image').trigger('click');
                                    });
                                    
                                    $('#image').on('change', function (e) {
                                        var filesSelected = document.getElementById('image').files[0];
                                        var reader = new FileReader();
                                        reader.readAsDataURL(filesSelected);

                                        reader.onload = function () {
                                            console.log(reader.result)
                                            $(".image-tag").val(reader.result);
                                            $('#profilePicture').attr('src', reader.result);
                                        }
                                    });

                                    const profileBtn = document.querySelector('#upload_btn');
                                    
                                    profileBtn.addEventListener('click', () => {
                                        const image = document.querySelector('.image-tag').value; 

                                        $.ajax({
                                            url: "/user/upload/update",
                                            method: "POST",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },

                                            data: {
                                                image: image,
                                            },
                                            success: function (data) {
                                                setTimeout(function() {
                                                    resultSection.innerHTML = ''; 
                                                    $('#updateImageModal').modal('hide'); 
                                                }, 2000);

                                                const alertHTML = '<div class="alert alert-success small-alert" role="alert" style="background-color:green;color:white; border-radius: 0;">' + data.message + '</div>';
                                                const resultSection = document.getElementById('user_upload');
                                                resultSection.innerHTML = alertHTML;
                                                
                                                for (let i = 0; i < displayElements.length; i++) {
                                                    displayElements[i].textContent = inputElements[i].value;
                                                }                       
                                            },
                                            error: function (data) {
                                                Swal.fire({
                                                    title: 'ERROR',
                                                    text: 'An error occured upon changing your profile picture',
                                                    icon: 'error',
                                                });
                                            }
                                        });
                                    });
                                });
                            }
                        </script>
                        <div class="modal fade" id="updateImageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content edit-content">
                                <div class="modal-header" >
                                    <h5 class="modal-title" id="updateImageModalLabel" style="margin-left:15px; margin-top: 5px;"><i class=" fa fa-gallery fa-image"></i> Update Profile Picture</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div id="user_upload"></div>
                                    <div class="modal-body">
                                        <input type="file" accept="image/*" id="image" name="image" style="display: none;">
                                        <input type="hidden"  name="image" class="image-tag">
                                        <button style="width: 100%;height:100%" class="btn btn-secondary">
                                        <label for="image" class="profile-btn">
                                        <div style="cursor: pointer;margin-top:10%;margin-left:10%"> <i class="fa-regular fa-image fa-3x"></i></div> Click to open gallery </label>
                                        </button>
                                    </div>
                                
                                    <div class="modal-footer" style="border-top: 1px solid #ccc;">
                                    <button type="button" id="upload_btn" class="btn btn-primary" style="margin-top: -6px;">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                           <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                              <h4 class="me-2 h4">{{ Auth::user()->f_name}} {{ Auth::user()->m_name}}. {{ Auth::user()->l_name}}</h4>
                              <span> - Web Developer</span>
                           </div>
                        </div>
                        
                        <div class="nav-slider-thumb position-absolute nav-link" aria-selected="false" tabindex="-1" role="tab" style="padding: 0px; width: 69px; height: 40px; transform: translate3d(0px, 0px, 0px); transition: 300ms ease-in-out;"><a class="nav-link active show" data-bs-toggle="tab" href="#profile-feed" role="tab" aria-selected="true"></a></div></ul>
                     </div>
                  </div>
             </div>
          </div>
          <div class="card">
               
                <div class="card-body">
                   
                     <form>
                            @csrf
                            @method('PUT')
                        
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-success"><i class="fa fa-user"></i> Personal Information</p>
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="f_name" value="{{ old('f_name', Auth::user()->f_name) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Middle Name <small class="text-black-50">Optional</small></label>
                                        <input type="text" class="form-control" name="m_name" value="{{ old('m_name', Auth::user()->m_name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="l_name" value="{{ old('l_name', Auth::user()->l_name) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" >
                                    </div>
                                    {{-- <div class="form-group"> --}}
                                        {{-- <label>Civil Status <span class="text-danger">*</span></label>
                                        <select name="civil_status" class="form-control" required>
                                            @php $status = Auth::user()->civil_status; @endphp
                                            <option value="Single" {{ old('civil_status', $status) == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Widowed" {{ old('civil_status', $status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                            <option value="Divorced" {{ old('civil_status', $status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                            <option value="Married" {{ old('civil_status', $status) == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Separated" {{ old('civil_status', $status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                        </select>
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        <label>Gender <span class="text-danger">*</span></label><br>
                                        @php $gender = Auth::user()->gender; @endphp
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="male" {{ old('gender', $gender) == 'male' ? 'checked' : '' }}>
                                            <label class="form-check-label">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="female" {{ old('gender', $gender) == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label">Female</label>
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <label>Phone Number <small class="text-black-50">Optional</small></label>
                                        <input type="text" class="form-control" name="phone_no" value="{{ old('phone_no', Auth::user()->phone_no) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="location" value="{{ old('location', Auth::user()->location) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-success"><i class="fa fa-lock"></i> Account Information</p>
                                    <div class="form-group">
                                        <label>Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username" value="{{ old('username', Auth::user()->username) }}" required>
                                    </div>
                                    <!-- Current Password -->
                                    {{-- <div class="form-group">
                                        <label>Current Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Current Password">
                                    </div>
                            
                                    <!-- New Password -->
                                    <div class="form-group">
                                        <label>New Password <small class="text-black-50">Optional</small></label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password">
                                    </div>
                            
                                    <!-- Confirm Password -->
                                    <div class="form-group">
                                        <label>Confirm Password <small class="text-black-50">Optional</small></label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm New Password">
                                    </div> --}}
                                <div class="form-group row password-fields" style="display: none;">
                                    <label for="inputOldPassword" class="col-sm-3 col-form-label">Old Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Old Password">
                                    </div>
                                </div>
                                <div class="form-group row password-fields" style="display: none;">
                                    <label for="inputNewPassword" class="col-sm-3 col-form-label">New Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password">
                                    </div>
                                </div>
                                <div class="form-group row password-fields" style="display: none;">
                                    <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-Enter Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10" style="display: flex;">
                                        <button type="button" class="btn btn-secondary change-password">Change Password</button>
                                        <button type="button" class="btn btn-danger hide-password" style="display: none;">Hide Password Field</button>
                                        <button type="button" class="btn btn-primary " id="save_btn" style="margin-left:10px;">Save Changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            {{-- <!-- Submit Button -->
                            <div class="card-footer d-flex justify-content-between">
                                <button type="button" id="upload_btn" class="btn btn-success float-end" style="width: 20%;"><i class="fa fa-edit"></i> Update Changes</button>
                            </div> --}}
                        </form>
                </div>
            </div>
           <script>
 const saveBtn = document.querySelector('#save_btn');
    saveBtn.addEventListener('click', () => {
        const first_name = document.querySelector('input[name="f_name"]').value;
        const middle_name = document.querySelector('input[name="m_name"]').value;
        const last_name = document.querySelector('input[name="l_name"]').value;
        const email = document.querySelector('input[name="email"]').value;
        const phone_no = document.querySelector('input[name="phone_no"]').value;
        const location = document.querySelector('input[name="location"]').value;
        const username = document.querySelector('input[name="username"]').value;
      
        const oldPasswordField = document.getElementById("password");
        const newPasswordField = document.getElementById("new_password");
        const confirmPasswordField = document.getElementById("confirm_password");
        const newPasswordValue = newPasswordField.value;
        const confirmPasswordValue = confirmPasswordField.value;
        const confirmError = document.getElementById('confirm-password-error');
    
        if (newPasswordValue !== confirmPasswordValue) {
            if (confirmError) {
                confirmError.style.display = 'block';
                confirmError.textContent = 'Password does not match!';
            }
            if (confirmPasswordField) {
                confirmPasswordField.classList.add('is-invalid');
            }
            setTimeout(() => {
                if (confirmError) {
                    confirmError.style.display = 'none';
                    confirmError.textContent = '';
                }
                if (confirmPasswordField) {
                    confirmPasswordField.classList.remove('is-invalid');
                }
            }, 5000);
            return;
        }
    
        const formData = new FormData();
        formData.append('f_name', first_name);
        formData.append('m_name', middle_name);
        formData.append('l_name', last_name);
        formData.append('email', email);
        formData.append('phone_no', phone_no);
        formData.append('location', location);
        formData.append('username', username);
        formData.append('password', oldPasswordField.value);
        formData.append('new_password', newPasswordField.value);
    
    
        $.ajax({
            url: "/profile/update",
            method: "POST",
            processData: false,
            contentType: false,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#password').val('');
                $('#new_password').val('');
                $('confirm_password').val('');
                Swal.fire({
                    title: 'Successfully Updated',
                    text: 'All the changes are now updated',
                    icon: 'sucess',
                });
            },
            error: function (data) {
                const errorMessage = data.responseJSON.message;
                const passwordError = document.getElementById('password-error');
                const passwordField = document.getElementById('password');
    
                if (passwordError) {
                    passwordError.style.display = 'block';
                    passwordError.textContent = errorMessage;
                }
                if (passwordField) {
                    passwordField.classList.add('is-invalid');
                }
    
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
    
                setTimeout(function () {
                    if (passwordError) {
                        passwordError.style.display = 'none';
                        passwordError.textContent = '';
                    }
                    if (passwordField) {
                        passwordField.classList.remove('is-invalid');
                    }
                    Swal.close();
                }, 5000);
            }
        });
    });
</script>


            <script>
                document.querySelector('.change-password').addEventListener('click', function () {
                    document.querySelectorAll('.password-fields').forEach(function (element) {
                        element.style.display = 'flex';
                    });
                    this.style.display = 'none';
                    document.querySelector('.hide-password').style.display = 'block';
                });

                document.querySelector('.hide-password').addEventListener('click', function () {
                    document.querySelectorAll('.password-fields').forEach(function (element) {
                        element.style.display = 'none';
                    });
                    this.style.display = 'none';
                    document.querySelector('.change-password').style.display = 'block';
                });

            </script>
      </div>
            
    </div>
   

    @endsection