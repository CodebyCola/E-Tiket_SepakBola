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

const buttons = document.querySelectorAll(".filter-container .right button");
const cards = document.querySelectorAll(".match-card");

// FILTER BUTTONS
buttons.forEach((btn) => {
  btn.addEventListener("click", () => {
    // set active class
    buttons.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");

    const filter = btn.dataset.value;

    cards.forEach((card) => {
      const stock = parseInt(card.dataset.stock);

      if (filter === "all") {
        card.style.display = "block";
      } else if (filter === "available" && stock > 0) {
        card.style.display = "block";
      } else if (filter === "soldout" && stock === 0) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
});

// CHANGE BUY BUTTON TEXT BASED ON STOCK
cards.forEach((card) => {
  const stock = parseInt(card.dataset.stock);
  const btn = card.querySelector(".buy-btn");

  if (stock === 0) {
    btn.textContent = "Sold Out";
    btn.classList.add("soldout");
    btn.href = "#";
    btn.style.pointerEvents = "none";
  }
});
