/**
 * SocialHub - Global JavaScript
 *
 * Handles client-side interactions and utilities for the social media platform.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize application
    console.log('SocialHub initialized');

    // Setup character counters for textareas
    setupCharacterCounters();

    // Initialize form validations
    initializeFormValidations();
});

/**
 * Toggle like button state and update count
 * @param {HTMLElement} element - The like button element
 * @param {number} postId - The post ID
 * @param {string} endpoint - API endpoint for like action
 */
function toggleLike(element, postId, endpoint) {
    // Toggle visual state
    element.classList.toggle('text-red-500');
    element.classList.toggle('text-gray-500');

    // Update like count
    const countSpan = element.querySelector('.like-count');
    if (countSpan) {
        const count = parseInt(countSpan.textContent);
        countSpan.textContent = element.classList.contains('text-red-500') ? count + 1 : count - 1;
    }

    // Send AJAX request (if endpoint provided)
    if (endpoint) {
        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // Revert on error
                toggleLike(element, postId);
            }
        })
        .catch(error => {
            console.error('Like action failed:', error);
            // Revert on error
            toggleLike(element, postId);
        });
    }
}

/**
 * Initialize form validations
 */
function initializeFormValidations() {
    const forms = document.querySelectorAll('form[data-validate="true"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
            }
        });
    });
}

/**
 * Setup character counters for all textareas
 */
function setupCharacterCounters() {
    const textareas = document.querySelectorAll('textarea[data-max-chars]');
    textareas.forEach(textarea => {
        const maxChars = parseInt(textarea.dataset.maxChars) || 5000;
        setupCharacterCounter(textarea, maxChars);
    });
}

/**
 * Setup character counter for a specific textarea
 * @param {HTMLTextAreaElement} textarea - The textarea element
 * @param {number} maxChars - Maximum allowed characters
 */
function setupCharacterCounter(textarea, maxChars = 5000) {
    if (!textarea) return;

    // Create counter element if it doesn't exist
    let counter = document.getElementById(textarea.id + '-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = textarea.id + '-counter';
        counter.className = 'text-sm text-gray-500 mt-1';
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);
    }

    textarea.addEventListener('input', function() {
        const remaining = maxChars - this.value.length;
        counter.textContent = `${remaining} characters remaining`;

        // Update styling based on remaining characters
        if (remaining < 50) {
            counter.className = 'text-sm text-red-500 mt-1 font-semibold';
        } else if (remaining < 100) {
            counter.className = 'text-sm text-yellow-600 mt-1';
        } else {
            counter.className = 'text-sm text-gray-500 mt-1';
        }

        // Prevent typing beyond limit
        if (this.value.length > maxChars) {
            this.value = this.value.substring(0, maxChars);
        }
    });

    // Trigger initial count
    textarea.dispatchEvent(new Event('input'));
}

/**
 * Show loading spinner
 * @param {HTMLElement} element - Element to show spinner in
 */
function showLoading(element) {
    element.innerHTML = '<div class="flex justify-center"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div></div>';
}

/**
 * Hide loading spinner
 * @param {HTMLElement} element - Element to restore
 * @param {string} originalContent - Original content to restore
 */
function hideLoading(element, originalContent) {
    element.innerHTML = originalContent;
}

/**
 * Confirm action with modern dialog
 * @param {string} message - Confirmation message
 * @param {Function} callback - Callback function if confirmed
 */
function confirmAction(message, callback) {
    if (window.confirm(message)) {
        callback();
    }
}

// Setup tooltips (if using Bootstrap 5)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

// Handle image preview
function previewImage(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if (!input || !preview) return;
    
    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
}

// Confirm delete action
function confirmDelete(message = 'Are you sure you want to delete this?') {
    return confirm(message);
}

// Load more posts (for infinite scroll)
function loadMorePosts(page) {
    const container = document.getElementById('posts-container');
    if (!container) return;
    
    fetch('/posts/feed?page=' + page)
        .then(response => response.text())
        .then(html => {
            container.innerHTML += html;
        })
        .catch(error => console.error('Error loading posts:', error));
}

// Search posts
function searchPosts(query) {
    if (!query || query.length < 2) {
        alert('Please enter at least 2 characters');
        return false;
    }
    window.location.href = '/posts/search?q=' + encodeURIComponent(query);
    return false;
}
