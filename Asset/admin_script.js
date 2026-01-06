// --- 1. NAVIGATION CONTROL ---
/**
 * Switches between different dashboard sections (Dashboard, Doctors, etc.)
 */
function showSection(sectionId) {
    // Hide all sections by removing the 'active' class
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
    
    // Show the targeted section
    const target = document.getElementById(sectionId);
    if (target) {
        target.classList.add('active');
    }
}

// --- 2. UNIVERSAL SEARCH FILTER ---
/**
 * Filters any table based on user input in real-time
 * @param {string} inputId - The ID of the search text box
 * @param {string} tableId - The ID of the table to filter
 */
function filterTable(inputId, tableId) {
    let input = document.getElementById(inputId);
    let filter = input.value.toLowerCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName("tr");

    // Loop through all table rows, except the first (header)
    for (let i = 1; i < tr.length; i++) {
        // Get the combined text content of the entire row
        let rowText = tr[i].innerText.toLowerCase();
        
        // If the filter string matches any part of the row text, show it; otherwise hide it
        tr[i].style.display = rowText.includes(filter) ? "" : "none";
    }
}

// --- 3. MODAL MANAGEMENT ---
function openModal(modalId) { 
    document.getElementById(modalId).style.display = "block"; 
}

function closeModal(modalId) { 
    document.getElementById(modalId).style.display = "none"; 
}

// Close modal automatically if user clicks on the dark background area
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}

// --- 4. DOCTOR EDIT LOGIC ---
/**
 * Pre-fills the Edit Doctor Modal with existing data
 */
function openEditDoctorModal(id, name, spec, phone, fee) {
    document.getElementById('edit_doc_id').value = id;
    document.getElementById('edit_doc_name').value = name;
    document.getElementById('edit_doc_spec').value = spec;
    document.getElementById('edit_doc_phone').value = phone;
    document.getElementById('edit_doc_fee').value = fee;
    
    openModal('edit-doctor-modal');
}

// --- 5. MEDICINE EDIT LOGIC ---
/**
 * Pre-fills the Edit Medicine Modal with existing data
 */
function openEditMedicineModal(id, name, type, strength, maker) {
    document.getElementById('edit_med_id').value = id;
    document.getElementById('edit_med_name').value = name;
    document.getElementById('edit_med_type').value = type;
    document.getElementById('edit_med_strength').value = strength;
    document.getElementById('edit_med_maker').value = maker;

    openModal('edit-medicine-modal');
}

// --- 6. LOGOUT ---
function logout() {
    if(confirm("Are you sure you want to log out?")) {
        window.location.href = '../Controller/logoutCheck.php'; 
    }
}

// --- 7. INITIALIZATION ---
// Ensure the dashboard is shown by default when the page loads
document.addEventListener("DOMContentLoaded", function() {
    showSection('dashboard');
});