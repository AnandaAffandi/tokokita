let video = document.getElementById("preview");

navigator.mediaDevices.getUserMedia({
    video:{facingMode:"environment"}
}).then(stream=>{
    video.srcObject = stream;
    video.setAttribute("playsinline", true);
    video.play();
    requestAnimationFrame(scanQR);
});

function scanQR(){

if(video.readyState === video.HAVE_ENOUGH_DATA){

let canvas=document.createElement("canvas");
canvas.width=video.videoWidth;
canvas.height=video.videoHeight;

let ctx=canvas.getContext("2d");
ctx.drawImage(video,0,0,canvas.width,canvas.height);

let imageData=ctx.getImageData(0,0,canvas.width,canvas.height);

let code=jsQR(
imageData.data,
imageData.width,
imageData.height,
{inversionAttempts:"dontInvert"}
);

if(code){

document.getElementById("hasil").value = code.data;

alert("QR BERHASIL TERDETEKSI!");

return; // STOP SCAN
}
}

requestAnimationFrame(scanQR);
}
