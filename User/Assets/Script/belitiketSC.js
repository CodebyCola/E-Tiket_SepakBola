let maxtiket = document.getElementById("jumlah");
let maxqty = parseInt(maxtiket.getAttribute("max"));

document.getElementById("jumlah").addEventListener("input", function () {
  let qty = parseInt(this.value) || 0;
  let price = parseInt(document.getElementById("harga").value);

  if (this.value < 1) {
    this.value = 1;
  }

  if (qty > maxqty) {
    qty = maxqty;
    this.value = qty;
  }

  let total = qty * price;
  document.getElementById("total").textContent =
    "Rp. " + new Intl.NumberFormat("id-ID").format(total);
});

const form = document.querySelector("form");
const btn = document.querySelector(".btn-pay");

form.addEventListener("submit", () => {
  btn.disabled = true;
  btn.textContent = "Processing..";
});
