<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS RTH Sarua & Ciputat</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* --- 1. VARS (PALET MEWAH) --- */
        :root {
            --bg-main: #05201a;
            --bg-card: rgba(11, 46, 39, 0.6);
            --primary: #d4af37;     /* Emas */
            --primary-glow: rgba(212, 175, 55, 0.4);
            --text-white: #f1f8f6;
            --text-grey: #a0b3af;
            --border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* --- 2. GLOBAL RESET & TEXTURE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main); 
            color: var(--text-white); 
            overflow-x: hidden;
            font-size: 14px;
            
            /* RAHASIA BIAR GAK POLOS: GRID PATTERN */
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px; /* Ukuran kotak grid */
            background-position: center top;
        }

        /* Efek Vignette (Pinggiran Gelap) */
        body::after {
            content: ""; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle, transparent 40%, #05201a 100%);
            pointer-events: none; z-index: -1;
        }

        /* Animasi Floating (Naik Turun Halus) */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        a { text-decoration: none; color: inherit; transition: 0.3s ease; }
        ul { list-style: none; }

        /* --- 3. NAVBAR --- */
        nav {
            position: fixed; top: 25px; left: 50%; transform: translateX(-50%);
            padding: 12px 40px; width: auto;
            background: rgba(5, 20, 16, 0.8); backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1); border-radius: 100px;
            display: flex; gap: 40px; align-items: center;
            z-index: 1000; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .logo { font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 10px; color: var(--text-white); letter-spacing: 1px;}
        .nav-links { display: flex; gap: 5px; }
        .nav-links a { 
            font-size: 0.85rem; font-weight: 600; color: var(--text-grey); 
            padding: 8px 18px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--bg-main); background: var(--primary); box-shadow: 0 0 15px var(--primary-glow); }

        /* --- 4. HERO SECTION --- */
        header {
            min-height: 90vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
            padding: 120px 20px 40px; position: relative;
        }
        
        /* Cahaya di belakang judul */
        .hero-glow {
            position: absolute; width: 300px; height: 300px; background: var(--primary);
            filter: blur(150px); opacity: 0.15; top: 30%; z-index: -1; animation: float 6s ease-in-out infinite;
        }

        .hero-badge {
            padding: 8px 20px; background: rgba(212, 175, 55, 0.1);
            color: var(--primary); border-radius: 50px; font-size: 0.75rem; font-weight: 700;
            margin-bottom: 25px; border: 1px solid rgba(212, 175, 55, 0.3); letter-spacing: 1px;
            display: inline-block;
        }

        header h1 { font-size: 3.5rem; line-height: 1.1; font-weight: 800; margin-bottom: 20px; text-shadow: 0 0 30px rgba(0,0,0,0.5); }
        .text-gradient {
            background: linear-gradient(135deg, #fff 30%, var(--primary) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        
        header p { font-size: 1.1rem; color: var(--text-grey); max-width: 600px; margin: 0 auto 35px; line-height: 1.6; }

        .btn-gold {
            background: var(--primary); color: var(--bg-main); padding: 15px 45px; border-radius: 50px; font-weight: 700;
            display: inline-flex; align-items: center; gap: 10px; text-transform: uppercase; font-size: 0.85rem;
            box-shadow: 0 0 20px var(--primary-glow); transition: 0.3s;
        }
        .btn-gold:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 0 40px var(--primary-glow); background: white; }

        /* Mouse Scroll Icon Animation */
        .scroll-icon {
            margin-top: 50px; width: 24px; height: 40px; border: 2px solid rgba(255,255,255,0.2);
            border-radius: 20px; position: relative; display: flex; justify-content: center;
        }
        .scroll-icon::before {
            content: ''; width: 4px; height: 8px; background: var(--primary); border-radius: 4px;
            margin-top: 6px; animation: scrollDown 1.5s infinite;
        }
        @keyframes scrollDown { 0% { opacity: 1; transform: translateY(0); } 100% { opacity: 0; transform: translateY(15px); } }

        /* --- 5. GLOBAL SECTIONS --- */
        section { padding: 80px 10%; position: relative; scroll-margin-top: 60px; }
        .section-title { text-align: center; margin-bottom: 50px; position: relative; z-index: 2; }
        .section-title h2 { font-size: 2.2rem; font-weight: 700; margin-bottom: 10px; color: var(--primary); text-transform: uppercase; letter-spacing: 2px; }
        .section-title p { color: var(--text-grey); font-size: 0.95rem; }

        /* --- 6. MAP SECTION --- */
        .map-window {
            background: rgba(11, 46, 39, 0.4); padding: 12px; border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);
            box-shadow: 0 20px 80px rgba(0,0,0,0.5);
        }
        .window-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding: 0 10px; }
        .window-dots { display: flex; gap: 8px; }
        .dot { width: 10px; height: 10px; border-radius: 50%; opacity: 0.8; }
        .red { background: #ff5f56; } .yellow { background: #ffbd2e; } .green { background: #27c93f; }
        
        .map-frame { width: 100%; height: 500px; border-radius: 12px; overflow: hidden; background: #000; border: 1px solid rgba(255,255,255,0.1); }
        iframe { width: 100%; height: 100%; border: none; filter: saturate(1.1); }

        /* --- 7. ABOUT CARDS (GLASS EFFECT) --- */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .glass-card {
            background: var(--bg-card); border: var(--border); padding: 35px; border-radius: 24px;
            transition: 0.4s; position: relative; overflow: hidden; backdrop-filter: blur(10px);
        }
        /* Efek Hover Keren */
        .glass-card:hover { transform: translateY(-10px); border-color: var(--primary); box-shadow: 0 10px 40px rgba(0,0,0,0.4); }
        .glass-card::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.03), transparent);
            transform: rotate(45deg); transition: 0.5s; opacity: 0; pointer-events: none;
        }
        .glass-card:hover::before { opacity: 1; }

        .icon-box {
            width: 60px; height: 60px; background: rgba(212, 175, 55, 0.1); border-radius: 16px;
            display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: var(--primary);
            margin-bottom: 20px; border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .glass-card h3 { font-size: 1.4rem; color: var(--text-white); margin-bottom: 15px; }
        .glass-card p { line-height: 1.7; color: var(--text-grey); font-size: 0.95rem; }
        .list-check li { display: flex; gap: 12px; margin-bottom: 10px; align-items: center; color: var(--text-white); }
        .list-check li i { color: var(--primary); }

        /* --- 8. TEAM SECTION (EQUAL CARDS) --- */
        .team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .team-card {
            background: linear-gradient(180deg, rgba(11,46,39,0.7) 0%, rgba(5,20,16,0.9) 100%);
            border: var(--border); border-radius: 24px; padding: 40px 20px; text-align: center;
            transition: 0.4s; position: relative;
        }
        .team-card:hover { transform: translateY(-10px); border-color: var(--primary); }
        
        .profile-glow {
            width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%;
            background: #0b2e27; border: 2px solid var(--primary);
            display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: var(--text-white);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }
        .team-card:hover .profile-glow { box-shadow: 0 0 30px var(--primary-glow); background: var(--primary); color: var(--bg-main); transition: 0.4s;}

        .role-badge { 
            background: rgba(255,255,255,0.05); padding: 5px 15px; border-radius: 30px; 
            font-size: 0.7rem; color: var(--primary); margin-bottom: 15px; display: inline-block; 
            text-transform: uppercase; letter-spacing: 1px; font-weight: 700;
        }
        .team-card h3 { font-size: 1.3rem; margin-bottom: 5px; color: var(--text-white); }
        .team-card p { font-size: 0.9rem; color: var(--text-grey); margin-bottom: 25px; }
        
        .social-row { display: flex; justify-content: center; gap: 15px; }
        .social-btn { 
            width: 38px; height: 38px; background: rgba(255,255,255,0.05); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; color: var(--text-grey);
            transition: 0.3s; border: 1px solid transparent;
        }
        .social-btn:hover { border-color: var(--primary); color: var(--primary); transform: scale(1.1); }

        /* --- 9. CONTACT SECTION --- */
        .contact-container { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
        .contact-box {
            display: flex; flex-direction: column; align-items: center; text-align: center;
            padding: 30px; background: var(--bg-card); border: var(--border); border-radius: 20px;
            transition: 0.3s; cursor: pointer;
        }
        .contact-box:hover { background: rgba(212, 175, 55, 0.1); border-color: var(--primary); }
        .contact-box i { font-size: 2rem; color: var(--primary); margin-bottom: 15px; }
        .contact-box h4 { margin-bottom: 5px; color: var(--text-white); }
        .contact-box span { color: var(--text-grey); font-size: 0.9rem; }

        /* FOOTER */
        footer { 
            text-align: center; padding: 40px; color: var(--text-grey); font-size: 0.8rem; 
            border-top: var(--border); background: #020d0b; margin-top: 80px; 
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            header h1 { font-size: 2.5rem; }
            .about-grid, .team-grid, .contact-container { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            nav { padding: 10px 20px; width: 90%; justify-content: space-between; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">
            <i class="fa-solid fa-map-location-dot" style="color: var(--primary);"></i> <span>SIG RTH</span>
        </div>
        <div class="nav-links">
            <a href="#home" class="active">Home</a>
            <a href="#map">Map</a>
            <a href="#about">About</a>
            <a href="#team">Team</a>
            <a href="#contact">Contact</a>
        </div>
        <a href="#" style="color: var(--primary); font-size: 1.2rem;"><i class="fa-regular fa-circle-user"></i></a>
    </nav>

    <header id="home">
        <div class="hero-glow"></div>

        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <div class="hero-badge">WebGIS Project 2025</div>
            <h1>Pemetaan Ruang Terbuka <br><span class="text-gradient">Hijau Digital.</span></h1>
            <p>Eksplorasi data spasial RTH Sarua serta pemetaan kelurahan di Ciputat dengan visualisasi modern. Analisis wilayah dan sebaran titik hijau dalam satu antarmuka.</p>
            
            <a href="#map" class="btn-gold">
                Mulai Eksplorasi <i class="fa-solid fa-arrow-down-long"></i>
            </a>

            <div style="display: flex; justify-content: center;">
                <div class="scroll-icon"></div>
            </div>
        </div>
    </header>

    <section id="map" data-aos="fade-up">
        <div class="section-title">
            <h2>Peta Interaktif</h2>
            <p>Visualisasi Data Titik RTH & Poligon Wilayah</p>
        </div>
        <div class="map-window">
            <div class="window-header">
                <div class="window-dots">
                    <div class="dot red"></div> <div class="dot yellow"></div> <div class="dot green"></div>
                </div>
                <div style="font-size: 0.7rem; color: #aaa; font-weight: 700; letter-spacing: 1px;">LIVE DATA VIEW</div>
                <div></div>
            </div>
            <div class="map-frame">
                <iframe src="<?=base_url()?>index.php/welcome"></iframe>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="section-title" data-aos="fade-up"><h2>Tentang Aplikasi</h2></div>
        
        <div class="about-grid">
            <div class="glass-card" data-aos="fade-right">
                <div class="icon-box"><i class="fa-solid fa-layer-group"></i></div>
                <h3>Sistem Informasi Geografis</h3>
                <p>WebGIS ini dibangun untuk memetakan persebaran Ruang Terbuka Hijau (RTH) di Sarua. Membantu analisis tata ruang yang transparan bagi masyarakat.</p>
            </div>

            <div class="glass-card" data-aos="fade-left">
                <div class="icon-box"><i class="fa-solid fa-bullseye"></i></div>
                <h3>Visi & Misi Kami</h3>
                <p style="margin-bottom: 15px;">Menjadi platform data spasial terdepan untuk pelestarian lingkungan kota.</p>
                <ul class="list-check">
                    <li><i class="fa-solid fa-circle-check"></i> Akses Data Cepat</li>
                    <li><i class="fa-solid fa-circle-check"></i> Integrasi Poligon Wilayah</li>
                    <li><i class="fa-solid fa-circle-check"></i> Visualisasi Interaktif</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="team">
        <div class="section-title" data-aos="fade-up"><h2>Developer Team</h2></div>
        <div class="team-grid">
            
            <div class="team-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="profile-glow"><i class="fa-solid fa-code"></i></div>
                <span class="role-badge">WebGIS Developer</span>
                <h3>Fatikah Aulia Farhah</h3>
                <p>NIM: 11220930000097</p>
                <div class="social-row">
                    <a href="#" class="social-btn"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="team-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="profile-glow"><i class="fa-solid fa-map"></i></div>
                <span class="role-badge">WebGIS Developer</span>
                <h3>Muhammad Al Ghiffary</h3>
                <p>NIM: 11220930000099</p>
                <div class="social-row">
                    <a href="#" class="social-btn"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="team-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="profile-glow"><i class="fa-solid fa-pen-nib"></i></div>
                <span class="role-badge">WebGIS Developer</span>
                <h3>Zalfa Rafi Putra</h3>
                <p>NIM: 11220930000134</p>
                <div class="social-row">
                    <a href="#" class="social-btn"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>
    </section>

    <section id="contact" data-aos="fade-up">
        <div class="section-title"><h2>Hubungi Kami</h2></div>
        <div class="contact-container">
            <a href="#" class="contact-box">
                <i class="fa-brands fa-whatsapp"></i>
                <h4>WhatsApp</h4>
                <span>+62 812-3456-789</span>
            </a>
            <a href="#" class="contact-box">
                <i class="fa-regular fa-envelope"></i>
                <h4>Email</h4>
                <span>admin@webgis.com</span>
            </a>
            <a href="#" class="contact-box">
                <i class="fa-solid fa-location-dot"></i>
                <h4>Kampus</h4>
                <span>UIN Syarif Hidayatullah Jakarta</span>
            </a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 WebGIS RTH Project. All Rights Reserved.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 1000, /* Kecepatan animasi */
        once: true,     /* Animasi cuma sekali saat scroll */
      });
    </script>
</body>
</html>