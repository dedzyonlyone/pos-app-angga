<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS App - Modern Dashboard</title>
    <style>
        /* RESET DASAR */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0f172a; /* Warna gelap modern */
            color: #f8fafc;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 48px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #818cf8; /* Biru terang */
        }
        .logo span { color: white; }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-login {
            color: #cbd5e1;
            margin-right: 15px;
        }
        .btn-login:hover { color: white; }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }
        .btn-primary:hover {
            background-color: #6366f1;
            transform: scale(1.05);
        }

        /* HERO SECTION */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 48px;
            min-height: 80vh;
            gap: 40px;
        }

        .hero-text { flex: 1; }

        .hero-text h1 {
            font-size: 64px;
            line-height: 1.1;
            font-weight: 900;
            margin-bottom: 20px;
        }

        .gradient-text {
            background: linear-gradient(to right, #818cf8, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-text p {
            font-size: 18px;
            color: #94a3b8;
            margin-bottom: 40px;
            max-width: 450px;
            line-height: 1.6;
        }

        .btn-group { display: flex; gap: 15px; }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.2); }

        /* MOCKUP DASHBOARD (Kotak Kanan) */
        .hero-visual {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
        }

        /* Efek Cahaya di belakang */
        .glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: #4f46e5;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .mockup {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            
            /* ANIMASI FLOAT */
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .mockup-header { display: flex; gap: 8px; margin-bottom: 20px; }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot.red { background: #ef4444; }
        .dot.yellow { background: #eab308; }
        .dot.green { background: #22c55e; }

        .mockup-line {
            height: 12px;
            background: #334155;
            border-radius: 6px;
            margin-bottom: 15px;
            width: 50%;
        }

        .mockup-chart {
            height: 120px;
            background: #1e293b;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-end;
            padding: 10px;
            gap: 10px;
        }

        .bar { flex: 1; background: #4f46e5; border-radius: 4px 4px 0 0; }
        .bar:nth-child(1) { height: 40%; }
        .bar:nth-child(2) { height: 70%; background: #6366f1; }
        .bar:nth-child(3) { height: 100%; background: #22d3ee; }
        .bar:nth-child(4) { height: 60%; background: #6366f1; }
        .bar:nth-child(5) { height: 80%; }

        .mockup-cards { display: flex; gap: 15px; }
        .m-card { flex: 1; height: 60px; background: #1e293b; border-radius: 8px; }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">POS<span>.App</span></div>
        <div>
            <a href="#" class="btn btn-login">Login</a>
            <a href="#" class="btn btn-primary">Get Started</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="hero">
        
        <!-- Area Teks -->
        <div class="hero-text">
            <h1>Kelola Toko <br><span class="gradient-text">Lebih Cerdas.</span></h1>
            <p>Sistem Point of Sale modern dengan analitik real-time. Tingkatkan penjualanmu dengan antarmuka yang cepat dan elegan.</p>
            <div class="btn-group">
                <a href="#" class="btn btn-primary" style="padding: 16px 32px; font-size: 18px;">Mulai Sekarang</a>
                <a href="#" class="btn btn-secondary" style="padding: 16px 32px; font-size: 18px;">
                    ▶ Lihat Demo
                </a>
            </div>
        </div>

        <!-- Area Visual (Kanan) -->
        <div class="hero-visual">
            <div class="glow"></div>
            
            <!-- Kotak Dashboard Palsu -->
            <div class="mockup">
                <div class="mockup-header">
                    <div class="dot red"></div>
                    <div class="dot yellow"></div>
                    <div class="dot green"></div>
                </div>
                
                <div class="mockup-line"></div>
                
                <div class="mockup-chart">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                
                <div class="mockup-cards">
                    <div class="m-card"></div>
                    <div class="m-card"></div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>