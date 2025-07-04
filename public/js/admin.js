console.log('admin.js loaded...........')
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Select All Checkbox
const selectAll = document.getElementById('select-all');
if (selectAll) {

    selectAll.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.review-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
}

// Quick Actions
function quickAction(reviewId, action) {
    const url = `admin/reviews/${reviewId}/${action}`;

    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
        .then(async response => {
            if (!response.ok) {
                const text = await response.text(); // Read raw response
                console.error('Raw response:', text); // Debug HTML if needed
                throw new Error(`Request failed with status ${response.status}`);
            }

            return response.json(); // Only parse JSON if safe
        })
        .then(data => {
            if (data.success) {
                document.getElementById(`status-${reviewId}`).innerHTML = data.status;

                // Show success message
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        });
}

// Toggle Featured
function toggleFeatured(reviewId) {
    const url = `/admin/reviews/${reviewId}/toggle-featured`;

    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    })
        .then(response => { console.log('featured', response); return response.json() })
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');

                // Update the featured status in the UI
                const checkbox = document.querySelector(`input[onclick="toggleFeatured(${reviewId})"]`);
                if (checkbox) {
                    checkbox.checked = data.is_featured;
                }

                // Optionally update stats if they exist
                if (data.stats) {
                    updateStatsCards(data.stats);
                }
            } else {
                showNotification(data.message || 'Failed to update featured status', 'error');

                // Revert checkbox state on error
                const checkbox = document.querySelector(`input[onclick="toggleFeatured(${reviewId})"]`);
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while updating featured status.', 'error');

            // Revert checkbox state on error
            const checkbox = document.querySelector(`input[onclick="toggleFeatured(${reviewId})"]`);
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
            }
        });
}

// Helper function to show notifications
function showNotification(message, type = 'info') {
    // You can customize this based on your notification system
    // Example with a simple alert (replace with your preferred notification library)

    // For Bootstrap toast (if you're using Bootstrap)
    const toastContainer = document.querySelector('.toast-container') || createToastContainer();
    const toast = createToast(message, type);
    toastContainer.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

// Helper function to create toast container
function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
    return container;
}

// Helper function to create toast element
function createToast(message, type) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    const typeClass = type === 'success' ? 'text-bg-success' :
        type === 'error' ? 'text-bg-danger' :
            type === 'warning' ? 'text-bg-warning' : 'text-bg-info';

    toast.innerHTML = `
        <div class="toast-header ${typeClass}">
            <strong class="me-auto">
                ${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'} 
                ${type.charAt(0).toUpperCase() + type.slice(1)}
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;

    return toast;
}

// Helper function to update stats cards (optional)
function updateStatsCards(stats) {
    const totalElement = document.querySelector('.card:nth-child(1) h4');
    const featuredElement = document.querySelector('.card:nth-child(4) h4');

    if (totalElement && stats.total !== undefined) {
        totalElement.textContent = new Intl.NumberFormat().format(stats.total);
    }

    if (featuredElement && stats.featured !== undefined) {
        featuredElement.textContent = new Intl.NumberFormat().format(stats.featured);
    }
}

// Bulk Actions Form Handler
const bulkActionForm = document.getElementById('bulk-action-form');
if (bulkActionForm) {
    bulkActionForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const selectedReviews = document.querySelectorAll('.review-checkbox:checked');
        const action = document.querySelector('select[name="action"]').value;

        if (!action) {
            showNotification('Please select an action.', 'warning');
            return;
        }

        if (selectedReviews.length === 0) {
            showNotification('Please select at least one review.', 'warning');
            return;
        }

        const confirmMessage = `Are you sure you want to ${action} ${selectedReviews.length} review(s)?`;
        if (action === 'delete') {
            if (!confirm(confirmMessage + ' This action cannot be undone.')) {
                return;
            }
        } else if (!confirm(confirmMessage)) {
            return;
        }

        // Submit the form
        this.submit();
    });
}


    let rateIndex = 1;

    const addRateRow = document.getElementById('addRateRow');
    addRateRow.addEventListener('click', function () {
        const tableBody = document.querySelector('#ratesTable tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <div class="input-group input-group-outline">
                    <input type="number" step="0.01" name="rates[${rateIndex}][weight_from]" class="form-control" required>
                </div>
            </td>
            <td>
                <div class="input-group input-group-outline">
                    <input type="number" step="0.01" name="rates[${rateIndex}][weight_to]" class="form-control" required>
                </div>
            </td>
            <td>
                <div class="input-group input-group-outline">
                    <input type="number" step="0.01" name="rates[${rateIndex}][rate]" class="form-control" required>
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-rate"><i class="fas fa-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(newRow);
        rateIndex++;
    });

    // Delegated event listener for removing rows
    document.addEventListener('click', function (e) {
        // Check if the clicked element (or its closest parent) has the 'remove-rate' class
        if (e.target.closest('.remove-rate')) {
            e.target.closest('tr').remove();
        }
    });