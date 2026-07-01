@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">INVENTORY</h4>
                        <p class="mb-0 text-muted">Equipment, Glassware, and Supplies Inventory Management</p>
                    </div>
                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" href="javascript:void(0);" aria-label="Add Equipment" title="Add Equipment">
                        <span class="btn-inner">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 12.5537C12.2546 12.5537 14.4626 10.3171 14.4626 7.52684C14.4626 4.73663 12.2546 2.5 9.5 2.5C6.74543 2.5 4.53737 4.73663 4.53737 7.52684C4.53737 10.3171 6.74543 12.5537 9.5 12.5537ZM9.5 15.0152C5.45422 15.0152 2 15.6621 2 18.2464C2 20.8298 5.4332 21.5 9.5 21.5C13.5448 21.5 17 20.8531 17 18.2687C17 15.6844 13.5668 15.0152 9.5 15.0152ZM19.8979 9.58786H21.101C21.5962 9.58786 22 9.99731 22 10.4995C22 11.0016 21.5962 11.4111 21.101 11.4111H19.8979V12.5884C19.8979 13.0906 19.4952 13.5 18.999 13.5C18.5038 13.5 18.1 13.0906 18.1 12.5884V11.4111H16.899C16.4027 11.4111 16 11.0016 16 10.4995C16 9.99731 16.4027 9.58786 16.899 9.58786H18.1V8.41162C18.1 7.90945 18.5038 7.5 18.999 7.5C19.4952 7.5 19.8979 7.90945 19.8979 8.41162V9.58786Z" fill="currentColor"></path></svg>
                        </span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-success bg-opacity-10 text-primary rounded-3 p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">Total Items</h6>
                                        <h3 class="mb-0 fw-bold">1,248</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3 p-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">Available</h6>
                                        <h3 class="mb-0 fw-bold">842</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">In Use</h6>
                                        <h3 class="mb-0 fw-bold">312</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1">Under Maintenance</h6>
                                        <h3 class="mb-0 fw-bold">94</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('equipments.index') }}" method="GET" class="form-inline d-flex flex-wrap gap-2 mt-2">
                        <input type="text" name="search" class="form-control" placeholder="Search inventory..." style="max-width: 300px;">
                        <select class="form-select" name="category" style="max-width: 170px;">
                            <option value="">Category</option>
                            <option value="equipment">Equipment</option>
                            <option value="glassware">Glassware</option>
                            <option value="supplies">Supplies</option>
                        </select>
                        <select class="form-select" name="status" style="max-width: 170px;">
                            <option value="">Status</option>
                            <option value="available">Available</option>
                            <option value="in-use">In Use</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        <select class="form-select" name="location" style="max-width: 170px;">
                            <option value="">Location</option>
                            <option value="lab-a">Lab A</option>
                            <option value="lab-b">Lab B</option>
                            <option value="storage">Storage Room</option>
                        </select>
                        <button type="submit" class="btn btn-outline-danger">Search</button>
                        <a href="{{ route('equipments.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </form>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped" role="grid" data-bs-toggle="data-table">
                            <thead>
                                <tr class="light">
                                    <th>Equipment</th>
                                    <th>Control No.</th>
                                    <th>QTY</th>
                                    <th>Unit</th>
                                    <th>RFL Control No.</th>
                                    <th>Description</th>
                                    <th>Brand</th>
                                    <th>Date Acquired</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                    <th>Status/Remarks</th>
                                    <th>Received Quantity</th>
                                    <th>Used Quantity</th>
                                    <th>Balance Quantity</th>
                                    <th>Location</th>
                                    <th>Person In-Charge</th>
                                    <th style="min-width: 100px">Updates</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="17" class="text-center text-muted py-5">
                                        <em>No inventory data available yet.</em>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body py-2">
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                    <li class="page-item active">
                                        <span class="page-link">1</span>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
