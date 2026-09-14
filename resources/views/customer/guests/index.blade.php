@extends('layouts.customer')

@section('title', __('app.guest_list'))
@section('page_title', __('app.guest_list'))

@section('content')
<div class="row g-4">
    <!-- Add Guest Form -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-plus text-danger me-2"></i> បន្ថែមភ្ញៀវថ្មី</h5>
            
            <div class="p-3 bg-light rounded-3 mb-3 border">
                <small class="text-muted d-block">ចំនួនភ្ញៀវបច្ចុប្បន្ន (Quota Usage):</small>
                <strong class="fs-5 text-danger">{{ number_format($guestCount) }} / {{ number_format($guestLimit) }} នាក់</strong>
            </div>

            <form action="{{ route('customer.guests.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold small">ឈ្មោះភ្ញៀវកិត្តិយស <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control rounded-3" placeholder="ឧ. លោក ហេង សម្បត្តិ & ភរិយា" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">លេខទូរស័ព្ទ</label>
                    <input type="text" name="phone" class="form-control rounded-3" placeholder="012 345 678">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ខាង (Side) <span class="text-danger">*</span></label>
                    <select name="side" class="form-select rounded-3" required>
                        <option value="groom">ខាងប្រុស (Groom Side)</option>
                        <option value="bride">ខាងស្រី (Bride Side)</option>
                        <option value="both">ទាំងសងខាង (Both)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">លេខតុ (Table No)</label>
                    <input type="text" name="table_number" class="form-control rounded-3" placeholder="ឧ. 01">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">ចំណាំ (Note)</label>
                    <input type="text" name="note" class="form-control rounded-3" placeholder="មិត្តភក្តិ ឬភ្ញៀវកិត្តិយស">
                </div>

                <button type="submit" class="btn btn-danger w-100 rounded-pill py-2" {{ $user->hasReachedGuestLimit() ? 'disabled' : '' }}>
                    <i class="fa-solid fa-plus me-1"></i> រក្សាទុកភ្ញៀវ
                </button>
            </form>
        </div>
    </div>

    <!-- Guest Table List -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list text-primary me-2"></i> បញ្ជីភ្ញៀវអញ្ជើញទាំងអស់</h5>

            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-gold-header yajra-datatable align-middle mb-0 w-100', 'style' => 'width:100%']) !!}
            </div>
        </div>
</div>

@foreach($user->guests ?? [] as $guest)
<!-- Edit Guest Modal {{ $guest->id }} -->
<div class="modal fade" id="editGuestModal{{ $guest->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom bg-light py-3 px-4" style="border-top: 3px solid #1877f2 !important;">
                <h5 class="modal-title fw-bold" style="color: #1877f2;"><i class="fa-solid fa-user-pen me-2"></i>កែប្រែព័ត៌មានភ្ញៀវ (Edit Guest)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customer.guests.update', $guest->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ឈ្មោះភ្ញៀវកិត្តិយស <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ $guest->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">លេខទូរស័ព្ទ</label>
                        <input type="text" name="phone" class="form-control rounded-3" value="{{ $guest->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">ខាង (Side) <span class="text-danger">*</span></label>
                        <select name="side" class="form-select rounded-3" required>
                            <option value="groom" {{ $guest->side == 'groom' ? 'selected' : '' }}>ខាងប្រុស (Groom Side)</option>
                            <option value="bride" {{ $guest->side == 'bride' ? 'selected' : '' }}>ខាងស្រី (Bride Side)</option>
                            <option value="both" {{ $guest->side == 'both' ? 'selected' : '' }}>ទាំងសងខាង (Both)</option>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small">លេខតុ (Table No)</label>
                            <input type="text" name="table_number" class="form-control rounded-3" value="{{ $guest->table_number }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small">ចំនួនអ្នករួមដំណើរ</label>
                            <input type="number" name="companions" class="form-control rounded-3" value="{{ $guest->companions }}" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">ស្ថានភាពចូលរួម (Attendance)</label>
                        <select name="attendance" class="form-select rounded-3">
                            <option value="pending" {{ $guest->attendance == 'pending' ? 'selected' : '' }}>រង់ចាំ (Pending)</option>
                            <option value="attending" {{ $guest->attendance == 'attending' ? 'selected' : '' }}>ចូលរួម (Attending)</option>
                            <option value="declined" {{ $guest->attendance == 'declined' ? 'selected' : '' }}>អវត្តមាន (Declined)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">ចំណាំ (Note)</label>
                        <input type="text" name="note" class="form-control rounded-3" value="{{ $guest->note }}">
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn text-white fw-medium px-4" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;" data-bs-dismiss="modal">បោះបង់</button>
                    <button type="submit" class="btn text-white fw-medium px-4" style="background-color: #1877f2; border: none; font-size: 13px; border-radius: 4px;">រក្សាទុកការកែប្រែ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
@endsection
