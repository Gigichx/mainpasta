<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Maninpasta - Pasta fresca artigianale barese. Orecchiette, cavatelli e strascinati fatti a mano secondo la tradizione di Bari Vecchia.">
    <title>Maninpasta - Pasta Fresca Artigianale Barese</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap');
        
        :root {
            --primary-color: #d4a574;
            --secondary-color: #8b4513;
            --accent-green: #2c5f2d;
            --text-dark: #2c3e50;
            --bg-light: #faf8f5;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23d4a574" width="1200" height="600"/><circle fill="%23c49563" cx="200" cy="150" r="80"/><circle fill="%23c49563" cx="600" cy="300" r="120"/><circle fill="%23c49563" cx="1000" cy="200" r="100"/></svg>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 900;
            margin-bottom: 25px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            letter-spacing: 2px;
            background: linear-gradient(45deg, #fff, #f4e4c1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }
        
        @keyframes rotate {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }
        
        .hero p {
            font-size: 1.5rem;
            max-width: 700px;
            margin: 0 auto;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            font-weight: 300;
        }
        
        /* Section Styling */
        section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: #7f8c8d;
        }
        
        /* Storia Section */
        .storia-section {
            background: white;
        }
        
        .storia-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .storia-content p {
            margin-bottom: 20px;
            color: #555;
        }
        
        /* Pasta Cards - Nuova Struttura */
        .pasta-section {
            background: var(--bg-light);
        }
        
        .pasta-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .pasta-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(212, 165, 116, 0.2);
        }
        
        .pasta-card-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .pasta-card-body {
            padding: 30px;
        }
        
        .pasta-card-body h3 {
            color: var(--secondary-color);
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .pasta-card-body .subtitle {
            color: var(--primary-color);
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        
        .pasta-card-body p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #555;
        }
        
        /* Size Selector */
        .size-selector {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .size-badge {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
            color: #666;
            transition: all 0.3s ease;
            cursor: default;
        }
        
        .size-badge.active {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        .pasta-info {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 0.9rem;
            color: #666;
        }
        
        /* Tradizione Section - Nuovi Colori */
        .tradizione-section {
            background: linear-gradient(135deg, var(--bg-light) 0%, #f0ebe3 100%);
        }
        
        .tradizione-section .section-title h2 {
            color: var(--secondary-color);
        }
        
        .tradizione-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .tradizione-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(212, 165, 116, 0.15);
        }
        
        .tradizione-box h4 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
            font-weight: 600;
        }
        
        .tradizione-box p {
            color: #555;
            line-height: 1.7;
            margin: 0;
        }
        
        /* Contact Section */
        .contact-section {
            background: white;
        }
        
        .contact-box {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.2);
            text-align: center;
            color: white;
        }
        
        .contact-box h3 {
            color: white;
            margin-bottom: 20px;
            font-size: 2rem;
        }
        
        .contact-box p {
            opacity: 0.95;
        }
        
        .btn-whatsapp {
            background: #25D366;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .btn-whatsapp:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            color: white;
        }
        
        /* Footer */
        footer {
            background: var(--text-dark);
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        
        .admin-link {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
            transition: transform 0.3s;
            z-index: 1000;
            font-weight: 600;
        }
        
        .admin-link:hover {
            transform: scale(1.1);
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .size-selector {
                flex-direction: column;
            }
            
            .contact-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Maninpasta</h1>
            <p>La tradizione della pasta fresca barese, fatta a mano con passione dal 1950</p>
        </div>
    </section>
    
    <!-- Storia Section -->
    <section class="storia-section">
        <div class="container">
            <div class="section-title">
                <h2>La Nostra Storia</h2>
                <p>Tre generazioni di maestria artigianale</p>
            </div>
            
            <div class="storia-content">
                <p>
                    Nel cuore di Bari Vecchia, tra i vicoli stretti dove il tempo sembra essersi fermato, 
                    nasce la nostra pasta. Da oltre settant'anni, le mani esperte delle nostre "signore delle orecchiette" 
                    lavorano la semola di grano duro seguendo gesti antichi, tramandati di madre in figlia.
                </p>
                <p>
                    Ogni orecchietta, ogni cavatello, ogni strascinato porta con sé non solo il sapore autentico 
                    della Puglia, ma anche la memoria di una tradizione che si rinnova ogni giorno. La nostra semola 
                    è rigorosamente di grano duro pugliese, lavorata a freddo per preservarne tutte le qualità nutritive.
                </p>
                <p>
                    Non vendiamo solo pasta: custodiamo un patrimonio culturale fatto di sapori, profumi e storie 
                    che meritano di essere raccontate e condivise. Ogni formato che produciamo è un piccolo capolavoro 
                    di artigianalità, fatto con amore per portare sulle vostre tavole il vero gusto di Bari.
                </p>
            </div>
        </div>
    </section>
    
    <!-- I Nostri Formati Section -->
    <section class="pasta-section">
        <div class="container">
            <div class="section-title">
                <h2>I Nostri Formati</h2>
                <p>Ogni pasta racconta una storia</p>
            </div>
            
            <div class="row">
                <!-- Orecchiette - Card Unica -->
                <div class="col-md-6">
                    <div class="pasta-card">
                        <img src="assets/css/IMG/Orecchiette.webp" 
                             alt="Orecchiette" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Orecchiette</h3>
                            <div class="subtitle">Il formato tradizionale barese</div>
                            <p>
                                Le piccole "recchie" sono il simbolo della cucina pugliese. Lavorate una ad una 
                                con il pollice, perfette per trattenere il sugo. Disponibili in tre taglie 
                                per soddisfare ogni preferenza.
                            </p>
                            
                            <div class="size-selector">
                                <div class="size-badge">
                                    <div style="font-size: 0.75rem; opacity: 0.8;">PICCOLE</div>
                                    <div style="margin-top: 5px;">10-12 min</div>
                                </div>
                                <div class="size-badge active">
                                    <div style="font-size: 0.75rem; opacity: 0.9;">NORMALI</div>
                                    <div style="margin-top: 5px;">12-14 min</div>
                                </div>
                                <div class="size-badge">
                                    <div style="font-size: 0.75rem; opacity: 0.8;">GRANDI</div>
                                    <div style="margin-top: 5px;">14-16 min</div>
                                </div>
                            </div>
                            
                            <div class="pasta-info">
                                <span><strong>Ideale con:</strong> Cime di rapa, pomodoro, ragù</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cavatelli -->
                <div class="col-md-6">
                    <div class="pasta-card">
                        <img src="https://www.puglia.com/wp-content/uploads/2018/05/ricetta-cavatelli-fatti-in-casa.jpg" 
                             alt="Cavatelli" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Cavatelli</h3>
                            <div class="subtitle">La tradizione rustica</div>
                            <p>
                                Piccoli gnocchetti allungati con la caratteristica forma scavata al centro. 
                                La loro consistenza porosa li rende perfetti per sughi corposi e ragù. 
                                Un formato che esalta i sapori della terra pugliese.
                            </p>
                            
                            <div class="pasta-info">
                                <span><strong>Tempo cottura:</strong> 10-12 min</span>
                                <span><strong>Formato:</strong> Corto</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <!-- Cartellate -->
                <div class="col-md-6 mx-auto">
                    <div class="pasta-card">
                        <img src="assets/css/IMG/Cartellate.webp" 
                             alt="Cartellate" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Cartellate</h3>
                            <div class="subtitle">Il dolce della tradizione</div>
                            <p>
                                Tipico dolce natalizio pugliese, fatto con sfoglie arrotolate a forma di rosa. 
                                Fritte e ricoperte di miele o vincotto, rappresentano la dolcezza delle feste 
                                secondo la tradizione di Bari Vecchia.
                            </p>
                            
                            <div class="pasta-info">
                                <span><strong>Preparazione:</strong> Fritte</span>
                                <span><strong>Occasione:</strong> Natale</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Tradizione Section -->
    <section class="tradizione-section">
        <div class="container">
            <div class="section-title">
                <h2>Il Rito della Pasta</h2>
                <p>Come si fa la vera pasta barese</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="tradizione-box">
                        <h4>1. La Semola</h4>
                        <p>
                            Solo grano duro pugliese di prima qualità, macinato a pietra per preservare 
                            tutte le proprietà nutritive e il sapore autentico del grano.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="tradizione-box">
                        <h4>2. L'Impasto</h4>
                        <p>
                            Acqua tiepida e semola, nient'altro. L'impasto viene lavorato a lungo, 
                            fino a ottenere quella consistenza liscia ed elastica che solo l'esperienza 
                            può riconoscere.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="tradizione-box">
                        <h4>3. La Lavorazione</h4>
                        <p>
                            Ogni pezzo è modellato a mano, uno per uno. Non esistono macchine che possano 
                            replicare il gesto sapiente delle mani che conoscono ogni segreto della pasta.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="tradizione-box">
                        <h4>4. L'Essiccazione</h4>
                        <p>
                            La pasta viene lasciata asciugare naturalmente su telai di legno, 
                            lontano da fonti di calore artificiali. Il tempo è un ingrediente fondamentale.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2025 Maninpasta - Pasta Fresca Artigianale Barese</p>
            <p class="mb-0"><small>Tradizione dal 1950 • Bari Vecchia</small></p>
        </div>
    </footer>
    
    <!-- Link Admin -->
    <a href="admin/login.php" class="admin-link" title="Area Amministratore">
        🔐 Admin
    </a>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>