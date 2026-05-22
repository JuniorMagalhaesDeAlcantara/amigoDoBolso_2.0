<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }

    :root {
        --primary: #667eea;
        --primary-dark: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── BASE (mobile-first) ── */
    html {
        height: -webkit-fill-available;
        overflow-x: hidden;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background: var(--gray-50);
        color: var(--gray-900);
        line-height: 1.6;
        min-height: 100vh;
        min-height: -webkit-fill-available;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

  

    /* ── WELCOME ── */
    .welcome-section {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1.125rem 1.25rem;
        border-radius: 16px;
        margin: 0.875rem 0 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: visible;
    }

    /* decoração — contida pelo overflow:hidden do pai */
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -15%;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
        /* confina o círculo visualmente sem overflow:hidden no pai */
        clip-path: inset(-100% -100% -100% -100% round 16px);
    }

    .welcome-content {
        display: flex;
        flex-direction: column;
        /* mobile: coluna */
        gap: 1rem;
        position: relative;
        z-index: 1;
    }

    .welcome-text h1 {
        font-size: 1.375rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        letter-spacing: -0.02em;
    }

    .welcome-text p {
        font-size: 0.875rem;
        opacity: 0.92;
    }

    .group-info {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: left;
        position: relative;
        z-index: 100;
        /* acima do ::before para o popover funcionar */
    }

    .group-name {
        font-size: 0.75rem;
        opacity: 0.88;
        margin-bottom: 0.375rem;
    }

    .group-code-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .group-code {
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .btn-share-trigger {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: white;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-share-trigger:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    /* ── POPOVER
       Em mobile: position:fixed posicionado via JS
       Em desktop (>=768px): position:absolute ancorado em .group-info
    ── */
    .share-popover {
        display: none;
        position: fixed;
        /* mobile default */
        width: 260px;
        background: white;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
        padding: 1.125rem;
        z-index: 9999;
        animation: popIn 0.18s ease-out;
        max-width: calc(100vw - 24px);
    }

    .share-popover.open {
        display: block;
    }

    @keyframes popIn {
        from {
            opacity: 0;
            transform: translateY(-6px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .share-popover-arrow {
        position: absolute;
        top: -6px;
        right: 20px;
        width: 12px;
        height: 12px;
        background: white;
        transform: rotate(45deg);
        border-radius: 2px;
        box-shadow: -2px -2px 4px rgba(0, 0, 0, 0.05);
    }

    .share-popover-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .share-code-display {
        background: #f3f4f6;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        text-align: center;
        font-family: 'Courier New', monospace;
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        letter-spacing: 1px;
        margin-bottom: 0.875rem;
    }

    .share-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .share-action-btn {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.625rem 0.875rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        border: none;
        width: 100%;
        font-family: inherit;
    }

    .share-action-btn.wpp {
        background: #dcfce7;
        color: #15803d;
    }

    .share-action-btn.wpp:hover {
        background: #bbf7d0;
    }

    .share-action-btn.copy {
        background: #f3f4f6;
        color: #374151;
    }

    .share-action-btn.copy:hover {
        background: #e5e7eb;
    }

    .share-action-btn.copied {
        background: #eff6ff;
        color: #1d4ed8;
    }

    /* ── SUMMARY ── */
    .summary-grid {
        display: grid;
        grid-template-columns: 1fr;
        /* mobile: 1 col */
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .summary-card {
        background: white;
        border-radius: 14px;
        padding: 0.875rem 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        border-left-width: 3px;
    }

    .summary-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .summary-card.income {
        border-left-color: var(--secondary);
    }

    .summary-card.expense {
        border-left-color: var(--danger);
    }

    .summary-card.balance {
        border-left-color: var(--info);
    }

    .card-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .card-icon {
        font-size: 1.5rem;
    }

    .card-label {
        font-size: 0.8125rem;
        color: var(--gray-500);
        font-weight: 500;
        margin-bottom: 0.375rem;
    }

    .card-value {
        font-size: 1.625rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .card-value.positive {
        color: var(--secondary);
    }

    .card-value.negative {
        color: var(--danger);
    }

    /* ── SECTIONS ── */
    .cards-section {
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .section-header h2 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ── CARTÕES DE CRÉDITO ── */
    /* ── CARTÕES DE CRÉDITO ── */
    .cards-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .credit-card-mini {
        border-radius: 18px;
        padding: 1.25rem 1.5rem;
        min-height: unset;
        /* igual ao benefício no mobile */
        aspect-ratio: unset;
        /* desliga no mobile */
        max-height: unset;
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.22),
            0 2px 8px rgba(0, 0, 0, 0.12),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 168px;
    }

    /* brilho holográfico no topo — usa ::before para não conflitar */
    .credit-card-mini::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 55%;
        background: linear-gradient(160deg,
                rgba(255, 255, 255, 0.2) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                transparent 100%);
        pointer-events: none;
        border-radius: 18px 18px 0 0;
        z-index: 1;
    }

    /* círculo decorativo — usa ::after */
    .credit-card-mini::after {
        content: '';
        position: absolute;
        top: -60%;
        right: -30%;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.07);
        pointer-events: none;
    }

    .credit-card-mini:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow:
            0 16px 48px rgba(0, 0, 0, 0.28),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* ── cores por banco ── */
    /* Nubank — roxo institucional */
    .credit-card-mini.nubank {
        background: linear-gradient(135deg, #820AD1 0%, #A020D0 100%);
    }

    /* Inter — laranja queimado real */
    .credit-card-mini.inter {
        background: linear-gradient(135deg, #E35205 0%, #FF6B00 100%);
    }

    /* C6 Bank — grafite/preto com toque dourado */
    .credit-card-mini.c6 {
        background: linear-gradient(135deg, #1A1A1A 0%, #2E2E2E 60%, #3D3020 100%);
    }

    /* Itaú — laranja+azul escuro; gradiente laranja é o mais reconhecível */
    .credit-card-mini.itau {
        background: linear-gradient(135deg, #EC7000 0%, #F07800 100%);
    }

    /* Bradesco — vermelho vivo */
    .credit-card-mini.bradesco {
        background: linear-gradient(135deg, #CC092F 0%, #E5002B 100%);
    }

    /* Santander — vermelho chama */
    .credit-card-mini.santander {
        background: linear-gradient(135deg, #CC0000 0%, #E00000 100%);
    }

    /* Banco do Brasil — amarelo ouro escuro; texto preto para contraste */
    .credit-card-mini.bb {
        background: linear-gradient(135deg, #E8B800 0%, #F5CC00 100%);
        color: #1a1a1a;
    }

    /* Caixa — azul governo */
    .credit-card-mini.caixa {
        background: linear-gradient(135deg, #005CA9 0%, #0070CC 100%);
    }

    /* PicPay — verde característico */
    .credit-card-mini.picpay {
        background: linear-gradient(135deg, #1DB954 0%, #21C25E 100%);
    }

    /* Neon — ciano/verde neon */
    .credit-card-mini.neon {
        background: linear-gradient(135deg, #00C4A0 0%, #00D9B0 100%);
    }

    /* Next — verde escuro */
    .credit-card-mini.next {
        background: linear-gradient(135deg, #007B4F 0%, #009B63 100%);
    }

    /* Original — verde médio */
    .credit-card-mini.original {
        background: linear-gradient(135deg, #007A3E 0%, #009950 100%);
    }

    /* XP — preto com dourado */
    .credit-card-mini.xp {
        background: linear-gradient(135deg, #000000 0%, #1A1A1A 70%, #2A2010 100%);
    }

    /* Sicoob — azul escuro */
    .credit-card-mini.sicoob {
        background: linear-gradient(135deg, #003F7F 0%, #0050A0 100%);
    }

    /* Outros — fallback */
    .credit-card-mini.outros {
        background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
    }

    /* chip realista */
    .card-mini-chip {
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    .mini-chip {
        width: 42px;
        height: 30px;
        background: linear-gradient(135deg, #e8c97a 0%, #c8952a 40%, #e8c97a 70%, #b8821a 100%);
        border-radius: 5px;
        position: relative;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .mini-chip::before {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        right: 4px;
        bottom: 4px;
        background:
            linear-gradient(90deg, rgba(0, 0, 0, 0.12) 1px, transparent 1px) 0 0 / 8px 100%,
            linear-gradient(0deg, rgba(0, 0, 0, 0.12) 1px, transparent 1px) 0 0 / 100% 7px;
        border-radius: 2px;
    }

    .mini-chip::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 14px;
        border: 1.5px solid rgba(0, 0, 0, 0.2);
        border-radius: 2px;
    }

    .card-mini-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        z-index: 2;
    }

    .card-mini-name {
        font-size: 1.0625rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        letter-spacing: 0.3px;
    }

    .card-mini-number {
        font-family: 'Courier New', monospace;
        font-size: 1.0625rem;
        letter-spacing: 3px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-weight: 600;
        position: relative;
        z-index: 2;
    }

    .card-mini-holder {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        letter-spacing: 1.2px;
        margin-bottom: 0.5rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        opacity: 0.92;
        position: relative;
        z-index: 2;
    }

    .card-mini-details {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.18);
        position: relative;
        z-index: 2;
    }

    .card-mini-info {
        flex: 1;
    }

    .card-mini-label {
        font-size: 0.55rem;
        opacity: 0.75;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 500;
    }

    .card-mini-value {
        font-size: 0.9375rem;
        font-weight: 700;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
    }

    /* ── BENEFÍCIOS ── */
    .benefits-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .benefit-card-mini {
        border-radius: 18px;
        padding: 1.375rem 1.5rem;
        min-height: unset;
        /* altura fixa no mobile */
        aspect-ratio: unset;
        /* desliga o ratio no mobile */
        box-shadow:
            0 8px 32px rgba(0, 0, 0, 0.18),
            0 2px 8px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 168px;
    }

    .benefit-card-mini:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow:
            0 16px 48px rgba(0, 0, 0, 0.22),
            0 4px 12px rgba(0, 0, 0, 0.12);
    }

    /* brilho topo */
    .benefit-card-mini::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(160deg,
                rgba(255, 255, 255, 0.22) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                transparent 100%);
        pointer-events: none;
        border-radius: 18px 18px 0 0;
        z-index: 1;
    }

    /* círculo decorativo */
    .benefit-card-mini::after {
        content: '';
        position: absolute;
        bottom: -40%;
        right: -20%;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    /* Swile — preto com toque índigo (identidade real da marca) */
    .benefit-card-mini.swile {
        background: linear-gradient(135deg, #0D0D0D 0%, #1A1A2E 100%);
    }

    /* Alelo — vermelho/coral */
    .benefit-card-mini.alelo {
        background: linear-gradient(135deg, #E8001C 0%, #FF1A35 100%);
    }

    /* Sodexo — azul escuro */
    .benefit-card-mini.sodexo {
        background: linear-gradient(135deg, #0033A0 0%, #0044CC 100%);
    }

    /* Ticket — azul médio/ciano */
    .benefit-card-mini.ticket {
        background: linear-gradient(135deg, #0073CF 0%, #0090E7 100%);
    }

    /* Flash — roxo/violeta */
    .benefit-card-mini.flash {
        background: linear-gradient(135deg, #5B21B6 0%, #7C3AED 100%);
    }

    /* Caju — laranja vibrante */
    .benefit-card-mini.caju {
        background: linear-gradient(135deg, #F97316 0%, #FB923C 100%);
    }

    /* Ifood Benefícios — vermelho ifood */
    .benefit-card-mini.ifood {
        background: linear-gradient(135deg, #EA1D2C 0%, #FF2D3D 100%);
    }

    /* Valer — verde */
    .benefit-card-mini.valer {
        background: linear-gradient(135deg, #1A7F37 0%, #22A84A 100%);
    }

    /* VR (genérico) — azul petróleo */
    .benefit-card-mini.vr {
        background: linear-gradient(135deg, #0F6B8E 0%, #1A8BB0 100%);
    }

    /* VA (genérico) — âmbar escuro */
    .benefit-card-mini.va {
        background: linear-gradient(135deg, #92400E 0%, #B45309 100%);
    }

    .benefit-mini-header {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        position: relative;
        z-index: 2;
    }

    .benefit-icon {
        font-size: 2rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.15);
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        flex-shrink: 0;
    }

    .benefit-mini-info h3 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .benefit-type {
        font-size: 0.7rem;
        opacity: 0.85;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .benefit-balance {
        font-size: 1rem;
        font-weight: 800;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        letter-spacing: -0.02em;
        position: relative;
        z-index: 2;
    }

    .benefit-details {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    /* ── GRÁFICOS ── */
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr;
        /* mobile: 1 col */
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        min-width: 0;
        overflow: hidden;
    }

    .chart-card h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Wrapper obrigatório para Chart.js com maintainAspectRatio:false */
    .chart-wrap {
        position: relative;
        height: 220px;
        /* fixo no mobile */
    }

    .chart-wrap canvas {
        position: absolute;
        inset: 0;
        width: 100% !important;
        height: 100% !important;
    }

    /* ── TRANSAÇÕES ── */
    .transactions-card {
        background: white;
        border-radius: 14px;
        padding: 1.125rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .card-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .transaction-item {
        display: flex;
        flex-direction: column;
        /* mobile: coluna */
        padding: 0.625rem 0.5rem;
        border-radius: 8px;
        border-bottom: 1px solid var(--gray-100);
        /* mais sutil que gray-200 */
        transition: var(--transition);
        gap: 0.5rem;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-item:hover {
        background: var(--gray-50);
        border-radius: 8px;
    }

    .transaction-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
        min-width: 0;
    }

    .transaction-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .transaction-icon.receita {
        background: rgba(16, 185, 129, 0.12);
    }

    .transaction-icon.despesa {
        background: rgba(239, 68, 68, 0.12);
    }

    .transaction-details {
        flex: 1;
        min-width: 0;
    }

    .transaction-details h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.375rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .transaction-badges {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        padding: 0.125rem 0.4rem;
        border-radius: 5px;
        font-size: 0.625rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .badge-date {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .badge-category {
        background: color-mix(in srgb, var(--cat-color) 12%, white);
        color: var(--cat-color);
    }

    .badge-payment {
        background: rgba(102, 126, 234, 0.12);
        color: var(--primary);
    }

    .badge-credit {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .badge-va,
    .badge-vr {
        background: rgba(16, 185, 129, 0.12);
        color: var(--secondary);
    }

    .badge-cash {
        background: rgba(100, 116, 139, 0.12);
        color: var(--gray-600);
    }

    .badge-recurring {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .installment-badge {
        padding: 0 0.2rem;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        font-weight: 600;
    }

    .transaction-amount {
        font-size: 1rem;
        font-weight: 700;
        white-space: nowrap;
        align-self: flex-end;
    }

    .transaction-amount.positive {
        color: var(--secondary);
    }

    .transaction-amount.negative {
        color: var(--danger);
    }

    /* ── METAS ── */
    .goals-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.875rem;
    }

    .goal-card {
        background: var(--gray-50);
        padding: 1.125rem;
        border-radius: 12px;
        transition: var(--transition);
    }

    .goal-card:hover {
        background: var(--gray-100);
    }

    .goal-card h4 {
        margin-bottom: 0.875rem;
        color: var(--gray-900);
        font-size: 0.9375rem;
        font-weight: 600;
    }

    .goal-progress {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        margin-bottom: 0.625rem;
    }

    .progress-bar {
        flex: 1;
        height: 7px;
        background: var(--gray-200);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
        transition: width 0.3s ease;
        border-radius: 4px;
    }

    .progress-text {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.8125rem;
        min-width: 42px;
    }

    .goal-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.375rem;
        font-size: 0.8125rem;
        color: var(--gray-600);
    }

    .goal-deadline {
        color: var(--gray-500);
        font-size: 0.75rem;
    }

    /* ── BUTTONS ── */
    .btn {
        padding: 0.5rem 0.875rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-link {
        background: transparent;
        color: var(--primary);
        padding: 0.5rem;
    }

    .btn-link:hover {
        background: var(--gray-100);
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--gray-400);
    }

    @media (min-width: 480px) {

        .credit-card-mini,
        .benefit-card-mini {
            height: 185px;
        }
    }

    /* ══════════════════════════════════════════
       TABLET  ≥ 640px
    ══════════════════════════════════════════ */
    @media (min-width: 640px) {
        .container {
            padding: 0 1.25rem;
        }

        .welcome-section {
            padding: 1.5rem 1.25rem;
            margin: 1.25rem 0;
        }

        .welcome-content {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-text h1 {
            font-size: 1.625rem;
        }

        .group-info {
            text-align: right;
            width: auto;
            flex-shrink: 0;
        }

        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .card-value {
            font-size: 1.625rem;
        }

        .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .benefits-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .credit-card-mini {
            aspect-ratio: 1.586;
            height: auto;
            max-height: 220px;
        }

        .benefit-card-mini {
            aspect-ratio: 1.9;
            height: auto;
        }

        .goals-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .transaction-item {
            flex-direction: row;
            align-items: center;
            padding: 0.875rem;
            gap: 1rem;
        }

        .transaction-amount {
            align-self: auto;
            font-size: 1.0625rem;
        }

        .card-header h3 {
            font-size: 1.1875rem;
        }

        .section-header h2 {
            font-size: 1.125rem;
            color: var(--gray-800);
            letter-spacing: -0.01em;
        }
    }

    /* ══════════════════════════════════════════
       DESKTOP  ≥ 1024px
    ══════════════════════════════════════════ */
    @media (min-width: 1024px) {
        .container {
            padding: 0 1.5rem;
        }

        .logo {
            height: 50px;
        }

        .navbar .container {
            padding: 0.875rem 1.5rem;
        }

        .mobile-toggle {
            display: none;
        }

        /* esconde hamburguer */
        .navbar-menu {
            display: flex;
            /* mostra menu horizontal */
            flex: 1;
            justify-content: center;
        }

        .welcome-section {
            padding: 1.75rem 1.5rem;
            margin: 1.5rem 0;
        }

        .welcome-text h1 {
            font-size: 1.75rem;
        }

        /* popover: agora pode ser absolute pois .group-info tem z-index:50 */
        .share-popover {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
        }

        .cards-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        .benefits-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }

        .credit-card-mini {
            max-height: 210px;
        }

        .benefit-card-mini {
            max-height: 200px;
        }

        .charts-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .goals-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .chart-wrap {
            height: 240px;
        }
    }

    /* ══════════════════════════════════════════
       LANDSCAPE MOBILE
    ══════════════════════════════════════════ */
    @media (max-width: 900px) and (orientation: landscape) {
        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .welcome-content {
            flex-direction: row;
            align-items: center;
        }

        .welcome-text h1 {
            font-size: 1.25rem;
        }
    }

    /* ══════════════════════════════════════════
       PWA
    ══════════════════════════════════════════ */
    @media (display-mode: standalone) {
        body {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }

        .navbar {
            padding-top: env(safe-area-inset-top);
        }
    }

    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }

    @media (prefers-contrast: high) {

        .summary-card,
        .credit-card-mini,
        .benefit-card-mini {
            border: 2px solid currentColor;
        }

        .btn-primary {
            border: 2px solid white;
        }
    }
</style>

<div class="container">
    <!-- Seção de Boas-vindas -->
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>👋 Olá, <?= explode(' ', $_SESSION['user_name'] ?? 'Usuário')[0] ?>!</h1>
                <p>Bem-vindo ao seu dashboard financeiro • <?= date('d/m/Y') ?></p>
            </div>
            <div class="group-info">
                <div class="group-name">👥 Grupo: <?= $currentGroup['name'] ?></div>
                <div class="group-code-wrapper">
                    <span class="group-code"><?= $currentGroup['invite_code'] ?></span>
                    <button class="btn-share-trigger" onclick="toggleShare(event)" title="Compartilhar">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="18" cy="5" r="3" />
                            <circle cx="6" cy="12" r="3" />
                            <circle cx="18" cy="19" r="3" />
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                        </svg>
                        Compartilhar
                    </button>

                    <div class="share-popover" id="sharePopover">
                        <div class="share-popover-arrow"></div>
                        <p class="share-popover-label">Convidar para o grupo</p>
                        <div class="share-code-display">
                            <span><?= $currentGroup['invite_code'] ?></span>
                        </div>
                        <div class="share-actions">
                            <a href="https://wa.me/?text=<?= urlencode('Entre no meu grupo no Amigo do Bolso! Use o código: ' . $currentGroup['invite_code']) ?>"
                                target="_blank" class="share-action-btn wpp">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                WhatsApp
                            </a>
                            <button onclick="copyInviteCode('<?= $currentGroup['invite_code'] ?>')" class="share-action-btn copy" id="copyBtn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                    <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                </svg>
                                <span id="copyBtnText">Copiar código</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Resumo Financeiro -->
    <div class="summary-grid">
        <div class="summary-card income">
            <div class="card-header-row">
                <div class="card-icon">📈</div>
            </div>
            <div class="card-label">Receitas do Mês</div>
            <div class="card-value positive">R$ <?= number_format($balance['total_income'] ?? 0, 2, ',', '.') ?></div>
        </div>

        <div class="summary-card expense">
            <div class="card-header-row">
                <div class="card-icon">📉</div>
            </div>
            <div class="card-label">Despesas do Mês</div>
            <div class="card-value negative">R$ <?= number_format($balance['total_expense'] ?? 0, 2, ',', '.') ?></div>
        </div>

        <div class="summary-card balance">
            <div class="card-header-row">
                <div class="card-icon">💰</div>
            </div>
            <div class="card-label">Saldo do Mês</div>
            <?php
            $saldo = ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0);
            $saldoClass = $saldo >= 0 ? 'positive' : 'negative';
            ?>
            <div class="card-value <?= $saldoClass ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></div>
        </div>


    </div>

    <!-- Cartões de Crédito -->
    <?php if (!empty($creditCards)): ?>
        <div class="cards-section">
            <div class="section-header">
                <h2>💳 Meus Cartões</h2>
                <a href="/cartoes" class="btn btn-link">Ver todos →</a>
            </div>
            <div class="cards-grid">
                <?php
                // Mapear cores por banco
                $bankClasses = [
                    'nubank' => 'nubank',
                    'inter' => 'inter',
                    'c6' => 'c6',
                    'itau' => 'itau',
                    'bradesco' => 'bradesco',
                    'santander' => 'santander',
                    'bb' => 'bb',
                    'caixa' => 'caixa',
                    'picpay' => 'picpay',
                    'neon' => 'neon',
                    'next' => 'next',
                    'original' => 'original',
                ];

                foreach (array_slice($creditCards, 0, 4) as $card):
                    $bankClass = $bankClasses[$card['bank'] ?? 'outros'] ?? 'outros';
                ?>
                    <div class="credit-card-mini <?= $bankClass ?>">
                        <div class="card-mini-chip">
                            <div class="mini-chip"></div>
                        </div>

                        <div class="card-mini-header">
                            <div>
                                <div class="card-mini-name"><?= htmlspecialchars($card['name']) ?></div>
                                <div class="card-mini-number">•••• •••• •••• <?= $card['last_digits'] ?></div>
                            </div>
                        </div>

                        <?php if (!empty($card['holder_name'])): ?>
                            <div class="card-mini-holder"><?= strtoupper(htmlspecialchars($card['holder_name'])) ?></div>
                        <?php endif; ?>

                        <div class="card-mini-details">
                            <div class="card-mini-info">
                                <div class="card-mini-label">Fatura Atual</div>
                                <div class="card-mini-value">R$ <?= number_format($card['current_bill'] ?? 0, 2, ',', '.') ?></div>
                            </div>
                            <div class="card-mini-info">
                                <div class="card-mini-label">Vencimento</div>
                                <div class="card-mini-value"><?= str_pad($card['due_day'], 2, '0', STR_PAD_LEFT) ?>/<?= date('m') ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Benefícios -->
    <?php if (!empty($benefitCards)): ?>
        <div class="cards-section">
            <div class="section-header">
                <h2>🎫 Meus Benefícios</h2>
                <a href="/beneficios" class="btn btn-link">Ver todos →</a>
            </div>

            <div class="benefits-grid">

                <?php
                $benefitColors = [
                    'swile'   => 'linear-gradient(135deg, #0D0D0D 0%, #1A1A2E 100%)',
                    'alelo'   => 'linear-gradient(135deg, #E8001C 0%, #FF1A35 100%)',
                    'sodexo'  => 'linear-gradient(135deg, #0033A0 0%, #0044CC 100%)',
                    'ticket'  => 'linear-gradient(135deg, #0073CF 0%, #0090E7 100%)',
                    'flash'   => 'linear-gradient(135deg, #5B21B6 0%, #7C3AED 100%)',
                    'caju'    => 'linear-gradient(135deg, #F97316 0%, #FB923C 100%)',
                    'ifood'   => 'linear-gradient(135deg, #EA1D2C 0%, #FF2D3D 100%)',
                    'valer'   => 'linear-gradient(135deg, #1A7F37 0%, #22A84A 100%)',
                    'vr'      => 'linear-gradient(135deg, #0F6B8E 0%, #1A8BB0 100%)',
                    'va'      => 'linear-gradient(135deg, #92400E 0%, #B45309 100%)',
                    'vale refeição' => 'linear-gradient(135deg, #0F6B8E 0%, #1A8BB0 100%)',
                    'vale alimentação' => 'linear-gradient(135deg, #92400E 0%, #B45309 100%)',
                ];
                ?>

                <?php foreach (array_slice($benefitCards, 0, 4) as $benefit): ?>

                    <?php
                    $nameKey = strtolower(trim($benefit['name']));
                    $bgGradient = 'linear-gradient(135deg, #374151 0%, #4B5563 100%)';

                    foreach ($benefitColors as $key => $gradient) {
                        if (str_contains($nameKey, $key)) {
                            $bgGradient = $gradient;
                            break;
                        }
                    }
                    ?>

                    <div class="benefit-card-mini <?= $benefit['type'] ?>"
                        style="background: <?= $bgGradient ?>;">

                        <div class="benefit-mini-header">
                            <div class="benefit-icon">
                                <?= $benefit['type'] === 'vr' ? '🍽️' : '🛒' ?>
                            </div>

                            <div class="benefit-mini-info">
                                <h3><?= htmlspecialchars($benefit['name']) ?></h3>

                                <div class="benefit-type">
                                    <?= $benefit['type'] === 'vr'
                                        ? 'Vale Refeição'
                                        : 'Vale Alimentação' ?>
                                </div>
                            </div>
                        </div>

                        <div class="benefit-balance">
                            R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?>
                        </div>

                        <div class="benefit-details">
                            <div>
                                Recarga:
                                R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?>
                            </div>

                            <div>
                                Próxima:
                                <?= str_pad($benefit['recharge_day'], 2, '0', STR_PAD_LEFT) ?>/<?= date('m', strtotime('+1 month')) ?>
                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>

    <!-- Gráficos -->
    <div class="charts-grid">
        <!-- Gráfico de Gastos por Categoria -->
        <?php if (!empty($spendingByCategory)): ?>
            <div class="chart-card">
                <h3>📊 Gastos por Categoria</h3>
                <div class="chart-wrap">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        <?php endif; ?>

        <!-- Gráfico de Evolução Mensal -->
        <?php if (!empty($monthlyEvolution)): ?>
            <div class="chart-card">
                <h3>📈 Evolução Mensal</h3>
                <div class="chart-wrap">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Metas em Andamento -->
    <?php if (!empty($goals)): ?>
        <div class="card">
            <div class="card-header">
                <h3>🎯 Metas em Andamento</h3>
                <a href="/metas" class="btn btn-link">Ver todas →</a>
            </div>

            <div class="goals-grid">
                <?php foreach (array_slice($goals, 0, 3) as $goal):
                    $progress = ($goal['current_amount'] / $goal['target_amount']) * 100;
                ?>
                    <div class="goal-card">
                        <h4><?= htmlspecialchars($goal['name']) ?></h4>
                        <div class="goal-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= min(100, $progress) ?>%"></div>
                            </div>
                            <span class="progress-text"><?= number_format($progress, 1) ?>%</span>
                        </div>
                        <div class="goal-info">
                            <span>R$ <?= number_format($goal['current_amount'], 2, ',', '.') ?></span>
                            <span>de R$ <?= number_format($goal['target_amount'], 2, ',', '.') ?></span>
                        </div>
                        <p class="goal-deadline">Prazo: <?= date('d/m/Y', strtotime($goal['deadline'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>


<!-- Últimas Transações -->
<div class="transactions-card">
    <div class="card-header">
        <h3>💸 Últimas Transações</h3>
        <a href="/transacoes/criar" class="btn btn-primary">+ Nova Transação</a>
    </div>

    <?php foreach (array_slice($transactions, 0, 8) as $transaction): ?>
        <div class="transaction-item">
            <div class="transaction-info">
                <div class="transaction-icon <?= $transaction['type'] ?>">
                    <?= $transaction['type'] === 'receita' ? '📈' : '📉' ?>
                </div>

                <div class="transaction-details">
                    <h4><?= htmlspecialchars($transaction['description']) ?></h4>

                    <div class="transaction-badges">
                        <!-- Data -->
                        <span class="badge badge-date">
                            <?= date('d/m', strtotime($transaction['transaction_date'])) ?>
                        </span>

                        <!-- Categoria -->
                        <span class="badge badge-category" style="--cat-color: <?= $transaction['color'] ?>">
                            <?= htmlspecialchars($transaction['category_name']) ?>
                        </span>

                        <!-- Forma de Pagamento -->
                        <?php if ($transaction['payment_method'] === 'credito'): ?>
                            <span class="badge badge-payment badge-credit">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                    <path d="M2 10h20" />
                                </svg>

                                <?php if (!empty($transaction['card_name'])): ?>
                                    <?= $transaction['card_name'] ?>
                                <?php else: ?>
                                    Cartão de Crédito
                                <?php endif; ?>

                                <?php if ($transaction['installments'] > 1): ?>
                                    <span class="installment-badge">
                                        <?= $transaction['installment_number'] ?>/<?= $transaction['installments'] ?>x
                                    </span>
                                <?php endif; ?>
                            </span>

                        <?php elseif ($transaction['payment_method'] === 'va'): ?>
                            <span class="badge badge-payment badge-va">
                                🍽️ VA
                            </span>

                        <?php elseif ($transaction['payment_method'] === 'vr'): ?>
                            <span class="badge badge-payment badge-vr">
                                🛒 VR
                            </span>

                        <?php else: ?>
                            <span class="badge badge-payment badge-cash">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                                À vista
                            </span>
                        <?php endif; ?>

                        <!-- Recorrente -->
                        <?php if (!empty($transaction['is_recurring'])): ?>
                            <span class="badge badge-recurring">
                                🔁 Recorrente
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="transaction-amount <?= $transaction['type'] === 'receita' ? 'positive' : 'negative' ?>">
                <?= $transaction['type'] === 'receita' ? '+' : '-' ?>
                R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
            </div>
        </div>
    <?php endforeach; ?>


    <div style="text-align: center; margin-top: 1.5rem;">
        <a href="/transacoes" class="btn btn-link">Ver todas as transações →</a>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Copiar código de convite
    function toggleShare(e) {
        e.stopPropagation();
        const pop = document.getElementById('sharePopover');
        pop.classList.toggle('open');
    }

    function copyInviteCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            const btn = document.getElementById('copyBtn');
            const text = document.getElementById('copyBtnText');
            btn.classList.add('copied');
            text.textContent = '✓ Copiado!';
            setTimeout(() => {
                btn.classList.remove('copied');
                text.textContent = 'Copiar código';
            }, 2000);
        });
    }

    // Fecha ao clicar fora
    document.addEventListener('click', function(e) {
        const pop = document.getElementById('sharePopover');
        if (pop && !pop.contains(e.target) && !e.target.closest('.btn-share-trigger')) {
            pop.classList.remove('open');
        }
    });

    function shareCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            const btn = document.querySelector('.btn-share.copy');
            const original = btn.textContent;
            btn.textContent = '✓ Copiado!';
            setTimeout(() => btn.textContent = original, 2000);
        });
    }

    <?php if (!empty($spendingByCategory)): ?>
        // Gráfico de Gastos por Categoria
        const categoryData = <?= json_encode(array_map(function ($cat) {
                                    return [
                                        'label' => $cat['category_name'],
                                        'value' => floatval($cat['total']),
                                        'color' => $cat['color']
                                    ];
                                }, $spendingByCategory)) ?>;

        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            new Chart(categoryCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: categoryData.map(d => d.label),
                    datasets: [{
                        data: categoryData.map(d => d.value),
                        backgroundColor: categoryData.map(d => d.color),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }
    <?php endif; ?>

    <?php if (!empty($monthlyEvolution)): ?>
        // Gráfico de Evolução Mensal
        const monthlyData = <?= json_encode($monthlyEvolution) ?>;

        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: monthlyData.map(d => d.month),
                    datasets: [{
                        label: 'Receitas',
                        data: monthlyData.map(d => parseFloat(d.income)),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Despesas',
                        data: monthlyData.map(d => parseFloat(d.expense)),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        }
    <?php endif; ?>
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>