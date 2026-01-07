@extends('layouts.app')

@push('css')
<style>
/* ===== Base Styles ===== */
body {
    background: #f8f9fa;
}

.container-fluid {
    max-width: 985px;
    margin: auto;
}

/* Sub Content */
.sub-content, .sub-content-two {
    width: 100%;
    max-width: 100%;
    margin: auto;
    border-radius: 12px;
}

.sub-content {
    background-image: url('{{ asset('assets/images/background.jpg') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center top;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    margin-bottom: 0;
}

.sub-content-two {
    background-image: url('{{ asset('assets/images/background2.jpg') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center top;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    margin-top: 0;
    padding: 20px;
}

/* Headings */
.head-text {
    color: rgb(245, 184, 15);
    text-shadow: 1px 2px 4px #000;
    line-height: 1.4;
}

.name {
    color: rgb(245, 184, 15);
    text-shadow: 1px 2px 4px #000;
}

/* Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in-up {
    opacity: 0;
    animation: fadeInUp 1s forwards;
}

/* Name Frame */
.name-frame-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
    max-width: 470px;
}

.name-frame-img {
    width: 100%;
    height: 65px;
}

.name-frame-text {
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 22px;
    font-weight: bold;
    color: #514d5a;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    white-space: nowrap;
}

/* Image Zoom */
.img-zoom {
    transition: transform 0.4s ease;
    cursor: pointer;
}

.img-zoom:hover {
    transform: scale(1.1);
}

/* Bride & Groom Row */
.bride-groom-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 30px;
}

.bride-groom-column {
    flex: 1 1 200px;
    text-align: center;
    position: relative;
}

.bride-groom-column h2.name {
    font-size: 24px;
    color: rgb(245, 184, 15);
    text-shadow: 1px 2px 4px #000;
    margin-bottom: 5px;
    font-weight: bold;
}

/* Decorative connector heart */
.bride-groom-connector {
    position: relative;
    width: 80px;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 10px auto;
}

.bride-groom-connector img {
    width: 100%;
    max-width: 80px;
    transition: transform 0.5s;
}

.bride-groom-connector img:hover {
    transform: scale(1.2);
}

/* Calendar */
.sub-content-two table {
    width: 100%;
    table-layout: fixed;
    background: rgba(255,255,255,0.85);
    border-radius: 8px;
    overflow: hidden;
}

.sub-content-two th, .sub-content-two td {
    padding: 10px;
}

.sub-content-two th {
    background-color: rgba(245, 184, 15, 0.9);
    color: #000;
}

.sub-content-two td.bg-warning,
.sub-content-two td.bg-success {
    border-radius: 50%;
    font-weight: bold;
    color: #000;
}

/* Countdown */
.countdown {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.countdown div {
    background: rgba(245, 184, 15, 0.9);
    color: #000;
    padding: 10px 15px;
    border-radius: 8px;
    min-width: 60px;
}

.countdown div span {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
}

.countdown div small {
    display: block;
    font-size: 0.75rem;
}

/* ===== Responsive for Tablets and Phones (≤768px) ===== */
@media (max-width: 768px) {

    .sub-content-two {
        padding: 15px;
    }

    .head-text {
        font-size: 20px;
    }

    .sub-content h3.head-text {
        font-size: 18px;
    }

    .sub-content h1.name {
        font-size: 18px;
    }

    .name-frame-text {
        font-size: 16px;
    }

    .row.align-items-center {
        flex-direction: column;
    }

    .row.align-items-center .col-md-5,
    .row.align-items-center .col-md-2 {
        max-width: 100%;
        text-align: center;
    }

    .row.align-items-center img {
        max-width: 100px;
        margin: 10px 0;
    }

    .sub-content-two th, .sub-content-two td {
        padding: 6px;
        font-size: 12px;
    }

    .container-fluid {
        padding: 0 10px;
    }

    .name-frame-wrapper {
        max-width: 100%;
    }

    .countdown div {
        min-width: 50px;
        padding: 8px 10px;
    }

    .bride-groom-column h2.name {
        font-size: 20px;
    }

    .bride-groom-connector {
        width: 60px;
        height: 60px;
    }
}

/* Extra Small Phones (≤576px) */
@media (max-width: 576px) {
    .head-text {
        font-size: 16px;
    }

    .sub-content h3.head-text {
        font-size: 14px;
    }

    .name-frame-text {
        font-size: 12px;
    }

    .sub-content-two th, .sub-content-two td {
        padding: 3px;
        font-size: 9px;
    }

    .countdown div {
        min-width: 40px;
        padding: 5px 6px;
    }

    .countdown div span {
        font-size: 1rem;
    }

    .countdown div small {
        font-size: 0.6rem;
    }

    /* Bride & Groom smaller text */
    .bride-groom-column h2.name {
        font-size: 14px;
        margin-bottom: 3px;
    }

    .bride-groom-connector {
        width: 40px;
        height: 40px;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card sub-content">
        <div class="card-body text-center mt-4">
            <!-- Title -->
            <h1 class="head-text muol fade-in-up pt-4">
                <br>
                សិរីមង្គលពិធីភ្ជាប់ពាក្យ
            </h1>
            <h3 class="head-text fade-in-up mt-2" style="animation-delay:.3s">
                The Engagement Ceremony
            </h3>

            <!-- Bride & Groom -->
            <div class="fade-in-up bride-groom-row" style="animation-delay:.6s">
                <!-- Groom -->
                <div class="bride-groom-column">
                    <h2 class="name muol">កូន ប្រុស</h2>
                    <h2 class="name muol">រ៉ាន់ រ៉ា</h2>
                </div>

                <!-- Connector -->
                <div class="bride-groom-connector">
                    <img src="{{ asset('assets/images/icon-wedding.png') }}" alt="wedding-icon" class="img-fluid">
                </div>

                <!-- Bride -->
                <div class="bride-groom-column">
                    <h2 class="name muol">កូន ស្រី</h2>
                    <h2 class="name muol">ខុម ស្រីណេត</h2>
                </div>
            </div>

            <!-- Invitation -->
            <div class="fade-in-up mt-4" style="animation-delay:.9s">
                <br>
                <h1 class="name muol">សូមគោរពអញ្ជើញ</h1>

                <!-- NAME IN FRAME -->
                <div class="name-frame-wrapper mt-2">
                    <img src="{{ asset('assets/images/name-frame-kbach.png') }}"
                         class="name-frame-img img-fluid">

                    <div class="name-frame-text muol">
                        <span class="name" style="font-size: 25px; text-shadow:2px 2px 2px 2px #000;">{{ $data['name'] ?? '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Countdown -->
            <div class="fade-in-up countdown" id="countdown" style="animation-delay:1.1s">
                <div>
                    <span id="days">0</span>
                    <small>Days</small>
                </div>
                <div>
                    <span id="hours">0</span>
                    <small>Hours</small>
                </div>
                <div>
                    <span id="minutes">0</span>
                    <small>Minutes</small>
                </div>
                <div>
                    <span id="seconds">0</span>
                    <small>Seconds</small>
                </div>
            </div>

            <!-- Date & Location -->
            <div class="fade-in-up mt-4 battambang" style="animation-delay:1.2s">
                <h4 class="name">
                    ថ្ងៃចន្ទ ទី១៨ ខែមករា ឆ្នាំ២០២៦ វេលាម៉ោង ៨៖០០ ព្រឹក
                </h4>
                <h4 class="name mt-3">
                    ស្ថិតនៅគេហដ្ឋានខាងស្រី ភូមិព្រៃខ្លាទី១ ឃុំព្រៃខ្លា
                    ស្រុកស្វាយអន្ទរ ខេត្តព្រៃវែង
                </h4>
            </div>

            <!-- Map -->
            <div class="fade-in-up mt-4" style="animation-delay:1.8s">
                <h3 class="name muol">ទីតាំងកម្មវិធី</h3>
                <img src="{{ asset('assets/images/Location.png') }}"
                     id="location-img"
                     class="img-fluid img-zoom mt-2"
                     style="max-width:150px;">
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="card sub-content-two p-3 p-md-4 mt-4">
        <h3 class="text-center mb-3 name muol fade-in-up" style="animation-delay:1.8s">ប្រតិទិទិនសម្រាប់កម្មវិធី</h3>
        @php
            use Carbon\Carbon;

            $today = Carbon::now();
            $dayevent = Carbon::create(2026, 1, 18);
            $firstDayOfMonth = $today->copy()->startOfMonth();
            $lastDayOfMonth = $today->copy()->endOfMonth();
            $startWeekDay = $firstDayOfMonth->dayOfWeek; // 0 = Sunday
            $daysInMonth = $today->daysInMonth;
        @endphp

        <table class="table table-bordered text-center fade-in-up" style="animation-delay:1.8s">
            <thead class="bg-warning text-dark">
                <tr>
                    <th>អាទិត្យ</th>
                    <th>ចន្ទ</th>
                    <th>អង្គារ</th>
                    <th>ពុធ</th>
                    <th>ព្រហស្បតិ៍</th>
                    <th>សុក្រ</th>
                    <th>សៅរ៍</th>
                </tr>
            </thead>
            <tbody>
                @php $day = 1; @endphp
                @for ($i = 0; $i < 6; $i++)
                    <tr>
                        @for ($j = 0; $j < 7; $j++)
                            @if ($i === 0 && $j < $startWeekDay)
                                <td></td>
                            @elseif ($day > $daysInMonth)
                                <td></td>
                            @else
                                @php
                                    $classes = '';
                                    if ($today->day == $day) {
                                        $classes = 'bg-warning text-white fw-bold';
                                    }
                                    if ($dayevent->day == $day) {
                                        $classes = 'bg-success text-white fw-bold';
                                    }
                                @endphp
                                <td class="{{ $classes }}">
                                    {{ $day }}
                                    @if ($dayevent->day == $day)    
                                        <br>
                                        <small>ថ្ងៃកម្មវិធី</small>
                                    @endif
                                </td>
                                @php $day++; @endphp
                            @endif
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="fade-in-up mt-4" style="animation-delay:1.8s">
            <h3 class="text-center mb-3 name muol">យើងខ្ញុំមានកិត្តិយសសូមគោរពអញ្ជើញ</h3>
            <p class="text-muted text-center" style="font-size: 20px;">
                ឯកឧត្តម លោកឧកញ៉ា អ្នកឧកញ៉ ឧកញ៉ា លោកជំទាវ លោក លោកស្រី អ្នកនាង កញ្ញា អញ្ជើញចូលរួមជាអធិបតី 
                និងជាភ្ញៀវកិត្តិយស ដើម្បីប្រសិទ្ធិពរជ័យសិរីសួស្តី ជ័យមង្គល ក្នុងពិធីអាពាហ៍ពិពាហ៍ របស់គូស្វាមីភរិយាថ្មី។
            </p>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-4 mb-2">
        <p class="text-muted">&copy; {{ date('Y') }} Ran Ra. All rights reserved.</p>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Location click
    const locationImg = document.getElementById('location-img');
    if (locationImg) {
        locationImg.addEventListener('click', function () {
            window.open('https://maps.app.goo.gl/mB65Fwu3L9natdqr6', '_blank');
        });
    }

    // Countdown
    const countdownDate = new Date("January 18, 2026 08:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        if (distance < 0) {
            document.getElementById('countdown').innerHTML = "<div>Event Started!</div>";
            clearInterval(interval);
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000*60*60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000*60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').innerText = days;
        document.getElementById('hours').innerText = hours;
        document.getElementById('minutes').innerText = minutes;
        document.getElementById('seconds').innerText = seconds;
    }

    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);
});
</script>
@endpush
