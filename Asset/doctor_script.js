// --- NAVIGATION ---
function showSection(id) {
  // Hide all sections
  document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
  // Show selected section
  document.getElementById(id).classList.add("active");
  
  // Helper for hidden class
  document.querySelectorAll(".section").forEach(sec => {
      if(!sec.classList.contains("active")) sec.classList.add("hidden");
      else sec.classList.remove("hidden");
  });
}

// --- LOGOUT ---
function logout() {
  if(confirm("Are you sure you want to log out?")) {
      window.location.href = "../Controller/logoutCheck.php"; 
  }
}

// Initialize: Show Dashboard by default
showSection('dashboard');