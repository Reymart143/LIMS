@extends('layouts.app')

@section('content')

@php
    $isEdit = !empty($certificate);

    $hcValue = function ($field, $default = '') use ($certificate) {
        return old($field, $certificate->$field ?? $default);
    };
@endphp

<div class="container-fluid">
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                {{ $isEdit ? 'Edit Health Certificate Form' : 'Add Health Certificate Form' }}
            </h4>

            @if($isEdit)
                <span class="badge bg-warning text-white">Update Mode</span>
            @else
                <span class="badge bg-success">Add Mode</span>
            @endif
        </div>

        <div class="card-body">

            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}"
                    });
                </script>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    Please check required fields.
                </div>
            @endif

            <form method="POST" action="{{ route('healthcertificate.store') }}">
                @csrf

                <input type="hidden" name="rla_no" value="{{ $rla->RLA_no }}">
                <input type="hidden" name="user_id" value="{{ $rla->user_id }}">

                {{-- CERTIFICATE INFO --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">RLA No.</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $rla->RLA_no }}"
                               readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Health Certificate No.</label>
                        <input type="text"
                               name="health_certificate_no"
                               class="form-control"
                               value="{{ $hcValue('health_certificate_no') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Interpretation</label>
                        <input type="text"
                               name="interpretation"
                               class="form-control"
                               value="{{ $hcValue('interpretation') }}">
                    </div>
                </div>

                <hr>

                <h5>I. Consignor</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name of Shipper</label>
                        <input type="text"
                               name="shipper_name"
                               class="form-control"
                               value="{{ $hcValue('shipper_name', $rla->company_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Shipper Address</label>
                        <input type="text"
                               name="shipper_address"
                               class="form-control"
                               value="{{ $hcValue('shipper_address', $rla->address) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name of Company / Facility</label>
                        <input type="text"
                               name="company_facility_name"
                               class="form-control"
                               value="{{ $hcValue('company_facility_name', $rla->company_name) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Company / Facility Address</label>
                        <input type="text"
                               name="company_facility_address"
                               class="form-control"
                               value="{{ $hcValue('company_facility_address', $rla->address) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Telephone Number</label>
                        <input type="text"
                               name="shipper_telephone"
                               class="form-control"
                               value="{{ $hcValue('shipper_telephone', $rla->contact_no) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Registration Number</label>
                        <input type="text"
                               name="shipper_registration_no"
                               class="form-control"
                               value="{{ $hcValue('shipper_registration_no') }}">
                    </div>
                </div>

                <hr>

                <h5>II. Commodity</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Description of Commodity</label>
                        <input type="text"
                               name="commodity_description"
                               class="form-control"
                               value="{{ $hcValue('commodity_description', $firstSampleDescription) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Scientific Name</label>
                        <input type="text"
                               name="scientific_name"
                               class="form-control"
                               value="{{ $hcValue('scientific_name') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Quantity</label>
                        <input type="text"
                               name="quantity"
                               class="form-control"
                               placeholder="Example: 130,000 pcs. / 250 Boxes"
                               value="{{ $hcValue('quantity') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Location of Source</label>
                        <input type="text"
                               name="location_of_source"
                               class="form-control"
                               value="{{ $hcValue('location_of_source', $rla->source_sample) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Wild Caught / Culture</label>
                        <input type="text"
                               name="wild_caught_culture"
                               class="form-control"
                               value="{{ $hcValue('wild_caught_culture') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tank Number</label>
                        <input type="text"
                               name="tank_number"
                               class="form-control"
                               value="{{ $hcValue('tank_number') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pond / Cage Number</label>
                        <input type="text"
                               name="pond_cage_number"
                               class="form-control"
                               value="{{ $hcValue('pond_cage_number') }}">
                    </div>
                </div>

                <hr>

                <h5>III. Consignee</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name of Consignee</label>
                        <input type="text"
                               name="consignee_name"
                               class="form-control"
                               value="{{ $hcValue('consignee_name') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Consignee Address</label>
                        <input type="text"
                               name="consignee_address"
                               class="form-control"
                               value="{{ $hcValue('consignee_address') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Registration Number</label>
                        <input type="text"
                               name="consignee_registration_no"
                               class="form-control"
                               value="{{ $hcValue('consignee_registration_no') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Telephone Number</label>
                        <input type="text"
                               name="consignee_telephone"
                               class="form-control"
                               value="{{ $hcValue('consignee_telephone') }}">
                    </div>
                </div>

                <hr>

                <h5>IV. Shipment Details</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Place of Loading</label>
                        <input type="text"
                               name="place_of_loading"
                               class="form-control"
                               value="{{ $hcValue('place_of_loading') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Loading Address</label>
                        <input type="text"
                               name="loading_address"
                               class="form-control"
                               value="{{ $hcValue('loading_address') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Date of Departure</label>
                        <input type="date"
                               name="date_of_departure"
                               class="form-control"
                               value="{{ $hcValue('date_of_departure') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Means of Transport</label>
                        <input type="text"
                               name="means_of_transport"
                               class="form-control"
                               value="{{ $hcValue('means_of_transport') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Port of Destination</label>
                        <input type="text"
                               name="port_of_destination"
                               class="form-control"
                               value="{{ $hcValue('port_of_destination') }}">
                    </div>
                </div>

                <hr>

                <h5>V. Declaration</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Sample Code</label>
                        <input type="text"
                               name="sample_code"
                               class="form-control"
                               value="{{ $hcValue('sample_code', $firstSampleCode) }}"
                               readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Result</label>
                        <select name="result" class="form-control">
                            <option value="">-- Select Result --</option>
                            <option value="Positive" {{ $hcValue('result') == 'Positive' ? 'selected' : '' }}>
                                Positive
                            </option>
                            <option value="Negative" {{ $hcValue('result') == 'Negative' ? 'selected' : '' }}>
                                Negative
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Disease / Toxin / Microbes</label>
                        <input type="text"
                               name="disease_toxin_microbes"
                               class="form-control"
                               placeholder="Example: TiLV"
                               value="{{ $hcValue('disease_toxin_microbes') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Analysis Date</label>
                        <input type="date"
                               name="analysis_date"
                               class="form-control"
                               value="{{ $hcValue('analysis_date') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Issued At</label>
                        <input type="text"
                               name="issued_at"
                               class="form-control"
                               placeholder="Example: BFAR RFL 12"
                               value="{{ $hcValue('issued_at', 'BFAR RFL 12') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Issued Date</label>
                        <input type="date"
                               name="issued_date"
                               class="form-control"
                               value="{{ $hcValue('issued_date') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Certifying Officer</label>
                        <input type="text"
                               name="certifying_officer"
                               class="form-control"
                               value="{{ $hcValue('certifying_officer', 'EUGENE GAY B. JAMORA') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Position</label>
                        <input type="text"
                               name="certifying_officer_position"
                               class="form-control"
                               value="{{ $hcValue('certifying_officer_position', 'Certifying Officer') }}">
                    </div>
                </div>

                <hr>

                <h5>Fees / OR Details</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Fees Collected</label>
                        <input type="number"
                               step="0.01"
                               name="fees_collected"
                               class="form-control"
                               value="{{ $hcValue('fees_collected', '50') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">OR No.</label>
                        <input type="text"
                               name="or_no"
                               class="form-control"
                               value="{{ $hcValue('or_no') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">OR Date</label>
                        <input type="date"
                               name="or_date"
                               class="form-control"
                               value="{{ $hcValue('or_date') }}">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('healthcertificate/index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn {{ $isEdit ? 'btn-warning' : 'btn-success' }}">
                        <i class="fa fa-check"></i>
                        {{ $isEdit ? 'Update' : 'Save' }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection