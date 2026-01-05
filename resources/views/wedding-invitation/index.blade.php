@extends('layouts.app')

@push('css')
<style>
    body {
        background: #f8f9fa;
    }

    .sub-content, .sub-content-two {
        width: 100%;
        max-width: 900px;
        margin: auto;
        border-radius: 12px;
    }

    .sub-content {
        background-image: url('{{ asset('assets/images/background.jpg') }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: top center;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        margin-bottom: 0px;
        padding: 30px 20px;
    }

    .sub-content-two {
        background-image: url('{{ asset('assets/images/background2.jpg') }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: top center;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        margin-top: 0px;
        padding: 20px;
    }

    .head-text {
        color: rgb(245, 184, 15);
        text-shadow: 1px 2px 4px #000;
        line-height: 1.4;
    }

    .name {
        color: rgb(245, 184, 15);
        text-shadow: 1px 2px 4px #000;
    }

    /* Scroll-trigger animation */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 1s ease-out;
    }

    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Name Frame */
    .name-frame-wrapper { position: relative; display:inline-block; width:100%; max-width:470px; }
    .name-frame-img { width:100%; height:75px; }
    .name-frame-text { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
        font-size:22px; font-weight:bold; color:#514d5a; text-shadow:1px 1px 3px rgba(0,0,0,0.6); white-space: nowrap;
    }

    /* Mobile */
    @media(max-width:576px) {
        .head-text { font-size:20px; }
        .name-frame-text { font-size:18px; }
    }

    /* Image zoom */
    .img-zoom { transition: transform 0.4s ease; cursor:pointer; }
    .img-zoom:hover { transform: scale(1.1); }

    /* Calendar */
    .sub-content-two table { width:100%; table-layout:fixed; background: rgba(255,255,255,0.85); border-radius:8px; overflow:hidden; }
    .sub-content-two th, .sub-content-two td { padding:10px; }
    .sub-content-two th { background-color: rgba(245,184,15,0.9); color:#000; }
    .sub-content-two td.bg-warning { background-color: rgb(245,184,15); color:#000; border-radius:50%; font-weight:bold; }
    @media(max-width:576px) { .sub-content-two th, .sub-content-two td { padding:6px; font-size:12px; } }

    /* Countdown Table */
    #countdown-table { max-width:500px; margin:20px auto; background: rgba(255,255,255,0.9); border-radius:8px; }
    #countdown-table th, #countdown-table td { padding:10px; font-size:20px; font-weight:bold; }
    @media(max-width:576px) { #countdown-table th, #countdown-table td { font-size:14px; padding:6px; } }

    /* Message */
    .invitation-msg { line-height:1.8; white-space: pre-line; font-size:22px; }
</style>
@endpush

@section('content')
<div class="container-fluid px-2 px-md-4 my-3">

    <!-- Invitation Card -->
    <div class="card sub-content p-3 p-md-4">
        <div class="card-body text-center">
            <h1 class="head-text muol fade-in-up pt-4">សិរីមង្គលអាពាហ៍ពិពាហ៍</h1>
            <h3 class="head-text fade-in-up mt-2">Celebration of Marriage</h3>

            <!-- Bride & Groom -->
            <div class="row fade-in-up align-items-center mt-4">
                <div class="col-12 col-md-5 mb-3 mb-md-0">
                    <h3 class="head-text muol">កូន ប្រុស</h3>
                    <h2 class="head-text muol pt-1">រ៉ុន ណារឹន</h2>
                </div>
                <div class="col-12 col-md-2 my-3 my-md-0">
                    <img src="{{ asset('assets/images/icon-wedding.png') }}" class="img-fluid" style="max-width:120px;">
                </div>
                <div class="col-12 col-md-5">
                    <h3 class="head-text muol">កូន ស្រី</h3>
                    <h2 class="head-text muol pt-1">សុវណ្ណនីតា</h2>
                </div>
            </div>

            <!-- Date -->
            <div class="fade-in-up mt-4">
                <h3 class="name muol">វេលាម៉ោង ៩៖០០ ព្រឹក</h3>
                <h3 class="name muol">ថ្ងៃអាទិត្យ ទី០៤ ខែ មករា ឆ្នាំ២០២៦</h3>
            </div>

            <!-- Invitation -->
            <div class="fade-in-up mt-4">
                <h1 class="name muol">សូមគោរពអញ្ជើញ</h1>
                <div class="name-frame-wrapper mt-2">
                    <img src="{{ asset('assets/images/name-frame-kbach.png') }}" class="name-frame-img img-fluid">
                    <div class="name-frame-text muol">សម្លាញ់ ធាសុធី</div>
                </div>
            </div>

            <!-- Message -->
            <div class="fade-in-up text-muted mt-4 invitation-msg">
ភ្ញៀវកត្តិយស ដើម្បីប្រសិទ្ធិពរជ័យ សិរីសួស្ដីមង្គល ពិធីភ្ជាប់ពាក្យ
យើងខ្ញុំ ដែល ប្រព្រឹត្តិទៅនៅវេលាម៉ោង ៩:០០ នាទីព្រឹក
ស្ថិតនៅគេហដ្ឋានខាងស្រី ស្ថិតនៅទីតាំងភូមិព្រៃខ្លាទី១ ឃុំព្រៃខ្លា
ស្រុកស្វាយអន្ទរ ខេត្តព្រៃវែង
            </div>

            <!-- Countdown Table -->
            <div class="fade-in-up text-center mt-4">
                <h3 class="name muol">កំណត់ពេលវេលាពិធី</h3>
                <table class="table table-bordered text-center" id="countdown-table">
                    <thead class="bg-warning text-dark">
                        <tr>
                            <th>ថ្ងៃ</th>
                            <th>ម៉ោង</th>
                            <th>នាទី</th>
                            <th>វិនាទី</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="countdown-days">0</td>
                            <td id="countdown-hours">0</td>
                            <td id="countdown-minutes">0</td>
                            <td id="countdown-seconds">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Map -->
            <div class="fade-in-up mt-4">
                <h3 class="name muol">ទីតាំងកម្មវិធី</h3>
                <img src="{{ asset('assets/images/Location.png') }}" id="location-img" class="img-fluid img-zoom mt-2" style="max-width:150px;">
            </div>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="card sub-content-two p-3 p-md-4">
        <h3 class="text-center mb-3 name">ប្រតិទិនថ្ងៃរៀបចំកម្មវិធី</h3>
        @php
            use Carbon\Carbon;
            $today = Carbon::create(2026, 1, 4);
            $monthName = $today->locale('km')->isoFormat('MMMM YYYY');
            $firstDayOfMonth = $today->copy()->startOfMonth();
            $daysInMonth = $today->daysInMonth;
            $startWeekDay = $firstDayOfMonth->dayOfWeek;
        @endphp

        <h4 class="text-center name mb-3">{{ $monthName }}</h4>
        <table class="table table-bordered text-center">
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
                @for($i=0;$i<6;$i++)
                    <tr>
                        @for($j=0;$j<7;$j++)
                            @if($i===0 && $j<$startWeekDay)
                                <td></td>
                            @elseif($day>$daysInMonth)
                                <td></td>
                            @else
                                <td class="{{ $today->day==$day ? 'bg-warning text-dark fw-bold' : '' }}">{{ $day }}</td>
                                @php $day++; @endphp
                            @endif
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="text-center mt-4 mb-2">
        <p class="text-muted">&copy; {{ date('Y') }} Ran Ra. All rights reserved.</p>
    </div>

</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function(){

    // Map click
    const locationImg = document.getElementById('location-img');
    if(locationImg){
        locationImg.addEventListener('click', function(){
            window.open('https://maps.app.goo.gl/mB65Fwu3L9natdqr6', '_blank');
        });
    }

    // Countdown
    const weddingDate = new Date("January 4, 2026 09:00:00").getTime();
    function updateCountdown(){
        const now = new Date().getTime();
        const distance = weddingDate - now;

        if(distance<=0){
            document.getElementById('countdown-days').innerHTML = 0;
            document.getElementById('countdown-hours').innerHTML = 0;
            document.getElementById('countdown-minutes').innerHTML = 0;
            document.getElementById('countdown-seconds').innerHTML = 0;
            clearInterval(interval);
            return;
        }

        const days = Math.floor(distance / (1000*60*60*24));
        const hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
        const minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
        const seconds = Math.floor((distance % (1000*60)) / 1000);

        document.getElementById('countdown-days').innerHTML = days;
        document.getElementById('countdown-hours').innerHTML = hours;
        document.getElementById('countdown-minutes').innerHTML = minutes;
        document.getElementById('countdown-seconds').innerHTML = seconds;
    }
    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);

    // Scroll-trigger animations
    const observer = new IntersectionObserver((entries, observer)=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting){
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('.fade-in-up').forEach(el=>observer.observe(el));
});
</script>
@endpush
