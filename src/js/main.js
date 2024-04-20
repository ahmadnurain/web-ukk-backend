document.addEventListener("DOMContentLoaded", function () {
  // Menambahkan event listener untuk setiap tombol like
  var likeButtons = document.querySelectorAll(".like-button");
  likeButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var fotoId = this.getAttribute("data-foto-id"); // Ambil foto_id dari atribut data-foto-id pada tombol
      var buttonIcon = this.querySelector(".svg"); // Ambil ikon tombol

      // Kirim permintaan AJAX ke LikeController.php
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "controller/LikeController.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
        if (xhr.status === 200) {
          // Respons berhasil, periksa status like dari respons
          var response = JSON.parse(xhr.responseText);
          if (response.status === "liked") {
            // Jika status adalah "liked", tambahkan kelas CSS untuk mengubah warna ikon menjadi merah
            buttonIcon.classList.add("liked");
          } else {
            // Jika status adalah "unliked", hapus kelas CSS untuk mengembalikan warna ikon menjadi hitam
            buttonIcon.classList.remove("liked");
          }
          console.log("Like berhasil");
          // Redirect kembali ke dashboard setelah melakukan like
          window.location.href = "dashboard.php";
        } else {
          // Tangani kesalahan respons
          console.error("Terjadi kesalahan saat melakukan like");
        }
      };
      // Kirim data foto_id ke LikeController.php
      xhr.send("foto_id=" + encodeURIComponent(fotoId));
    });
  });
});

// Add your existing AJAX logic here
/// Fungsi AJAX untuk mengirim komentar
function sendComment(formId, messageId) {
  console.log("Mengirim komentar...");
  var form = document.getElementById(formId);
  var formData = new FormData(form);
  formData.append("submit", "true"); // Tambahkan submit=true untuk menandai pengiriman formulir

  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action, true); // Gunakan form.action untuk mendapatkan URL dari form
  xhr.onload = function () {
    if (xhr.status == 200) {
      console.log("Respon diterima.");
      var response = xhr.responseText;
      var messageElement = document.getElementById(messageId);
      messageElement.innerHTML = response; // Tampilkan pesan dari server

      // Redirect kembali ke dashboard setelah mengirim komentar
      setTimeout(function () {
        window.location.href = "dashboard.php";
      }, 3000); // Redirect setelah 3 detik
    }
  };
  xhr.onerror = function () {
    console.error("Terjadi kesalahan jaringan.");
    var messageElement = document.getElementById(messageId);
    messageElement.innerHTML = "<p>Gagal menyimpan komentar: Terjadi kesalahan jaringan.</p>";
  };
  xhr.send(formData);
}
