@extends('layouts.app')
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-success p-3">Update Clients Information</span></h4>
                     </div>
                  </div>
                  <div class="card-body">
                     
                     <form class="row g-3 needs-validation" action="{{ route('clients.update')}}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="client_id" name="client_id" value="{{ $client->id}}">
                         <div class="col-md-6 position-relative mb-2">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="{{ old('company_name', $client->company_name) }}" required>
                            <div class="invalid-tooltip">Please provide a company name.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address', $client->address) }}" required>
                            <div class="invalid-tooltip">Please provide a address</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="contact_no" class="form-label">Contact No.</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no"
                                value="{{ old('contact_no', $client->contact_no) }}" required>
                            <div class="invalid-tooltip">Please provide a contact number</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="source_sample" class="form-label">Source Sample</label>
                            <input type="text" class="form-control" id="source_sample" name="source_sample"
                                value="{{ old('source_sample', $client->source_sample) }}" required>
                            <div class="invalid-tooltip">Please provide a source sample.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="sample_description" class="form-label">Sample Description</label>
                            <input type="text" class="form-control" id="sample_description" name="sample_description"
                                value="{{ old('sample_description', $client->sample_description) }}" required>
                            <div class="invalid-tooltip">Please provide a sample description.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="sample_code" class="form-label">Sample Code</label>
                            <input type="text" class="form-control" id="sample_code" name="sample_code"
                                value="{{ old('sample_code', $client->sample_code) }}" required>
                            <div class="invalid-tooltip">Please provide a sample code.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="analysis_requested" class="form-label">Analysis Requested</label>
                            <input type="text" class="form-control" id="analysis_requested" name="analysis_requested"
                                value="{{ old('analysis_requested', $client->analysis_requested) }}" required>
                            <div class="invalid-tooltip">Please provide a analysis requested.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="species" class="form-label">Species</label>
                            <input type="text" class="form-control" id="species" name="species"
                                value="{{ old('species', $client->species) }}" required>
                            <div class="invalid-tooltip">Please provide a species.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                               value="{{ old('date', $client->date ? \Carbon\Carbon::parse($client->date)->format('Y-m-d') : '') }}">
                            <div class="valid-tooltip">Looks good!</div>
                        </div>

                        <div class="col-md-6 position-relative mt-4">
                            <label for="classification" class="form-label">Classification</label>
                            <input type="text" class="form-control" id="classification" name="classification"
                                value="{{ old('classification', $client->classification) }}" required>
                            <div class="invalid-tooltip">Please provide a classification.</div>
                            <div class="valid-tooltip">Looks good!</div>
                        </div>
                        <div class="col-12">
                            <a class="btn btn-secondary" href="{{ route('clients') }}">Cancel</a>
                            <button class="btn btn-primary" type="submit">Update Changes</button>
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