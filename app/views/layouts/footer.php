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