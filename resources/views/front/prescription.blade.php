@extends('front.layout')
@section('title')
Prescription
@stop
@section('meta-data')
<meta property="og:type" content="website" />
<meta property="og:url" content="{{route('user-login')}}" />
<meta property="og:title" content="{{__('message.site_name')}}" />
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}" />
<meta property="og:image:width" content="250px" />
<meta property="og:image:height" content="250px" />
<meta property="og:site_name" content="{{__('message.site_name')}}" />
<meta property="og:description" content="{{__('message.meta_description')}}" />
<meta property="og:keyword" content="{{__('message.meta_keyword')}}" />
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')

<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__("message.Home")}}</a>
                <i data-lucide="chevron-right"></i>
                <span>Upload Prescription</span>
            </nav>
            <h1 class="hd-dash-title">Upload Your Prescription</h1>
            <p class="hd-rx-hero-sub">Share your doctor's prescription with us and our healthcare team will help you book the right tests — quick, secure and hassle-free.</p>
        </div>

        @if(Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        @endif

        <form action="{{route('save_prescription')}}" method="post" enctype="multipart/form-data" id="hdRxForm">
            {{csrf_field()}}

            <!-- Upload zone -->
            <div class="hd-dash-card hd-rx-upload-card">
                <h3 class="hd-dash-card-title"><i data-lucide="file-up"></i>Prescription File</h3>

                <div class="hd-rx-upload-grid">
                    <div>
                        <label for="hdRxFileInput" class="hd-rx-dropzone" id="hdRxDropzone">
                            <input type="file" name="prescription" id="hdRxFileInput" accept=".jpeg,.jpg,.png,.pdf" required="">
                            <span class="hd-rx-dropzone-icon"><i data-lucide="upload-cloud"></i></span>
                            <span class="hd-rx-dropzone-title">Drag &amp; drop your prescription here</span>
                            <span class="hd-rx-dropzone-sub">or <span class="hd-rx-dropzone-browse">click to browse</span> from your device</span>
                        </label>

                        <!-- Selected file preview -->
                        <div class="hd-rx-preview" id="hdRxPreview" hidden>
                            <span class="hd-rx-preview-icon" id="hdRxPreviewIcon"><i data-lucide="file-text"></i></span>
                            <span class="hd-rx-preview-info">
                                <strong id="hdRxPreviewName"></strong>
                                <span id="hdRxPreviewSize"></span>
                            </span>
                            <button type="button" class="hd-rx-preview-remove" id="hdRxPreviewRemove" aria-label="Remove selected file">
                                <i data-lucide="x"></i>
                            </button>
                        </div>

                        <div class="hd-rx-info-box">
                            <i data-lucide="info"></i>
                            <span>Accepted formats: <strong>JPG, PNG, PDF</strong>. Please make sure the prescription is clear and fully readable.</span>
                        </div>
                    </div>

                    <!-- Illustration -->
                    <div class="hd-rx-illustration" aria-hidden="true">
                        <span class="hd-rx-illu-float hd-rx-illu-float-1"><i data-lucide="image"></i></span>
                        <span class="hd-rx-illu-float hd-rx-illu-float-2"><i data-lucide="file-check-2"></i></span>
                        <span class="hd-rx-illu-float hd-rx-illu-float-3"><i data-lucide="shield-check"></i></span>
                        <div class="hd-rx-illu-core">
                            <i data-lucide="clipboard-plus"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patient details -->
            <div class="hd-dash-card hd-rx-details-card">
                <h3 class="hd-dash-card-title"><i data-lucide="user-round"></i>Patient Details</h3>

                <div class="hd-auth-grid">
                    <div class="hd-field">
                        <label for="hdRxName">{{__('message.Name')}}</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="user-round"></i>
                            <input type="text" name="name" id="hdRxName" required="">
                        </div>
                    </div>

                    <div class="hd-field">
                        <label for="hdRxEmail">{{__('message.email')}}</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="mail"></i>
                            <input type="email" name="email" id="hdRxEmail">
                        </div>
                    </div>

                    <div class="hd-field">
                        <label for="hdRxNumber">Number</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="phone"></i>
                            <input type="text" name="number" id="hdRxNumber" required>
                        </div>
                    </div>

                    <div class="hd-field">
                        <label for="cityid">Location</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="map-pin"></i>
                            <select id="cityid" name="location_id" required class="form-control">
                                <option value="">Select Location</option>
                                @foreach($city as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="hd-field">
                        <label for="hdRxGender">Gender</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="users-round"></i>
                            <select name="gender" id="hdRxGender" required class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="hd-field">
                        <label for="hdRxDob">Date Of Birth</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="cake"></i>
                            <input type="date" name="d_o_b" id="hdRxDob" max="{{ date('Y-m-d') }}" required="">
                        </div>
                    </div>

                    <div class="hd-field hd-field-full">
                        <label class="custom-control material-checkbox">
                            <input type="checkbox" value="1" name="is_agree" class="material-control-input" required="">
                            <span class="material-control-indicator"></span>
                            <span class="description">I agree to the Terms of Use and Privacy Policy</span>
                        </label>
                    </div>
                </div>

                <div class="hd-rx-submit-row">
                    <button type="submit" class="hd-contact-submit" id="hdRxSubmitBtn">
                        <span class="hd-contact-submit-text">Upload Prescription</span>
                        <i data-lucide="upload" class="hd-contact-submit-icon"></i>
                        <span class="hd-contact-submit-spinner" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Trust section -->
        <div class="hd-rx-trust">
            <div class="hd-rx-trust-item">
                <span class="hd-rx-trust-icon"><i data-lucide="lock"></i></span>
                <span>Secure Upload</span>
            </div>
            <div class="hd-rx-trust-item">
                <span class="hd-rx-trust-icon"><i data-lucide="badge-check"></i></span>
                <span>NABL Partner Labs</span>
            </div>
            <div class="hd-rx-trust-item">
                <span class="hd-rx-trust-icon"><i data-lucide="shield-check"></i></span>
                <span>100% Privacy Protected</span>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var input = document.getElementById('hdRxFileInput');
    var dropzone = document.getElementById('hdRxDropzone');
    var preview = document.getElementById('hdRxPreview');
    var previewName = document.getElementById('hdRxPreviewName');
    var previewSize = document.getElementById('hdRxPreviewSize');
    var previewIcon = document.getElementById('hdRxPreviewIcon');
    var removeBtn = document.getElementById('hdRxPreviewRemove');
    if (!input || !dropzone) { return; }

    function humanSize(bytes) {
        if (bytes < 1024) { return bytes + ' B'; }
        if (bytes < 1024 * 1024) { return (bytes / 1024).toFixed(1) + ' KB'; }
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    function showPreview(file) {
        if (!file) { return; }
        previewName.textContent = file.name;
        previewSize.textContent = humanSize(file.size);
        var isPdf = /\.pdf$/i.test(file.name);
        previewIcon.innerHTML = '<i data-lucide="' + (isPdf ? 'file-text' : 'image') + '"></i>';
        preview.hidden = false;
        dropzone.classList.add('has-file');
        if (window.lucide) { lucide.createIcons(); }
    }

    input.addEventListener('change', function () {
        if (input.files && input.files[0]) {
            showPreview(input.files[0]);
        }
    });

    if (removeBtn) {
        removeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            input.value = '';
            preview.hidden = true;
            dropzone.classList.remove('has-file');
        });
    }

    ['dragenter', 'dragover'].forEach(function (evt) {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('is-dragover');
        });
    });
    ['dragleave', 'drop'].forEach(function (evt) {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('is-dragover');
        });
    });
    dropzone.addEventListener('drop', function (e) {
        var files = e.dataTransfer && e.dataTransfer.files;
        if (!files || !files.length) { return; }
        // The backend accepts a single prescription file, so only the
        // first dropped file is used even if several are dropped.
        if (typeof DataTransfer !== 'undefined') {
            var dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
        } else {
            input.files = files;
        }
        showPreview(input.files[0]);
    });

    var form = document.getElementById('hdRxForm');
    var submitBtn = document.getElementById('hdRxSubmitBtn');
    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.classList.add('is-loading');
            submitBtn.disabled = true;
        });
    }
})();
</script>

@stop
@section('footer')
<script>
    function getlab(city) {
        var cityId = city;
        var optionsHTML = ' <select id="" name="lab_id" required="" >'; // Initialize optionsHTML to an empty string
        // Perform the AJAX request
        $.ajax({
            url: '/get-users-by-city/' + cityId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate the dropdown with the fetched data
                var select = $('.labid');
                select.empty(); // Clear existing options

                if (Array.isArray(data)) {
                    // Generate HTML for options based on the received data
                    $.each(data, function (index, user) {
                        optionsHTML += '  <option value="' + user.id + '">' + user.name + '</option>';
                    });
                    optionsHTML += ' </select>  ';
                    select.html(optionsHTML);
                } else {
                    console.log('Error: Data is not an array.');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    $('#cityid').change(function () {
        var selectedCity = $(this).val();
        getlab(selectedCity);
    });

</script>

@stop
