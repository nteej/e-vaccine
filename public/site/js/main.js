// Constants
const FLOATING_ICONS = ['💉', '🏥', '🔬', '🩺', '📱', '📋'];
const ANIMATION_CONFIG = {
  minDuration: 15,
  maxDuration: 30,
  minDelay: -20,
  maxDelay: 0,
  iconCount: 15
};

/**
 * Creates floating icons in the hero section
 */
function createFloatingIcons() {
  const container = document.querySelector('.floating-icons');
  if (!container) return;

  for (let i = 0; i < ANIMATION_CONFIG.iconCount; i++) {
    const icon = createFloatingIcon();
    container.appendChild(icon);
  }
}

/**
 * Creates a single floating icon element
 * @returns {HTMLDivElement}
 */
function createFloatingIcon() {
  const icon = document.createElement('div');
  icon.className = 'floating-icon';
  icon.textContent = getRandomIcon();
  
  // Set random position
  icon.style.left = `${Math.random() * 100}%`;
  icon.style.top = `${Math.random() * 100}%`;
  
  // Set animation properties
  const duration = ANIMATION_CONFIG.minDuration + 
    Math.random() * (ANIMATION_CONFIG.maxDuration - ANIMATION_CONFIG.minDuration);
  const delay = ANIMATION_CONFIG.minDelay + 
    Math.random() * (ANIMATION_CONFIG.maxDelay - ANIMATION_CONFIG.minDelay);
  
  icon.style.animationDuration = `${duration}s`;
  icon.style.animationDelay = `${delay}s`;
  
  return icon;
}

/**
 * Returns a random icon from the FLOATING_ICONS array
 * @returns {string}
 */
function getRandomIcon() {
  return FLOATING_ICONS[Math.floor(Math.random() * FLOATING_ICONS.length)];
}

/**
 * Sets up intersection observer for fade-in animations
 */
function setupIntersectionObserver() {
  const sections = document.querySelectorAll(
    '.benefits-section, .features-section, .how-it-works-section'
  );
  
  /**
   * Handles intersection observer entries
   * @param {IntersectionObserverEntry[]} entries
   * @param {IntersectionObserver} observer
   */
  const handleIntersection = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(handleIntersection, {
    threshold: 0.2
  });

  sections.forEach(section => observer.observe(section));
}

/**
 * Sets up CTA button click animation
 */
function setupCTAButton() {
  const ctaButton = document.querySelector('.cta-button');
  if (!ctaButton) return;

  ctaButton.addEventListener('click', () => {
    ctaButton.style.transform = 'scale(0.95)';
    setTimeout(() => {
      ctaButton.style.transform = '';
    }, 150);
  });
}

/**
 * Initializes all page functionality
 */
function initializePage() {
  createFloatingIcons();
  setupIntersectionObserver();
  setupCTAButton();
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializePage);

