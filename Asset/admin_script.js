// --- NAVIGATION ---
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
    // Show the clicked section
    document.getElementById(sectionId).classList.add('active');
}

// --- MODALS ---
function openModal(modalId) { 
    document.getElementById(modalId).style.display = "block"; 
}

function closeModal(modalId) { 
    document.getElementById(modalId).style.display = "none"; 
}

// --- EDIT FUNCTIONS ---

// Open Edit Doctor Modal and pre-fill data
function openEditDoctorModal(id, name, spec, phone, fee) {
    document.getElementById('edit_doc_id').value = id;
    document.getElementById('edit_doc_name').value = name;
    document.getElementById('edit_doc_spec').value = spec;
    document.getElementById('edit_doc_phone').value = phone;
    document.getElementById('edit_doc_fee').value = fee;
    
    openModal('edit-doctor-modal');
}

// Open Edit Medicine Modal and pre-fill data
function openEditMedicineModal(id, name, type, strength, maker) {
    document.getElementById('edit_med_id').value = id;
    document.getElementById('edit_med_name').value = name;
    document.getElementById('edit_med_type').value = type;
    document.getElementById('edit_med_strength').value = strength;
    document.getElementById('edit_med_maker').value = maker;

    openModal('edit-medicine-modal');
}

// --- LOGOUT ---
function logout() {
    if(confirm("Are you sure you want to log out?")) {
        window.location.href = '../Controller/logoutCheck.php'; 
    }
}

// Initialize: Show Dashboard by default
showSection('dashboard');