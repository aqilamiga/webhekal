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

// untuk deteksi wajah
function mulaiDeteksi() {
    document.getElementById("status").innerText = "Sedang mendeteksi wajah...";

    fetch("./not-to-show/run_detect.php")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("status").innerText = "Deteksi berhasil!";
                document.getElementById("hasil-foto").style.display = "block";
                document.getElementById("hasil-foto").src = data.image;
                document.getElementById("bentuk_wajah").value = data.face_shape;
            } else {
                document.getElementById("status").innerText = "Gagal mendeteksi wajah.";
            }
        })
        .catch(err => {
            document.getElementById("status").innerText = "Terjadi error.";
        });
}

// untuk data kapster
document.querySelectorAll('.kapster-header').forEach(header => {
    header.addEventListener('click', () => {
        header.parentElement.classList.toggle('active');
    });
});

