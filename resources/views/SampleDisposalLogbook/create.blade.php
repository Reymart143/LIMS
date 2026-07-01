@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
    .choices {
        width: 100% !important;
    }

    .choices__inner {
        width: 100% !important;
        box-sizing: border-box;
    }

    .choices__input {
        width: 100% !important;
        box-sizing: border-box;
    }

    td {
        position: relative;
    }
</style>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title"><span class="badge bg-success p-3">SAMPLE STORAGE AND DISPOSAL LOGBOOK </span></h4>
                     </div>
                  </div>
                  <div class="card-body">
                     
                     <form class="row g-3 needs-validation" action="{{ route('sample.store')}}" method="POST" novalidate>
                        @csrf
                        <div class="col-md-6 position-relative  mb-2">
                            <label for="lab_code" class="form-label">Laboratory Code</label>
                            <select name="lab_code" id="lab_code" class="form-control">
                                <option value="">-- Select Laboratory Code --</option>

                             @foreach ($RLA as $s)
                                    <option 
                                        value="{{ $s->laboratory_code[0] ?? '' }}" 
                                        data-id="{{ $s->id }}">
                                        {{ $s->laboratory_code[0] ?? '' }}
                                    </option>
                                @endforeach

                            </select>
                            <script>
                                   document.addEventListener("DOMContentLoaded", function () {

                                    const element = document.getElementById('lab_code');

                                    const choices = new Choices(element, {
                                        searchEnabled: true,
                                        itemSelectText: '',
                                        shouldSort: false,
                                        position: 'bottom', 
                                    });

                                    element.addEventListener('change', function () {

                                        let selectedOption = this.options[this.selectedIndex];

                                        let labCode = selectedOption.value;  
                                        let RlaId = selectedOption.getAttribute('data-id');

                                        document.getElementById("lf_06_02_id").value = RlaId;

                                        if (RlaId) {
                                            $.ajax({
                                                url: '/get-RLA-info/' + RlaId,
                                                type: 'GET',
                                                success: function (data) {
                                                    $('#sample_desc').val(data.sample_description);
                                                }
                                            });
                                        } else {
                                            $('#sample_desc').val('');
                                            $('#lf_06_02_id').val('');
                                        }

                                    });

                                });

                                    </script>

                        </div>
                        <input type="hidden" name="lf_06_02_id" id="lf_06_02_id">
                        <div class="col-md-6 position-relative mb-2">
                            <label for="address" class="form-label">Sample Description</label>
                            <input type="text" class="form-control" id="sample_desc" required name="sample_desc">
                                {{-- <div class="invalid-tooltip">
                                    Please provide a sample_des
                                </div>
                                <div class="valid-tooltip">
                                    Looks good!
                                </div> --}}
                        </div>
                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="date_received" class="form-label">Date Received</label>
                            <input type="date" class="form-control" id="date_received" required name="date_received">
                            {{-- <div class="invalid-tooltip">
                                Please provide a date received
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div> --}}
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="date_stored" class="form-label">Date Stored</label>
                            <input type="date" class="form-control" id="date_stored" required name="date_stored">
                            <div class="invalid-tooltip">
                                Please provide a date stored.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="date_analyzed" class="form-label">Date Analyzed</label>
                            <input type="date" class="form-control" id="date_analyzed" required name="date_analyzed">
                            <div class="invalid-tooltip">
                                Please provide a date analyzed.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="date_disposal" class="form-label">Date Disposal</label>
                            <input type="date" class="form-control" id="date_disposal" required name="date_disposal">
                            <div class="invalid-tooltip">
                                Please provide a date of disposal.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="disposed_by" class="form-label">Disposed By</label>
                            <input type="text" class="form-control" id="disposed_by" required name="disposed_by">
                            <div class="invalid-tooltip">
                                Please provide a disposed by.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                         <div class="col-md-6 position-relative mt-4 mb-2">
                            <label for="disposed_by" class="form-label">Checked By</label>
                            <input type="text" class="form-control" id="checked_by" required name="checked_by">
                            {{-- <div class="invalid-tooltip">
                                Please provide a disposed by.
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div> --}}
                        </div>

                        <div class="col-12 mt-5">
                             <a class="btn btn-secondary" type="submit" href="/sample_logbook">Cancel</a>
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