// Tiny accessibility: allow Enter to "click" upload area
const upload = document.getElementById("uploadArea");
upload &&
    upload.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            alert("Open file picker (not implemented in demo).");
        }
    });

// Validasi form tambah kapster
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("kapsterForm");

    form.addEventListener("submit", function (e) {
        const nama = document.getElementById("nama").value.trim();
        const nomor = document.getElementById("nomor_hp").value.trim();
        const jabatan = document.getElementById("jabatan").value.trim();
        const password = document.getElementById("password").value.trim();
        const errorMsg = document.getElementById("errorMessage");

        let error = "";

        if (nama === "") error = "Nama tidak boleh kosong";
        else if (nomor === "") error = "Nomor HP wajib diisi";
        else if (jabatan === "") error = "Pilih jabatan dulu";
        else if (password === "") error = "Password wajib diisi";

        if (error !== "") {
            e.preventDefault(); // BLOCK submit
            errorMsg.textContent = error;
            errorMsg.style.display = "block";
        }
    });
});
// untuk data kapster
document.querySelectorAll('.kapster-header').forEach(header => {
    header.addEventListener('click', () => {
        header.parentElement.classList.toggle('active');
    });
});

