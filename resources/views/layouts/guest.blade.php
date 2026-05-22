<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Inventaris') }} — BAN-PDM Papua Barat</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        /* ── Background halaman ── */
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            background: #0a1628;
            position: relative;
            overflow: hidden;
        }

        /* Blob dekoratif di background */
        body::before {
            content: '';
            position: fixed;
            top: -200px; left: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(26,122,74,0.18) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -180px; right: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,197,24,0.12) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }
        .blob-mid {
            position: fixed;
            top: 40%; left: 55%;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(30,58,95,0.35) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ── Card utama (boxed, centered) ── */
        .auth-card {
            position: relative;
            z-index: 10;
            display: flex;
            width: 100%;
            max-width: 860px;
            min-height: 480px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 32px 80px rgba(0,0,0,0.5),
                0 0 0 1px rgba(255,255,255,0.06);
        }

        /* ══════════════════════════════
           PANEL KIRI
        ══════════════════════════════ */
        .left-panel {
            width: 42%;
            flex-shrink: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 36px 28px;
            text-align: center;
            overflow: hidden;
            background: linear-gradient(160deg, #0f2744 0%, #1e3a5f 40%, #145c37 80%, #0d3d24 100%);
        }

        /* Glow lingkaran di panel kiri */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(245,197,24,0.18) 0%, transparent 70%);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(26,122,74,0.22) 0%, transparent 70%);
            border-radius: 50%;
        }

        .left-content { position: relative; z-index: 2; }

        /* Logo bulat glassmorphism */
        .logo-wrap {
            width: 76px; height: 76px;
            margin: 0 auto 16px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25), 0 0 0 4px rgba(245,197,24,0.1);
            transition: transform 0.3s ease;
        }
        .logo-wrap:hover { transform: scale(1.04); }
        .logo-wrap img { width: 52px; height: 52px; object-fit: contain; }

        .left-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 6px;
        }
        .left-title span { color: #f5c518; }

        .left-sub {
            font-size: 10.5px;
            font-weight: 400;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .left-location {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            font-weight: 600;
            color: #f5c518;
            background: rgba(245,197,24,0.1);
            border: 1px solid rgba(245,197,24,0.25);
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 14px;
        }
        .left-location svg { width: 10px; height: 10px; fill: #f5c518; }

        /* Garis divider */
        .left-divider {
            width: 40px; height: 2px;
            background: linear-gradient(90deg, #f5c518, #1a7a4a);
            border-radius: 2px;
            margin: 0 auto 12px;
        }

        .left-desc {
            font-size: 10.5px;
            color: rgba(255,255,255,0.5);
            line-height: 1.75;
        }

        /* Badge kecil */
        .left-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: center;
            margin-top: 16px;
        }
        .left-badge {
            font-size: 9.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.65);
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* ══════════════════════════════
           PANEL KANAN
        ══════════════════════════════ */
        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 36px 32px;
            background: #0f1e35;
            border-left: 1px solid rgba(255,255,255,0.06);
        }

        /* Logo mini + nama di atas form */
        .form-header {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 20px;
        }
        .form-header img {
            width: 30px; height: 30px;
            object-fit: contain;
        }
        .form-header-text .name {
            font-size: 12px; font-weight: 700; color: #fff; line-height: 1.2;
        }
        .form-header-text .sub {
            font-size: 9.5px; color: #f5c518; font-weight: 500;
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 3px;
        }
        .form-subtitle {
            font-size: 11.5px;
            color: rgba(255,255,255,0.45);
            margin-bottom: 22px;
        }

        /* Label */
        .f-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        /* Input group */
        .f-group { margin-bottom: 14px; }

        .f-input-wrap {
            position: relative;
        }
        .f-icon {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            width: 15px; height: 15px;
            fill: rgba(255,255,255,0.3);
            pointer-events: none;
            transition: fill 0.2s;
        }
        .f-input-wrap:focus-within .f-icon { fill: #f5c518; }

        .f-input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 12.5px;
            color: #fff;
            outline: none;
            transition: all 0.2s ease;
        }
        .f-input::placeholder { color: rgba(255,255,255,0.25); }
        .f-input:focus {
            border-color: rgba(245,197,24,0.5);
            background: rgba(245,197,24,0.04);
            box-shadow: 0 0 0 3px rgba(245,197,24,0.08);
        }

        /* Toggle password */
        .pw-toggle {
            position: absolute;
            right: 11px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer;
            padding: 2px;
            color: rgba(255,255,255,0.3);
            transition: color 0.2s;
            display: flex; align-items: center;
        }
        .pw-toggle:hover { color: #f5c518; }
        .pw-toggle svg { width: 15px; height: 15px; fill: currentColor; }

        /* Remember & Forgot */
        .f-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .f-remember {
            display: flex; align-items: center; gap: 7px;
            font-size: 11px; color: rgba(255,255,255,0.55);
            cursor: pointer;
        }
        .f-remember input { accent-color: #f5c518; width: 13px; height: 13px; cursor: pointer; }
        .f-forgot {
            font-size: 11px; font-weight: 500;
            color: #f5c518; text-decoration: none;
            transition: opacity 0.2s;
        }
        .f-forgot:hover { opacity: 0.7; text-decoration: underline; }

        /* Tombol login */
        .btn-login {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #1a7a4a 0%, #22a060 100%);
            border: none; border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px; font-weight: 600;
            color: #fff; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 16px rgba(26,122,74,0.35);
            letter-spacing: 0.2px;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #145c37 0%, #1a7a4a 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(26,122,74,0.45);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login svg { width: 14px; height: 14px; fill: #fff; }

        /* Alert */
        .alert-ok {
            background: rgba(26,122,74,0.12);
            border: 1px solid rgba(26,122,74,0.3);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 11px; color: #6ee7b7;
            margin-bottom: 14px;
        }
        .alert-err {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 11px; color: #fca5a5;
            margin-bottom: 14px;
        }

        /* Footer */
        .form-footer {
            margin-top: 18px;
            text-align: center;
            font-size: 10px;
            color: rgba(255,255,255,0.2);
            line-height: 1.6;
        }

        /* ── Responsive ── */
        @media (max-width: 680px) {
            .auth-card { flex-direction: column; max-width: 420px; }
            .left-panel { width: 100%; padding: 28px 24px; }
            .left-panel::before, .left-panel::after { display: none; }
            .right-panel { padding: 28px 24px; }
        }
    </style>
</head>
<body>
    <div class="blob-mid"></div>

    <div class="auth-card">

        {{-- ===== PANEL KIRI ===== --}}
        <div class="left-panel">
            <div class="left-content">

                <div class="logo-wrap">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BAN-PDM">
                </div>

                <h1 class="left-title">
                    Sistem Inventaris<br><span>BAN-PDM</span>
                </h1>

                <p class="left-sub">
                    Badan Akreditasi Nasional<br>
                    Pendidikan Dasar dan Menengah
                </p>

                <div class="left-location">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Manokwari, Papua Barat
                </div>

                <div class="left-divider"></div>

                <p class="left-desc">
                    Sistem digital untuk pengelolaan data, administrasi, dan layanan BAN-PDM secara efektif dan terintegrasi.
                </p>

                <div class="left-badges">
                    <span class="left-badge">🔒 Aman</span>
                    <span class="left-badge">📊 Terintegrasi</span>
                    <span class="left-badge">✅ Akreditasi</span>
                </div>

            </div>
        </div>

        {{-- ===== PANEL KANAN ===== --}}
        <div class="right-panel">

            <div class="form-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <div class="form-header-text">
                    <div class="name">BAN-PDM</div>
                    <div class="sub">Papua Barat</div>
                </div>
            </div>

            <h2 class="form-title">Welcome Back! 👋</h2>
            <p class="form-subtitle">Silakan login untuk mengakses sistem</p>

            {{-- Slot konten form --}}
            {{ $slot }}

            <div class="form-footer">
                &copy; {{ date('Y') }} BAN-PDM Papua Barat &mdash; Sistem Inventaris v1.0
            </div>

        </div>

    </div>
</body>
</html>
