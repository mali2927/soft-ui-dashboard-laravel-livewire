<div class="container-fluid py-4">
    <div class="row">
        <!-- Employee Stats Cards -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Employees</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalEmployees }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Active Employees</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $activeEmployees }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="ni ni-user-run text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">On Leave Today</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $onLeaveToday }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending Leave Requests</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $leaveRequestsPending }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="ni ni-notification-70 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Department Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="departmentChart" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Shift Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="shiftChart" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Recent Leave Requests</h6>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Employee</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Leave Type</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Dates</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentLeaveRequests as $request)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $request->employee->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $request->leaveType->name ?? 'N/A' }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold">{{ $request->start_date->format('M d') }}
                                                - {{ $request->end_date->format('M d') }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="badge badge-sm {{ $request->status == 'approved' ? 'bg-gradient-success' : ($request->status == 'pending' ? 'bg-gradient-warning' : 'bg-gradient-danger') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Salary Statistics</h6>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-money-coins text-success text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Total Monthly Salary</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    ${{ number_format($salaryStats['total_monthly'], 2) }}</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-chart-bar-32 text-info text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Average Salary</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    ${{ number_format($salaryStats['average'], 2) }}</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-trophy text-warning text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Highest Salary</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    ${{ number_format($salaryStats['highest'], 2) }}</p>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="ni ni-collection text-danger text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Lowest Salary</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    ${{ number_format($salaryStats['lowest'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/assets/js/plugins/chartjs.min.js"></script>
<script>
    // Department Distribution Chart
    var ctx1 = document.getElementById("departmentChart").getContext("2d");
    new Chart(ctx1, {
        type: "doughnut",
        data: {
            labels: @json(array_keys($departmentDistribution)),
            datasets: [{
                data: @json(array_values($departmentDistribution)),
                backgroundColor: [
                    '#2dce89',
                    '#5e72e4',
                    '#f5365c',
                    '#fb6340',
                    '#11cdef',
                    '#172b4d'
                ],
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 70,
        }
    });

    // Shift Distribution Chart
    // Shift Distribution Chart
    var ctx2 = document.getElementById("shiftChart").getContext("2d");
    new Chart(ctx2, {
        type: "doughnut",
        data: {
            labels: @json(array_keys($shiftDistribution)),
            datasets: [{
                label: "Employees per Shift",
                data: @json(array_values($shiftDistribution)),
                backgroundColor: [
                    '#5e72e4', '#11cdef', '#2dce89', '#f5365c',
                    '#fb6340', '#5603ad', '#8965e0', '#ffd600'
                ],
                borderWidth: 1
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw || 0;
                            var total = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} employees (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            cutout: '65%'
        }
    });
</script>
