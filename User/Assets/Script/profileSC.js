// Edit Personal Information
const editBtn = document.getElementById("editPersonalBtn");
const cancelBtn = document.getElementById("cancelPersonalBtn");
const formInputs = document.querySelectorAll("#personalInfoForm input");
const formActions = document.querySelector(".form-actions");
const fullname = document.getElementById("fullname");
const telp = document.getElementById("phone");

if (!fullname.value) {
  fullname.placeholder = "Please fill in your full name";
}

if (!telp.value) {
  telp.placeholder = "Please fill in your phone number";
}

editBtn.addEventListener("click", () => {
  formInputs.forEach((input) => (input.disabled = false));
  formActions.style.display = "flex";
  editBtn.style.display = "none";
});

cancelBtn.addEventListener("click", () => {
  formInputs.forEach((input) => (input.disabled = true));
  formActions.style.display = "none";
  editBtn.style.display = "block";
});

