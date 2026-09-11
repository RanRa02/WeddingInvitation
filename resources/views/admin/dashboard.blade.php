@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')

<!-- Row 1: Top 5 Solid Color Stat Block Cards (Matching Dashboard Reference Layout) -->
<div class="row g-3 mb-4">
    <!-- Block 1: Purple / Indigo -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #7367f0, #9e95f5);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="small text-white-50 fw-bold">Total Guests</span>
                    <h3 class="fw-bold mb-0 mt-1" style="font-size: 26px;">{{ number_format($totalGuests) }}</h3>
                </div>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                <span>Registered Guests</span>
                <span class="text-white fw-bold">{{ $totalGuests }}</span>
            </div>
        </div>
    </div>

    <!-- Block 2: Cyan / Sky Blue -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #00cfe8, #48dae3);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="small text-white-50 fw-bold">Attending Guests</span>
                    <h3 class="fw-bold mb-0 mt-1" style="font-size: 26px;">{{ number_format($attendingGuests) }}</h3>
                </div>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                <span>Confirmed RSVP</span>
                <span class="text-white fw-bold">{{ $attendingGuests }}</span>
            </div>
        </div>
    </div>

    <!-- Block 3: Emerald Green -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #28c76f, #52e093);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="small text-white-50 fw-bold">Pending RSVP</span>
                    <h3 class="fw-bold mb-0 mt-1" style="font-size: 26px;">{{ number_format($pendingGuests) }}</h3>
                </div>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                <span>Awaiting Response</span>
                <span class="text-white fw-bold">{{ $pendingGuests }}</span>
            </div>
        </div>
    </div>

    <!-- Block 4: Gold Champagne -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #1877f2, #0866ff);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="small text-white-50 fw-bold">Declined</span>
                    <h3 class="fw-bold mb-0 mt-1" style="font-size: 26px;">{{ number_format($declinedGuests) }}</h3>
                </div>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
            <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                <span>Declined RSVP</span>
                <span class="text-white fw-bold">{{ $declinedGuests }}</span>
            </div>
        </div>
    </div>

    <!-- Block 5: Coral Red -->
    <div class="col-12 col-sm-6 col-xl">
        <div class="rounded-4 p-3 text-white shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #ea5455, #f57f80);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="small text-white-50 fw-bold">Total Users</span>
                    <h3 class="fw-bold mb-0 mt-1" style="font-size: 26px;">{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; font-size: 18px;">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
            <div class="pt-2 mt-2 border-top border-white border-opacity-20 d-flex justify-content-between small text-white-50">
                <span>System Accounts</span>
                <span class="text-white fw-bold">{{ $totalUsers }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Middle Layout (Large Bar Chart + Right Stacked Widgets) -->
<div class="row g-4 mb-4">
    <!-- Left Column: Overall Monthly Performance Bar Chart -->
    <div class="col-12 col-xl-7">
        <div class="bg-white rounded-4 p-4 border shadow-sm h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Overall Monthly Performance</h5>
                    <span class="text-muted small">Guest Attendance & RSVP Statistics</span>
                </div>
                <div class="d-flex align-items-center gap-2 small fw-semibold">
                    <span class="badge rounded-pill" style="background-color: rgba(40, 199, 111, 0.15); color: #28c76f;">&bull; Attending</span>
                    <span class="badge rounded-pill" style="background-color: rgba(115, 103, 240, 0.15); color: #7367f0;">&bull; Pending</span>
                    <span class="badge rounded-pill" style="background-color: rgba(234, 84, 85, 0.15); color: #ea5455;">&bull; Declined</span>
                </div>
            </div>
            <div style="height: 310px; position: relative;">
                <canvas id="overallMonthlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Right Column: RSVP Distribution Donut Chart & Side Ratio Widget -->
    <div class="col-12 col-xl-5">
        <div class="row g-3 h-100">
            <!-- Top Right Widget 1: Donut Chart -->
            <div class="col-12 col-md-6 col-xl-12">
                <div class="bg-white rounded-4 p-4 border shadow-sm h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-dark mb-0">RSVP Attendance Distribution</h6>
                        <span class="badge bg-light text-dark border px-3 rounded-pill">Real-time</span>
                    </div>
                    <div style="height: 180px; position: relative;" class="d-flex align-items-center justify-content-center">
                        <canvas id="satisfactionDonutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Right Widget 2: Side Breakdown Rate -->
            <div class="col-12 col-md-6 col-xl-12">
                <div class="bg-white rounded-4 p-4 border shadow-sm h-100">
                    <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Groom vs Bride Side Ratio</span>
                    <div class="d-flex align-items-center justify-content-between mt-2 mb-3">
                        <h3 class="fw-bold text-dark mb-0">
                            {{ $groomGuests + $brideGuests > 0 ? round(($groomGuests / ($groomGuests + $brideGuests)) * 100, 1) : 50 }}%
                            <span class="text-success small fs-6 fw-semibold">(+6%)</span>
                        </h3>
                        <span class="text-muted small">Side Ratio Rate</span>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="p-2 border rounded-3 bg-light flex-fill text-center">
                            <span class="text-muted d-block" style="font-size: 11px;">Groom Side</span>
                            <span class="fw-bold text-dark small">{{ $groomGuests }} Guests</span>
                        </div>
                        <div class="p-2 border rounded-3 bg-light flex-fill text-center">
                            <span class="text-muted d-block" style="font-size: 11px;">Bride Side</span>
                            <span class="fw-bold text-dark small">{{ $brideGuests }} Guests</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Bottom Grid (YTD vs Goal Bar Chart + 12 Month Line Chart + Gauge Completion Scores) -->
<div class="row g-4 mb-4">
    <!-- Bottom Left: YTD vs Goal Grouped Bar Chart -->
    <div class="col-12 col-md-6 col-xl-4">
        <div class="bg-white rounded-4 p-4 border shadow-sm h-100">
            <h6 class="fw-bold text-dark mb-3">YTD vs. Goal</h6>
            <div style="height: 220px; position: relative;">
                <canvas id="ytdGoalChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Middle: 12 Month Trend Line Chart -->
    <div class="col-12 col-md-6 col-xl-4">
        <div class="bg-white rounded-4 p-4 border shadow-sm h-100">
            <h6 class="fw-bold text-dark mb-3">12 Month Trend</h6>
            <div style="height: 220px; position: relative;">
                <canvas id="trendLineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Right: Average Result Scores (Circular Ring Gauges) -->
    <div class="col-12 col-xl-4">
        <div class="bg-white rounded-4 p-4 border shadow-sm h-100">
            <h6 class="fw-bold text-dark mb-3">Average Result Area Scores</h6>
            <div class="row g-3 text-center">
                <div class="col-4">
                    <div class="position-relative d-inline-flex align-items-center justify-content-center mb-1">
                        <svg width="60" height="60" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f3f5" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#7367f0" stroke-width="3.5" stroke-dasharray="75, 100"/>
                        </svg>
                        <span class="position-absolute fw-bold text-dark small">6.5</span>
                    </div>
                    <span class="d-block text-muted" style="font-size: 11px;">Groom Side</span>
                </div>

                <div class="col-4">
                    <div class="position-relative d-inline-flex align-items-center justify-content-center mb-1">
                        <svg width="60" height="60" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f3f5" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#28c76f" stroke-width="3.5" stroke-dasharray="85, 100"/>
                        </svg>
                        <span class="position-absolute fw-bold text-dark small">8.5</span>
                    </div>
                    <span class="d-block text-muted" style="font-size: 11px;">Bride Side</span>
                </div>

                <div class="col-4">
                    <div class="position-relative d-inline-flex align-items-center justify-content-center mb-1">
                        <svg width="60" height="60" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f3f5" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#00cfe8" stroke-width="3.5" stroke-dasharray="50, 100"/>
                        </svg>
                        <span class="position-absolute fw-bold text-dark small">5.0</span>
                    </div>
                    <span class="d-block text-muted" style="font-size: 11px;">Both Sides</span>
                </div>

                <div class="col-6">
                    <div class="position-relative d-inline-flex align-items-center justify-content-center mb-1">
                        <svg width="60" height="60" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f3f5" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#1877f2" stroke-width="3.5" stroke-dasharray="60, 100"/>
                        </svg>
                        <span class="position-absolute fw-bold text-dark small">5.9</span>
                    </div>
                    <span class="d-block text-muted" style="font-size: 11px;">Attending RSVP</span>
                </div>

                <div class="col-6">
                    <div class="position-relative d-inline-flex align-items-center justify-content-center mb-1">
                        <svg width="60" height="60" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f3f5" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#ea5455" stroke-width="3.5" stroke-dasharray="40, 100"/>
                        </svg>
                        <span class="position-absolute fw-bold text-dark small">3.9</span>
                    </div>
                    <span class="d-block text-muted" style="font-size: 11px;">Pending RSVP</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Overall Monthly Performance Bar Chart
        const ctxBar = document.getElementById('overallMonthlyChart')?.getContext('2d');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Attending',
                            data: [7, 6, 4, 8, 10, 5, 3, 10, 7, 5, 6, 12],
                            backgroundColor: '#28c76f',
                            borderRadius: 5
                        },
                        {
                            label: 'Pending',
                            data: [5, 4, 3, 6, 7, 4, 2, 8, 5, 3, 4, 8],
                            backgroundColor: '#7367f0',
                            borderRadius: 5
                        },
                        {
                            label: 'Declined',
                            data: [2, 1, 4, 2, 3, 2, 1, 2, 3, 2, 1, 3],
                            backgroundColor: '#ea5455',
                            borderRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f0f3f6' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 2. RSVP Distribution Donut Chart
        const ctxDonut = document.getElementById('satisfactionDonutChart')?.getContext('2d');
        if (ctxDonut) {
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: ['Attending', 'Pending', 'Declined'],
                    datasets: [{
                        data: [{{ $attendingGuests ?: 55 }}, {{ $pendingGuests ?: 20 }}, {{ $declinedGuests ?: 25 }}],
                        backgroundColor: ['#28c76f', '#7367f0', '#ea5455'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } }
                    }
                }
            });
        }

        // 3. YTD vs Goal Grouped Bar Chart
        const ctxYtd = document.getElementById('ytdGoalChart')?.getContext('2d');
        if (ctxYtd) {
            new Chart(ctxYtd, {
                type: 'bar',
                data: {
                    labels: ['All', 'Groom', 'Bride', 'Both', 'VIP'],
                    datasets: [
                        { label: 'YTD', data: [12, 14, 13, 11, 12], backgroundColor: '#7367f0', borderRadius: 5 },
                        { label: 'Goal', data: [15, 17, 16, 14, 15], backgroundColor: '#ea5455', borderRadius: 5 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true }, x: { grid: { display: false } } }
                }
            });
        }

        // 4. 12 Month Trend Line Chart
        const ctxTrend = document.getElementById('trendLineChart')?.getContext('2d');
        if (ctxTrend) {
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Trend',
                            data: [16, 17, 15, 14, 16, 15, 13, 16, 14, 13, 15, 16],
                            borderColor: '#7367f0',
                            backgroundColor: 'rgba(115, 103, 240, 0.12)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#7367f0'
                        },
                        {
                            label: 'Goal',
                            data: [15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15],
                            borderColor: '#ea5455',
                            borderDash: [4, 4],
                            fill: false,
                            pointRadius: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: false }, x: { grid: { display: false } } }
                }
            });
        }
    });
</script>
@endpush

@endsection

