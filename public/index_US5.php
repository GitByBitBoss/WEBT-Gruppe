<?php
declare(strict_types=1);
session_start();

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['user']['username'];

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>DriveWell – Theoriefragen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
    :root{
    --bg:#f6f7fb; --panel:#ffffff; --text:#1f2937; --muted:#6b7280;
    --brand:#2563eb; --ok:#16a34a; --border:#e5e7eb;
    --radius:14px; --shadow:0 10px 28px rgba(2,6,23,.06); --focus:2px solid #2563eb;
    }
    *{box-sizing:border-box}
    html:focus-within{scroll-behavior:smooth}
    body{margin:0;background:var(--bg);color:var(--text);font:16px/1.55 system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif}
    a{color:var(--brand);text-decoration:none}
    a:hover{text-decoration:underline}
    .skip{position:absolute;left:-9999px;top:auto}
    .skip:focus{left:16px;top:16px;background:#fff;border:2px solid var(--brand);padding:8px 10px;border-radius:10px;z-index:10}
    .wrap{max-width:1024px;margin:28px auto;padding:0 16px}

    /* Header: sichtbarer Systemstatus */
    .header{
    background:linear-gradient(96deg,#0ea5e9,#2563eb);color:#fff;border-radius:18px;padding:18px 20px;
    box-shadow:var(--shadow);display:flex;align-items:center;gap:12px;justify-content:space-between
    }
    .h-left{display:flex;align-items:center;gap:12px}
    .h-title{margin:0;font-size:clamp(20px,2.2vw,28px)}
    .h-sub{opacity:.95;font-size:14px}
    .status{font-size:13px;opacity:.95}

    /* Toolbar: Kontrolle & Freiheit */
    .toolbar{display:flex;gap:10px;flex-wrap:wrap;margin:16px 2px}
    .btn{
    border:1px solid var(--border);background:#fff;border-radius:10px;padding:9px 12px;font-weight:600;cursor:pointer;
    box-shadow:0 2px 10px rgba(0,0,0,.04);transition:transform .06s ease, box-shadow .15s ease
    }
    .btn:hover{box-shadow:0 6px 18px rgba(0,0,0,.08)}
    .btn:active{transform:translateY(1px)}
    .btn[aria-pressed="true"]{outline:var(--focus)}

    /* Panel */
    .panel{background:var(--panel);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);padding:18px}

    /* Kurskopf */
    .meta{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:12px}
    .badge{
    background:#eef2ff;color:#1d4ed8;border:1px solid #dbe3ff;padding:4px 8px;border-radius:999px;
    font-size:12px;font-weight:700
    }
    .kpi{color:var(--muted);font-size:14px}

    /* Suche/Filter */
    .search{display:flex;gap:10px;align-items:center;margin:8px 0 14px}
    .input{
    width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:10px;background:#fff;
    }
    .input:focus{outline:var(--focus)}

    /* Fragenliste – Minimalismus, Erkennung statt Erinnerung */
    .q-list{display:flex;flex-direction:column;gap:10px;margin-top:6px}
    .q{
    border:1px solid var(--border);border-radius:12px;background:#fafcff;padding:12px;
    transition:max-height .2s ease, opacity .2s ease;
    }
    .q.collapsed .q-options,
    .q.collapsed .answer{display:none}
    .q header{display:flex;justify-content:space-between;gap:8px;align-items:center;margin-bottom:6px}
    .q-title{font-weight:700}
    .q-num{color:var(--muted);font-size:13px}
    .q-options{margin:8px 0 0 0;padding-left:18px}
    .q-options li{margin:2px 0}
    .answer{margin-top:8px;padding:8px 10px;border-left:4px solid var(--ok);background:#f1fbf5;border-radius:8px}
    .hidden{display:none}

    /* Hilfe */
    .help{margin-top:16px}
    .help details{border:1px solid var(--border);border-radius:10px;background:#fff}
    .help summary{list-style:none;padding:10px 12px;cursor:pointer;font-weight:700}
    .help .content{padding:0 12px 12px;color:var(--muted);font-size:14px}

    footer{margin:22px 2px 8px;color:var(--muted);font-size:14px;text-align:center}
    </style>
</head>
<body>
<a href="logout.php" style="color:#00000;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,.5);padding:8px 10px;border-radius:10px">
  Logout
</a>
<a href="#content" class="skip">Zum Inhalt springen</a>
<div class="wrap">

  <div class="header" role="banner" aria-label="Seitenkopf">
    <div class="h-left">
      <div aria-hidden="true" style="font-size:22px">🚗</div>
      <div>
        <h1 class="h-title"> Hallo <?php echo $username?>! DriveWell – Theoriefragen</h1>
        <div class="h-sub">Ein Kurs, klare Übersicht</div>
      </div>
    </div>
    <div class="status" aria-live="polite">Status: geladen um <span id="loadedAt">–:–</span> Uhr</div>
  </div>

  <div id="courseRoot"></div>

  <section class="help">
    <details>
      <summary>Hilfe & Shortcuts</summary>
      <div class="content">
        <ul>
          <li><strong>/</strong> – Suche fokussieren</li>
          <li><strong>A</strong> – Lösungen ein-/ausblenden</li>
          <li><strong>O</strong> – Alle öffnen, <strong>S</strong> – Alle schließen</li>
        </ul>
        <p>Hinweis: Aktionen sind reversibel (erneut klicken), klare Labels und konsistentes Layout erleichtern die Orientierung.</p>
      </div>
    </details>
  </section>

  <footer>&copy; <span id="year"></span> DriveWell</footer>
</div>

<script>
// =====================
// API-only Variante (keine Klassen im Frontend)
// =====================

// Konfiguration: relative Pfade zu euren PHP-APIs
const API = {
  courses: 'getCourses.php',           // liefert: [ { id, name, vehicleType, questions:[...] }, ... ]
  course:  (id)=> `getCourse.php?id=${encodeURIComponent(id)}` // liefert: { id, name, vehicleType, questions:[...] }
};

// Utility: HTML-escape
const esc = (s)=>{ const d=document.createElement('div'); d.textContent=String(s ?? ''); return d.innerHTML; };

// UI Helfer
function setAnswers(visible){
  document.querySelectorAll('.answer').forEach(a => a.classList.toggle('hidden', !visible));
  const toggleBtn = document.getElementById('toggleAnswers');
  if(toggleBtn){
    toggleBtn.setAttribute('aria-pressed', String(visible));
    toggleBtn.textContent = visible ? 'Lösungen verbergen' : 'Lösungen anzeigen';
  }
}

// Daten laden
async function fetchJSON(url){
  const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
  if(!res.ok) throw new Error(`HTTP ${res.status} bei ${url}`);
  return res.json();
}

async function loadCourse(){
  // 1) Versuche alle Kurse zu laden
  try{
    const list = await fetchJSON(API.courses);
    if(Array.isArray(list) && list.length){
      return list[0]; // wie im PHP: nur den ersten Kurs anzeigen
    }
  }catch(e){ /* fällt zurück auf Einzelkurs */ }

  // 2) Fallback: Einzelkurs (id=1)
  try{
    return await fetchJSON(API.course(1));
  }catch(e){
    console.error(e);
    return null;
  }
}

function renderCourse(course){
  const root = document.getElementById('courseRoot');
  if(!course){
    document.title = 'Kurs | DriveWell';
    root.innerHTML = `
      <div class="panel" role="alert">
        <strong>Kein Kurs gefunden.</strong>
        <div class="kpi">Bitte prüfe die API-Endpunkte (getCourses.php / getCourse.php) oder lade die Seite neu.</div>
      </div>`;
    return;
  }

  const name = course.name ?? 'Kurs';
  const vehicle = course.vehicleType ?? '';
  const questions = Array.isArray(course.questions) ? course.questions : [];
  const qCount = questions.length;

  document.title = `${name} | DriveWell`;

  root.innerHTML = `
    <nav class="toolbar" aria-label="Aktionen">
      <button class="btn" id="expand" type="button">Alle öffnen</button>
      <button class="btn" id="collapse" type="button">Alle schließen</button>
      <button class="btn" id="toggleAnswers" type="button" aria-pressed="false">Lösungen anzeigen</button>
    </nav>

    <main id="content" class="panel" role="main" aria-labelledby="course-title">
      <div class="meta">
        <h2 id="course-title" style="margin:0">${esc(name)}</h2>
        ${vehicle ? `<span class="badge" aria-label="Fahrzeugtyp">${esc(vehicle)}</span>` : ''}
        <span class="kpi"><strong>${qCount}</strong> Fragen</span>
      </div>

      <label class="search" for="q-search">
        <input id="q-search" class="input" type="search" placeholder="Fragen durchsuchen … (Taste / zum Fokussieren)" aria-label="Fragen durchsuchen" />
      </label>

      <section class="q-list" id="q-list" aria-label="Fragenliste"></section>
    </main>
  `;

  const list = document.getElementById('q-list');
  if(qCount){
    list.innerHTML = questions.map((q, i)=>{
      const text = esc(q.text ?? '');
      const opts = Array.isArray(q.options) ? q.options : [];
      const answer = esc(q.correctAnswer ?? '');
      return `
      <article class="q" data-title="${text.toLowerCase()}">
        <header>
          <div class="q-title">${text || `Frage ${i+1}`}</div>
          <div class="q-num">#${i+1}</div>
        </header>
        ${opts.length ? `<ul class="q-options">${opts.map(o=>`<li>${esc(o)}</li>`).join('')}</ul>`: ''}
        ${answer ? `<div class="answer hidden" role="note"><strong>Lösung:</strong> ${answer}</div>` : ''}
      </article>`;
    }).join('');
  } else {
    list.innerHTML = `<p class="kpi">Für diesen Kurs sind noch keine Fragen vorhanden.</p>`;
  }

  // Interaktionen
  const toggleBtn = document.getElementById('toggleAnswers');
  const expandBtn = document.getElementById('expand');
  const collapseBtn = document.getElementById('collapse');
  const search = document.getElementById('q-search');

  expandBtn?.addEventListener('click', () => {
    document.querySelectorAll('.q').forEach(el => el.classList.remove('collapsed'));
  });
  collapseBtn?.addEventListener('click', () => {
    document.querySelectorAll('.q').forEach(el => el.classList.add('collapsed'));
  });
  toggleBtn?.addEventListener('click', () => {
    const nowVisible = toggleBtn.getAttribute('aria-pressed') !== 'true';
    setAnswers(nowVisible);
  });
  search?.addEventListener('input', (e) => {
    const term = e.target.value.trim().toLowerCase();
    document.querySelectorAll('.q').forEach(card => {
      const t = card.getAttribute('data-title') || '';
      card.style.display = t.includes(term) ? '' : 'none';
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && !e.ctrlKey && !e.metaKey) {
      e.preventDefault(); search?.focus(); return;
    }
    if (e.key.toLowerCase() === 'a') { setAnswers(toggleBtn.getAttribute('aria-pressed') !== 'true'); }
    if (e.key.toLowerCase() === 'o') { document.querySelectorAll('.q').forEach(el => el.classList.remove('collapsed')); }
    if (e.key.toLowerCase() === 's') { document.querySelectorAll('.q').forEach(el => el.classList.add('collapsed')); }
  });
}

(async function init(){
  const now = new Date();
  document.getElementById('loadedAt').textContent = now.toLocaleTimeString('de-DE',{hour:'2-digit',minute:'2-digit'});
  document.getElementById('year').textContent = now.getFullYear();

  const course = await loadCourse();
  renderCourse(course);
})();
</script>
</body>
</html>
