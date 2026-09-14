@extends('layouts.customer')

@section('title', __('app.send_invitations'))
@section('page_title', __('app.send_invitations'))

@section('content')
<div class="container-fluid p-0">

    @php
        $publicUrl = route('w.show', $wedding->slug ?? 'default');
    @endphp

    <!-- 1. Top Public Link Share Card -->
    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white mb-4 position-relative overflow-hidden">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                <i class="fas fa-paper-plane text-primary"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-dark">{{ __('ដំណរភ្ជាប់សំបុត្រអញ្ជើញទូទៅ (Public Invitation Link)') }}</h5>
                <p class="text-muted small mb-0">{{ __('អ្នកអាចចម្លង ឬចែករំលែក Link នេះទៅកាន់គ្រួសារ មិត្តភក្តិ តាមបណ្តាញសង្គម') }}</p>
            </div>
        </div>

        <div class="p-3 bg-light rounded-4 border">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-link"></i></span>
                <input type="text" id="publicLinkInput" class="form-control bg-white border-start-0 py-2" value="{{ $publicUrl }}" readonly>
                <button class="btn btn-primary px-4 fw-semibold" onclick="copyPublicLink()">
                    <i class="fas fa-copy me-1"></i> {{ __('ចម្លង Link') }}
                </button>
                <a href="https://t.me/share/url?url={{ urlencode($publicUrl) }}&text={{ urlencode('សូមអញ្ជើញចូលរួមពិធីអាពាហ៍ពិពាហ៍របស់យើងខ្ញុំ!') }}" target="_blank" class="btn btn-info text-white px-3 fw-semibold">
                    <i class="fab fa-telegram-plane me-1"></i> Telegram
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode('សូមអញ្ជើញចូលរួមពិធីអាពាហ៍ពិពាហ៍របស់យើងខ្ញុំ! ' . $publicUrl) }}" target="_blank" class="btn btn-success px-3 fw-semibold">
                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                </a>
            </div>
            <div id="copyToast" class="text-success fw-bold small mt-2 d-none">
                <i class="fas fa-check-circle me-1"></i> {{ __('បានចម្លង Link ជោគជ័យ! (Link copied)') }}
            </div>
        </div>
    </div>

    <!-- 2. Individual Guest Personalized Links Table -->
    <div class="dreams-card p-0 overflow-hidden border-0 shadow-sm bg-white">
        <div class="p-3 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="fas fa-share-alt"></i>
                </div>
                <div>
                    <h5 class="dreams-card-title mb-0">{{ __('ចែករំលែកសំបុត្រផ្ទាល់ខ្លួនសម្រាប់ភ្ញៀវម្នាក់ៗ (Personalized Links)') }}</h5>
                    <small class="text-muted">{{ __('ភ្ញៀវម្នាក់ៗមាន Link ផ្ទាល់ខ្លួនដែលមានឈ្មោះ និងកូដសម្គាល់ផ្ទាល់') }}</small>
                </div>
            </div>
            <a href="{{ route('customer.guests.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                <i class="fas fa-user-plus me-1"></i> {{ __('គ្រប់គ្រងបញ្ជីភ្ញៀវ (Manage Guests)') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-gold-header align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">{{ __('app.no') }}</th>
                        <th>{{ __('app.guest_name') }}</th>
                        <th class="text-center">{{ __('កូដសំបុត្រ') }}</th>
                        <th>{{ __('Link សំបុត្រផ្ទាល់ខ្លួន (Personal Link)') }}</th>
                        <th class="text-center" style="width: 220px;">{{ __('ចែករំលែក (Quick Share)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $guest)
                        @php
                            $personalUrl = $publicUrl . '?guest=' . $guest->invitation_code;
                            $shareMessage = "សូមគោរពអញ្ជើញ " . $guest->name . " ចូលរួមពិធីមង្គលការរបស់ " . ($wedding->groom_name ?? '') . " & " . ($wedding->bride_name ?? '') . " \nសូមចុច Link សំបុត្រអញ្ជើញ៖ " . $personalUrl;
                        @endphp
                        <tr>
                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                            <td>
                                <strong class="text-dark">{{ $guest->name }}</strong>
                                @if($guest->phone)
                                    <small class="text-muted d-block"><i class="fas fa-phone-alt me-1"></i> {{ $guest->phone }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-2 py-1 font-monospace">
                                    {{ $guest->invitation_code }}
                                </span>
                            </td>
                            <td>
                                <div class="input-group input-group-sm" style="max-width: 360px;">
                                    <input type="text" class="form-control bg-light" value="{{ $personalUrl }}" id="guest_url_{{ $guest->id }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyGuestLink('{{ $guest->id }}')" title="{{ __('Copy Link') }}">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="https://t.me/share/url?url={{ urlencode($personalUrl) }}&text={{ urlencode($shareMessage) }}" target="_blank" class="btn btn-outline-info rounded-pill px-2 me-1" title="Share via Telegram">
                                        <i class="fab fa-telegram-plane"></i> Telegram
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($shareMessage) }}" target="_blank" class="btn btn-outline-success rounded-pill px-2" title="Share via WhatsApp">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                                {{ __('មិនទាន់មានភ្ញៀវនៅក្នុងបញ្ជីនៅឡើយទេ') }}
                                <div class="mt-2">
                                    <a href="{{ route('customer.guests.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                        <i class="fas fa-user-plus me-1"></i> {{ __('បន្ថែមភ្ញៀវឥឡូវនេះ') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function copyPublicLink() {
        var copyText = document.getElementById("publicLinkInput");
        if (copyText) {
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value).then(function() {
                var toast = document.getElementById("copyToast");
                if (toast) {
                    toast.classList.remove("d-none");
                    setTimeout(function() {
                        toast.classList.add("d-none");
                    }, 3000);
                }
            });
        }
    }

    function copyGuestLink(guestId) {
        var copyText = document.getElementById("guest_url_" + guestId);
        if (copyText) {
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value).then(function() {
                alert("{{ __('បានចម្លង Link សម្រាប់ភ្ញៀវនេះជោគជ័យ!') }}");
            });
        }
    }
</script>
@endpush
