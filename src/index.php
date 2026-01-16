<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Maninpasta - Pasta fresca artigianale barese. Orecchiette, cavatelli e strascinati fatti a mano secondo la tradizione di Bari Vecchia.">
    <title>Maninpasta - Pasta Fresca Artigianale Barese</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #d4a574;
            --secondary-color: #8b4513;
            --accent-color: #2c5f2d;
            --text-dark: #2c3e50;
        }
        
        body {
            font-family: 'Georgia', serif;
            color: var(--text-dark);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23d4a574" width="1200" height="600"/><circle fill="%23c49563" cx="200" cy="150" r="80"/><circle fill="%23c49563" cx="600" cy="300" r="120"/><circle fill="%23c49563" cx="1000" cy="200" r="100"/></svg>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            max-width: 700px;
            margin: 0 auto;
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
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: #666;
        }
        
        /* Storia Section */
        .storia-section {
            background: #faf8f5;
        }
        
        .storia-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .storia-content p {
            margin-bottom: 20px;
        }
        
        /* Pasta Cards */
        .pasta-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .pasta-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .pasta-card-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .pasta-card-body {
            padding: 25px;
        }
        
        .pasta-card-body h3 {
            color: var(--secondary-color);
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .pasta-card-body h4 {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        
        .pasta-card-body p {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .pasta-card-footer {
            padding: 20px 25px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        .pasta-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #666;
        }
        
        /* Tradizione Section */
        .tradizione-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .tradizione-section .section-title h2,
        .tradizione-section .section-title p {
            color: white;
        }
        
        .tradizione-box {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .tradizione-box h4 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        /* Contact Section */
        .contact-section {
            background: #f8f9fa;
        }
        
        .contact-box {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .contact-box h3 {
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        .btn-whatsapp {
            background: #25D366;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-whatsapp:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
            color: white;
        }
        
        /* Footer */
        footer {
            background: var(--secondary-color);
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        
        .admin-link {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--secondary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: transform 0.3s;
            z-index: 1000;
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
    <section>
        <div class="container">
            <div class="section-title">
                <h2>I Nostri Formati</h2>
                <p>Ogni pasta racconta una storia</p>
            </div>
            
            <div class="row">
                <!-- Orecchiette Piccole -->
                <div class="col-md-4">
                    <div class="pasta-card">
                        <img src="https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=800&h=600&fit=crop" 
                             alt="Orecchiette Piccole" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Orecchiette Piccole</h3>
                            <h4>Il Formato Tradizionale</h4>
                            <p>
                                Le piccole "recchie" sono il formato classico della tradizione barese. 
                                Perfette per trattenere il sugo, ideali con le cime di rapa o qualsiasi condimento. 
                                Lavorate una ad una con il pollice.
                            </p>
                        </div>
                        <div class="pasta-card-footer">
                            <div class="pasta-info">
                                <span><strong>Tempo cottura:</strong> 10-12 min</span>
                                <span><strong>Taglia:</strong> Piccola</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Orecchiette Normali -->
                <div class="col-md-4">
                    <div class="pasta-card">
                        <img src="https://images.unsplash.com/photo-1608897013039-887f21d8c804?w=800&h=600&fit=crop" 
                             alt="Orecchiette Normali" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Orecchiette Normali</h3>
                            <h4>Il Formato Versatile</h4>
                            <p>
                                La dimensione perfetta per ogni occasione. Il formato più richiesto, 
                                ideale con sughi di carne, verdure o pesce. La scelta classica 
                                per portare la Puglia in tavola.
                            </p>
                        </div>
                        <div class="pasta-card-footer">
                            <div class="pasta-info">
                                <span><strong>Tempo cottura:</strong> 12-14 min</span>
                                <span><strong>Taglia:</strong> Normale</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Orecchiette Grandi -->
                <div class="col-md-4">
                    <div class="pasta-card">
                        <img src="https://images.unsplash.com/photo-1611599537845-67677d89b6b4?w=800&h=600&fit=crop" 
                             alt="Orecchiette Grandi" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Orecchiette Grandi</h3>
                            <h4>Il Formato Generoso</h4>
                            <p>
                                Per chi ama la consistenza rustica e decisa. Le orecchiette grandi 
                                sono perfette con sughi corposi e ricchi. Un formato che fa la differenza 
                                nel piatto.
                            </p>
                        </div>
                        <div class="pasta-card-footer">
                            <div class="pasta-info">
                                <span><strong>Tempo cottura:</strong> 14-16 min</span>
                                <span><strong>Taglia:</strong> Grande</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <!-- Cavatelli -->
                <div class="col-md-6">
                    <div class="pasta-card">
                        <img src="https://www.puglia.com/wp-content/uploads/2018/05/ricetta-cavatelli-fatti-in-casa.jpg" 
                             alt="Cavatelli" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Cavatelli</h3>
                            <h4>La Tradizione Rustica</h4>
                            <p>
                                Piccoli gnocchetti allungati con la caratteristica forma scavata al centro. 
                                La loro consistenza porosa li rende perfetti per sughi corposi e ragù. 
                                Un formato che esalta i sapori della terra pugliese.
                            </p>
                        </div>
                        <div class="pasta-card-footer">
                            <div class="pasta-info">
                                <span><strong>Tempo cottura:</strong> 10-12 min</span>
                                <span><strong>Formato:</strong> Corto</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cartellate -->
                <div class="col-md-6">
                    <div class="pasta-card">
                        <img src="assets/css/IMG/Cartellate.webp" 
                             alt="Cartellate" 
                             class="pasta-card-image">
                        <div class="pasta-card-body">
                            <h3>Cartellate</h3>
                            <h4>Il Dolce della Tradizione</h4>
                            <p>
                                Tipico dolce natalizio pugliese, fatto con sfoglie arrotolate a forma di rosa. 
                                Fritte e ricoperte di miele o vincotto, rappresentano la dolcezza delle feste 
                                secondo la tradizione di Bari Vecchia.
                            </p>
                        </div>
                        <div class="pasta-card-footer">
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
                <div class="col-md-4">
                    <div class="tradizione-box">
                        <h4>1. La Semola</h4>
                        <p>
                            Solo grano duro pugliese di prima qualità, macinato a pietra per preservare 
                            tutte le proprietà nutritive e il sapore autentico del grano.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="tradizione-box">
                        <h4>2. L'Impasto</h4>
                        <p>
                            Acqua tiepida e semola, nient'altro. L'impasto viene lavorato a lungo, 
                            fino a ottenere quella consistenza liscia ed elastica che solo l'esperienza 
                            può riconoscere.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="tradizione-box">
                        <h4>3. La Lavorazione</h4>
                        <p>
                            Ogni pezzo è modellato a mano, uno per uno. Non esistono macchine che possano 
                            replicare il gesto sapiente delle mani che conoscono ogni segreto della pasta.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6 mx-auto">
                    <div class="tradizione-box">
                        <h4>4. L'Essiccazione</h4>
                        <p>
                            La pasta viene lasciata asciugare naturalmente su telai di legno, 
                            lontano da fonti di calore artificiali. Il tempo è un ingrediente fondamentale: 
                            non si può avere fretta quando si lavora con la tradizione.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <!-- <section class="contact-section">
        <div class="container">
            <div class="section-title">
                <h2>Ordina la Tua Pasta</h2>
                <p>Portiamo la tradizione barese nella tua cucina</p>
            </div>
            
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="contact-box">
                        <h3>Contattaci su WhatsApp</h3>
                        <p class="mb-4">
                            Ordina la tua pasta fresca direttamente dal laboratorio. 
                            Rispondiamo rapidamente a tutte le richieste e prepariamo 
                            la tua pasta fresca su ordinazione.
                        </p>
                        <a href="https://wa.me/393331234567?text=Ciao!%20Vorrei%20informazioni%20sulla%20pasta%20fresca" 
                           class="btn-whatsapp" 
                           target="_blank">
                            Scrivici su WhatsApp
                        </a>
                        <p class="mt-4 text-muted">
                            <small>Rispondiamo dal lunedì al sabato, dalle 8:00 alle 19:00</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2025 Maninpasta - Pasta Fresca Artigianale Barese</p>
            <p class="mb-0"><small>Tradizione dal 1950 • Bari Vecchia</small></p>
        </div>
    </footer>
    
    <!-- Link Admin (nascosto) -->
    <a href="admin/login.php" class="admin-link" title="Area Amministratore">
        Admin
    </a>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>