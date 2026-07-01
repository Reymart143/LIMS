<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipment' => ['required', 'string', 'max:255', Rule::exists('lf_03_05', 'equipment')],
            'equipment_no' => ['required', 'string', 'max:255', Rule::exists('lf_03_05', 'equipment_no'), Rule::unique('equipment', 'equipment_no')],
            'qty' => ['required', 'integer', 'min:0'],
            'unit' => ['nullable', 'string', 'max:255'],
            'rfl_control_no' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'brand_model' => ['nullable', 'string', 'max:255'],
            'date_acquired' => ['nullable', 'date'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'total_cost' => ['nullable', 'numeric', 'min:0'],
            'status_remarks' => ['nullable', 'string', 'max:5000'],
            'received_quantity' => ['required', 'integer', 'min:0'],
            'used_quantity' => ['required', 'integer', 'min:0'],
            'balance_quantity' => ['nullable', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'array'],
            'person_in_charge.*' => ['integer', 'distinct', Rule::exists('users', 'id')],
            'updates' => ['nullable', 'string', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'equipment.required' => 'Equipment is required.',
            'equipment.string' => 'Equipment must be text.',
            'equipment.max' => 'Equipment may not exceed 255 characters.',
            'equipment.exists' => 'Selected equipment does not exist in the inventory source.',
            'equipment_no.required' => 'Equipment No. is required.',
            'equipment_no.string' => 'Equipment No. must be text.',
            'equipment_no.max' => 'Equipment No. may not exceed 255 characters.',
            'equipment_no.exists' => 'Equipment No. does not match a valid inventory source record.',
            'equipment_no.unique' => 'Equipment No. has already been used.',
            'qty.required' => 'Quantity is required.',
            'qty.integer' => 'Quantity must be a whole number.',
            'qty.min' => 'Quantity must be zero or greater.',
            'unit.string' => 'Unit must be text.',
            'unit.max' => 'Unit may not exceed 255 characters.',
            'rfl_control_no.string' => 'RFL Control No. must be text.',
            'rfl_control_no.max' => 'RFL Control No. may not exceed 255 characters.',
            'description.string' => 'Description must be text.',
            'description.max' => 'Description may not exceed 5000 characters.',
            'brand_model.string' => 'Brand / Model must be text.',
            'brand_model.max' => 'Brand / Model may not exceed 255 characters.',
            'date_acquired.date' => 'Date Acquired must be a valid date.',
            'unit_cost.required' => 'Unit Cost is required.',
            'unit_cost.numeric' => 'Unit Cost must be a valid number.',
            'unit_cost.min' => 'Unit Cost cannot be negative.',
            'total_cost.numeric' => 'Total Cost must be a valid number.',
            'total_cost.min' => 'Total Cost cannot be negative.',
            'status_remarks.string' => 'Status / Remarks must be text.',
            'status_remarks.max' => 'Status / Remarks may not exceed 5000 characters.',
            'received_quantity.required' => 'Received Quantity is required.',
            'received_quantity.integer' => 'Received Quantity must be a whole number.',
            'received_quantity.min' => 'Received Quantity cannot be negative.',
            'used_quantity.required' => 'Used Quantity is required.',
            'used_quantity.integer' => 'Used Quantity must be a whole number.',
            'used_quantity.min' => 'Used Quantity cannot be negative.',
            'balance_quantity.integer' => 'Balance Quantity must be a whole number.',
            'balance_quantity.min' => 'Balance Quantity cannot be negative.',
            'location.string' => 'Location must be text.',
            'location.max' => 'Location may not exceed 255 characters.',
            'person_in_charge.array' => 'Person In-Charge must be a valid selection.',
            'person_in_charge.*.integer' => 'Person In-Charge contains an invalid selection.',
            'person_in_charge.*.distinct' => 'Person In-Charge cannot contain duplicates.',
            'person_in_charge.*.exists' => 'Assigned Employee does not exist.',
            'updates.string' => 'Updates must be text.',
            'updates.max' => 'Updates may not exceed 10000 characters.',
        ];
    }
}