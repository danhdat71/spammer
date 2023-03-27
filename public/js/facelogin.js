const size = {
    width: 200,
    height: 200
};

var videoStream = document.getElementById('video');

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
]).then(openCamera).then(mainProcess);

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
    console.log('working...');
    let loadAllFaces = await loadAllPerson();
    let faceMatcher = new faceapi.FaceMatcher(loadAllFaces, 0.6);

    let interval = setInterval(async function(){
        const detections = await faceapi.detectAllFaces(videoStream).withFaceLandmarks().withFaceDescriptors();
        const resizedDetections = faceapi.resizeResults(detections, size);
        const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));
        results.forEach((result, i) => {
            let currentPersonName = result.toString().replace(/[0-9]/g, '').replace('(.)', '').trim();
            if (currentPersonName != "unknown" && lastPersonName != currentPersonName) {
                console.log(`Call api đăng nhập cho ${currentPersonName}`);
            }
            console.log(currentPersonName);
            if (currentPersonName != "unknown") {
                lastPersonName = currentPersonName;
            }
        });
    }, 1000);
}

function loadAllPerson() 
{
    const labels = ['thuybinh'];
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

function getUserModels()
{
    let basePath = `img/profile/`;
    let url = 'get-user-paths';

    ajax(url, 'get', null, null, function(results) {
        console.log(results);
    });
}

// function captureImageIfDetected()
// {
//   let canvas = document.querySelector("#canvas");
//   canvas.getContext('2d').drawImage(videoStream, 0, 0, size.width, size.height);
//   let image_data_url = canvas.toDataURL('image/jpeg');

//   // data url of the image
//   console.log(image_data_url);
// }
