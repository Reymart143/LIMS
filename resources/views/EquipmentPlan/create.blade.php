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
                        <form action="{{ route('equipment-maintenance-plans.store') }}" method="POST">
                            @csrf

                            <table>
                                <tr>
                                    <td colspan="4" class="title">EQUIPMENT MAINTENANCE PLAN</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <label>Unit:</label>
                                        <input type="text" name="unit" value="{{ old('unit') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label>Equipment Code:</label>
                                        <input type="text" name="equipment_code" value="{{ old('equipment_code') }}">
                                    </td>
                                    <td colspan="2">
                                        <label>Equipment Name:</label>
                                        <input type="text" name="equipment_name" value="{{ old('equipment_name') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label>Manufacturer:</label>
                                        <input type="text" name="manufacturer" value="{{ old('manufacturer') }}">
                                    </td>
                                    <td colspan="2">
                                        <label>Brand / Model No.:</label>
                                        <input type="text" name="brand_model_no" value="{{ old('brand_model_no') }}">
                                    </td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td colspan="4" class="title">MAINTENANCE INFORMATION</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label>Date of Maintenance:</label>
                                        <input type="date" name="date_of_maintenance" value="{{ old('date_of_maintenance') }}">
                                    </td>
                                    <td colspan="2">
                                        <label>Service Report No.:</label>
                                        <input type="text" name="service_report_no" value="{{ old('service_report_no') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <label>Maintenance Type:</label>
                                        <select name="maintenance_type">
                                            <option value="">-- Select --</option>
                                            <option value="Preventive">Preventive</option>
                                            <option value="Corrective">Corrective</option>
                                            <option value="Emergency">Emergency</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <label>Maintenance Provider:</label>
                                        <input type="text" name="maintenance_provider" value="{{ old('maintenance_provider') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <label>Maintenance Technician:</label>
                                        <input type="text" name="maintenance_technician" value="{{ old('maintenance_technician') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <label>Maintenance Hours:</label>
                                        <input type="text" name="maintenance_hours" value="{{ old('maintenance_hours') }}">
                                    </td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td colspan="2" class="title">MAINTENANCE DETAILS</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>1. Issue Reported</strong>
                                        <div class="checkbox-group">
                                            <label><input type="checkbox" name="issues_reported[]" value="Equipment not functioning"> Equipment not functioning</label>
                                            <label><input type="checkbox" name="issues_reported[]" value="Performance issues"> Performance issues (slow, noisy, etc.)</label>
                                            <label><input type="checkbox" name="issues_reported[]" value="Overheating"> Overheating</label>
                                            <label><input type="checkbox" name="issues_reported[]" value="Mechanical failure"> Mechanical failure</label>
                                            <label><input type="checkbox" name="issues_reported[]" value="Electrical issue"> Electrical issue</label>
                                            <label><input type="checkbox" name="issues_reported[]" value="General wear and tear"> General wear and tear</label>
                                        </div>
                                        <label>Other:</label>
                                        <input type="text" name="issue_other" value="{{ old('issue_other') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>2. Maintenance Actions Taken</strong>
                                        <div class="checkbox-group">
                                            <label><input type="checkbox" name="actions_taken[]" value="Cleaning and lubricating"> Cleaning and lubricating</label>
                                            <label><input type="checkbox" name="actions_taken[]" value="Part replacement"> Part replacement</label>
                                            <label><input type="checkbox" name="actions_taken[]" value="Calibration"> Calibration</label>
                                            <label><input type="checkbox" name="actions_taken[]" value="Software firmware updates"> Software/firmware updates</label>
                                            <label><input type="checkbox" name="actions_taken[]" value="Inspection and testing"> Inspection and testing</label>
                                        </div>
                                        <label>Other:</label>
                                        <input type="text" name="action_other" value="{{ old('action_other') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label>Tools Used:</label>
                                        <textarea name="tools_used">{{ old('tools_used') }}</textarea>
                                    </td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td colspan="2" class="title">CONDITION AFTER MAINTENANCE</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label><strong>Operational Status</strong></label>
                                        <div class="checkbox-group">
                                            <label><input type="checkbox" name="operational_status[]" value="Fully Operational"> Fully Operational</label>
                                            <label><input type="checkbox" name="operational_status[]" value="Partially Operational"> Partially Operational</label>
                                            <label><input type="checkbox" name="operational_status[]" value="Not Operational"> Not Operational</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label><strong>Equipment Status</strong></label>
                                        <div class="checkbox-group">
                                            <label><input type="checkbox" name="equipment_status[]" value="Good Condition"> Good Condition</label>
                                            <label><input type="checkbox" name="equipment_status[]" value="Needs Repair"> Needs Repair</label>
                                            <label><input type="checkbox" name="equipment_status[]" value="Further Monitoring Required"> Further Monitoring Required</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td colspan="2" class="title">MAINTENANCE DUE</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label>Next Maintenance Due:</label>
                                        <input type="date" name="next_maintenance_due" value="{{ old('next_maintenance_due') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label><strong>Frequency</strong></label>
                                        <div class="checkbox-group">
                                            <label><input type="checkbox" name="frequency[]" value="Daily"> Daily</label>
                                            <label><input type="checkbox" name="frequency[]" value="Weekly"> Weekly</label>
                                            <label><input type="checkbox" name="frequency[]" value="Monthly"> Monthly</label>
                                            <label><input type="checkbox" name="frequency[]" value="Quarterly"> Quarterly</label>
                                            <label><input type="checkbox" name="frequency[]" value="Annually"> Annually</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td colspan="2" class="title">MAINTENANCE COMMENTS</td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Maintenance Provider / Technician Notes</label>
                                        <textarea name="technician_notes">{{ old('technician_notes') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Technical Manager / Laboratory Analyst Feedback</label>
                                        <textarea name="manager_feedback">{{ old('manager_feedback') }}</textarea>
                                    </td>
                                </tr>
                            </table>

                            <button type="submit" class="btn">Save</button>
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