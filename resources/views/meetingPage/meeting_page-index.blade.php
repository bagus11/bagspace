<html>
<head>
    <title>Pralon - Meeting Room</title>
    <link rel="icon" href="{{asset('60.png')}}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
</head>
<style>
    /* Custom styles */
    body{
        font-family: Poppins;
        background-color: #31363F !important;
    }
    .video-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .video-box {
        margin: 10px;
        position: relative;
    }
    .video-name {
        position: absolute;
        bottom: 0;
        left: 0;
        background-color:black;
        color: white;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
        padding: 5px;
        font-size: 12px;
    }
    .video-box video {
        width: 100%;
        transform: scaleX(-1) !important; /* Mirror horizontally */
        object-fit: cover;
        border-radius: 15px;
        border-color: #76ABAE !important;
        /* border: 2px solid blue; */
    }
    #localVideo {
        width: 100 !important;
        max-width: 640px;
        max-height: auto; /* Mirror horizontally */
        border-color: #76ABAE !important;
       
    }
    .sub_div {
            position: absolute;
            bottom: 0px;
        }
    .talking { /* CSS class for border color when talking */
        border: 4px solid #76ABAE !important; /* Change border color to green */
    }
    .image-cropper {
        width: 50px;
        height: 50px;
        position: relative;
        overflow: hidden;
        border-radius: 50%;
    }

    img {
        display: inline;
        margin: 0 auto;
        height: 100%;
        width: auto;
    }
    .video-box video.user-video {
   
    }
    #screen{
        transform: scaleX(1) !important;
    }
    .video-box video.screen-video {
        /* Add any specific styles for screen sharing videos here */
        transform: scaleX(-1) !important;
        /* max-height: 500px !important; */
    }
    .footerChat {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #191919;
        padding-top: 5px;
        /* border-top-right-radius: 25px; */
        /* border-bottom-right-radius: 25px; */
        z-index: 999; /* Ensure it's above other elements */
    }
    .user-video-container {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1; /* Ensure user video is above screen sharing video */
        width: 200px; /* Adjust the size as needed */
        height: auto;
    }

    .screen-video-container {
        position: absolute;
        top: 10px;
        left: 10px;
        width: calc(100% - 220px); /* Adjust the width to leave space for user video */
        height: auto;
    }

    .screen-video-container video {
        width: 100%;
        height: auto;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="font-size: 14px;font-weight:bold;color:#EEEE">Pralon - Meeting Room</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Button on the right side -->
            <div class="d-flex">
                <button class="btn  btn-danger">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>
        </div>
    </nav>
    <ul id="active-users-list"></ul>
    <div class="video-container" id="videoContainer">
        <div class="user-video-container">
            <video id="localVideo" class="user-video" autoplay muted></video>
        </div>
        <div class="screen-video-container">
            <!-- Screen sharing video will be added here -->
        </div>
    </div>
    <div class="sub_div">
        <div class="footerChat">
            <div class="d-flex  align-items-center mx-2">
                <div class="image-cropper">
                    <img src="{{ asset('storage/users-avatar/' . auth()->user()->avatar) }}" class="rounded" />
                </div>
                <span style="color:#EEEEEE; font-size:12px;font-weight:bold" class="mx-2 mr-4">{{auth()->user()->name}}</span>
                <div class="">
                    <button id="startButton" class="btn my-2 btn-primary" title="Turn on camera">
                        <i class="fa-solid fa-video"></i>
                    </button>
                    <button id="stopButton" class="btn my-2 btn-danger" title="Turn off camera">
                        <i class="fa-solid fa-video-slash"></i>
                    </button>
                    <button class="btn btn-dark" title="Share screen" id="btnShareScreen">
                        <i class="fa-solid fa-display"></i>
                    </button>
                    <button class="btn btn-danger" title="Share screen" id="btnStopShareScreen">
                        <i class="fa-solid fa-display"></i>
                    </button>
                    <button id="muteButton" class="btn my-2 btn-secondary" title="Mute">
                        <i class="fa-solid fa-microphone"></i>
                    </button>
                    <button id="unmuteButton" class="btn my-2 btn-secondary" title="Unmute">
                        <i class="fa-solid fa-microphone-slash"></i>
                    </button>
                    <button id="participantButton" class="btn my-2 btn-dark" title="Participant">
                        <i class="fa-solid fa-users-rectangle"></i>
                    </button>
                </div>
            </div>
        </div>
</div>

</body>

<script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
<script src="{{asset('assets/js/argon.js?v=1.2.0')}}"></script>
@include('meetingPage.meeting_page-js')
</html>