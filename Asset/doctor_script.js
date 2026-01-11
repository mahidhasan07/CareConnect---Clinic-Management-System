
function showSection(id) {
  
  document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
  
  document.getElementById(id).classList.add("active");
  
  
  document.querySelectorAll(".section").forEach(sec => {
      if(!sec.classList.contains("active")) sec.classList.add("hidden");
      else sec.classList.remove("hidden");
  });
}


function logout() {
  if(confirm("Are you sure you want to log out?")) {
      window.location.href = "../Controller/logoutCheck.php"; 
  }
}

showSection('dashboard');