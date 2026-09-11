@extends('layouts.customer')

@section('title', 'Send Invitations')
@section('page_title', 'ផ្ញើសំបុត្រអញ្ជើញ (Send Invitations & Share Links)')

@section('content')
<div class="card border-0 rounded-4 shadow-sm p-4 bg-white mb-4">
    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-paper-plane text-warning me-2"></i> ដំណរភ្ជាប់សំបុត្រអញ្ជើញទូទៅ (Public Invitation Link)</h5>
    @php
        $publicUrl = route('w.show', $wedding->slug ?? 'default');
    @endphp
    
    <div class="input-group mb-3">
        <input type="text" id="publicLinkInput" class="form-control form-control-lg bg-light" value="{{ $publicUrl }}" readonly>
        <button class="btn btn-dark px-4" onclick="copyPublicLink()"><i class="fa-solid fa-copy me-1"></i> ចម្លង Link</button>
        <a href="https://t.me/share/url?url={{ urlencode($publicUrl) }}&text={{ urlencode('សូមអញ្ជើញចូលរួមពិធីអាពាហ៍ពិពាហ៍របស់យើងខ្ញុំ!') }}" target="_blank" class="btn btn-primary px-4">
            <i class="fa-brands fa-telegram me-1"></i> Telegram
        </a>
    </div>
</div>

<div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-share-nodes text-success me-2"></i> ចែករំលែកសំបុត្រផ្ទាល់ខ្លួនសម្រាប់ភ្ញៀវម្នាក់ៗ (Personalized Links)</h5>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>ឈ្មោះភ្ញៀវ</th>
                    <th>កូដ</th>
                    <th>Personal Link</th>
                    <th>ចែករំលែក (Share)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    @php
                        $personalUrl = $publicUrl . '?guest=' . $guest->invitation_code;
                        $shareMessage = "សូមគោរពអញ្ជើញ " . $guest->name . " ចូលរួមពិធីមង្គលការរបស់ " . ($wedding->groom_name ?? '') . " & " . ($wedding->bride_name ?? '') . " \nសូមចុច Link សំបុត្រអញ្ជើញ៖ " . $personalUrl;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $guest->name }}</td>
                        <td><code>{{ $guest->invitation_code }}</code></td>
                        <td>
                            <input type="text" class="form-control form-control-sm bg-light" value="{{ $personalUrl }}" readonly style="max-width: 320px;">
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="https://t.me/share/url?url={{ urlencode($personalUrl) }}&text={{ urlencode($shareMessage) }}" target="_blank" class="btn btn-outline-primary" title="Share Telegram">
                                    <i class="fa-brands fa-telegram"></i> Telegram
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($shareMessage) }}" target="_blank" class="btn btn-outline-success" title="Share WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">មិនទាន់មានភ្ញៀវនៅក្នុងបញ្ជីនៅឡើយទេ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function copyPublicLink() {
    var copyText = document.getElementById("publicLinkInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("បានចម្លង Link ជោគជ័យ! (Link copied)");
}
</script>
@endpush
@endsection
