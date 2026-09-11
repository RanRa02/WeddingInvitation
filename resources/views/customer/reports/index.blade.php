@extends('layouts.customer')

@section('title', 'RSVP & Guest Reports')
@section('page_title', 'របាយការណ៍វត្តមានភ្ញៀវ (RSVP & Attendance Analytics)')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Guests -->
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white text-center">
            <small class="text-muted fw-bold text-uppercase">TOTAL INVITED</small>
            <h2 class="display-6 fw-bold text-dark my-1">{{ number_format($totalGuests) }}</h2>
            <small class="text-muted">ភ្ញៀវអញ្ជើញសរុប</small>
        </div>
    </div>

    <!-- Attending Guests -->
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white text-center border-start border-success border-4">
            <small class="text-success fw-bold text-uppercase">ATTENDING</small>
            <h2 class="display-6 fw-bold text-success my-1">{{ number_format($attendingCount) }}</h2>
            <small class="text-muted">+ {{ $totalCompanions }} នាក់អមដំណើរ</small>
        </div>
    </div>

    <!-- Declined Guests -->
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white text-center border-start border-danger border-4">
            <small class="text-danger fw-bold text-uppercase">DECLINED</small>
            <h2 class="display-6 fw-bold text-danger my-1">{{ number_format($declinedCount) }}</h2>
            <small class="text-muted">ភ្ញៀវមិនបានចូលរួម</small>
        </div>
    </div>

    <!-- Pending Guests -->
    <div class="col-md-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 bg-white text-center border-start border-warning border-4">
            <small class="text-warning fw-bold text-uppercase">PENDING RSVP</small>
            <h2 class="display-6 fw-bold text-warning my-1">{{ number_format($pendingCount) }}</h2>
            <small class="text-muted">រង់ចាំការឆ្លើយតប</small>
        </div>
    </div>
</div>

<div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-file-invoice text-info me-2"></i> របាយការណ៍លម្អិតតាមភ្ញៀវ</h5>
        <button class="btn btn-outline-success btn-sm rounded-pill" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> បោះពុម្ភ / Save PDF
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>ឈ្មោះភ្ញៀវ</th>
                    <th>លេខតុ</th>
                    <th>ស្ថានភាព RSVP</th>
                    <th>អ្នកអមដំណើរ</th>
                    <th>ចំណងដៃ</th>
                    <th>ពាក្យជូនពរ (Wishes)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $guest->name }}</td>
                        <td>តុ {{ $guest->table_number ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $guest->attendance == 'attending' ? 'bg-success' : ($guest->attendance == 'declined' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($guest->attendance) }}
                            </span>
                        </td>
                        <td>{{ $guest->companions ?? 0 }} នាក់</td>
                        <td class="fw-bold text-success">{{ $guest->gift_amount ?? '-' }}</td>
                        <td class="small text-muted">{{ $guest->wishes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">មិនទាន់មានទិន្នន័យរបាយការណ៍នៅឡើយទេ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
