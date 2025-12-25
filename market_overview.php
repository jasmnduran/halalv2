<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Discover Your Halal Market Potential</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <style>

.overview-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 25px;
      border-top: 4px solid var(--primary-green);
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .overview-card:hover {
      box-shadow: var(--shadow-hover);
      transform: translateY(-3px);
    }

    .overview-card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      text-align: center;
    }

    .overview-card h3 {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary-green);
      margin-bottom: 15px;
    }

    .overview-card p {
      color: #333;
      line-height: 1.7;
      margin-bottom: 15px;
    }

    .form-section {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 30px;
      margin-bottom: 24px;
      border-top: 4px solid var(--primary-green);
      animation: fadeInUp 0.6s ease 0.3s both;
    }

    .form-section h2 {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--primary-green);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-green);
    }

    .form-row {
      display: flex;
      gap: 16px;
      margin-bottom: 16px;
    }

    .form-row .form-group {
      flex: 1;
      margin-bottom: 0;
    }

    .submit-btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.3rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(13, 140, 76, 0.3);
      margin-bottom: 12px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 140, 76, 0.4);
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
      
      .form-section, .overview-card {
        padding: 25px 20px;
      }
    }
  </style>
  <style>
    body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
    body { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .main-card { max-width: 600px; margin: 0 auto; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; }
    .header-bar { background: #fff; border-bottom: 1px solid #e5e7eb; border-radius: 1rem 1rem 0 0; padding: 1rem 1.5rem; display: flex; align-items: center; }
    .header-bar img { height: 40px; width: 40px; border-radius: 50%; margin-right: 1rem; }
    .header-bar .menu-btn { margin-left: auto; font-size: 2rem; color: #222; background: none; border: none; }
    .stat-card { background: #f8fafc; border-radius: 0.75rem; padding: 1.2rem; text-align: center; margin-bottom: 1rem; }
    .stat-title { font-size: 1.1em; color: #64748b; }
    .stat-value { font-size: 2em; font-weight: bold; }
    .stat-accent { color: #22c55e; }
    .section-title { font-weight: 600; font-size: 1.2em; margin-top: 1.5rem; }
    .tool-link { text-decoration: none; font-weight: 500; }
    .tool-link.try { color: #22c55e; }
    .tool-link.report { color: #2563eb; }
    .tool-link.guide { color: #f59e42; }
    @media (max-width: 600px) {
      body { align-items: flex-start; }
      .main-card { margin: 0; border-radius: 0; }
      .header-bar { border-radius: 0; }
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="owner_dashboard.php" class="btn btn-outline-secondary mb-3" style="margin-top:24px; margin-bottom:16px; font-weight:600;">
      &larr; Back to Dashboard
    </a>
    <div class="main-card bg-white">
      <div class="header-bar">
        <img src="logo.jpg" alt="Halal Keeps Logo">
        <button class="menu-btn d-md-none" title="Menu"><span>&#9776;</span></button>
      </div>
      <div class="p-4">
        <div class="text-center mb-3">
          <h2 class="fw-bold" style="font-size:1.5em;">Discover Your Halal Market Potential</h2>
          <div class="text-muted mb-3">Get data-driven insights on local halal consumer demand and revenue opportunities for your business.</div>
        </div>
        <div class="row g-2 mb-3" id="market-stats">
          <div class="col-4">
            <div class="stat-card">
              <div class="stat-title">Local Demand</div>
              <div class="stat-value stat-accent" id="local-demand">0%</div>
              <button class="btn btn-outline-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#localDemandModal">View</button>
            </div>
          </div>
          <div class="col-4">
            <div class="stat-card">
              <div class="stat-title">Avg Revenue Boost</div>
              <div class="stat-value" id="revenue-boost" style="color:#16a34a;">0%</div>
              <button class="btn btn-outline-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#revenueBoostModal">Calculate</button>
            </div>
          </div>
        </div>
        <div class="text-center mb-4">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#marketOverviewModal">View Market Overview</button>
        </div>
        <!-- Market Overview Modal -->
        <div class="modal fade" id="marketOverviewModal" tabindex="-1" aria-labelledby="marketOverviewModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="marketOverviewModalLabel">Market Overview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="market-overview-section">
                  <div class="fw-semibold mb-2" style="color:#5b3cc4;"><span style="font-size:1.2em;">&#128101;</span> <span id="overview-demand-label">Local Demand</span></div>
                  <div class="mb-2" id="overview-demand">0% of consumers seek halal options</div>
                  <div class="fw-semibold mb-2" style="color:#16a34a;"><span style="font-size:1.2em;">&#36;</span> <span id="overview-boost-label">Revenue Boost</span></div>
                  <div class="mb-2" id="overview-boost">0% average increase</div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Local Demand Modal -->
        <div class="modal fade" id="localDemandModal" tabindex="-1" aria-labelledby="localDemandModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="localDemandModalLabel">View Local Demand by Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <label>Select Barangay in Davao City</label>
                <select id="barangaySelect" class="form-control mb-2">
                  <option value="">-- Select Barangay --</option>
                  <!-- Barangay options will be populated by JS -->
                </select>
                <div id="localDemandResult" class="mt-2"></div>
                <div class="small text-muted mt-2">
                  Local demand is calculated as: (<b>Muslim Population</b> / <b>Total Population</b>) × 100
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Revenue Boost Modal -->
        <div class="modal fade" id="revenueBoostModal" tabindex="-1" aria-labelledby="revenueBoostModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="revenueBoostModalLabel">Calculate Avg Revenue Boost</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form onsubmit="calcRevenueBoost(event)">
                <div class="modal-body">
                  <label>Revenue After Halal Adoption (₱)</label>
                  <input type="number" id="revenueAfter" class="form-control mb-2" min="0" required>
                  <label>Revenue Before Halal Adoption (₱)</label>
                  <input type="number" id="revenueBefore" class="form-control" min="0" required>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Calculate</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
        <script>
          function calcRevenueBoost(e) {
            e.preventDefault();
            var after = parseFloat(document.getElementById('revenueAfter').value) || 0;
            var before = parseFloat(document.getElementById('revenueBefore').value) || 0;
            var percent = before > 0 ? ((after - before) / before * 100) : 0;
            document.getElementById('revenue-boost').textContent = (percent > 0 ? '+' : '') + Math.round(percent) + '%';
            var modal = bootstrap.Modal.getInstance(document.getElementById('revenueBoostModal'));
            modal.hide();
          }
          function updateOverview() {
            var demand = document.getElementById('local-demand').textContent;
            var boost = document.getElementById('revenue-boost').textContent;
            document.getElementById('overview-demand').textContent = demand + ' of consumers seek halal options';
            document.getElementById('overview-boost').textContent = boost + ' average increase';
          }
          // Davao City barangay population data (2020) and estimated Muslim population
          // Source: citypopulation.de/en/philippines/davao/
          // Muslim population: 35% for known Muslim-majority barangays, 10% for adjacent, 3.5% for others
          const barangayData = {
            "Acacia": { total: 6014, muslim: Math.round(6014*0.035) },
            "Agdao": { total: 6957, muslim: Math.round(6957*0.035) },
            "Alambre": { total: 2952, muslim: Math.round(2952*0.035) },
            "Alejandra Navarro (Lasang)": { total: 11774, muslim: Math.round(11774*0.035) },
            "Alfonso Angliongto Sr.": { total: 14962, muslim: Math.round(14962*0.035) },
            "Angalan": { total: 2741, muslim: Math.round(2741*0.035) },
            "Atan-Awe": { total: 1444, muslim: Math.round(1444*0.035) },
            "Baganihan": { total: 1507, muslim: Math.round(1507*0.035) },
            "Bago Aplaya": { total: 18930, muslim: Math.round(18930*0.035) },
            "Bago Gallera": { total: 19201, muslim: Math.round(19201*0.035) },
            "Bago Oshiro": { total: 17717, muslim: Math.round(17717*0.035) },
            "Baguio": { total: 4801, muslim: Math.round(4801*0.035) },
            "Balengaeng": { total: 2390, muslim: Math.round(2390*0.035) },
            "Baliok": { total: 17165, muslim: Math.round(17165*0.035) },
            "Bangkas Heights": { total: 8056, muslim: Math.round(8056*0.035) },
            "Bantol": { total: 2334, muslim: Math.round(2334*0.035) },
            "Baracatan": { total: 2965, muslim: Math.round(2965*0.035) },
            "Barangay 1-A": { total: 3089, muslim: Math.round(3089*0.035) },
            "Barangay 10-A": { total: 7867, muslim: Math.round(7867*0.10) },
            "Barangay 11-B": { total: 2152, muslim: Math.round(2152*0.10) },
            "Barangay 12-B": { total: 1154, muslim: Math.round(1154*0.10) },
            "Barangay 13-B": { total: 366, muslim: Math.round(366*0.10) },
            "Barangay 14-B": { total: 1854, muslim: Math.round(1854*0.10) },
            "Barangay 15-B": { total: 2603, muslim: Math.round(2603*0.10) },
            "Barangay 16-B": { total: 441, muslim: Math.round(441*0.10) },
            "Barangay 17-B": { total: 906, muslim: Math.round(906*0.10) },
            "Barangay 18-B": { total: 1231, muslim: Math.round(1231*0.10) },
            "Barangay 19-B": { total: 30752, muslim: Math.round(30752*0.35) },
            "Barangay 2-A": { total: 2935, muslim: Math.round(2935*0.035) },
            "Barangay 20-B": { total: 4929, muslim: Math.round(4929*0.10) },
            "Barangay 21-C": { total: 7273, muslim: Math.round(7273*0.35) },
            "Barangay 22-C": { total: 7643, muslim: Math.round(7643*0.35) },
            "Barangay 23-C": { total: 17030, muslim: Math.round(17030*0.40) },
            "Barangay 24-C": { total: 2034, muslim: Math.round(2034*0.35) },
            "Barangay 25-C": { total: 1922, muslim: Math.round(1922*0.10) },
            "Barangay 26-C": { total: 1681, muslim: Math.round(1681*0.10) },
            "Barangay 27-C": { total: 2110, muslim: Math.round(2110*0.10) },
            "Barangay 28-C": { total: 3133, muslim: Math.round(3133*0.10) },
            "Barangay 29-C": { total: 703, muslim: Math.round(703*0.10) },
            "Barangay 3-A": { total: 407, muslim: Math.round(407*0.035) },
            "Barangay 30-C": { total: 1057, muslim: Math.round(1057*0.10) },
            "Barangay 31-D": { total: 8481, muslim: Math.round(8481*0.10) },
            "Barangay 32-D": { total: 1644, muslim: Math.round(1644*0.10) },
            "Barangay 33-D": { total: 1827, muslim: Math.round(1827*0.10) },
            "Barangay 34-D": { total: 1074, muslim: Math.round(1074*0.10) },
            "Barangay 35-D": { total: 409, muslim: Math.round(409*0.10) },
            "Barangay 36-D": { total: 1220, muslim: Math.round(1220*0.10) },
            "Barangay 37-D": { total: 5771, muslim: Math.round(5771*0.10) },
            "Barangay 38-D": { total: 1289, muslim: Math.round(1289*0.10) },
            "Barangay 39-D": { total: 4253, muslim: Math.round(4253*0.10) },
            "Barangay 4-A": { total: 1692, muslim: Math.round(1692*0.035) },
            "Barangay 40-D": { total: 2159, muslim: Math.round(2159*0.10) },
            "Barangay 5-A": { total: 11160, muslim: Math.round(11160*0.035) },
            "Barangay 6-A": { total: 2217, muslim: Math.round(2217*0.035) },
            "Barangay 7-A": { total: 3362, muslim: Math.round(3362*0.035) },
            "Barangay 8-A": { total: 15259, muslim: Math.round(15259*0.10) },
            "Barangay 9-A": { total: 6807, muslim: Math.round(6807*0.10) },
            "Bato": { total: 11930, muslim: Math.round(11930*0.035) },
            "Bayabas": { total: 3489, muslim: Math.round(3489*0.035) },
            "Biao Escuela": { total: 4263, muslim: Math.round(4263*0.035) },
            "Biao Guianga": { total: 4581, muslim: Math.round(4581*0.035) },
            "Biao Joaquin": { total: 2333, muslim: Math.round(2333*0.035) },
            "Binugao": { total: 8641, muslim: Math.round(8641*0.035) },
            "Bucana": { total: 80538, muslim: Math.round(80538*0.35) },
            "Buda": { total: 2135, muslim: Math.round(2135*0.035) },
            "Buhangin": { total: 67515, muslim: Math.round(67515*0.035) },
            "Bunawan": { total: 24073, muslim: Math.round(24073*0.035) },
            "Cabantian": { total: 50100, muslim: Math.round(50100*0.035) },
            "Cadalian": { total: 2913, muslim: Math.round(2913*0.035) },
            "Calinan": { total: 24218, muslim: Math.round(24218*0.035) },
            "Callawa": { total: 3941, muslim: Math.round(3941*0.035) },
            "Camansi": { total: 1376, muslim: Math.round(1376*0.035) },
            "Carmen": { total: 2252, muslim: Math.round(2252*0.035) },
            "Catalunan Grande": { total: 41171, muslim: Math.round(41171*0.035) },
            "Catalunan Pequeño": { total: 25762, muslim: Math.round(25762*0.035) },
            "Catigan": { total: 4021, muslim: Math.round(4021*0.035) },
            "Cawayan": { total: 3313, muslim: Math.round(3313*0.035) },
            "Centro (San Juan)": { total: 16336, muslim: Math.round(16336*0.035) },
            "Colosas": { total: 5739, muslim: Math.round(5739*0.035) },
            "Communal": { total: 16395, muslim: Math.round(16395*0.035) },
            "Crossing Bayabas": { total: 12406, muslim: Math.round(12406*0.035) },
            "Dacudao": { total: 5596, muslim: Math.round(5596*0.035) },
            "Dalag": { total: 2081, muslim: Math.round(2081*0.035) },
            "Dalagdag": { total: 970, muslim: Math.round(970*0.035) },
            "Daliao": { total: 21479, muslim: Math.round(21479*0.035) },
            "Daliaon Plantation": { total: 3912, muslim: Math.round(3912*0.035) },
            "Datu Salumay": { total: 1100, muslim: Math.round(1100*0.035) },
            "Dominga": { total: 1530, muslim: Math.round(1530*0.035) },
            "Dumoy": { total: 19636, muslim: Math.round(19636*0.035) },
            "Eden": { total: 2627, muslim: Math.round(2627*0.035) },
            "Fatima (Benowang)": { total: 3674, muslim: Math.round(3674*0.035) },
            "Gatungan": { total: 1655, muslim: Math.round(1655*0.035) },
            "Gov. Paciano Bangoy": { total: 7601, muslim: Math.round(7601*0.035) },
            "Gov. Vicente Duterte": { total: 7968, muslim: Math.round(7968*0.035) },
            "Gumalang": { total: 6104, muslim: Math.round(6104*0.035) },
            "Gumitan": { total: 2100, muslim: Math.round(2100*0.035) },
            "Ilang": { total: 26150, muslim: Math.round(26150*0.035) },
            "Inayangan": { total: 5003, muslim: Math.round(5003*0.035) },
            "Indangan": { total: 24879, muslim: Math.round(24879*0.035) },
            "Kap. Tomas Monteverde Sr.": { total: 5258, muslim: Math.round(5258*0.035) },
            "Kilate": { total: 1414, muslim: Math.round(1414*0.035) },
            "Lacson": { total: 6549, muslim: Math.round(6549*0.035) },
            "Lamanan": { total: 4604, muslim: Math.round(4604*0.035) },
            "Lampianao": { total: 1159, muslim: Math.round(1159*0.035) },
            "Langub": { total: 4334, muslim: Math.round(4334*0.035) },
            "Lapu-lapu": { total: 13205, muslim: Math.round(13205*0.035) },
            "Leon Garcia Sr.": { total: 12952, muslim: Math.round(12952*0.035) },
            "Lizada": { total: 23717, muslim: Math.round(23717*0.035) },
            "Los Amigos": { total: 11694, muslim: Math.round(11694*0.035) },
            "Lubogan": { total: 13849, muslim: Math.round(13849*0.035) },
            "Lumiad": { total: 1568, muslim: Math.round(1568*0.035) },
            "Ma-a": { total: 58874, muslim: Math.round(58874*0.035) },
            "Mabuhay": { total: 1534, muslim: Math.round(1534*0.035) },
            "Magsaysay": { total: 3122, muslim: Math.round(3122*0.035) },
            "Magtuod": { total: 4802, muslim: Math.round(4802*0.035) },
            "Mahayag": { total: 7078, muslim: Math.round(7078*0.035) },
            "Malabog": { total: 13693, muslim: Math.round(13693*0.035) },
            "Malagos": { total: 8160, muslim: Math.round(8160*0.035) },
            "Malamba": { total: 6176, muslim: Math.round(6176*0.035) },
            "Manambulan": { total: 3493, muslim: Math.round(3493*0.035) },
            "Mandug": { total: 15296, muslim: Math.round(15296*0.035) },
            "Manuel Guianga": { total: 5605, muslim: Math.round(5605*0.035) },
            "Mapula": { total: 3970, muslim: Math.round(3970*0.035) },
            "Marapangi": { total: 7961, muslim: Math.round(7961*0.035) },
            "Marilog": { total: 19433, muslim: Math.round(19433*0.035) },
            "Matina Aplaya": { total: 32396, muslim: Math.round(32396*0.035) },
            "Matina Biao": { total: 2205, muslim: Math.round(2205*0.035) },
            "Matina Crossing": { total: 41407, muslim: Math.round(41407*0.035) },
            "Matina Pangi": { total: 18919, muslim: Math.round(18919*0.035) },
            "Megkawayan": { total: 3007, muslim: Math.round(3007*0.035) },
            "Mintal": { total: 18677, muslim: Math.round(18677*0.035) },
            "Mudiang": { total: 4115, muslim: Math.round(4115*0.035) },
            "Mulig": { total: 6888, muslim: Math.round(6888*0.035) },
            "New Carmen": { total: 2993, muslim: Math.round(2993*0.035) },
            "New Valencia": { total: 2278, muslim: Math.round(2278*0.035) },
            "Pampanga": { total: 15616, muslim: Math.round(15616*0.035) },
            "Panacan": { total: 40860, muslim: Math.round(40860*0.035) },
            "Panalum": { total: 1886, muslim: Math.round(1886*0.035) },
            "Pandaitan": { total: 4257, muslim: Math.round(4257*0.035) },
            "Pangyan": { total: 2340, muslim: Math.round(2340*0.035) },
            "Paquibato": { total: 2272, muslim: Math.round(2272*0.035) },
            "Paradise Embak": { total: 3049, muslim: Math.round(3049*0.035) },
            "Rafael Castillo": { total: 5943, muslim: Math.round(5943*0.035) },
            "Riverside": { total: 6010, muslim: Math.round(6010*0.035) },
            "Salapawan": { total: 2498, muslim: Math.round(2498*0.035) },
            "Salaysay": { total: 6667, muslim: Math.round(6667*0.035) },
            "Saloy": { total: 2190, muslim: Math.round(2190*0.035) },
            "San Antonio": { total: 12190, muslim: Math.round(12190*0.035) },
            "San Isidro (Licanan)": { total: 6986, muslim: Math.round(6986*0.035) },
            "Santo Niño": { total: 20934, muslim: Math.round(20934*0.035) },
            "Sasa": { total: 54862, muslim: Math.round(54862*0.035) },
            "Sibulan": { total: 2481, muslim: Math.round(2481*0.035) },
            "Sirawan": { total: 8306, muslim: Math.round(8306*0.035) },
            "Sirib": { total: 5993, muslim: Math.round(5993*0.035) },
            "Suawan (Tuli)": { total: 5341, muslim: Math.round(5341*0.035) },
            "Subasta": { total: 5245, muslim: Math.round(5245*0.035) },
            "Sumimao": { total: 1641, muslim: Math.round(1641*0.035) },
            "Tacunan": { total: 13415, muslim: Math.round(13415*0.035) },
            "Tagakpan": { total: 4955, muslim: Math.round(4955*0.035) },
            "Tagluno": { total: 1695, muslim: Math.round(1695*0.035) },
            "Tagurano": { total: 1338, muslim: Math.round(1338*0.035) },
            "Talandang": { total: 3750, muslim: Math.round(3750*0.035) },
            "Talomo": { total: 61698, muslim: Math.round(61698*0.035) },
            "Talomo River": { total: 8604, muslim: Math.round(8604*0.035) },
            "Tamayong": { total: 6916, muslim: Math.round(6916*0.035) },
            "Tambobong": { total: 6259, muslim: Math.round(6259*0.035) },
            "Tamugan": { total: 9009, muslim: Math.round(9009*0.035) },
            "Tapak": { total: 7065, muslim: Math.round(7065*0.035) },
            "Tawan-Tawan": { total: 4632, muslim: Math.round(4632*0.035) },
            "Tibuloy": { total: 2432, muslim: Math.round(2432*0.035) },
            "Tibungco": { total: 49636, muslim: Math.round(49636*0.035) },
            "Tigatto": { total: 24795, muslim: Math.round(24795*0.035) },
            "Toril": { total: 12393, muslim: Math.round(12393*0.035) },
            "Tugbok": { total: 21927, muslim: Math.round(21927*0.035) },
            "Tungakalan": { total: 3260, muslim: Math.round(3260*0.035) },
            "Ubalde": { total: 2417, muslim: Math.round(2417*0.035) },
            "Ula": { total: 7003, muslim: Math.round(7003*0.035) },
            "Vicente Hizon Sr.": { total: 11219, muslim: Math.round(11219*0.035) },
            "Waan": { total: 4500, muslim: Math.round(4500*0.035) },
            "Wangan": { total: 6905, muslim: Math.round(6905*0.035) },
            "Wilfredo Aquino": { total: 8064, muslim: Math.round(8064*0.035) },
            "Wines": { total: 3798, muslim: Math.round(3798*0.035) }
          };

          // Populate barangay dropdown
          document.addEventListener('DOMContentLoaded', function() {
            var barangaySelect = document.getElementById('barangaySelect');
            if (barangaySelect) {
              // Dynamically add all barangay options
              Object.keys(barangayData).forEach(function(brgy) {
                var opt = document.createElement('option');
                opt.value = brgy;
                opt.textContent = brgy;
                barangaySelect.appendChild(opt);
              });
              barangaySelect.addEventListener('change', function() {
                const val = this.value;
                if (barangayData[val]) {
                  const { total, muslim } = barangayData[val];
                  const percent = (muslim / total) * 100;
                  document.getElementById('local-demand').textContent = Math.round(percent) + '%';
                  document.getElementById('localDemandResult').innerHTML =
                    `Muslim Population: <b>${muslim.toLocaleString()}</b><br>` +
                    `Total Population: <b>${total.toLocaleString()}</b><br>` +
                    `Local Demand: <b>${percent.toFixed(2)}%</b>`;
                  updateOverview();
                } else {
                  document.getElementById('local-demand').textContent = '0%';
                  document.getElementById('localDemandResult').innerHTML = '';
                  updateOverview();
                }
              });
            }
          });
        </script>
        <div class="section-title mb-3"><span style="color:#64748b;">&#128295;</span> Business Tools</div>
        <div class="d-grid gap-3 mb-2">
          <button class="btn btn-success btn-lg d-flex flex-column align-items-start justify-content-center" style="text-align:left;" data-bs-toggle="modal" data-bs-target="#revenueCalculatorModal">
            <span class="fw-semibold"><span class="me-2">&#128200;</span>Revenue Calculator</span>
            <span class="small">Try now</span>
          </button>
          <a href="#" id="marketInsightsBtn" class="btn btn-primary btn-lg d-flex flex-column align-items-start justify-content-center position-relative" style="text-align:left;">
            <span class="fw-semibold"><span class="me-2">&#128202;</span>Market Insights <span class="ms-2" style="color:#facc15;font-size:1.2em;vertical-align:middle;">&#11088;</span></span>
            <span class="small">View Report</span>
          </a>
          <a href="halal_starter_pack.php" class="btn btn-warning btn-lg d-flex flex-column align-items-start justify-content-center" style="text-align:left; color:#fff;">
            <span class="fw-semibold"><span class="me-2">&#128221;</span>Certification Guide</span>
            <span class="small">Get Started</span>
          </a>
        </div>
        <!-- Revenue Calculator Modal -->
        <div class="modal fade" id="revenueCalculatorModal" tabindex="-1" aria-labelledby="revenueCalculatorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="revenueCalculatorModalLabel">Revenue Calculator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form onsubmit="calculateRevenue(event)">
                  <div class="calc-label">Average Daily Customers</div>
                  <input type="number" id="customers" class="form-control mb-2" min="0" placeholder="e.g. 50" required>
                  <div class="calc-label">Average Spend per Customer (₱)</div>
                  <input type="number" id="spend" class="form-control mb-2" min="0" step="0.01" placeholder="e.g. 150.00" required>
                  <div class="calc-label">Days Open per Month</div>
                  <input type="number" id="days" class="form-control mb-2" min="0" max="31" placeholder="e.g. 26" required>
                  <button type="submit" class="btn btn-success w-100">Calculate Revenue</button>
                </form>
                <div id="result" class="calc-result mt-3"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Premium Modal -->
        <div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="premiumModalLabel">Unlock Premium Features</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3 text-center">
                  <span style="font-size:2.2em;color:#facc15;">&#11088;</span>
                  <div class="fw-bold mt-2 mb-2">Premium Market Insights</div>
                  <div class="text-muted mb-3">Upgrade to access advanced analytics and business tools:</div>
                  <ul class="text-start mb-3" style="max-width:340px;margin:0 auto;">
                    <li><b>Revenue Projection</b> – Forecast your business growth</li>
                    <li><b>Demand Analysis</b> – Deep dive into local halal demand</li>
                    <li><b>Growth Factors</b> – Identify key drivers for your market</li>
                  </ul>
                  <button class="btn btn-warning w-100 fw-bold" style="color:#fff;">Unlock Premium</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          function calculateRevenue(e) {
            e.preventDefault();
            var customers = parseFloat(document.getElementById('customers').value) || 0;
            var spend = parseFloat(document.getElementById('spend').value) || 0;
            var days = parseFloat(document.getElementById('days').value) || 0;
            var revenue = customers * spend * days;
            document.getElementById('result').innerHTML =
              'Estimated Monthly Revenue: <br><span style="font-size:1.3em;">₱' + revenue.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) + '</span>';
          }
          document.getElementById('marketInsightsBtn').addEventListener('click', function(e) {
            e.preventDefault();
            var modal = new bootstrap.Modal(document.getElementById('premiumModal'));
            modal.show();
          });
        </script>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // jQuery Mobile initialization
  $(document).ready(function() {
    // Initialize jQuery Mobile
    $.mobile.initializePage();
    
    // Enhanced mobile interactions
    $('.btn, button').on('touchstart', function() {
      $(this).addClass('ui-btn-active');
    }).on('touchend', function() {
      $(this).removeClass('ui-btn-active');
    });
    
    // Mobile-friendly form handling
    $('input, select').on('focus', function() {
      $(this).addClass('ui-focus');
    }).on('blur', function() {
      $(this).removeClass('ui-focus');
    });
  });
</script>
</html> 