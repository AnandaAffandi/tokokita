let video = document.getElementById("preview");

navigator.mediaDevices.getUserMedia({
    video: { facingMode:"environment" }
}).then(stream=>{
    video.srcObject = stream;
    video.play();
});

function scanQR(){
    let canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    let ctx = canvas.getContext("2d");
    ctx.drawImage(video,0,0,canvas.width,canvas.height);

    let imageData = ctx.getImageData(0,0,canvas.width,canvas.height);
    let code = jsQR(imageData.data,imageData.width,imageData.height);

    if(code){
        document.getElementById("hasil").value = code.data;
        alert("QR ditemukan : "+code.data);
    }
}
