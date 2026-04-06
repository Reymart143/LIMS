@extends('layouts.app')
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-success p-3">Clients Information</span></h4>
                     </div>
                  </div>
                  <div class="card-body">
                     
                     <form class="row g-3 needs-validation" action="{{ route('clients.store')}}" method="POST" novalidate>
                        @csrf
                        <div class="col-md-6 position-relative  mb-2">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" required name="company_name">
                            <div class="invalid-tooltip">
                                Please provide a company name.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" required name="address">
                            <div class="invalid-tooltip">
                                Please provide a address
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="contact_no" class="form-label">Contact No.</label>
                            <input type="text" class="form-control" id="contact_no" required name="contact_no">
                            <div class="invalid-tooltip">
                                Please provide a contact number
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="source_sample" class="form-label">Source Sample</label>
                            <input type="text" class="form-control" id="source_sample" required name="source_sample">
                            <div class="invalid-tooltip">
                                Please provide a source sample.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="sample_description" class="form-label">Sample Description</label>
                            <input type="text" class="form-control" id="sample_description" required name="sample_description">
                            <div class="invalid-tooltip">
                                Please provide a sample description.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="sample_code" class="form-label">Sample Code</label>
                            <input type="text" class="form-control" id="sample_code" required name="sample_code">
                            <div class="invalid-tooltip">
                                Please provide a sample code.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="analysis_requested" class="form-label">Analysis Requested</label>
                            <input type="text" class="form-control" id="analysis_requested" required name="analysis_requested">
                            <div class="invalid-tooltip">
                                Please provide a analysis requested.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="species" class="form-label">Species</label>
                            <input type="text" class="form-control" id="species" required name="species">
                            <div class="invalid-tooltip">
                                Please provide a species.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                            
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4">
                            <label for="classification" class="form-label">Classification</label>
                            <input type="text" class="form-control" id="classification" required name="classification">
                            <div class="invalid-tooltip">
                                Please provide a classification.
                            </div>  
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                             <a class="btn btn-secondary" type="submit" href="/clients">Cancel</a>
                            <button class="btn btn-primary" type="submit">Submit</button>
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