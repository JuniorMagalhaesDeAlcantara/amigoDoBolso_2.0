</main>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-divider"></div>

            <p class="footer-text">
                &copy; <?= date('Y') ?> Amigo do Bolso - Controle Financeiro Colaborativo
            </p>

            <p class="footer-tagline">
                Simplicidade • Organização • Evolução
            </p>
        </div>
    </div>
</footer>

<script>
    // Toggle Mobile Menu
    function toggleMobileMenu() {
        const menu = document.getElementById('navMenu');
        menu.classList.toggle('mobile-open');
    }

    // Show mobile toggle on small screens
    window.addEventListener('resize', function() {
        const toggle = document.querySelector('.mobile-toggle');
        const menu = document.getElementById('navMenu');

        if (window.innerWidth <= 768) {
            toggle.style.display = 'flex';
        } else {
            toggle.style.display = 'none';
            menu.classList.remove('mobile-open');
        }
    });

    // Initialize on load
    window.dispatchEvent(new Event('resize'));
</script>

<script src="/js/main.js"></script>
</body>

</html>

<style>
    /* ========================================
   FOOTER - RESPONSIVO
   ======================================== */

.footer {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-top: auto;
    position: relative;
    overflow: hidden;
}

/* Linha decorativa sutil no topo */
.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255,255,255,0.3) 50%, 
        transparent
    );
}

.footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.footer-content {
    padding: 2rem 0;
    text-align: center;
}

.footer-divider {
    height: 1px;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255,255,255,0.2) 50%, 
        transparent
    );
    margin-bottom: 1.5rem;
}

.footer-text {
    font-size: 0.9375rem;
    opacity: 0.9;
    margin: 0 0 0.75rem 0;
    line-height: 1.5;
}

.footer-tagline {
    font-size: 0.875rem;
    opacity: 0.75;
    font-weight: 300;
    letter-spacing: 0.05em;
    margin: 0;
}

/* Mobile */
@media (max-width: 640px) {
    .footer .container {
        padding: 0 1rem;
    }

    .footer-content {
        padding: 1.5rem 0;
    }

    .footer-divider {
        margin-bottom: 1rem;
    }

    .footer-text {
        font-size: 0.8125rem;
    }

    .footer-tagline {
        font-size: 0.75rem;
    }
}

/* Extra Small */
@media (max-width: 375px) {
    .footer-content {
        padding: 1.25rem 0;
    }

    .footer-text {
        font-size: 0.75rem;
    }

    .footer-tagline {
        font-size: 0.6875rem;
    }
}
</style>