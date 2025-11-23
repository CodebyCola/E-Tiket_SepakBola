document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".match-card");

  cards.forEach((card, i) => {
    setTimeout(() => {
      card.classList.add("show");
    }, i * 150);
  });
});

const search = document.getElementById("search");
search.addEventListener("input", function () {
  const value = this.value.toLowerCase();
  const cards = document.querySelectorAll(".match-card");

  cards.forEach((card) => {
    const text = card.innerText.toLowerCase();
    card.style.display = text.includes(value) ? "" : "none";
  });
});
