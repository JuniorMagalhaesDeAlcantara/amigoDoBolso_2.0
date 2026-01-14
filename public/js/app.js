// Script básico do Amigo do Bolso
console.log('Amigo do Bolso carregado!');

// Copiar código de convite ao clicar
document.addEventListener('DOMContentLoaded', function() {
    const inviteCode = document.querySelector('.invite-code');
    
    if (inviteCode) {
        inviteCode.addEventListener('click', function() {
            const code = this.textContent.trim().replace(' ', '');
            navigator.clipboard.writeText(code);
            
            // Feedback visual
            const originalText = this.textContent;
            this.textContent = ' Copiado!';
            setTimeout(() => {
                this.textContent = originalText;
            }, 2000);
        });
    }
});
