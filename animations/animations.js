// Function to handle the intersection observer callback
function handleIntersection(entries, observer) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
            // Once the animation is triggered, this element doesn't need to be observed anymore
            observer.unobserve(entry.target);
        }
    });
}

// Create the intersection observer
const options = {
    root: null, // use viewport
    rootMargin: '0px',
    threshold: 0.1 // trigger when at least 10% of the element is visible
};

const observer = new IntersectionObserver(handleIntersection, options);

// Function to initialize animations
function initScrollAnimations() {
    // Observe the members section title
    const membersTitle = document.querySelector('.members h2');
    if (membersTitle) {
        observer.observe(membersTitle);
    }

    // Observe all member cards
    const memberCards = document.querySelectorAll('.member-flip-card');
    memberCards.forEach((card, index) => {
        // Add a slight delay based on the card's position
        card.style.transitionDelay = `${index * 0.2}s`;
        observer.observe(card);
    });
}

// Initialize when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initScrollAnimations);

