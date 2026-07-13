@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            {{-- <h4 class="card-title"><span class="badge bg-warning p-3">DOCUMENT CODE : LF 06-06 - SAMPLE RECEIVING AND RELEASING LOGBOOK</span></h4>
                          --}}
                        </div>
                         <a class="btn btn-danger btn-icon"
                                href="#"
                                id="downloadPdfBtn"
                                data-bs-toggle="tooltip"
                                title="Download PDF">
                                <span class="btn-inner">
                                    <svg class="icon-25" width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.2301 7.29052V3.2815C11.2301 2.85523 11.5701 2.5 12.0001 2.5C12.3851 2.5 12.7113 2.79849 12.763 3.17658L12.7701 3.2815V7.29052L17.55 7.29083C19.93 7.29083 21.8853 9.23978 21.9951 11.6704L22 11.8861V16.9254C22 19.373 20.1127 21.3822 17.768 21.495L17.56 21.5H6.44C4.06 21.5 2.11409 19.5608 2.00484 17.1213L2 16.9047L2 11.8758C2 9.4281 3.87791 7.40921 6.22199 7.29585L6.43 7.29083H11.23V13.6932L9.63 12.041C9.33 11.7312 8.84 11.7312 8.54 12.041C8.39 12.1959 8.32 12.4024 8.32 12.6089C8.32 12.7659 8.3648 12.9295 8.45952 13.0679L8.54 13.1666L11.45 16.1819C11.59 16.3368 11.79 16.4194 12 16.4194C12.1667 16.4194 12.3333 16.362 12.4653 16.2533L12.54 16.1819L15.45 13.1666C15.75 12.8568 15.75 12.3508 15.45 12.041C15.1773 11.7594 14.7475 11.7338 14.4462 11.9642L14.36 12.041L12.77 13.6932V7.29083L11.2301 7.29052Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="card-body ">
                          <form method="GET">

                                <div class="row mb-4">

                                    <div class="col-md-3">
                                        <label>Year</label>

                                        <select name="year" class="form-control">

                                            <option value="">All</option>

                                            @for($y=date('Y');$y>=2020;$y--)
                                                <option value="{{ $y }}"
                                                    {{ request('year') == $y ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor

                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Month</label>

                                        <select name="month" class="form-control">

                                            <option value="">All</option>

                                            @for($m=1;$m<=12;$m++)
                                                <option value="{{ $m }}"
                                                    {{ request('month') == $m ? 'selected' : '' }}>
                                                    {{ date('F',mktime(0,0,0,$m,1)) }}
                                                </option>
                                            @endfor

                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>&nbsp;</label>

                                        <button class="btn btn-success w-100">
                                            Filter
                                        </button>
                                    </div>

                                </div>

                            </form>
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">

                                    <h6 class="text-muted">
                                        Total Registered Customers
                                    </h6>

                                    <h1 class="text-success">
                                        {{ number_format($totalCustomers) }}
                                    </h1>

                                </div>
                            </div>
                            <div class="table-responsive">

                                        <table class="table table-bordered table-hover">

                                            <thead class="table-light">

                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th>Address</th>
                                                    <th>Contact Number</th>
                                                    <th>Date Registered</th>
                                                </tr>

                                            </thead>

                                            <tbody>

                                                @forelse($customers as $customer)

                                                <tr>

                                                    <td>
                                                        {{ $customer->company_name }}
                                                    </td>

                                                    <td>{{ $customer->resolved_address }}</td>

                                                    <td>
                                                        {{ $customer->contact_no }}
                                                    </td>

                                                    <td>
                                                        {{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y') }}
                                                    </td>

                                                </tr>

                                                @empty

                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>

                                                @endforelse

                                            </tbody>

                                        </table>

                                        </div>
                </div>
            </div>
        </div>
   
 
    </div>


@endsection