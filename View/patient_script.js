// [Content from patient-dashboard.js]
let patient = { name: "John Doe", email: "john@example.com", phone: "01700000000", medicalHistory: "Asthma, Mild Hypertension", password: "password123" };
let doctors = [ { id: 1, name: "Dr. Rahim", spec: "Cardiology", fee: "500" }, { id: 2, name: "Dr. Karim", spec: "Neurology", fee: "700" } ];
let myAppointments = [ { id: 101, doctorName: "Dr. Rahim", spec: "Cardiology", date: "2025-12-10", time: "10:00", status: "Pending" } ];
let myPrescriptions = [ { id: 1, doctor: "Dr. Lina", date: "2024-11-20", medicines: "Napa 500mg (1-0-1)", advice: "Drink plenty of water." } ];

function showSection(id) {
  document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
  document.getElementById(id).classList.add("active");
  refreshStats();
}

function logout() {
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = "../Controller/logoutCheck.php";
  }
}

function refreshStats() {
    document.getElementById("stat-appts").innerText = myAppointments.length;
    document.getElementById("stat-presc").innerText = myPrescriptions.length;
}

function updateProfile() {
  patient.name = document.getElementById("patName").value;
  alert("Profile updated successfully!");
}

function filterDoctors() {
  const spec = document.getElementById("specSelect").value;
  const doctorList = document.getElementById("doctorList");
  doctorList.innerHTML = "";
  const filtered = doctors.filter(doc => spec === "All" || doc.spec === spec);
  if (filtered.length === 0) { doctorList.innerHTML = '<div class="card">No doctors found for this specialization.</div>'; return; }
  filtered.forEach(doc => {
    doctorList.innerHTML += `<div class="card"><h3>${doc.name}</h3><p><b>Specialization:</b> ${doc.spec}</p><p><b>Visit Fee:</b> ${doc.fee} BDT</p><button class="action-btn book-btn" onclick="bookAppointment('${doc.name}', '${doc.spec}')">Book Appointment</button></div>`;
  });
}

function bookAppointment(docName, spec) {
    const date = prompt(`Enter preferred date for ${docName} (YYYY-MM-DD):`);
    const time = prompt(`Enter preferred time (HH:MM):`);
    if (date && time) {
        myAppointments.push({ id: Date.now(), doctorName: docName, spec: spec, date: date, time: time, status: "Pending" });
        alert("Appointment booked successfully!");
        renderAppointments(); refreshStats(); showSection('appointments');
    }
}

function renderAppointments() {
  const list = document.getElementById("appointmentList");
  list.innerHTML = "";
  if (myAppointments.length === 0) { list.innerHTML = '<div class="card">You have no scheduled appointments.</div>'; return; }
  myAppointments.forEach((ap, index) => {
    let color = ap.status === 'Pending' ? 'orange' : 'green';
    list.innerHTML += `<div class="card" style="border-top-color: ${color};"><h3>${ap.doctorName} <small>(${ap.spec})</small></h3><p><b>Date:</b> ${ap.date} at ${ap.time}</p><p><b>Status:</b> <span style="color:${color}; font-weight:bold;">${ap.status}</span></p><div style="margin-top:10px;"><button class="action-btn reschedule-btn" onclick="rescheduleAppt(${index})">Reschedule</button><button class="action-btn cancel-btn" onclick="cancelAppt(${index})">Cancel</button></div></div>`;
  });
}

function rescheduleAppt(index) {
    alert("Reschedule request sent to doctor.");
}

function cancelAppt(index) {
    if(confirm("Are you sure you want to cancel this appointment?")) {
        myAppointments.splice(index, 1);
        renderAppointments(); refreshStats();
    }
}

function renderPrescriptions() {
  const list = document.getElementById("prescriptionList");
  list.innerHTML = "";
  if (myPrescriptions.length === 0) { list.innerHTML = '<div class="card">No prescriptions uploaded yet.</div>'; return; }
  myPrescriptions.forEach(p => {
    list.innerHTML += `<div class="card" style="border-top-color: #27ae60;"><h3 style="color:#27ae60;">Prescribed by ${p.doctor}</h3><p><b>Date:</b> ${p.date}</p><hr style="margin: 10px 0; border: 0; border-top: 1px solid #eee;"><p><b>Medicines:</b><br> ${p.medicines}</p><p style="margin-top:10px;"><b>Advice:</b> ${p.advice}</p></div>`;
  });
}

function init() {
  document.getElementById("patName").value = patient.name;
  filterDoctors(); renderAppointments(); renderPrescriptions(); refreshStats(); showSection('dashboard');
}
init();