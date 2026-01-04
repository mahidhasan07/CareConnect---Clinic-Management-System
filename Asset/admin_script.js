// [Content from your script.js]
let doctors = [ { name: "Dr. Smith", spec: "Cardiology", phone: "123-456", fee: 500 } ];
let patients = [ { name: "John Doe", age: 30, gender: "Male", phone: "555-0100" } ];
let medicines = [ { name: "Napa", type: "Tablet", strength: "500mg", maker: "Beximco" } ];
let backups = [ { name: "backup_2025_12_01.sql", date: "2025-12-01" } ];
let appointments = [ { patient: "John Doe", doctor: "Dr. Smith", date: "2025-12-10 10:00 AM", status: "Pending" } ];

function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
}

function openModal(modalId) { document.getElementById(modalId).style.display = "block"; }
function closeModal(modalId) { document.getElementById(modalId).style.display = "none"; }

function renderAll() {
    const docList = document.getElementById('doctor-list');
    docList.innerHTML = "";
    doctors.forEach((doc, index) => {
        docList.innerHTML += `<tr><td>${doc.name}</td><td>${doc.spec}</td><td>${doc.phone}</td><td>$${doc.fee}</td><td><button class="btn-cancel" onclick="deleteItem('doctors', ${index})">Remove</button></td></tr>`;
    });
    const medList = document.getElementById('medicine-list');
    medList.innerHTML = "";
    medicines.forEach((med, index) => {
        medList.innerHTML += `<tr><td>${med.name}</td><td>${med.type}</td><td>${med.strength}</td><td>${med.maker}</td><td><button class="btn-cancel" onclick="deleteItem('medicines', ${index})">Remove</button></td></tr>`;
    });
    const patList = document.getElementById('patient-list');
    patList.innerHTML = "";
    patients.forEach(pat => patList.innerHTML += `<tr><td>${pat.name}</td><td>${pat.age}</td><td>${pat.gender}</td><td>${pat.phone}</td></tr>`);
    const backupList = document.getElementById('backup-list');
    backupList.innerHTML = "";
    backups.forEach(bk => backupList.innerHTML += `<tr><td>${bk.name}</td><td>${bk.date}</td><td><button class="btn-save">Download</button></td></tr>`);
    const apptList = document.getElementById('appointment-list');
    apptList.innerHTML = "";
    appointments.forEach(app => apptList.innerHTML += `<tr><td>${app.patient}</td><td>${app.doctor}</td><td>${app.date}</td><td>${app.status}</td></tr>`);
    
    document.getElementById('total-doctors').innerText = doctors.length;
    document.getElementById('total-patients').innerText = patients.length;
    document.getElementById('total-medicines').innerText = medicines.length;
    document.getElementById('total-appointments').innerText = appointments.length;
}

function saveDoctor(e) {
    e.preventDefault();
    doctors.push({ name: document.getElementById('docName').value, spec: document.getElementById('docSpec').value, phone: document.getElementById('docPhone').value, fee: document.getElementById('docFee').value });
    renderAll(); closeModal('doctor-modal'); e.target.reset();
}

function saveMedicine(e) {
    e.preventDefault();
    medicines.push({ name: document.getElementById('medName').value, type: document.getElementById('medType').value, strength: document.getElementById('medStrength').value, maker: document.getElementById('medMaker').value });
    renderAll(); closeModal('medicine-modal'); e.target.reset();
}


function updateProfile(e) {
    e.preventDefault();
    alert("Profile and Password Updated Successfully!");
}

function deleteItem(type, index) {
    if(confirm("Are you sure?")) {
        if(type === 'doctors') doctors.splice(index, 1);
        if(type === 'medicines') medicines.splice(index, 1);
        renderAll();
    }
}

// *** UPDATED LOGOUT ***
function logout() {
    if(confirm("Are you sure you want to log out?")) {
        window.location.href = '../Controller/logoutCheck.php'; 
    }
}

renderAll();