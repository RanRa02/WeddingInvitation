@extends('layouts.customer')

@section('title', __('app.wedding_information_form'))
@section('page_title', __('app.wedding_information_form'))

@section('content')
<div class="col-12 col-xl-10 mx-auto">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>{{ __('app.wedding_information_form') }}</h4>
            <p class="text-muted small mb-0">បញ្ចូល និងកែប្រែព័ត៌មានលម្អិតអាពាហ៍ពិពាហ៍របស់អ្នក (Fill and customize your wedding details)</p>
        </div>
        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> {{ __('app.cancel') }}
        </a>
    </div>

    <form action="{{ route('customer.wedding.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Section 1: Groom & Bride Information & Cover Image Upload -->
        <div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #365cf5 !important;">
            <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle cursor-pointer" data-bs-toggle="collapse" data-bs-target="#groomBrideCard" aria-expanded="true">
                <span class="fw-bold fs-6" style="color: #1877f2;"><i class="fa-solid fa-user-group me-2"></i>{{ __('app.groom_bride_details') }}</span>
                <a class="text-primary fs-6 text-decoration-none">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <div class="collapse show" id="groomBrideCard">
                <div class="card-body p-4">
                    <div class="row g-4 align-items-start">
                        <!-- Left Column: Groom & Bride Text Inputs -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-group text-primary me-2"></i>{{ __('app.groom_bride_details') }}</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.groom_name_kh') }} <span class="text-danger">*</span></label>
                                <input type="text" name="groom_name" class="form-control" value="{{ old('groom_name', $wedding->groom_name) }}" placeholder="ឧ. រ៉ាន់ រ៉ា" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.groom_name_en') }}</label>
                                <input type="text" name="groom_name_en" class="form-control" value="{{ old('groom_name_en', $wedding->groom_name_en) }}" placeholder="e.g. Ran Ra">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.bride_name_kh') }} <span class="text-danger">*</span></label>
                                <input type="text" name="bride_name" class="form-control" value="{{ old('bride_name', $wedding->bride_name) }}" placeholder="ឧ. ខុម ស្រីណេត" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.bride_name_en') }}</label>
                                <input type="text" name="bride_name_en" class="form-control" value="{{ old('bride_name_en', $wedding->bride_name_en) }}" placeholder="e.g. Khom Sreyneang">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.groom_parents') }}</label>
                                <input type="text" name="groom_parents" class="form-control" value="{{ old('groom_parents', $wedding->groom_parents) }}" placeholder="ឧ. លោក ជា ធារ៉ា & លោកស្រី អ៊ុក សុផល">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.bride_parents') }}</label>
                                <input type="text" name="bride_parents" class="form-control" value="{{ old('bride_parents', $wedding->bride_parents) }}" placeholder="ឧ. លោក សុខ ចាន់ & លោកស្រី មាស គឹមស៊ាង">
                            </div>
                        </div>

                        <!-- Right Column: Upload File - Cover Image -->
                        <div class="col-lg-6">
                            <div class="card border border-light-subtle shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-center">
                                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i>Upload file - {{ __('app.cover_image') }}</h5>
                                
                                <div class="dropzone-area text-center p-3 rounded-3 position-relative d-flex flex-column align-items-center justify-content-center mx-auto" id="coverDropzone" style="border: 2px dashed #3b82f6; background-color: #f8fafc; transition: all 0.2s ease; width: 220px; height: 220px; aspect-ratio: 1/1;">
                                    <input type="file" name="cover_image" id="coverInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer; z-index: 10;" accept="image/*" onchange="handleFileSelect(this, 'coverPreview', 'coverFileName')">
                                    
                                    <div id="coverPreviewContainer" class="{{ $wedding && $wedding->cover_image ? '' : 'd-none' }}">
                                        <img id="coverPreview" src="{{ $wedding && $wedding->cover_image ? asset($wedding->cover_image) : '' }}" class="rounded-3 shadow-sm" style="width: 180px; height: 180px; aspect-ratio: 1/1; object-fit: cover;" alt="Cover Preview">
                                    </div>

                                    <div id="coverPlaceholder" class="{{ $wedding && $wedding->cover_image ? 'd-none' : '' }}">
                                        <div class="mb-2">
                                            <i class="fa-solid fa-cloud-arrow-up text-primary" style="font-size: 40px;"></i>
                                        </div>
                                        <p class="mb-1 text-dark small font-medium">
                                            Drag & Drop your files or <span class="text-primary text-decoration-underline fw-bold">Browse</span>
                                        </p>
                                    </div>
                                    <p id="coverFileName" class="text-primary fw-bold small mt-2 mb-0" style="font-size: 11px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 200px;"></p>
                                </div>

                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3 pt-1">
                                    <span class="text-muted small">Formats: PNG, JPG, WEBP</span>
                                    <span class="text-muted small">Max size: 5MB</span>
                                    <button type="button" class="btn btn-primary btn-sm px-4 fw-bold rounded-3 ms-auto" onclick="document.getElementById('coverInput').click();">Upload</button>
                                </div>
                                @error('cover_image') <div class="text-danger small mt-1 text-center">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Event Dates & Schedule -->
        <div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #365cf5 !important;">
            <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle cursor-pointer" data-bs-toggle="collapse" data-bs-target="#scheduleCard" aria-expanded="true">
                <span class="fw-bold fs-6" style="color: #1877f2;"><i class="fa-solid fa-calendar-days me-2"></i>{{ __('app.event_dates_schedule') }}</span>
                <a class="text-primary fs-6 text-decoration-none">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <div class="collapse show" id="scheduleCard">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.solar_date') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="datetime-local" name="event_date" class="form-control" value="{{ old('event_date', $wedding->event_date ? $wedding->event_date->format('Y-m-d\TH:i') : '') }}" required>
                                <span class="input-group-text bg-white text-muted"><i class="far fa-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.lunar_date_text') }}</label>
                            <input type="text" name="lunar_date" class="form-control" value="{{ old('lunar_date', $wedding->lunar_date) }}" placeholder="ឧ. ថ្ងៃអាទិត្យ ៥កើត ខែចេត្រ ឆ្នាំមមី ឆស័ក ព.ស. ២៥៧០">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.morning_time') }}</label>
                            <div class="input-group">
                                <input type="text" name="morning_time" class="form-control" value="{{ old('morning_time', $wedding->morning_time) }}" placeholder="ឧ. ០៧:៣០ ព្រឹក">
                                <span class="input-group-text bg-white text-muted"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.evening_time') }}</label>
                            <div class="input-group">
                                <input type="text" name="evening_time" class="form-control" value="{{ old('evening_time', $wedding->evening_time) }}" placeholder="ឧ. ០៥:០០ ល្ងាច">
                                <span class="input-group-text bg-white text-muted"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Venue & Music -->
        <div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #365cf5 !important;">
            <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle cursor-pointer" data-bs-toggle="collapse" data-bs-target="#venueCard" aria-expanded="true">
                <span class="fw-bold fs-6" style="color: #1877f2;"><i class="fa-solid fa-location-dot me-2"></i>{{ __('app.venue_music') }}</span>
                <a class="text-primary fs-6 text-decoration-none">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <div class="collapse show" id="venueCard">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.venue_name') }}</label>
                            <input type="text" name="venue_name" class="form-control" value="{{ old('venue_name', $wedding->venue_name) }}" placeholder="ឧ. គេហដ្ឋានខាងស្រី / មជ្ឈមណ្ឌលសិរីមង្គល">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.map_url') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="url" name="venue_location_url" class="form-control" value="{{ old('venue_location_url', $wedding->venue_location_url) }}" placeholder="https://maps.google.com/...">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.venue_address') }}</label>
                            <textarea name="venue_address" class="form-control" rows="2" placeholder="ឧ. ភូមិព្រៃខ្លាទី១ ឃុំព្រៃខ្លា ស្រុកស្វាយអន្ទរ ខេត្តព្រៃវែង">{{ old('venue_address', $wedding->venue_address) }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark small mb-1">{{ __('app.music_url') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fas fa-music"></i></span>
                                <input type="url" name="music_url" class="form-control" value="{{ old('music_url', $wedding->music_url) }}" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Gift / KHQR Account Information & KHQR Upload -->
        <div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden mb-4" style="border-top: 3px solid #365cf5 !important;">
            <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light-subtle cursor-pointer" data-bs-toggle="collapse" data-bs-target="#bankCard" aria-expanded="true">
                <span class="fw-bold fs-6" style="color: #1877f2;"><i class="fa-solid fa-qrcode me-2"></i>{{ __('app.gift_khqr_account') }}</span>
                <a class="text-primary fs-6 text-decoration-none">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <div class="collapse show" id="bankCard">
                <div class="card-body p-4">
                    <div class="row g-4 align-items-start">
                        <!-- Left Column: Bank Account Details -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-university text-primary me-2"></i>{{ __('app.gift_khqr_account') }}</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.bank_name') }}</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $wedding->bank_name) }}" placeholder="ឧ. ABA Bank">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.account_name') }}</label>
                                <input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name', $wedding->bank_account_name) }}" placeholder="ឧ. RAN RA & KHOM SREYNEANG">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small mb-1">{{ __('app.account_number') }}</label>
                                <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number', $wedding->bank_account_number) }}" placeholder="ឧ. 000 123 456">
                            </div>
                        </div>

                        <!-- Right Column: Upload File - KHQR Code Image -->
                        <div class="col-lg-6">
                            <div class="card border border-light-subtle shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-center">
                                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-qrcode text-success me-2"></i>Upload file - {{ __('app.bank_qr_image') }}</h5>
                                
                                <div class="dropzone-area text-center p-3 rounded-3 position-relative d-flex flex-column align-items-center justify-content-center mx-auto" id="qrDropzone" style="border: 2px dashed #10b981; background-color: #f0fdf4; transition: all 0.2s ease; width: 220px; height: 220px; aspect-ratio: 1/1;">
                                    <input type="file" name="bank_qr_image" id="qrInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer; z-index: 10;" accept="image/*" onchange="handleFileSelect(this, 'qrPreview', 'qrFileName')">
                                    
                                    <div id="qrPreviewContainer" class="{{ $wedding && $wedding->bank_qr_image ? '' : 'd-none' }}">
                                        <img id="qrPreview" src="{{ $wedding && $wedding->bank_qr_image ? asset($wedding->bank_qr_image) : '' }}" class="rounded-3 shadow-sm" style="width: 180px; height: 180px; aspect-ratio: 1/1; object-fit: contain;" alt="KHQR Preview">
                                    </div>

                                    <div id="qrPlaceholder" class="{{ $wedding && $wedding->bank_qr_image ? 'd-none' : '' }}">
                                        <div class="mb-2">
                                            <i class="fa-solid fa-qrcode text-success" style="font-size: 40px;"></i>
                                        </div>
                                        <p class="mb-1 text-dark small font-medium">
                                            Drag & Drop your files or <span class="text-success text-decoration-underline fw-bold">Browse</span>
                                        </p>
                                    </div>
                                    <p id="qrFileName" class="text-success fw-bold small mt-2 mb-0" style="font-size: 11px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 200px;"></p>
                                </div>

                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3 pt-1">
                                    <span class="text-muted small">Formats: PNG, JPG, WEBP</span>
                                    <span class="text-muted small">Max size: 5MB</span>
                                    <button type="button" class="btn btn-success btn-sm px-4 fw-bold rounded-3 ms-auto" onclick="document.getElementById('qrInput').click();">Upload</button>
                                </div>
                                @error('bank_qr_image') <div class="text-danger small mt-1 text-center">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2 my-4">
            <a href="{{ route('customer.dashboard') }}" class="btn fw-medium px-4 text-white" style="background-color: #ea5455; border: none; font-size: 13px; border-radius: 4px;">{{ __('app.cancel') }}</a>
            <button type="submit" class="btn fw-medium px-5 text-white" style="background-color: #1b2559; border: none; font-size: 13px; border-radius: 4px;">
                <i class="fa-solid fa-floppy-disk me-1"></i> {{ __('app.save') }}
            </button>
        </div>
    </form>
</div>

<script>
    function handleFileSelect(input, previewId, nameId) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById(previewId);
                var container = document.getElementById(previewId + 'Container');
                var placeholder = document.getElementById(previewId.replace('Preview', 'Placeholder'));
                var fileName = document.getElementById(nameId);

                if (preview) preview.src = e.target.result;
                if (container) container.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
                if (fileName) fileName.textContent = 'Selected: ' + file.name;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
