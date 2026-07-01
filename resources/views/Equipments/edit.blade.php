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
</style>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Equipment</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>Please correct the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('equipments.update', $equipment->id) }}" method="POST" class="row g-3 needs-validation">
                        @csrf
                        @method('PUT')
                        
                        <div class="col-md-6 position-relative mb-2">
                            <label for="equipment" class="form-label">Equipment *</label>
                            <select class="form-select @error('equipment') is-invalid @enderror" id="equipment" name="equipment" required>
                                <option value="">Select Equipment</option>
                                @foreach($equipmentDropdown as $item)
                                    <option value="{{ $item->equipment }}" data-id="{{ $item->id }}" data-equipment-no="{{ $item->equipment_no }}" data-brand-model="{{ $item->model }}" data-location="{{ $item->location }}" data-year="{{ $item->year }}" data-date="{{ $item->date }}" {{ old('equipment', $equipment->equipment) == $item->equipment ? 'selected' : '' }}>
                                        {{ $item->equipment }}{{ $item->model ? ' (' . $item->model . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('equipment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="equipment_no" class="form-label">Equipment No. *</label>
                            <input type="text" class="form-control @error('equipment_no') is-invalid @enderror" id="equipment_no" name="equipment_no" value="{{ old('equipment_no', $equipment->equipment_no) }}" readonly required>
                            @error('equipment_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="qty" class="form-label">Qty *</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" min="0" value="{{ old('qty', $equipment->qty) }}" required>
                            @error('qty')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit', $equipment->unit) }}" maxlength="255">
                            @error('unit')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="rfl_control_no" class="form-label">RFL Control No.</label>
                            <input type="text" class="form-control @error('rfl_control_no') is-invalid @enderror" id="rfl_control_no" name="rfl_control_no" value="{{ old('rfl_control_no', $equipment->rfl_control_no) }}" maxlength="255">
                            @error('rfl_control_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2" maxlength="5000">{{ old('description', $equipment->description) }}</textarea>
                            @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="brand_model" class="form-label">Brand / Model</label>
                            <input type="text" class="form-control @error('brand_model') is-invalid @enderror" id="brand_model" name="brand_model" value="{{ old('brand_model', $equipment->brand_model) }}" readonly maxlength="255">
                            @error('brand_model')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="date_acquired" class="form-label">Date Acquired</label>
                            <input type="date" class="form-control @error('date_acquired') is-invalid @enderror" id="date_acquired" name="date_acquired" value="{{ old('date_acquired', $equipment->date_acquired ? $equipment->date_acquired->format('Y-m-d') : '') }}">
                            @error('date_acquired')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="unit_cost" class="form-label">Unit Cost *</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('unit_cost') is-invalid @enderror" id="unit_cost" name="unit_cost" value="{{ old('unit_cost', $equipment->unit_cost) }}" required>
                            @error('unit_cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="total_cost" class="form-label">Total Cost</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('total_cost') is-invalid @enderror" id="total_cost" name="total_cost" value="{{ old('total_cost', $equipment->total_cost) }}" readonly>
                            @error('total_cost')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="status_remarks" class="form-label">Status / Remarks</label>
                            <textarea class="form-control @error('status_remarks') is-invalid @enderror" id="status_remarks" name="status_remarks" rows="2" maxlength="5000">{{ old('status_remarks', $equipment->status_remarks) }}</textarea>
                            @error('status_remarks')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="received_quantity" class="form-label">Received Quantity *</label>
                            <input type="number" class="form-control @error('received_quantity') is-invalid @enderror" id="received_quantity" name="received_quantity" min="0" value="{{ old('received_quantity', $equipment->received_quantity) }}" required>
                            @error('received_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="used_quantity" class="form-label">Used Quantity *</label>
                            <input type="number" class="form-control @error('used_quantity') is-invalid @enderror" id="used_quantity" name="used_quantity" min="0" value="{{ old('used_quantity', $equipment->used_quantity) }}" required>
                            @error('used_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="balance_quantity" class="form-label">Balance Quantity</label>
                            <input type="number" class="form-control @error('balance_quantity') is-invalid @enderror" id="balance_quantity" name="balance_quantity" value="{{ old('balance_quantity', $equipment->balance_quantity) }}" readonly>
                            @error('balance_quantity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 position-relative mb-2">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $equipment->location) }}" readonly maxlength="255">
                            @error('location')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12 position-relative mb-2">
                            <label for="person_in_charge" class="form-label">Person In-Charge</label>
                            @php
                                $selectedPersonInCharge = old('person_in_charge', $equipment->person_in_charge ?? []);
                                if (is_string($selectedPersonInCharge)) {
                                    $selectedPersonInCharge = json_decode($selectedPersonInCharge, true);
                                }
                                $selectedPersonInCharge = is_array($selectedPersonInCharge) ? $selectedPersonInCharge : [];
                            @endphp
                            <select class="form-select @error('person_in_charge') is-invalid @enderror @error('person_in_charge.*') is-invalid @enderror" id="person_in_charge" name="person_in_charge[]" multiple>
                                @foreach($users as $user)
                                    @php
                                        $personInCharge = $equipment->person_in_charge;
                                        if (is_string($personInCharge)) {
                                            $personInCharge = json_decode($personInCharge, true);
                                        }
                                        $personInCharge = is_array($personInCharge) ? $personInCharge : [];
                                        $initials = strtoupper(
                                            ($user->f_name ? substr($user->f_name, 0, 1) : '') .
                                            ($user->m_name ? substr($user->m_name, 0, 1) : '') .
                                            ($user->l_name ? substr($user->l_name, 0, 1) : '')
                                        );
                                    @endphp
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $selectedPersonInCharge) ? 'selected' : '' }}>{{ $initials }}</option>
                                @endforeach
                            </select>
                            @error('person_in_charge')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            @error('person_in_charge.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12 position-relative mb-2">
                            <label for="updates" class="form-label">Updates</label>
                            <textarea class="form-control @error('updates') is-invalid @enderror" id="updates" name="updates" rows="3" maxlength="10000">{{ old('updates', $equipment->updates) }}</textarea>
                            @error('updates')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-success" type="submit">Update Equipment</button>
                            <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    const equipmentSelect = document.getElementById('equipment');
    const equipmentNoInput = document.getElementById('equipment_no');
    const brandModelInput = document.getElementById('brand_model');
    const dateAcquiredInput = document.getElementById('date_acquired');
    const locationInput = document.getElementById('location');
    
    equipmentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            equipmentNoInput.value = selectedOption.dataset.equipmentNo || '';
            brandModelInput.value = selectedOption.dataset.brandModel || '';
            if (selectedOption.dataset.date) {
                const datePart = selectedOption.dataset.date.split(' ')[0];
                dateAcquiredInput.value = datePart;
            } else {
                dateAcquiredInput.value = '';
            }
            locationInput.value = selectedOption.dataset.location || '';
        }
    });

    if (equipmentSelect.value) {
        equipmentSelect.dispatchEvent(new Event('change'));
    }
    
    const qtyInput = document.getElementById('qty');
    const unitCostInput = document.getElementById('unit_cost');
    const totalCostInput = document.getElementById('total_cost');
    
    function calculateTotalCost() {
        const qty = parseFloat(qtyInput.value) || 0;
        const unitCost = parseFloat(unitCostInput.value) || 0;
        totalCostInput.value = (qty * unitCost).toFixed(2);
    }
    
    qtyInput.addEventListener('input', calculateTotalCost);
    unitCostInput.addEventListener('input', calculateTotalCost);
    
    const receivedQtyInput = document.getElementById('received_quantity');
    const usedQtyInput = document.getElementById('used_quantity');
    const balanceQtyInput = document.getElementById('balance_quantity');
    
    function calculateBalance() {
        const received = parseInt(receivedQtyInput.value) || 0;
        const used = parseInt(usedQtyInput.value) || 0;
        balanceQtyInput.value = Math.max(0, received - used);
    }
    
    receivedQtyInput.addEventListener('input', calculateBalance);
    usedQtyInput.addEventListener('input', calculateBalance);

    calculateTotalCost();
    calculateBalance();
    
    const personInChargeSelect = document.getElementById('person_in_charge');
    if (personInChargeSelect) {
        new Choices(personInChargeSelect, {
            removeItemButton: true,
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Select persons in-charge',
        });
    }

    const firstInvalid = document.querySelector('.is-invalid, .form-control:invalid, .form-select:invalid');
    if (firstInvalid) {
        firstInvalid.focus();
    }
})();
</script>
@endsection