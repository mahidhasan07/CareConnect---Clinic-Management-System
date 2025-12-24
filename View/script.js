function toggleFields() {
    var role = document.getElementById("role").value;
    var specField = document.getElementById("specialization-group");
    
    if (role === "doctor") {
        specField.style.display = "block";
    } else {
        specField.style.display = "none";
    }
}