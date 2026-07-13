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

                                                @for($y = date('Y'); $y >= 2020; $y--)
                                                    <option value="{{ $y }}"
                                                        {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Month</label>
                                            <select name="month" class="form-control">

                                                <option value="">All Months</option>

                                                @for($m=1;$m<=12;$m++)
                                                    <option value="{{ $m }}"
                                                        {{ request('month') == $m ? 'selected' : '' }}>
                                                        {{ date('F', mktime(0,0,0,$m,1)) }}
                                                    </option>
                                                @endfor

                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Date From</label>
                                            <input type="date"
                                                name="date_from"
                                                value="{{ request('date_from') }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Date To</label>
                                            <input type="date"
                                                name="date_to"
                                                value="{{ request('date_to') }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-2">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-primary w-100">
                                                Filter
                                            </button>
                                        </div>

                                    </div>

                                </form>
                                <style>
                                    .dashboard-card{
                                        border:none;
                                        border-radius:15px;
                                        box-shadow:0 2px 10px rgba(0,0,0,.08);
                                    }

                                    .stats-icon{
                                        width:90px;
                                        height:90px;
                                        border-radius:15px;
                                        background:#eaf7ee;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                    }

                                    .stats-icon i{
                                        font-size:40px;
                                        color:#28a745;
                                    }

                                    .stats-value{
                                        font-size:42px;
                                        font-weight:700;
                                        color:#28a745;
                                    }

                                    .chart-card{
                                        border:none;
                                        border-radius:15px;
                                        box-shadow:0 2px 10px rgba(0,0,0,.08);
                                    }

                                    .table-card{
                                        border:none;
                                        border-radius:15px;
                                        box-shadow:0 2px 10px rgba(0,0,0,.08);
                                    }

                                    .grand-total{
                                        background:#eef9f1 !important;
                                        font-weight:bold;
                                    }
                                </style>

                                <div class="row mb-4">

                                    <div class="col-md-6">
                                        <div class="card dashboard-card">
                                            <div class="card-body p-4">

                                                <div class="d-flex align-items-center">

                                                    <div class="stats-icon">
                                                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                                            <image xlink:href="data:image/png;base64,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" x="0" y="0" width="24" height="24"/>
                                                        </svg>
                                                    </div>

                                                    <div class="ms-4">
                                                        <h5 class="text-muted mb-2">
                                                            Total Customers
                                                        </h5>

                                                        <div class="stats-value">
                                                            {{ number_format($totalCustomers) }}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card dashboard-card">
                                            <div class="card-body p-4">

                                                <div class="d-flex align-items-center">

                                                    <div class="stats-icon">
                                                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                                            <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEBElEQVR4AZyUD0yUdRjHv9whRQeH5YCReK4/tEaT4OrG9JI7VALPOQlbauXNNpEs1ArmbpVki+gPInM1+jNbOZw5KRUXcFy64/iT5xhKieCfIKrBcQgHlECk753P8+od4vvq0O35vO/vfX7P83zf318FgBDCQBjvkoco75bGAvNDI2PqYhdn2u+USO0zdqpcQtzSWCBoVkIydAVfIHbRijuCBLjwXHqsI+IJibGA6HQ1WjG6fxcS/2qdNinKcbyas0Wbakz7lopkExILCHCPfoEBHxbuxHsFH6NgW5EshR+UiDEc52flyjWcLssUAY4QBAEphkQkah+R5XBlBYeJCMIV2GxVqK45wt/z6fESoSICJhFQKpVwHm9Hx5keWZ7LfEFMPneuHcZULcq/yYVK8RuQeH8yMmL2YoaikwIyCNEkAgKNYEPOy1hrzpKlznEUfX29WLU6HUV5sTi8Ox3phjlAXDjwzhPA8tnRQUAlVecRQSLAI8jJ2cyLJ8uTCVp88un7yDVrYFqkoTo3WPkf0NWP4YAxhc/WLu6RCPh8PvT390mIioqGXm9ARMRM1NQcRPaaxzl/kjo3dAeHYU1bjKy5GjymVj9NnRpZgaYmBxpvorPrAsUDo6OX4BkaQtLSHxGXsl/EUnQCOl8Yaqn4zBD+eZoxdTjNFKQCCoUCvBVLdpThRjLSl4sCoaH3QX2vCicXLsVpwzKRLlMmmkwZiLhenANd4+P8uigZAS/yU7o4PPzorCl89vkOTkBwcDAWGJfA2tMLFbX9KIP4h8UQnBkexqlBD++m84prrsknL3JL8wV0/T44hU25+YEgy9btsPzahrMjIwGfvzE4MQFzQxOtJCzk80kEyBmw7/Z8jfUbXsTG18zi3Ps74uPnofjLcjzbcBzbTrWi3t0P58UBlLZ3IOlI1ZVWz9CbFPsDId2m7HS7XeCFrqjYi0NxbhxwVmHQM8BdAdKWmHCsgQ7YslV4o3cA+mprV35zS3HP2Ng8ChK3KL3lBXi+t7++Fn92UIGEGCAsBHX2n+FwHOOcAJGR0ch7621kZ+eyj++LrdQ4SwRMdor4LGxaqEeyZvIg7aw9iudXmwKJ023ICsglJ+UXQzHjHrmu2/pkBbxeLy4LXgheH/C/ANBLuDxBhXzg0VEDefkb8WCsCrPnhGHzlvXsGuXHzYgCw+dPo7vqe7GPz4HdbsO7jkacGPAgylKPKI8Cza8Y8UC4Gv7reuSfEZSWliMrywz6IRslFxISY4GWS393ruv7xbabe/kcTOe65tiyso+wb99XXHwFff9HSIwF/iXvHqLBWvuT7BUtd3U7nY1oazt52+JUc8o2PdTd3ZlaXVM5LVyunlQqkEnI/jn5RbsKAAD//yB+6GMAAAAGSURBVAMAmcoAZdfKQwEAAAAASUVORK5CYII=" x="0" y="0" width="24" height="24"/>
                                                        </svg>
                                                    </div>

                                                    <div class="ms-4">
                                                        <h5 class="text-muted mb-2">
                                                            Total Payments
                                                        </h5>

                                                        <div class="stats-value">
                                                            ₱{{ number_format($totalPayments,2) }}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card chart-card mb-4">
                                    <div class="card-body p-4">

                                        <canvas id="paymentChart" height="90"></canvas>

                                    </div>
                                </div>

                                <div class="card table-card">
                                    <div class="card-body">

                                        <div class="table-responsive">

                                            <table class="table align-middle">

                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Customers</th>
                                                        <th>Payments</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    @php
                                                        $grandCustomers = 0;
                                                        $grandPayments = 0;
                                                    @endphp

                                                    @foreach($report as $row)

                                                    @php
                                                        $grandCustomers += $row['customers'];
                                                        $grandPayments += $row['payments'];
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $row['month'] }}</td>
                                                        <td>{{ number_format($row['customers']) }}</td>
                                                        <td>₱{{ number_format($row['payments'],2) }}</td>
                                                    </tr>

                                                    @endforeach

                                                    <tr class="grand-total">
                                                        <td>Grand Total</td>
                                                        <td>{{ number_format($grandCustomers) }}</td>
                                                        <td>₱{{ number_format($grandPayments,2) }}</td>
                                                    </tr>

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                <script>

                                const ctx = document.getElementById('paymentChart');

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            @foreach($report as $row)
                                                "{{ $row['month'] }}",
                                            @endforeach
                                        ],
                                        datasets: [{
                                            data: [
                                                @foreach($report as $row)
                                                    {{ $row['payments'] }},
                                                @endforeach
                                            ],

                                            backgroundColor: '#28a745',
                                            borderRadius: 8,

                                            barThickness: 60,
                                            maxBarThickness: 65
                                        }]
                                    },
                                    options: {

                                        responsive: true,

                                        plugins: {
                                            legend: {
                                                display: false
                                            }
                                        },

                                        scales: {

                                            x: {
                                                grid: {
                                                    display: false,
                                                    drawBorder: false
                                                },
                                                ticks: {
                                                    color: '#000',
                                                    font: {
                                                        size: 13,
                                                        weight: 'bold'
                                                    }
                                                }
                                            },

                                            y: {
                                                beginAtZero: true,

                                                grid: {
                                                    display: false
                                                },

                                                ticks: {
                                                    display: false
                                                },

                                                border: {
                                                    display: false
                                                }
                                            }
                                        }
                                    }
                                });

                                </script>
                    </div>
                </div>
            </div>
        </div>
   
 
    </div>


@endsection