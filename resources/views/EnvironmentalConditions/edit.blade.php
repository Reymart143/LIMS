@extends('layouts.app')
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">
                            <span class="badge bg-success p-3">ENVIRONMENTAL CONDITIONS MONITORING FORM - EDIT</span>
                        </h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('environmental.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="{{ $environmental->id}}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Area</label>
                                <input type="text" name="area" class="form-control"
                                    value="{{ old('area', $environmental->area) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Name of Laboratory</label>
                                <input type="text" name="laboratory_name" class="form-control"
                                    value="{{ old('laboratory_name', $environmental->laboratory_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', $environmental->date) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Temperature AM</label>
                                <input type="number" step="0.01" name="temperature_am" class="form-control"
                                    value="{{ old('temperature_am', $environmental->temperature_am) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Temperature PM</label>
                                <input type="number" step="0.01" name="temperature_pm" class="form-control"
                                    value="{{ old('temperature_pm', $environmental->temperature_pm) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Humidity AM</label>
                                <input type="number" step="0.01" name="humidity_am" class="form-control"
                                    value="{{ old('humidity_am', $environmental->humidity_am) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Humidity PM</label>
                                <input type="number" step="0.01" name="humidity_pm" class="form-control"
                                    value="{{ old('humidity_pm', $environmental->humidity_pm) }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $environmental->remarks) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Analyst</label>
                                <input type="text" name="analyst" class="form-control"
                                    value="{{ old('analyst', $environmental->analyst) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Checked By</label>
                                <input type="text" name="checked_by" class="form-control"
                                    value="{{ old('checked_by', $environmental->checked_by) }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('environmental_plan/index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection