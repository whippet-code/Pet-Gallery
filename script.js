// Pet Gallery App with Voting System
class PetGallery {
    constructor() {
        this.modal = document.getElementById('modal');
        this.modalClose = document.getElementById('modalClose');
        this.modalBackdrop = this.modal.querySelector('.modal-backdrop');
        this.modalImage = document.getElementById('modalImage');
        this.modalName = document.getElementById('modalName');
        this.petCards = document.querySelectorAll('.pet-card');
        
        // Voting state
        this.votes = {
            first: null,
            second: null,
            third: null
        };
        this.votingActive = false;
        this.votingPanel = document.getElementById('votingPanel');
        
        this.init();
    }
    
    init() {
        // Add click listeners to all pet cards for voting
        this.petCards.forEach(card => {
            card.addEventListener('click', (e) => this.handleCardClick(e, card));
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
        
        // Start voting button
        const startVotingBtn = document.getElementById('startVotingBtn');
        if (startVotingBtn) {
            startVotingBtn.addEventListener('click', () => this.showVotingPanel());
        }
        
        // Voting UI listeners
        document.getElementById('submitVoteBtn').addEventListener('click', () => this.submitVotes());
        document.getElementById('clearVotesBtn').addEventListener('click', () => this.clearVotes());
        
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
    
    handleCardClick(event, card) {
        event.preventDefault();
        
        const petName = card.dataset.petName;
        const petImage = card.dataset.petImage;
        
        // If voting not active, just open modal
        if (!this.votingActive) {
            this.openModal(card);
            return;
        }
        
        // Check if pet is already selected
        const selectedRank = this.getPetRank(petName);
        
        if (selectedRank) {
            // If already selected, open modal to view
            this.openModal(card);
        } else {
            // Add to next available slot
            this.addPetToVote(petName, petImage, card);
        }
    }
    
    openModal(card) {
        const petName = card.dataset.petName;
        const petImage = card.dataset.petImage;
        
        // Update modal content
        this.modalImage.src = petImage;
        this.modalImage.alt = petName;
        this.modalName.textContent = petName;
        
        // Update instruction text based on voting state
        const instruction = document.getElementById('modalInstruction');
        if (instruction) {
            if (this.votingActive) {
                const rank = this.getPetRank(petName);
                if (rank) {
                    instruction.textContent = `${petName} is already in your ${this.getSlotLabel(rank)}! 🎉`;
                } else {
                    instruction.textContent = 'Close this and click the card again to add to your voting hand! 🎲';
                }
            } else {
                instruction.textContent = 'What an adorable contestant! Click "Start Voting" to begin selecting your favorites! 🎲';
            }
        }
        
        // Randomize stats for fun
        this.randomizeStats();
        
        // Open modal with animation
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Add entrance animation
        this.animateCardEntrance();
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
    
    // Voting System Methods
    showVotingPanel() {
        this.votingActive = true;
        this.votingPanel.style.display = 'block';
        
        // Smooth scroll to voting panel
        setTimeout(() => {
            this.votingPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
        
        // Add entrance animation
        this.votingPanel.style.animation = 'fadeInScale 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
        
        // Hide start voting button
        const startBtn = document.getElementById('startVotingBtn');
        if (startBtn) {
            startBtn.style.display = 'none';
        }
        
        this.showNotification('Click on 3 pet cards to build your voting hand! 🎲', 'info', 4000);
    }
    
    hideVotingPanel() {
        // Clear all selections
        this.clearVotes();
        
        // Add fade out animation
        this.votingPanel.style.animation = 'fadeOut 0.5s ease';
        
        setTimeout(() => {
            this.votingPanel.style.display = 'none';
            this.votingActive = false;
            
            // Show start voting button again
            const startBtn = document.getElementById('startVotingBtn');
            if (startBtn) {
                startBtn.style.display = 'inline-block';
            }
            
            // Scroll to top smoothly
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 500);
    }
    
    getPetRank(petName) {
        if (this.votes.first === petName) return 'first';
        if (this.votes.second === petName) return 'second';
        if (this.votes.third === petName) return 'third';
        return null;
    }
    
    getNextAvailableSlot() {
        if (!this.votes.first) return 'first';
        if (!this.votes.second) return 'second';
        if (!this.votes.third) return 'third';
        return null;
    }
    
    addPetToVote(petName, petImage, card) {
        const slot = this.getNextAvailableSlot();
        
        if (!slot) {
            this.showNotification('You can only select 3 pets! Clear your selections to choose different ones.', 'warning');
            return;
        }
        
        this.votes[slot] = petName;
        this.updateVotingSlot(slot, petName, petImage);
        this.updateCardBadge(card, slot);
        this.updateSubmitButton();
        this.showNotification(`${petName} added to ${this.getSlotLabel(slot)}! 🎉`, 'success');
    }
    
    getSlotLabel(slot) {
        const labels = {
            first: '1st place',
            second: '2nd place',
            third: '3rd place'
        };
        return labels[slot];
    }
    
    updateVotingSlot(slot, petName, petImage) {
        const slotMap = { first: 'slot1', second: 'slot2', third: 'slot3' };
        const slotElement = document.getElementById(slotMap[slot]);
        const slotContent = slotElement.querySelector('.slot-content');
        
        slotContent.classList.remove('empty');
        slotContent.classList.add('filled');
        
        const badges = {
            first: '🥇 1st Place',
            second: '🥈 2nd Place',
            third: '🥉 3rd Place'
        };
        
        const points = { first: '3 Points', second: '2 Points', third: '1 Point' };
        
        slotContent.innerHTML = `
            <div class="slot-badge">${badges[slot]}</div>
            <div class="slot-pet-image" style="background-image: url('${petImage}')"></div>
            <div class="slot-pet-name">${petName}</div>
            <div class="slot-points">${points[slot]}</div>
            <button class="slot-remove-btn" onclick="petGallery.removePetFromSlot('${slot}')">×</button>
        `;
        
        slotContent.style.animation = 'slotFill 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
    }
    
    updateCardBadge(card, slot) {
        const badge = card.querySelector('.selection-badge');
        const badges = {
            first: '🥇 1st',
            second: '🥈 2nd',
            third: '🥉 3rd'
        };
        
        badge.textContent = badges[slot];
        badge.style.display = 'flex';
        card.classList.add('selected');
    }
    
    removePetFromSlot(slot) {
        const petName = this.votes[slot];
        this.votes[slot] = null;
        
        // Reset slot UI
        const slotMap = { first: 'slot1', second: 'slot2', third: 'slot3' };
        const slotElement = document.getElementById(slotMap[slot]);
        const slotContent = slotElement.querySelector('.slot-content');
        
        slotContent.classList.remove('filled');
        slotContent.classList.add('empty');
        
        const badges = {
            first: '🥇 1st Place',
            second: '🥈 2nd Place',
            third: '🥉 3rd Place'
        };
        
        const points = { first: '3 Points', second: '2 Points', third: '1 Point' };
        
        slotContent.innerHTML = `
            <div class="slot-badge">${badges[slot]}</div>
            <div class="slot-points">${points[slot]}</div>
            <div class="slot-placeholder">Click a pet to select</div>
        `;
        
        // Remove badge from card
        this.petCards.forEach(card => {
            if (card.dataset.petName === petName) {
                const badge = card.querySelector('.selection-badge');
                badge.style.display = 'none';
                card.classList.remove('selected');
            }
        });
        
        this.updateSubmitButton();
        this.showNotification(`${petName} removed!`, 'info');
    }
    
    clearVotes() {
        ['first', 'second', 'third'].forEach(slot => {
            if (this.votes[slot]) {
                this.removePetFromSlot(slot);
            }
        });
        
        document.getElementById('emailSection').style.display = 'none';
        document.getElementById('voterEmail').value = '';
    }
    
    updateSubmitButton() {
        const allSelected = this.votes.first && this.votes.second && this.votes.third;
        const submitBtn = document.getElementById('submitVoteBtn');
        const emailSection = document.getElementById('emailSection');
        
        if (allSelected) {
            submitBtn.disabled = false;
            emailSection.style.display = 'block';
            emailSection.style.animation = 'fadeInUp 0.5s ease';
        } else {
            submitBtn.disabled = true;
            emailSection.style.display = 'none';
        }
    }
    
    async submitVotes() {
        const email = document.getElementById('voterEmail').value.trim();
        
        if (!email) {
            this.showNotification('Please enter your email address!', 'error');
            return;
        }
        
        if (!this.validateEmail(email)) {
            this.showNotification('Please enter a valid email address!', 'error');
            return;
        }
        
        const submitBtn = document.getElementById('submitVoteBtn');
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-text').innerHTML = '<span class="btn-icon">⏳</span> Submitting...';
        
        try {
            const response = await fetch('vote-submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    firstChoice: this.votes.first,
                    secondChoice: this.votes.second,
                    thirdChoice: this.votes.third
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showNotification(data.message, 'success', 5000);
                
                // Add confetti effect
                triggerConfetti();
                
                // Hide voting panel and reset after a delay
                setTimeout(() => {
                    this.hideVotingPanel();
                }, 2000);
            } else {
                this.showNotification(data.message, 'error', 5000);
            }
        } catch (error) {
            console.error('Vote submission error:', error);
            this.showNotification('An error occurred. Please try again!', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').innerHTML = '<span class="btn-icon">⚡</span> Submit Your Votes <span class="btn-icon">⚡</span>';
        }
    }
    
    validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    
    showNotification(message, type = 'info', duration = 3000) {
        // Remove existing notification if any
        const existing = document.querySelector('.notification');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span class="notification-icon">${this.getNotificationIcon(type)}</span>
            <span class="notification-message">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Trigger animation
        setTimeout(() => notification.classList.add('show'), 10);
        
        // Auto remove
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }
    
    getNotificationIcon(type) {
        const icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: 'ℹ️'
        };
        return icons[type] || icons.info;
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
let petGallery;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        petGallery = new PetGallery();
    });
} else {
    petGallery = new PetGallery();
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
