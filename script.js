// Pet Gallery App
class PetGallery {
    constructor() {
        this.modal = document.getElementById('modal');
        this.modalClose = document.getElementById('modalClose');
        this.modalBackdrop = this.modal.querySelector('.modal-backdrop');
        this.modalImage = document.getElementById('modalImage');
        this.modalName = document.getElementById('modalName');
        this.petCards = document.querySelectorAll('.pet-card');
        
        this.init();
    }
    
    init() {
        // Add click listeners to all pet cards
        this.petCards.forEach(card => {
            card.addEventListener('click', (e) => this.openModal(e, card));
        });
        
        // Close modal listeners
        this.modalClose.addEventListener('click', () => this.closeModal());
        this.modalBackdrop.addEventListener('click', () => this.closeModal());
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.classList.contains('active')) {
                this.closeModal();
            }
        });
        
        // Add hover effects with mouse tracking
        this.petCards.forEach(card => {
            this.addCardTiltEffect(card);
        });
        
        // Add parallax effect to modal card
        const battleCard = document.querySelector('.battle-card');
        if (battleCard) {
            this.addModalTiltEffect(battleCard);
        }
        
        // Smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
        
        // Add intersection observer for lazy animations
        this.observeCards();
    }
    
    openModal(event, card) {
        event.preventDefault();
        
        const petName = card.dataset.petName;
        const petImage = card.dataset.petImage;
        
        // Update modal content
        this.modalImage.src = petImage;
        this.modalImage.alt = petName;
        this.modalName.textContent = petName;
        
        // Randomize stats for fun
        this.randomizeStats();
        
        // Open modal with animation
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Add entrance animation
        this.animateCardEntrance();
        
        // Play sound effect (optional - commented out by default)
        // this.playSound('open');
    }
    
    closeModal() {
        this.modal.classList.remove('active');
        document.body.style.overflow = '';
        
        // Play sound effect (optional - commented out by default)
        // this.playSound('close');
    }
    
    randomizeStats() {
        const statFills = document.querySelectorAll('.stat-fill');
        statFills.forEach(fill => {
            const randomValue = Math.floor(Math.random() * 20) + 80; // 80-100%
            fill.style.setProperty('--value', `${randomValue}%`);
            // Reset animation
            fill.style.animation = 'none';
            setTimeout(() => {
                fill.style.animation = '';
            }, 10);
        });
    }
    
    animateCardEntrance() {
        const battleCard = document.querySelector('.battle-card');
        battleCard.style.animation = 'none';
        setTimeout(() => {
            battleCard.style.animation = 'cardFlip 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
        }, 10);
    }
    
    addCardTiltEffect(card) {
        const cardInner = card.querySelector('.card-inner');
        
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            cardInner.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });
        
        card.addEventListener('mouseleave', () => {
            cardInner.style.transform = '';
        });
    }
    
    addModalTiltEffect(battleCard) {
        const modal = this.modal;
        
        modal.addEventListener('mousemove', (e) => {
            if (!modal.classList.contains('active')) return;
            
            const rect = battleCard.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            // Reduced rotation for less overflow (was /50, now /100)
            const rotateX = (y - centerY) / 100;
            const rotateY = (centerX - x) / 100;
            
            battleCard.style.transform = `perspective(1500px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        
        modal.addEventListener('mouseleave', () => {
            battleCard.style.transform = '';
        });
    }
    
    observeCards() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        this.petCards.forEach(card => {
            observer.observe(card);
        });
    }
    
    // Optional: Add sound effects
    playSound(type) {
        // You can add audio files and play them here
        // const audio = new Audio(`sounds/${type}.mp3`);
        // audio.volume = 0.3;
        // audio.play();
    }
}

// Additional CSS keyframes (add to styles.css if needed)
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes cardFlip {
        0% {
            transform: perspective(1000px) rotateY(-90deg) scale(0.8);
            opacity: 0;
        }
        100% {
            transform: perspective(1000px) rotateY(0deg) scale(1);
            opacity: 1;
        }
    }
`;
document.head.appendChild(styleSheet);

// Initialize the gallery when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new PetGallery();
    });
} else {
    new PetGallery();
}

// Add smooth page transitions
window.addEventListener('beforeunload', () => {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.3s ease';
});

// Performance optimization: Preload images
window.addEventListener('load', () => {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
        if (img.complete) return;
        const imageLoader = new Image();
        imageLoader.src = img.src;
    });
});

// Add easter egg: Konami code for confetti effect
let konamiCode = [];
const konamiPattern = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];

document.addEventListener('keydown', (e) => {
    konamiCode.push(e.key);
    konamiCode = konamiCode.slice(-10);
    
    if (konamiCode.join(',') === konamiPattern.join(',')) {
        triggerConfetti();
        konamiCode = [];
    }
});

function triggerConfetti() {
    // Simple confetti effect
    const colors = ['#ff6b6b', '#4ecdc4', '#ffe66d', '#667eea', '#f093fb'];
    const confettiCount = 50;
    
    for (let i = 0; i < confettiCount; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
                position: fixed;
                top: -10px;
                left: ${Math.random() * 100}%;
                width: 10px;
                height: 10px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                pointer-events: none;
                z-index: 9999;
                animation: confettiFall ${2 + Math.random() * 2}s linear forwards;
                transform: rotate(${Math.random() * 360}deg);
            `;
            document.body.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 4000);
        }, i * 30);
    }
}

// Add confetti animation
const confettiStyle = document.createElement('style');
confettiStyle.textContent = `
    @keyframes confettiFall {
        to {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
`;
document.head.appendChild(confettiStyle);
