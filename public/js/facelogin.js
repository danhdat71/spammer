const size = {
    width: 200,
    height: 200
};

var videoStream = document.getElementById('video');
let labels = [];

let promiseFaceApi = Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
]).then(getUserModels);

$('#submit-login-face').click(function(){
    promiseFaceApi.then(openCamera).then(mainProcess);
});


function openCamera()
{
    navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false
    }).then(function(stream){
        videoStream.srcObject = stream;
    });
}

let lastPersonName = '';
async function mainProcess()
{
    console.log('face api initialled !!!');
    let loadAllFaces = await loadAllPerson();
    let faceMatcher = new faceapi.FaceMatcher(loadAllFaces, 0.6);

    setInterval(async function(){
        const detections = await faceapi.detectAllFaces(videoStream).withFaceLandmarks().withFaceDescriptors();
        const resizedDetections = faceapi.resizeResults(detections, size);
        const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));
        results.forEach(async (result, i) => {
            let currentPersonName = result.toString().replace(/[0-9]/g, '').replace('(.)', '').trim();
            if (currentPersonName != "unknown" && lastPersonName != currentPersonName) {
                console.log(`Call api đăng nhập cho ${currentPersonName}`);
                $('#username').val(currentPersonName);

                let formData = new FormData();
                formData.append('username', currentPersonName);

                let res = await fetch('face-login', {
                    method: 'post',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                    },
                });
                res = await res.json();
                
                if (res.status) {
                    location.href = 'dashboard';
                } else {
                    sAlert(false, res.message);
                }
            }
            if (currentPersonName != "unknown") {
                lastPersonName = currentPersonName;
            }
        });
    }, 1000);
}

async function getUserModels()
{
    let url = 'get-user-paths';
    let res = await fetch(url);
    let data = await res.json();
    data = await data.data;

    labels = data.map(function(val, i){
        return val.username;
    });
    console.log(labels);
}

async function loadAllPerson() 
{
    return Promise.all(
        labels.map(async label => {
            const descriptions = []
            for (let i = 1; i <= 1; i++) {
                const img = await faceapi.fetchImage(`http://localhost/img/profile/${label}/${i}.jpg`);
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                descriptions.push(detections.descriptor);
            }
            return new faceapi.LabeledFaceDescriptors(label, descriptions);
        })
    );
}

// function captureImageIfDetected()
// {
//   let canvas = document.querySelector("#canvas");
//   canvas.getContext('2d').drawImage(videoStream, 0, 0, size.width, size.height);
//   let image_data_url = canvas.toDataURL('image/jpeg');

//   // data url of the image
//   console.log(image_data_url);
// }
