<?php include VIEWS . '/layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

<style>
/* ── Reset & Base ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --brand:       #5b4cf5;
  --brand-light: #ede9fe;
  --brand-dark:  #3d31d4;
  --green:       #059669;
  --green-bg:    #d1fae5;
  --red:         #dc2626;
  --red-bg:      #fee2e2;
  --amber:       #d97706;
  --amber-bg:    #fef3c7;
  --surface:     #ffffff;
  --page:        #f4f3ff;
  --border:      #e8e5ff;
  --text-1:      #18181b;
  --text-2:      #52525b;
  --text-3:      #a1a1aa;
  --radius-sm:   8px;
  --radius:      14px;
  --radius-lg:   20px;
  --shadow-sm:   0 1px 3px rgba(91,76,245,.06), 0 1px 2px rgba(0,0,0,.04);
  --shadow:      0 4px 16px rgba(91,76,245,.10), 0 1px 4px rgba(0,0,0,.04);
  --shadow-lg:   0 8px 32px rgba(91,76,245,.14);
}

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--page);
  color: var(--text-1);
  -webkit-font-smoothing: antialiased;
}

/* ── Layout ── */
.rpt {
  max-width: 800px;
  margin: 0 auto;
  padding: 1rem;
}
@media (min-width: 640px) { .rpt { padding: 1.5rem; } }
@media (min-width: 768px) { .rpt { padding: 2rem; } }

/* ── Hero ── */
.hero {
  background: linear-gradient(135deg, var(--brand) 0%, #7c3aed 60%, #a855f7 100%);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  margin-bottom: 1.25rem;
  position: relative;
  overflow: hidden;
  color: #fff;
}
.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  pointer-events: none;
}
.hero-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
  margin-bottom: 1.25rem;
  position: relative;
}
.hero-icon {
  width: 48px; height: 48px;
  background: rgba(255,255,255,.18);
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
}
.hero-title {
  font-family: 'Sora', sans-serif;
  font-size: clamp(1.2rem, 4vw, 1.6rem);
  font-weight: 800;
  line-height: 1.2;
  flex: 1;
}
.hero-period {
  background: rgba(255,255,255,.2);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,.25);
  border-radius: 100px;
  padding: .35rem .9rem;
  font-size: .8rem;
  font-weight: 600;
  white-space: nowrap;
  align-self: flex-start;
}
.hero-nav {
  display: flex;
  align-items: center;
  gap: .5rem;
  position: relative;
}
.hero-nav button {
  width: 36px; height: 36px;
  border-radius: 50%;
  border: none;
  background: rgba(255,255,255,.2);
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background .2s;
}
.hero-nav button:hover { background: rgba(255,255,255,.35); }
.hero-nav .period-label {
  font-size: .875rem;
  font-weight: 600;
  min-width: 140px;
  text-align: center;
}

/* ── Summary chips ── */
.summary-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: .75rem;
  margin-bottom: 1.25rem;
}
.chip {
  background: var(--surface);
  border-radius: var(--radius);
  padding: 1rem 1rem;
  border: 1px solid var(--border);
  box-shadow: var(--shadow-sm);
  display: flex;
  flex-direction: column;
  gap: .25rem;
}
.chip-label {
  font-size: .7rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .6px;
  color: var(--text-3);
}
.chip-val {
  font-family: 'Sora', sans-serif;
  font-size: clamp(.9rem, 2.5vw, 1.25rem);
  font-weight: 800;
  line-height: 1.1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.chip-val.green  { color: var(--green); }
.chip-val.red    { color: var(--red);   }
.chip-val.brand  { color: var(--brand); }
.chip-diff {
  font-size: .7rem;
  color: var(--text-3);
  margin-top: .1rem;
}

/* ── Card genérico ── */
.card {
  background: var(--surface);
  border-radius: var(--radius);
  border: 1px solid var(--border);
  box-shadow: var(--shadow-sm);
  padding: 1.25rem;
  margin-bottom: 1rem;
}
.card-title {
  font-family: 'Sora', sans-serif;
  font-size: .75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .8px;
  color: var(--text-3);
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: .4rem;
}

/* ── Categorias ── */
.cat-list { display: flex; flex-direction: column; gap: .5rem; }
.cat-row {
  display: grid;
  grid-template-columns: 28px 1fr auto auto;
  align-items: center;
  gap: .6rem;
  padding: .6rem .75rem;
  border-radius: var(--radius-sm);
  background: #fafaf9;
  transition: background .15s;
}
.cat-row:hover { background: #f4f3ff; }
.cat-dot {
  width: 28px; height: 28px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
}
.cat-info { min-width: 0; }
.cat-name {
  font-size: .85rem;
  font-weight: 600;
  color: var(--text-1);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.cat-progress {
  height: 4px;
  background: var(--border);
  border-radius: 2px;
  margin-top: 4px;
  overflow: hidden;
}
.cat-fill {
  height: 100%;
  border-radius: 2px;
  transition: width .6s cubic-bezier(.4,0,.2,1);
}
.cat-pct {
  font-size: .75rem;
  color: var(--text-3);
  font-weight: 500;
  min-width: 34px;
  text-align: right;
}
.cat-amount {
  font-size: .85rem;
  font-weight: 700;
  color: var(--red);
  min-width: 80px;
  text-align: right;
}

/* ── Análise IA ── */
.ai-card {
  background: var(--surface);
  border-radius: var(--radius-lg);
  border: 1.5px solid var(--brand-light);
  box-shadow: var(--shadow);
  overflow: hidden;
  margin-bottom: 1rem;
}
.ai-head {
  background: linear-gradient(135deg, var(--brand) 0%, #7c3aed 100%);
  padding: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: .75rem;
}
.ai-head-left {
  display: flex;
  align-items: center;
  gap: .6rem;
  color: #fff;
}
.ai-head-left span { font-size: 20px; }
.ai-head-left h2 {
  font-family: 'Sora', sans-serif;
  font-size: 1rem;
  font-weight: 700;
  color: #fff;
}
.badge-ia {
  background: rgba(255,255,255,.25);
  border: 1px solid rgba(255,255,255,.4);
  color: #fff;
  font-size: .65rem;
  font-weight: 700;
  padding: .2rem .55rem;
  border-radius: 100px;
  letter-spacing: .5px;
}
.btn-ai {
  background: rgba(255,255,255,.15);
  border: 1.5px solid rgba(255,255,255,.4);
  color: #fff;
  padding: .55rem 1.1rem;
  border-radius: 100px;
  font-size: .82rem;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: .4rem;
  backdrop-filter: blur(4px);
  transition: background .2s, transform .1s;
  white-space: nowrap;
}
.btn-ai:hover:not(:disabled) { background: rgba(255,255,255,.28); }
.btn-ai:active { transform: scale(.97); }
.btn-ai:disabled { opacity: .55; cursor: not-allowed; transform: none; }
@media (max-width: 480px) { .btn-ai { width: 100%; justify-content: center; } }

.ai-body { padding: 1.25rem; min-height: 100px; }

/* Placeholder */
.ai-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .5rem;
  padding: 1.5rem 1rem;
  text-align: center;
  color: var(--text-3);
}
.ai-placeholder .ph-icon { font-size: 36px; opacity: .5; }
.ai-placeholder p { font-size: .875rem; line-height: 1.6; }

/* Loading dots */
.ai-dots {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 1.25rem 0;
  justify-content: center;
}
.ai-dots span {
  width: 8px; height: 8px;
  background: var(--brand);
  border-radius: 50%;
  animation: dot-bounce .9s ease-in-out infinite;
}
.ai-dots span:nth-child(2) { animation-delay: .15s; }
.ai-dots span:nth-child(3) { animation-delay: .3s; }
@keyframes dot-bounce {
  0%,80%,100% { transform: scale(0.7); opacity: .5; }
  40%         { transform: scale(1.1); opacity: 1; }
}

/* Conteúdo IA renderizado */
.ai-rendered { color: var(--text-1); font-size: .9rem; line-height: 1.8; }

/* Bloco de seção da análise */
.ai-section-block {
  margin-bottom: 1.25rem;
  padding: 1rem;
  border-radius: var(--radius);
  border-left: 3px solid var(--brand);
  background: var(--page);
}
.ai-section-block:last-child { margin-bottom: 0; }

.ai-section-title {
  font-family: 'Sora', sans-serif;
  font-size: .88rem;
  font-weight: 700;
  color: var(--text-1);
  display: flex;
  align-items: center;
  gap: .4rem;
  margin-bottom: .6rem;
}
.ai-section-body {
  font-size: .875rem;
  color: var(--text-2);
  line-height: 1.75;
}
.ai-section-body p { margin-bottom: .5rem; }
.ai-section-body p:last-child { margin-bottom: 0; }
.ai-section-body ul {
  margin: .25rem 0 .25rem 1.1rem;
}
.ai-section-body li { margin-bottom: .35rem; }
.ai-section-body strong { color: var(--text-1); font-weight: 600; }

/* Cor da borda por tipo de seção */
.ai-section-block.alert   { border-left-color: var(--amber); background: #fffbeb; }
.ai-section-block.tip     { border-left-color: var(--green); background: #f0fdf4; }
.ai-section-block.goal    { border-left-color: var(--brand); background: var(--page); }
.ai-section-block.good    { border-left-color: #06b6d4;     background: #ecfeff; }

/* Streaming cursor */
.ai-cursor {
  display: inline-block;
  width: 2px; height: 1em;
  background: var(--brand);
  margin-left: 2px;
  vertical-align: text-bottom;
  animation: blink .65s step-end infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

/* ── Botões de ação ── */
.action-row {
  display: flex;
  gap: .75rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}
.btn-action {
  flex: 1;
  min-width: 130px;
  padding: .7rem 1rem;
  border: none;
  border-radius: var(--radius-sm);
  font-size: .85rem;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  transition: filter .2s, transform .1s;
  letter-spacing: .2px;
}
.btn-action:hover  { filter: brightness(1.08); }
.btn-action:active { transform: scale(.97); }
.btn-print    { background: #d1fae5; color: #065f46; }
.btn-download { background: #dbeafe; color: #1e40af; }

/* ── Responsive tweaks ── */
@media (max-width: 480px) {
  .summary-row { grid-template-columns: 1fr 1fr; }
  .summary-row .chip:last-child { grid-column: 1 / -1; }
  .cat-row { grid-template-columns: 24px 1fr auto; }
  .cat-amount { display: none; }
  .cat-name::after { content: attr(data-amount); display: block; font-weight: 700; color: var(--red); font-size: .78rem; margin-top: 1px; }
}
@media print {
  body { background: #fff; }
  .btn-ai, .action-row { display: none; }
  .ai-card { box-shadow: none; border: 1px solid #e5e7eb; }
}
</style>

<div class="rpt">

  <!-- Hero -->
  <div class="hero">
    <div class="hero-top">
      <div style="display:flex;align-items:center;gap:.75rem;flex:1;min-width:0">
        <div class="hero-icon">📊</div>
        <div>
          <div class="hero-title">Relatório Financeiro</div>
          <div style="font-size:.85rem;opacity:.85;margin-top:.15rem;">Análise inteligente dos seus gastos</div>
        </div>
      </div>
      <div class="hero-period">
        <?= $reportData['period']['monthName'] ?> <?= $reportData['period']['year'] ?>
      </div>
    </div>
  </div>

  <!-- Resumo -->
  <div class="summary-row">
    <div class="chip">
      <div class="chip-label">Receitas</div>
      <div class="chip-val green">R$&nbsp;<?= number_format($reportData['summary']['total_income'], 2, ',', '.') ?></div>
    </div>
    <div class="chip">
      <div class="chip-label">Despesas</div>
      <div class="chip-val red">R$&nbsp;<?= number_format($reportData['summary']['total_expense'], 2, ',', '.') ?></div>
    </div>
    <?php $saldo = $reportData['summary']['balance']; ?>
    <div class="chip">
      <div class="chip-label">Saldo</div>
      <div class="chip-val <?= $saldo >= 0 ? 'green' : 'red' ?>">
        R$&nbsp;<?= number_format(abs($saldo), 2, ',', '.') ?>
      </div>
      <div class="chip-diff"><?= $saldo >= 0 ? '▲ positivo' : '▼ negativo' ?></div>
    </div>
  </div>

  <!-- Categorias -->
  <?php if (!empty($reportData['categories'])): ?>
  <div class="card">
    <div class="card-title">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/></svg>
      Gastos por categoria
    </div>
    <div class="cat-list">
      <?php
        $totalGastos = array_sum(array_column($reportData['categories'], 'total'));
        foreach ($reportData['categories'] as $cat):
          $pct = $totalGastos > 0 ? round(($cat['total'] / $totalGastos) * 100, 1) : 0;
          $amtFmt = 'R$ ' . number_format($cat['total'], 2, ',', '.');
      ?>
      <div class="cat-row">
        <div class="cat-dot" style="background:<?= $cat['color'] ?>22">
          <?= htmlspecialchars($cat['icon'] ?? '📦') ?>
        </div>
        <div class="cat-info">
          <div class="cat-name" data-amount="<?= $amtFmt ?>"><?= htmlspecialchars($cat['category_name']) ?></div>
          <div class="cat-progress">
            <div class="cat-fill" style="width:<?= $pct ?>%;background:<?= $cat['color'] ?>"></div>
          </div>
        </div>
        <div class="cat-pct"><?= $pct ?>%</div>
        <div class="cat-amount"><?= $amtFmt ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Análise IA -->
  <div class="ai-card">
    <div class="ai-head">
      <div class="ai-head-left">
        <span>✨</span>
        <h2>Análise Inteligente</h2>
        <span class="badge-ia">IA</span>
      </div>
      <button class="btn-ai" id="btnGerarIA" onclick="gerarAnaliseIA()">
        <span>🤖</span> Analisar gastos
      </button>
    </div>
    <div class="ai-body" id="aiBody">
      <div class="ai-placeholder">
        <div class="ph-icon">🔍</div>
        <p>Clique no botão para receber uma análise personalizada dos seus gastos com dicas práticas de economia.</p>
      </div>
    </div>
  </div>

  <!-- Ações -->
  <div class="action-row">
    <button class="btn-action btn-print" onclick="window.print()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Imprimir
    </button>
    <button class="btn-action btn-download" onclick="salvarPDF()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Salvar PDF
    </button>
  </div>

</div><!-- /rpt -->

<script>
/* ── Parser de markdown simples → HTML estruturado ── */
function parseAnalise(texto) {
  // Remove separadores desnecessários (-- ou --- ou ***)
  texto = texto.replace(/^[-*]{2,}\s*$/gm, '');
  // Remove linhas em branco excessivas
  texto = texto.replace(/\n{3,}/g, '\n\n').trim();

  const linhas  = texto.split('\n');
  const secoes  = [];
  let secAtual  = null;

  const tiposPorEmoji = {
    '⚠': 'alert', '🚨': 'alert', '🔴': 'alert',
    '💡': 'tip',   '✅': 'tip',   '💰': 'tip',
    '🎯': 'goal',  '📌': 'goal',  '📋': 'goal',
    '💪': 'good',  '👍': 'good',  '🌟': 'good', '⭐': 'good',
  };

  function detectTipo(titulo) {
    for (const [emoji, tipo] of Object.entries(tiposPorEmoji)) {
      if (titulo.includes(emoji)) return tipo;
    }
    return 'goal';
  }

  linhas.forEach(raw => {
    const l = raw.trim();
    // Cabeçalho h2 / h3
    const h = l.match(/^#{1,3}\s+(.+)/);
    if (h) {
      if (secAtual) secoes.push(secAtual);
      secAtual = { titulo: h[1], tipo: detectTipo(h[1]), corpo: [] };
      return;
    }
    if (!secAtual) {
      secAtual = { titulo: null, tipo: 'goal', corpo: [] };
    }
    secAtual.corpo.push(l);
  });
  if (secAtual) secoes.push(secAtual);

  // Converte para HTML
  return secoes.map(sec => {
    const bodyHTML = renderBody(sec.corpo);
    if (!bodyHTML.trim()) return '';
    const tituloHTML = sec.titulo
      ? `<div class="ai-section-title">${inlineFormat(sec.titulo)}</div>`
      : '';
    return `
      <div class="ai-section-block ${sec.tipo}">
        ${tituloHTML}
        <div class="ai-section-body">${bodyHTML}</div>
      </div>`;
  }).join('');
}

function renderBody(linhas) {
  let html = '';
  let inUl = false;

  linhas.forEach(l => {
    if (!l) {
      if (inUl) { html += '</ul>'; inUl = false; }
      return;
    }
    const isBullet = /^[-*•]\s+(.+)/.exec(l);
    if (isBullet) {
      if (!inUl) { html += '<ul>'; inUl = true; }
      html += `<li>${inlineFormat(isBullet[1])}</li>`;
    } else {
      if (inUl) { html += '</ul>'; inUl = false; }
      html += `<p>${inlineFormat(l)}</p>`;
    }
  });
  if (inUl) html += '</ul>';
  return html;
}

function inlineFormat(t) {
  return t
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
    .replace(/\*(.*?)\*/g,     '<em>$1</em>');
}

/* ── Chamada à API ── */
async function gerarAnaliseIA() {
  const btn  = document.getElementById('btnGerarIA');
  const body = document.getElementById('aiBody');

  btn.disabled = true;
  btn.innerHTML = '<span>⏳</span> Analisando...';

  body.innerHTML = `
    <div class="ai-dots">
      <span></span><span></span><span></span>
    </div>
    <p style="text-align:center;font-size:.82rem;color:var(--text-3);padding-bottom:1rem">
      Analisando seus gastos…
    </p>`;

  try {
    const fd = new FormData();
    fd.append('month', <?= (int)$month ?>);
    fd.append('year',  <?= (int)$year ?>);

    const res  = await fetch('/relatorios/analyze', { method: 'POST', body: fd });
    const data = await res.json();

    if (!data.success) throw new Error(data.message || 'Erro desconhecido');

    body.innerHTML = `<div class="ai-rendered">${parseAnalise(data.analysis)}</div>`;

  } catch (err) {
    body.innerHTML = `
      <div class="ai-placeholder">
        <div class="ph-icon">⚠️</div>
        <p style="color:var(--red);font-weight:600">Não foi possível gerar a análise</p>
        <p>${err.message}</p>
      </div>`;
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<span>🔄</span> Analisar novamente';
  }
}

function salvarPDF() {
  window.print();
}
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>