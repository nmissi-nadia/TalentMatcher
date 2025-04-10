import './bootstrap';

/**
 * TalentMatcher API Client
 * 
 * This module provides a centralized API client for interacting with the TalentMatcher backend.
 * It includes helper functions for common operations and handles authentication.
 */

// API Base URL
const API_BASE_URL = '/api';

/**
 * API Client for making HTTP requests to the TalentMatcher backend
 */
const apiClient = {
    /**
     * Get the authentication token from localStorage
     * @returns {string|null} The authentication token
     */
    getToken() {
        return localStorage.getItem('token');
    },

    /**
     * Set the authentication token in localStorage
     * @param {string} token - The authentication token
     */
    setToken(token) {
        localStorage.setItem('token', token);
    },

    /**
     * Remove the authentication token from localStorage
     */
    removeToken() {
        localStorage.removeItem('token');
    },

    /**
     * Configure Axios headers with authentication token
     */
    configureAxios() {
        const token = this.getToken();
        if (token) {
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
    },

    /**
     * Make a GET request to the specified endpoint
     * @param {string} endpoint - The API endpoint to request
     * @param {Object} params - Query parameters (optional)
     * @returns {Promise} The response data
     */
    async get(endpoint, params = {}) {
        this.configureAxios();
        try {
            const response = await window.axios.get(`${API_BASE_URL}${endpoint}`, { params });
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    },

    /**
     * Make a POST request to the specified endpoint
     * @param {string} endpoint - The API endpoint to request
     * @param {Object} data - The data to send
     * @returns {Promise} The response data
     */
    async post(endpoint, data = {}) {
        this.configureAxios();
        try {
            const response = await window.axios.post(`${API_BASE_URL}${endpoint}`, data);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    },

    /**
     * Make a PUT request to the specified endpoint
     * @param {string} endpoint - The API endpoint to request
     * @param {Object} data - The data to send
     * @returns {Promise} The response data
     */
    async put(endpoint, data = {}) {
        this.configureAxios();
        try {
            const response = await window.axios.put(`${API_BASE_URL}${endpoint}`, data);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    },

    /**
     * Make a DELETE request to the specified endpoint
     * @param {string} endpoint - The API endpoint to request
     * @returns {Promise} The response data
     */
    async delete(endpoint) {
        this.configureAxios();
        try {
            const response = await window.axios.delete(`${API_BASE_URL}${endpoint}`);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    },

    /**
     * Handle API errors
     * @param {Error} error - The error object
     */
    handleError(error) {
        if (error.response) {
            // Server responded with a status code outside the 2xx range
            console.error('API Error Response:', error.response.data);
            
            // Handle 401 Unauthorized - User needs to log in again
            if (error.response.status === 401) {
                this.removeToken();
                // Redirect to login page if not already there
                if (!window.location.pathname.includes('/login')) {
                    window.location.href = '/login';
                }
            }
            
            // Display error notification if available
            if (window.showNotification) {
                window.showNotification(
                    error.response.data.message || 'Une erreur est survenue', 
                    'error'
                );
            }
        } else if (error.request) {
            // The request was made but no response was received
            console.error('API Error Request:', error.request);
            
            if (window.showNotification) {
                window.showNotification(
                    'Impossible de communiquer avec le serveur', 
                    'error'
                );
            }
        } else {
            // Something happened in setting up the request
            console.error('API Error:', error.message);
            
            if (window.showNotification) {
                window.showNotification(
                    'Erreur lors de la préparation de la requête', 
                    'error'
                );
            }
        }
    }
};

/**
 * Auth module for handling authentication operations
 */
const auth = {
    /**
     * Register a new user
     * @param {Object} userData - The user registration data
     * @returns {Promise} The response data
     */
    async register(userData) {
        try {
            const response = await apiClient.post('/register', userData);
            
            if (response.token) {
                apiClient.setToken(response.token);
                return { success: true, user: response.user };
            }
            
            return { success: false, message: 'Enregistrement réussi mais sans token d\'authentification' };
        } catch (error) {
            return { success: false, message: error.response?.data?.message || 'Échec de l\'enregistrement' };
        }
    },

    /**
     * Log in a user
     * @param {Object} credentials - The user login credentials
     * @returns {Promise} The response data
     */
    async login(credentials) {
        try {
            const response = await apiClient.post('/login', credentials);
            
            if (response.token) {
                apiClient.setToken(response.token);
                return { success: true, user: response.user };
            }
            
            return { success: false, message: 'Connexion réussie mais sans token d\'authentification' };
        } catch (error) {
            return { success: false, message: error.response?.data?.message || 'Échec de la connexion' };
        }
    },

    /**
     * Log out the current user
     * @returns {Promise} The response data
     */
    async logout() {
        try {
            await apiClient.post('/logout');
            apiClient.removeToken();
            return { success: true };
        } catch (error) {
            apiClient.removeToken(); // Remove token even if the API call fails
            return { success: false, message: error.response?.data?.message || 'Erreur lors de la déconnexion' };
        }
    },

    /**
     * Check if the user is authenticated
     * @returns {boolean} True if the user is authenticated
     */
    isAuthenticated() {
        return !!apiClient.getToken();
    },

    /**
     * Get the current user profile
     * @returns {Promise} The user profile data
     */
    async getCurrentUser() {
        if (!this.isAuthenticated()) {
            return null;
        }
        
        try {
            return await apiClient.get('/user');
        } catch (error) {
            // If the token is invalid, clear it
            if (error.response && error.response.status === 401) {
                apiClient.removeToken();
            }
            return null;
        }
    }
};

/**
 * Annonces (Job Announcements) module for managing job announcements
 */
const annonces = {
    /**
     * Get all job announcements
     * @returns {Promise} The job announcements data
     */
    async getAll() {
        return apiClient.get('/annonces');
    },

    /**
     * Get a specific job announcement
     * @param {number} id - The job announcement ID
     * @returns {Promise} The job announcement data
     */
    async get(id) {
        return apiClient.get(`/annonces/${id}`);
    },

    /**
     * Create a new job announcement
     * @param {Object} data - The job announcement data
     * @returns {Promise} The created job announcement
     */
    async create(data) {
        return apiClient.post('/annonces', data);
    },

    /**
     * Update a job announcement
     * @param {number} id - The job announcement ID
     * @param {Object} data - The updated job announcement data
     * @returns {Promise} The updated job announcement
     */
    async update(id, data) {
        return apiClient.put(`/annonces/${id}`, data);
    },

    /**
     * Delete a job announcement
     * @param {number} id - The job announcement ID
     * @returns {Promise} The response data
     */
    async delete(id) {
        return apiClient.delete(`/annonces/${id}`);
    },

    /**
     * Get job announcements statistics
     * @returns {Promise} The statistics data
     */
    async getStats() {
        return apiClient.get('/stats/annonces');
    }
};

/**
 * Candidatures (Job Applications) module for managing job applications
 */
const candidatures = {
    /**
     * Get all job applications
     * @returns {Promise} The job applications data
     */
    async getAll() {
        return apiClient.get('/candidatures');
    },

    /**
     * Get a specific job application
     * @param {number} id - The job application ID
     * @returns {Promise} The job application data
     */
    async get(id) {
        return apiClient.get(`/candidatures/${id}`);
    },

    /**
     * Apply for a job
     * @param {number} annonceId - The job announcement ID
     * @returns {Promise} The created job application
     */
    async create(annonceId) {
        return apiClient.post('/candidatures', { id_annonce: annonceId });
    },

    /**
     * Update a job application status
     * @param {number} id - The job application ID
     * @param {string} status - The new status
     * @returns {Promise} The updated job application
     */
    async updateStatus(id, status) {
        return apiClient.put(`/candidatures/${id}/status`, { statut: status });
    },

    /**
     * Withdraw a job application
     * @param {number} id - The job application ID
     * @returns {Promise} The response data
     */
    async withdraw(id) {
        return apiClient.delete(`/candidatures/${id}`);
    },

    /**
     * Get job applications statistics
     * @returns {Promise} The statistics data
     */
    async getStats() {
        return apiClient.get('/stats/candidatures');
    }
};

/**
 * Utility functions for displaying notifications
 */
window.showNotification = (message, type = 'info') => {
    // Check if the notification element exists, create if not
    let notificationElement = document.getElementById('notification-container');
    if (!notificationElement) {
        notificationElement = document.createElement('div');
        notificationElement.id = 'notification-container';
        notificationElement.className = 'fixed top-4 right-4 z-50 flex flex-col items-end space-y-2';
        document.body.appendChild(notificationElement);
    }

    // Create the notification
    const notification = document.createElement('div');
    
    // Add tailwind classes based on type
    let typeClasses = '';
    let icon = '';
    
    switch (type) {
        case 'success':
            typeClasses = 'bg-green-100 text-green-800 border-green-200';
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
            break;
        case 'error':
            typeClasses = 'bg-red-100 text-red-800 border-red-200';
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
            break;
        case 'warning':
            typeClasses = 'bg-yellow-100 text-yellow-800 border-yellow-200';
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
            break;
        default: // info
            typeClasses = 'bg-blue-100 text-blue-800 border-blue-200';
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
    }

    // Set notification content
    notification.className = `flex items-center p-3 border rounded-lg shadow-md transform transition-all duration-300 ease-in-out ${typeClasses}`;
    notification.innerHTML = `<div class="flex items-center">${icon}<span>${message}</span></div>`;

    // Add to container
    notificationElement.appendChild(notification);

    // Remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
};

/**
 * Initialize the application when the DOM is loaded
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize authentication state
    apiClient.configureAxios();
    
    // Set up forms to use AJAX instead of traditional submission
    setupFormHandlers();
    
    // Set up interactive components
    setupInteractiveComponents();
});

/**
 * Set up AJAX form handlers
 */
function setupFormHandlers() {
    // Login form
    const loginForm = document.querySelector('form[action*="login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = loginForm.querySelector('[name="email"]').value;
            const password = loginForm.querySelector('[name="password"]').value;
            const remember = loginForm.querySelector('[name="remember"]')?.checked || false;
            
            const result = await auth.login({ email, password, remember });
            
            if (result.success) {
                window.showNotification('Connexion réussie', 'success');
                
                // Redirect based on user role
                if (result.user.role === 'admin') {
                    window.location.href = '/admin';
                } else if (result.user.role === 'recruteur') {
                    window.location.href = '/recruteur/dashboard';
                } else {
                    window.location.href = '/candidat/dashboard';
                }
            } else {
                window.showNotification(result.message, 'error');
            }
        });
    }
    
    // Registration form
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const name = registerForm.querySelector('[name="name"]').value;
            const email = registerForm.querySelector('[name="email"]').value;
            const password = registerForm.querySelector('[name="password"]').value;
            const password_confirmation = registerForm.querySelector('[name="password_confirmation"]').value;
            const role = registerForm.querySelector('[name="role"]').value;
            
            const result = await auth.register({ name, email, password, password_confirmation, role });
            
            if (result.success) {
                window.showNotification('Inscription réussie', 'success');
                
                // Redirect based on user role
                if (result.user.role === 'admin') {
                    window.location.href = '/admin';
                } else if (result.user.role === 'recruteur') {
                    window.location.href = '/recruteur/dashboard';
                } else {
                    window.location.href = '/candidat/dashboard';
                }
            } else {
                window.showNotification(result.message, 'error');
            }
        });
    }
}

/**
 * Set up interactive components
 */
function setupInteractiveComponents() {
    // Setup logout buttons
    const logoutButtons = document.querySelectorAll('[data-action="logout"]');
    logoutButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            
            const result = await auth.logout();
            
            if (result.success) {
                window.showNotification('Déconnexion réussie', 'success');
                window.location.href = '/login';
            } else {
                window.showNotification(result.message, 'error');
            }
        });
    });
}

// Expose the API client globally
window.apiClient = apiClient;
window.auth = auth;
window.annonces = annonces;
window.candidatures = candidatures;