let video = document.getElementById("preview");
let scanning = true;

// Inisialisasi kamera dengan resolusi yang lebih baik
navigator.mediaDevices.getUserMedia({
    video: {
        facingMode: "environment",
        width: { ideal: 1280 },
        height: { ideal: 720 }
    }
}).then(stream => {
    video.srcObject = stream;
    video.play();
    
    // Tambahkan loading indicator
    const loadingIndicator = document.createElement('div');
    loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memulai kamera...';
    loadingIndicator.style.cssText = 'position: absolute; top: 20px; left: 20px; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 8px;';
    video.parentElement.appendChild(loadingIndicator);
    
    setTimeout(() => {
        loadingIndicator.remove();
    }, 2000);
    
    requestAnimationFrame(scan);
}).catch(err => {
    console.error("Error accessing camera:", err);
    alert("Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.");
});

function scan() {
    if (!scanning) return;
    
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
        let canvas = document.createElement("canvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        let ctx = canvas.getContext("2d");
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        
        // Tambahkan efek deteksi visual
        ctx.strokeStyle = "#3b82f6";
        ctx.lineWidth = 4;
        
        try {
            let code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });
            
            if (code) {
                // Tampilkan kotak deteksi
                drawLine(ctx, code.location.topLeftCorner, code.location.topRightCorner);
                drawLine(ctx, code.location.topRightCorner, code.location.bottomRightCorner);
                drawLine(ctx, code.location.bottomRightCorner, code.location.bottomLeftCorner);
                drawLine(ctx, code.location.bottomLeftCorner, code.location.topLeftCorner);
                
                // Proses hasil QR
                let hasil = code.data.split("|");
                if (hasil.length >= 2) {
                    document.getElementById("barang").value = hasil[0];
                    
                    // Tampilkan feedback sukses
                    showSuccessFeedback();
                    
                    // Pause scanning sementara
                    scanning = false;
                    setTimeout(() => {
                        scanning = true;
                        requestAnimationFrame(scan);
                    }, 2000);
                    
                    return;
                }
            }
            
            // Gambar pemandu scan
            drawScanGuide(ctx, canvas.width, canvas.height);
            
        } catch (error) {
            console.error("QR scan error:", error);
        }
    }
    
    if (scanning) {
        requestAnimationFrame(scan);
    }
}

function drawLine(ctx, start, end) {
    ctx.beginPath();
    ctx.moveTo(start.x, start.y);
    ctx.lineTo(end.x, end.y);
    ctx.stroke();
}

function drawScanGuide(ctx, width, height) {
    const centerX = width / 2;
    const centerY = height / 2;
    const size = Math.min(width, height) * 0.4;
    
    // Gambar kotak pemandu
    ctx.strokeStyle = "rgba(59, 130, 246, 0.6)";
    ctx.lineWidth = 3;
    ctx.setLineDash([10, 5]);
    
    ctx.strokeRect(centerX - size/2, centerY - size/2, size, size);
    
    // Gambar corner
    ctx.setLineDash([]);
    const cornerLength = 20;
    
    // Top-left corner
    ctx.beginPath();
    ctx.moveTo(centerX - size/2, centerY - size/2 + cornerLength);
    ctx.lineTo(centerX - size/2, centerY - size/2);
    ctx.lineTo(centerX - size/2 + cornerLength, centerY - size/2);
    ctx.stroke();
    
    // Top-right corner
    ctx.beginPath();
    ctx.moveTo(centerX + size/2 - cornerLength, centerY - size/2);
    ctx.lineTo(centerX + size/2, centerY - size/2);
    ctx.lineTo(centerX + size/2, centerY - size/2 + cornerLength);
    ctx.stroke();
    
    // Bottom-right corner
    ctx.beginPath();
    ctx.moveTo(centerX + size/2, centerY + size/2 - cornerLength);
    ctx.lineTo(centerX + size/2, centerY + size/2);
    ctx.lineTo(centerX + size/2 - cornerLength, centerY + size/2);
    ctx.stroke();
    
    // Bottom-left corner
    ctx.beginPath();
    ctx.moveTo(centerX - size/2 + cornerLength, centerY + size/2);
    ctx.lineTo(centerX - size/2, centerY + size/2);
    ctx.lineTo(centerX - size/2, centerY + size/2 - cornerLength);
    ctx.stroke();
}

function showSuccessFeedback() {
    // Tambahkan efek visual dan suara
    const feedback = document.createElement('div');
    feedback.innerHTML = '<i class="fas fa-check-circle"></i> QR Code Terdeteksi!';
    feedback.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px 40px; border-radius: 15px; font-size: 18px; font-weight: bold; z-index: 1000; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.5); animation: popIn 0.5s ease;';
    
    document.body.appendChild(feedback);
    
    // Tambahkan efek suara (opsional)
    try {
        const audio = new Audio('data:audio/wav;base64,UklGRigAAABXQVZFZm10IBIAAAABAAEARKwAAIhYAQACABAAZGF0YQQ='); // Placeholder
        audio.play();
    } catch (e) {}
    
    setTimeout(() => {
        feedback.style.animation = 'fadeOut 0.5s ease';
        setTimeout(() => feedback.remove(), 500);
    }, 1500);
}

// Tambahkan style untuk animasi
const style = document.createElement('style');
style.textContent = `
    @keyframes popIn {
        0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0; }
        70% { transform: translate(-50%, -50%) scale(1.1); }
        100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }
    
    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }
`;
document.head.appendChild(style);

// Tombol untuk pause/resume scan
const controls = document.createElement('div');
controls.innerHTML = `
    <button id="pauseScan" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.8); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
        <i class="fas fa-pause"></i> Pause Scan
    </button>
`;
video.parentElement.appendChild(controls);

document.getElementById('pauseScan').addEventListener('click', function() {
    scanning = !scanning;
    this.innerHTML = scanning ? 
        '<i class="fas fa-pause"></i> Pause Scan' : 
        '<i class="fas fa-play"></i> Resume Scan';
});