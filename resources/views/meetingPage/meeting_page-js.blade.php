<script>
    async function startWebcam() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        createVideoElement('localVideo', stream, false, 'Your Video');
        window.localStream = stream;
        $('#startButton').prop('hidden', true);
        $('#stopButton').prop('hidden', false);
        registerUser(); // Daftarkan user ke meeting setelah nyalain webcam
    } catch (error) {
        console.error('Error accessing webcam:', error);
    }
}

async function stopWebcam() {
    if (window.localStream) {
        window.localStream.getTracks().forEach(track => track.stop());
        $('#localVideo').remove();
        $('#startButton').prop('hidden', false);
        $('#stopButton').prop('hidden', true);
    }
}

async function shareScreen() {
    try {
        const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
        createVideoElement('screenShare', screenStream, true, 'Screen Share');

        screenStream.getTracks()[0].addEventListener('ended', () => {
            stopScreenShare();
        });

        $('#btnStopShareScreen').prop('hidden', false);
        $('#btnShareScreen').prop('hidden', true);
    } catch (error) {
        console.error('Error sharing screen:', error);
    }
}

function stopScreenShare() {
    const screenVideo = $('#screenShare')[0];
    if (screenVideo && screenVideo.srcObject) {
        screenVideo.srcObject.getTracks().forEach(track => track.stop());
    }
    $('#screenShare').remove();
    $('#btnStopShareScreen').prop('hidden', true);
    $('#btnShareScreen').prop('hidden', false);
    startWebcam(); // Kembali ke webcam setelah screen share dihentikan
}

function createVideoElement(id, stream, isMuted, label) {
    if ($(`#${id}`).length) return; // Hindari duplikasi
    
    const videoContainer = document.getElementById('videoContainer');
    const videoWrapper = document.createElement('div');
    videoWrapper.classList.add('video-box');
    
    const video = document.createElement('video');
    video.id = id;
    video.srcObject = stream;
    video.autoplay = true;
    video.muted = isMuted;
    video.classList.add(id === 'screenShare' ? 'screen-video' : 'user-video');
    
    const labelElement = document.createElement('span');
    labelElement.innerText = label;
    labelElement.classList.add('video-name');
    
    videoWrapper.appendChild(video);
    videoWrapper.appendChild(labelElement);
    videoContainer.appendChild(videoWrapper);
}

function fetchActiveUsers() {
    $.ajax({
        url: "{{ route('getActiveUsers') }}",
        method: "GET",
        data: { meeting_id: "{{ $meeting->meeting_id }}" },
        success: function(response) {
            let userList = $("#active-users-list");
            userList.empty();
            
            if (!response || response.length === 0) {
                userList.append("<li>Tidak ada pengguna aktif</li>");
                return;
            }

            response.forEach(user => {
                userList.append(`<li>${user.user.name}</li>`);
            });
        },
        error: function(xhr) {
            console.error("Gagal mengambil pengguna aktif:", xhr.responseText);
            alert("Terjadi kesalahan, coba lagi nanti!");
        }
    });
}

function registerUser() {
    let userName = prompt("Masukkan nama Anda untuk bergabung:");
    if (!userName) return;

    $.ajax({
        url: "{{ route('joinMeeting') }}",
        method: "POST",
        data: {
            meeting_id: "{{ $meeting->meeting_id }}",
            user_name: userName,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            alert("Berhasil bergabung sebagai " + userName);
            fetchActiveUsers(); // Refresh daftar user aktif
        },
        error: function(xhr) {
            console.error("Gagal bergabung:", xhr.responseText);
            alert("Gagal bergabung, coba lagi!");
        }
    });
}

</script>