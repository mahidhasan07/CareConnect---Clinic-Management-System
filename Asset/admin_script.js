function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
    
    const target = document.getElementById(sectionId);
    if (target) {
        target.classList.add('active');
    }
}

function filterTable(inputId, tableId) {
    let input = document.getElementById(inputId);
    let filter = input.value.toLowerCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let rowText = tr[i].innerText.toLowerCase();
        
        tr[i].style.display = rowText.includes(filter) ? "" : "none";
    }
}

function openModal(modalId) { 
    document.getElementById(modalId).style.display = "block"; 
}

function closeModal(modalId) { 
    document.getElementById(modalId).style.display = "none"; 
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}

function openEditDoctorModal(id, name, spec, phone, fee) {
    document.getElementById('edit_doc_id').value = id;
    document.getElementById('edit_doc_name').value = name;
    document.getElementById('edit_doc_spec').value = spec;
    document.getElementById('edit_doc_phone').value = phone;
    document.getElementById('edit_doc_fee').value = fee;
    
    openModal('edit-doctor-modal');
}

function openEditMedicineModal(id, name, type, strength, maker) {
    document.getElementById('edit_med_id').value = id;
    document.getElementById('edit_med_name').value = name;
    document.getElementById('edit_med_type').value = type;
    document.getElementById('edit_med_strength').value = strength;
    document.getElementById('edit_med_maker').value = maker;

    openModal('edit-medicine-modal');
}

function logout() {
    if(confirm("Are you sure you want to log out?")) {
        window.location.href = '../Controller/logoutCheck.php'; 
    }
}

document.addEventListener("DOMContentLoaded", function() {
    showSection('dashboard');
});