// [Content from your doctor-dashboard.js]
let doctor = { name: "Dr. Rahim", email: "rahim@gmail.com", phone: "0123456789", specialization: "Cardiology", experience: "5", fee: "500" };
let availability = [];
let medicines = ["Paracetamol", "Amoxicillin", "Napa Extra"];
let appointments = [ { id: 1, patientName: "Sabbir", date: "2025-01-10", time: "10:00", status: "Pending" } ];
let patientHistory = [];

function showSection(id) {
  document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
  document.getElementById(id).classList.add("active");
}

function logout() {
  if(confirm("Are you sure you want to log out?")) {
      window.location.href = "../Controller/logoutCheck.php"; 
  }
}

function updateProfile() {
  doctor.name = document.getElementById('docName').value;
  alert("Profile updated successfully!");
}

function addAvailability() {
  const date = document.getElementById('availDate').value;
  const time = document.getElementById('availTime').value;
  if (!date || !time) return alert("Please select both date and time");
  availability.push({ date, time });
  renderAvailability();
}

function renderAvailability() {
  const list = document.getElementById('availabilityList');
  list.innerHTML = "";
  availability.forEach((slot) => {
    list.innerHTML += `<div class="card"><b>Date:</b> ${slot.date} &nbsp; <b>Time:</b> ${slot.time}</div>`;
  });
}

function renderAppointments() {
  const list = document.getElementById('appointmentList');
  list.innerHTML = "";
  if(appointments.length === 0) { list.innerHTML = "<p>No pending appointments.</p>"; return; }

  appointments.forEach((ap, index) => {
    if(ap.status === "Pending" || ap.status === "Rescheduled") {
        list.innerHTML += `
          <div class="card">
            <h3>${ap.patientName}</h3>
            <p><b>When:</b> ${ap.date} at ${ap.time}</p>
            <p><b>Status:</b> ${ap.status}</p>
            <div style="margin-top:10px;">
                <button class="action-btn approve-btn" onclick="approveAppt(${index})">Approve</button>
                <button class="action-btn reject-btn" onclick="rejectAppt(${index})">Reject</button>
                <button class="action-btn reschedule-btn" onclick="rescheduleAppt(${index})">Reschedule</button>
            </div>
          </div>`;
    }
  });
}

function approveAppt(i) {
  appointments[i].status = "Approved";
  moveToHistory(appointments[i]);
  renderAppointments(); 
}

function rejectAppt(i) {
  appointments[i].status = "Rejected";
  alert("Appointment rejected");
  renderAppointments(); 
}

function rescheduleAppt(i) {
  const newDate = prompt("Enter new date (YYYY-MM-DD):", appointments[i].date);
  const newTime = prompt("Enter new time (HH:MM):", appointments[i].time);
  if (!newDate || !newTime) return;
  appointments[i].date = newDate; appointments[i].time = newTime; appointments[i].status = "Rescheduled";
  renderAppointments(); alert("Appointment rescheduled.");
}

function moveToHistory(appt) { patientHistory.push(appt); renderHistory(); }

function renderHistory() {
  const list = document.getElementById('historyList');
  list.innerHTML = "";
  patientHistory.forEach(h => {
    list.innerHTML += `<div class="card" style="border-top-color: #27ae60;"><h3>${h.patientName}</h3><p>${h.date} - ${h.time}</p><p style="color:#27ae60; font-weight:bold;">${h.status}</p></div>`;
  });
}

function loadMedicines() {
  const select = document.getElementById('medicineSelect');
  select.innerHTML = "";
  medicines.forEach(med => {
    const opt = document.createElement("option"); opt.value = med; opt.textContent = med; select.appendChild(opt);
  });
}

function writePrescription() {
  alert("Prescription Saved!");
}

function requestNewMedicine() {
  const name = prompt("Enter medicine name to request from Admin:");
  if (name) alert("Request sent to admin for: " + name);
}

function updateFee() {
  doctor.fee = document.getElementById('visitFee').value;
  alert("Visit fee updated to: " + doctor.fee);
}

function init() {
  document.getElementById('docName').value = doctor.name;
  document.getElementById('docEmail').value = doctor.email;
  document.getElementById('docPhone').value = doctor.phone;
  document.getElementById('docSpec').value = doctor.specialization;
  document.getElementById('docExp').value = doctor.experience;
  document.getElementById('visitFee').value = doctor.fee;
  showSection('profile');
  renderAppointments();
  loadMedicines();
}
init();