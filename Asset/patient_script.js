// --- NAVIGATION ---
function showSection(id) {
  // Hide all sections
  document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
  // Show selected section
  document.getElementById(id).classList.add("active");
  
  // Helper to ensure 'hidden' class logic (if used in CSS) is consistent
  document.querySelectorAll(".section").forEach(sec => {
      if(!sec.classList.contains("active")) sec.classList.add("hidden");
      else sec.classList.remove("hidden");
  });
}

// --- LOGOUT ---
function logout() {
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = "../Controller/logoutCheck.php";
  }
}

// Initialize: Show Dashboard by default
showSection('dashboard');

function filterDoctors() {
    let input = document.getElementById('docSearch');
    let filter = input.value.toUpperCase();
    let container = document.getElementById("doctor-list");
    let cards = container.getElementsByClassName('doctor-card');

    for (let i = 0; i < cards.length; i++) {
        let h3 = cards[i].getElementsByTagName("h3")[0];
        let txtValue = h3.textContent || h3.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}