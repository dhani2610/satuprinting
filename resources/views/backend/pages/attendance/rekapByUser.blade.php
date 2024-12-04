@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important
        }

        label {
            float: left;
        }

        h1 {
            margin: 20px 10%;
            font-size: 60px;
            letter-spacing: 10px;
        }

        .jam-digital {
            width: 70%;
            margin: 1% 30%;
        }

        #jam span {
            float: left;
            text-align: center;
            font-size: 70px;
            margin: 0 2.5%;
            padding: 20px;
            width: 15%;
            border-radius: 10px;
            box-sizing: border-box;
        }

        #jam span:nth-child(1) {
            background: #00aef0;
        }

        #jam span:nth-child(2) {
            background: #00aef0;
        }

        #jam span:nth-child(3) {
            background: #00aef0;
        }

        #jam::after {
            content: "";
            display: block;
            clear: both;
        }

        #unit span {
            float: left;
            width: 20%;
            margin-top: 30px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 18px;
            text-shadow: white
        }

        span.turn {
            animation: turn 0.7s ease;
        }

        @keyframes turn {
            0% {
                transform: rotateX(0deg)
            }

            100% {
                transform: rotateX(360deg)
            }
        }

        @media screen and (max-width: 980px) {
            #jam span {
                float: left;
                text-align: center;
                font-size: 50px;
                margin: 0 1.5%;
                padding: 20px;
                width: 20%;
            }

            h1 {
                margin: 20px 5%;
            }

            .jam-digital {
                width: 100%;
                margin: 10% 20%;
            }

            #unit span {
                width: 23%;
            }
        }

        .panel {
            padding-bottom: 10px;
        }

        #cam {
            border: 1px;
            border-color: black;
            border-style: solid;
        }

        #photo {
            border: 1px;
            border-color: black;
            border-style: dashed;
        }
    </style>

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Rekap Attendance</h4>
                        <div class="clearfix"></div>
                        <div class="card-datatable table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="datatables-simply table border-top">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>User</th>
                                        <th>Divisi</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Date Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendance as $attend)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center user-name">
                                                    <div class="avatar-wrapper">
                                                        @php
                                                            $user = \App\Models\Admin::where('id',$attend->id_user)->first();
                                                            $words = explode(' ', $user->name);
                                                            $initials = '';
                                                            foreach ($words as $word) {
                                                                $initials .= strtoupper($word[0]);
                                                            }
                                                            // return $initials;
                                                        @endphp
                                                        <div class="avatar avatar-sm me-3">
                                                            @if ($attend->foto == null)
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-primary">{{ $initials }}</span>
                                                            @else
                                                                <img src="{{ asset('assets/img/team/' . $user->foto) }}"
                                                                    alt="Avatar" class="rounded-circle">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"><a href="#"
                                                            class="text-body text-truncate"><span
                                                                class="fw-medium">{{ $user->name }}</span></a><small
                                                            class="text-muted">{{ $user->email }}</small></div>
                                                </div>
                                            </td>
                                            @php
                                                if ($attend->id_divisi != null) {
                                                    $divisiV = \App\Models\Divisi::where(
                                                        'id',
                                                        $user->id_divisi,
                                                    )->first();
                                                }
                                            @endphp
                                            <td>
                                                <span class="text-truncate d-flex align-items-center"><span
                                                        class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i
                                                            class="bx bx-cog bx-xs"></i></span>{{ !empty($attend->id_divisi) ? $divisiV->divisi : '-' }}</span>
                                            </td>
                                            <td>
                                                @if ($attend->type == 1)
                                                    <span class="badge bg-label-success">In</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Out</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($attend->date)->locale('id')->translatedFormat('l, j F Y') }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($attend->datetime)->locale('id')->translatedFormat('l, j F Y H:i:s') }}
                                            </td>
                                            <td>

                                                <a href=""
                                                    data-bs-toggle="tooltip" class="text-body" data-bs-placement="top"
                                                    aria-label="Rekap Attendance"
                                                    data-bs-original-title="Rekap Attendance"><i
                                                        class="bx bx-show mx-1"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>



            <!-- data table end -->

        </div>
    </div>
@endsection


@section('script')
    <script>
        /*
        Please try with devices with camera!
        */

        /*
        Reference: 
        https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
        https://developers.google.com/web/updates/2015/07/mediastream-deprecations?hl=en#stop-ended-and-active
        https://developer.mozilla.org/en-US/docs/Web/API/WebRTC_API/Taking_still_photos
        */

        // reference to the current media stream
        var mediaStream = null;

        // Prefer camera resolution nearest to 1280x720.
        var constraints = {
            audio: false,
            video: {
                width: {
                    ideal: 640
                },
                height: {
                    ideal: 480
                },
                facingMode: "environment"
            }
        };

        async function getMediaStream(constraints) {
            try {
                mediaStream = await navigator.mediaDevices.getUserMedia(constraints);
                let video = document.getElementById('cam');
                video.srcObject = mediaStream;
                video.onloadedmetadata = (event) => {
                    video.play();
                };
            } catch (err) {
                console.error(err.message);
            }
        };

        async function switchCamera(cameraMode) {
            try {
                // stop the current video stream
                if (mediaStream != null && mediaStream.active) {
                    var tracks = mediaStream.getVideoTracks();
                    tracks.forEach(track => {
                        track.stop();
                    })
                }

                // set the video source to null
                document.getElementById('cam').srcObject = null;

                // change "facingMode"
                constraints.video.facingMode = cameraMode;

                // get new media stream
                await getMediaStream(constraints);
            } catch (err) {
                console.error(err.message);
                alert(err.message);
            }
        }

        function takePicture() {
            let canvas = document.getElementById('canvas');
            let video = document.getElementById('cam');
            let photo = document.getElementById('photo');
            let context = canvas.getContext('2d');

            const height = video.videoHeight;
            const width = video.videoWidth;

            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
                document.getElementById('base64data').value = data;
            } else {
                clearphoto();
            }
        }

        function clearPhoto() {
            let canvas = document.getElementById('canvas');
            let photo = document.getElementById('photo');
            let context = canvas.getContext('2d');

            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        document.getElementById('switchFrontBtn').onclick = (event) => {
            switchCamera("user");
        }

        document.getElementById('switchBackBtn').onclick = (event) => {
            switchCamera("environment");
        }

        document.getElementById('snapBtn').onclick = (event) => {
            takePicture();
            event.preventDefault();
        }

        clearPhoto();

        function animation(span) {
            span.className = "turn";
            setTimeout(function() {
                span.className = ""
            }, 700);
        }

        function jam() {
            setInterval(function() {

                var waktu = new Date();
                var jam = document.getElementById('jam');
                var hours = waktu.getHours();
                var minutes = waktu.getMinutes();
                var seconds = waktu.getSeconds();

                if (waktu.getHours() < 10) {
                    hours = '0' + waktu.getHours();
                }
                if (waktu.getMinutes() < 10) {
                    minutes = '0' + waktu.getMinutes();
                }
                if (waktu.getSeconds() < 10) {
                    seconds = '0' + waktu.getSeconds();
                }
                jam.innerHTML = '<span class="text-white" style="color:white">' + hours + '</span>' +
                    '<span class="text-white" style="color:white">' + minutes + '</span>' +
                    '<span class="text-white" style="color:white">' + seconds + '</span>';

                var spans = jam.getElementsByTagName('span');
                animation(spans[2]);
                if (seconds == 0) animation(spans[1]);
                if (minutes == 0 && seconds == 0) animation(spans[0]);

            }, 1000);
        }

        jam();
    </script>
@endsection
