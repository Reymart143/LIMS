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
                 <form class="row g-3 needs-validation" action="{{ route('sample.update') }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="id" value="{{ $sample->id }}">
                    <input type="hidden" name="lf_06_02_id" id="lf_06_02_id" value="{{ $sample->lf_06_02_id ?? '' }}">

                    <div class="col-md-6 position-relative mb-2">
                        <label for="lab_code" class="form-label">Laboratory Code</label>
                        <select name="lab_code" id="lab_code" class="form-control">
                            <option value="">-- Select Laboratory Code --</option>
                            @foreach ($RLA as $s)
                                <option 
                                    value="{{ $s->lab_code_display }}"
                                    data-id="{{ $s->id }}"
                                    {{ $sample->lab_code == $s->lab_code_display ? 'selected' : '' }}>
                                    {{ $s->lab_code_display }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 position-relative mb-2">
                        <label for="sample_desc" class="form-label">Sample Description</label>
                        <input type="text" class="form-control" id="sample_desc" name="sample_desc" value="{{ $sample->sample_desc ?? '' }}" required>
                    </div>

                    <div class="col-md-6 position-relative mt-4 mb-2">
                        <label for="date_received" class="form-label">Date Received</label>
                        <input type="date" class="form-control" id="date_received" name="date_received" value="{{ $sample->date_received ?? '' }}" required>
                    </div>

                    <div class="col-md-6 position-relative mt-4 mb-2">
                        <label for="date_stored" class="form-label">Date Stored</label>
                        <input type="date" class="form-control" id="date_stored" name="date_stored" value="{{ $sample->date_stored ?? '' }}" required>
                    </div>

                    <div class="col-md-6 position-relative mt-4 mb-2">
                        <label for="date_analyzed" class="form-label">Date Analyzed</label>
                        <input type="date" class="form-control" id="date_analyzed" name="date_analyzed" value="{{ $sample->date_analyzed ?? '' }}" required>
                    </div>

                    <div class="col-md-6 position-relative mt-4 mb-2">
                        <label for="date_disposal" class="form-label">Date Disposal</label>
                        <input type="date" class="form-control" id="date_disposal" name="date_disposal" value="{{ $sample->date_disposal ?? '' }}" required>
                    </div>

                    <div class="col-md-6 position-relative mt-4 mb-2">
                        <label for="disposed_by" class="form-label">Disposed By</label>
                        <input type="text" class="form-control" id="disposed_by" name="disposed_by" value="{{ $sample->disposed_by ?? '' }}" required>
                    </div>

                    <div class="col-md-6 position-relative mt-4 mb-2">
                        <label for="checked_by" class="form-label">Checked By</label>
                        <input type="text" class="form-control" id="checked_by" name="checked_by" value="{{ $sample->checked_by ?? '' }}" required>
                    </div>

                    <div class="col-12 mt-5">
                        <a class="btn btn-secondary" href="/sample_logbook">Cancel</a>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
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
                        let RlaId = selectedOption.getAttribute('data-id');

                        const hiddenId = document.getElementById("lf_06_02_id");
                        if (hiddenId) {
                            hiddenId.value = RlaId ?? '';
                        }

                        if (RlaId) {
                            $.ajax({
                                url: '/get-RLA-info/' + RlaId,
                                type: 'GET',
                                success: function (data) {
                                    $('#sample_desc').val(data.sample_description ?? '');
                                },
                                error: function () {
                                    $('#sample_desc').val('');
                                }
                            });
                        } else {
                            $('#sample_desc').val('');
                            if (hiddenId) hiddenId.value = '';
                        }
                    });
                });
                </script>
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