document.addEventListener("DOMContentLoaded", () => {
  const profileDropdownBtn = document.getElementById("profileDropdownBtn");
  const profileDropdownMenu = document.getElementById("profileDropdownMenu");

  if (profileDropdownBtn && profileDropdownMenu) {
    profileDropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      profileDropdownMenu.classList.toggle("show");
    });
    document.addEventListener("click", () => {
      profileDropdownMenu.classList.remove("show");
    });
  }

  const searchInput = document.getElementById("searchInput");
  const itemCards = document.querySelectorAll(".item-card");

  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const keyword = this.value.toLowerCase().trim();
      itemCards.forEach((card) => {
        const nama = card.getAttribute("data-nama").toLowerCase();
        const merek = card.getAttribute("data-merek").toLowerCase();
        const jenis = card.getAttribute("data-jenis").toLowerCase();
        if (
          nama.includes(keyword) ||
          merek.includes(keyword) ||
          jenis.includes(keyword)
        ) {
          card.style.display = "flex";
        } else {
          card.style.display = "none";
        }
      });
    });
  }

  const logoutLinks = document.querySelectorAll("a[href*='logout.php']");
  logoutLinks.forEach((link) => {
    link.removeAttribute("onclick");
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const targetUrl = this.getAttribute("href");

      Swal.fire({
        title: "YAKIN INGIN KELUAR?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ff4d4d",
        cancelButtonColor: "#ffffff",
        confirmButtonText: "Keluar",
        cancelButtonText: "Batal",
        background: "#ffffff",
        customClass: {
          popup: "swal-neubrutalism-popup",
          confirmButton: "swal-neubrutalism-btn-confirm",
          cancelButton: "swal-neubrutalism-btn-cancel",
          title: "swal-neubrutalism-title",
        },
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = targetUrl;
        }
      });
    });
  });
});

const previewPane = document.getElementById("previewPane");
const inventoryGrid = document.getElementById("inventoryGrid");
const asideContent = document.getElementById("asideDynamicContent");
const itemCardsGlobal = document.querySelectorAll(".item-card");

function closePreviewPane() {
  if (previewPane) previewPane.classList.remove("open");
  if (inventoryGrid) inventoryGrid.classList.remove("split-view-active");
  if (itemCardsGlobal)
    itemCardsGlobal.forEach((c) => c.classList.remove("selected-card"));
}

function openPreviewPane(card, role = "user") {
  const id = card.getAttribute("data-id");
  const nama = card.getAttribute("data-nama");
  const merek = card.getAttribute("data-merek");
  const jenis = card.getAttribute("data-jenis");
  const harga = card.getAttribute("data-harga");
  const stok = card.getAttribute("data-stok");

  let actionButton = "";
  if (role === "admin") {
    actionButton =
      '<hr class="pane-divider" style="margin-top:20px;">' +
      '<a href="prosesBarang.php?aksi=hapus&id=' +
      id +
      '" id="btnHapusBarang" style="display:block; text-align:center; background:#ff4d4d; color:white; padding:12px; font-weight:800; border:3px solid #1a1a1a; box-shadow:3px 3px 0 #1a1a1a; text-decoration:none; margin-top:20px; text-transform:uppercase;">Hapus</a>';
  }

  asideContent.innerHTML =
    `
        <div class="pane-header">
            <h3>Detail Perangkat</h3>
            <button class="close-pane-btn" onclick="closePreviewPane()">✕</button>
        </div>
        <div class="pane-content" style="margin-top:20px;">
            <div class="pane-badge" style="background-color:#33ccff;">` +
    jenis +
    `</div>
            <h2>` +
    nama +
    `</h2>
            <hr class="pane-divider">
            <div class="pane-meta-group">
                <p><strong>Merek Perangkat:</strong> <span>` +
    merek +
    `</span></p>
                <p><strong>Estimasi Harga:</strong> <span>` +
    harga +
    `</span></p>
                <p><strong>Sisa Stok di Gudang:</strong> <span>` +
    stok +
    ` Unit</span></p>
            </div>
            ` +
    actionButton +
    `
        </div>
    `;

  previewPane.classList.add("open");
  if (inventoryGrid) inventoryGrid.classList.add("split-view-active");
  itemCardsGlobal.forEach((c) => c.classList.remove("selected-card"));
  card.classList.add("selected-card");

  const btnHapus = document.getElementById("btnHapusBarang");
  if (btnHapus) {
    btnHapus.addEventListener("click", function (e) {
      e.preventDefault();
      const deleteUrl = this.getAttribute("href");

      Swal.fire({
        title: "HAPUS ITEM INI?",
        text: "Data perangkat akan dihapus permanen dari sistem",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#ff4d4d",
        cancelButtonColor: "#ffffff",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        background: "#ffffff",
        customClass: {
          popup: "swal-neubrutalism-popup",
          confirmButton: "swal-neubrutalism-btn-confirm",
          cancelButton: "swal-neubrutalism-btn-cancel",
          title: "swal-neubrutalism-title",
        },
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = deleteUrl;
        }
      });
    });
  }
}

// Tambah barang
function openTambahBarangPane() {
  let opsiJenis = `<option value="">-- Pilih --</option>`;
  if (typeof kategoriData !== "undefined") {
    kategoriData.forEach((k) => {
      opsiJenis +=
        `<option value="` + k.id_jenis + `">` + k.nama_jenis + `</option>`;
    });
  }

  asideContent.innerHTML = `
        <div class="pane-header">
            <h3>Tambah Barang Baru</h3>
            <button class="close-pane-btn" onclick="closePreviewPane()">✕</button>
        </div>

        <form action="prosesBarang.php" method="POST" enctype="multipart/form-data" class="admin-form-inside">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-group"><label>Nama Perangkat</label><input type="text" name="nama_perangkat" placeholder="masukan nama" required /></div>
            <div class="form-group"><label>Merek Alat</label><input type="text" name="merek" placeholder="masukkan merk" required /></div>
            <div class="form-group"><label>Harga Per Unit (Rp)</label><input type="number" name="harga" placeholder="masukkan harga" required /></div>
            <div class="form-group"><label>Jumlah Stok</label><input type="number" name="stok" placeholder="masukan jumlah stok" required /></div>
            <div class="form-group">
                <label>Kategori Jenis</label>
                <select name="id_jenis" required>
                    ${opsiJenis}
                </select>
            </div>

            <div class="form-group"><label>Upload Foto Kondisi</label><input type="file" name="foto_kondisi" accept="image/*" required style="border:3px solid #1a1a1a; background:#fff; padding:6px;"></div>
            <button type="submit" class="btn-admin-submit">Simpan</button>
        </form>
    `;
  previewPane.classList.add("open");
  if (inventoryGrid) inventoryGrid.classList.add("split-view-active");
  itemCardsGlobal.forEach((c) => c.classList.remove("selected-card"));
}

// Kelola Kategori
function openKategoriPane(e) {
  e.preventDefault();
  document.getElementById("profileDropdownMenu").classList.remove("show");

  let rowsKategori = "";
  let no = 1;
  if (typeof kategoriData !== "undefined") {
    kategoriData.forEach((k) => {
      rowsKategori +=
        "<tr>" +
        '<td style="text-align:center; font-weight:800;">' +
        no++ +
        "</td>" +
        "<td>" +
        k.nama_jenis +
        "</td>" +
        '<td style="text-align:center;"><a href="#" class="btn-mini-delete btn-hapus-kategori" data-url="prosesJenis.php?aksi=hapus&id=' +
        k.id_jenis +
        '">Hapus</a></td>' +
        "</tr>";
    });
  }

  asideContent.innerHTML =
    `
        <div class="pane-header">
            <h3>Kelola Kategori</h3>
            <button class="close-pane-btn" onclick="closePreviewPane()">✕</button>
        </div>
        <form action="prosesJenis.php" method="POST" class="admin-form-inside" style="margin-bottom:20px;">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-group"><label>Nama Kategori Baru</label><input type="text" name="nama_jenis" placeholder="masukkan kategori..." required></div>
            <button type="submit" class="btn-admin-submit" style="background:#ff99ff;">Tambahkan</button>
        </form>
        <h4 style="font-size:0.85rem; text-transform:uppercase; margin-top:15px;">Daftar Kategori</h4>
        <div class="aside-table-wrapper">
            <table class="aside-table">
                <thead><tr><th style="width:40px;">No</th><th>Kategori</th><th style="width:70px;">Edit</th></tr></thead>
                <tbody>` +
    (rowsKategori
      ? rowsKategori
      : '<tr><td colspan="3" style="text-align:center;">Kosong</td></tr>') +
    `</tbody>
            </table>
        </div>
    `;
  previewPane.classList.add("open");
  if (inventoryGrid) inventoryGrid.classList.add("split-view-active");
  itemCardsGlobal.forEach((c) => c.classList.remove("selected-card"));

  document.querySelectorAll(".btn-hapus-kategori").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      const targetUrl = this.getAttribute("data-url");
      Swal.fire({
        title: "HAPUS KATEGORI?",
        text: "Kategori container ini akan dihapus dari sistem.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ff4d4d",
        cancelButtonColor: "#ffffff",
        confirmButtonText: "HAPUS KATEGORI",
        cancelButtonText: "BATAL",
        customClass: {
          popup: "swal-neubrutalism-popup",
          confirmButton: "swal-neubrutalism-btn-confirm",
          cancelButton: "swal-neubrutalism-btn-cancel",
        },
      }).then((res) => {
        if (res.isConfirmed) window.location.href = targetUrl;
      });
    });
  });
}

// Kelola User
function openUserPane(e) {
  e.preventDefault();
  document.getElementById("profileDropdownMenu").classList.remove("show");

  let rowsUser = "";
  if (typeof usersData !== "undefined") {
    usersData.forEach((u) => {
      rowsUser +=
        "<tr>" +
        "<td><strong>" +
        u.username +
        "</strong></td>" +
        '<td style="text-align:center;">' +
        '<form action="prosesUbahRole.php" method="POST" style="margin:0; display:flex; gap:5px; align-items:center;">' +
        '<input type="hidden" name="id_user" value="' +
        u.id +
        '">' +
        '<select name="role_baru" style="padding:4px; font-weight:700; border:2px solid #1a1a1a; background:#fff; font-size:0.75rem; border-radius:4px !important;">' +
        '<option value="user" ' +
        (u.role === "user" ? "selected" : "") +
        ">USER</option>" +
        '<option value="admin" ' +
        (u.role === "admin" ? "selected" : "") +
        ">ADMIN</option>" +
        "</select>" +
        '<button type="submit" class="btn-mini-delete" style="background:#00ff66; color:#1a1a1a;">Set</button>' +
        "</form>" +
        "</td>" +
        "</tr>";
    });
  }

  asideContent.innerHTML =
    `
        <div class="pane-header">
            <h3>Otorisasi Karyawan</h3>
            <button class="close-pane-btn" onclick="closePreviewPane()">✕</button>
        </div>
        <div class="aside-table-wrapper" style="margin-top:15px; max-height:450px;">
            <table class="aside-table">
                <thead><tr><th>Username</th><th style="width:160px; text-align:center;">Ubah Otorisasi</th></tr></thead>
                <tbody>` +
    rowsUser +
    `</tbody>
            </table>
        </div>
    `;
  previewPane.classList.add("open");
  if (inventoryGrid) inventoryGrid.classList.add("split-view-active");
  itemCardsGlobal.forEach((c) => c.classList.remove("selected-card"));
}

// Setting
function openSettingProfilPane(e, usernameSekarang, fotoSekarang) {
  e.preventDefault();
  document.getElementById("profileDropdownMenu").classList.remove("show");

  let avatarHtml =
    '<div class="avatar-profile bg-secondary d-flex align-items-center justify-content-center text-white h1 mx-auto" style="width:100px; height:100px; font-size:2rem; margin-bottom:15px; display:flex; align-items:center; justify-content:center; border-radius:50% !important;">' +
    usernameSekarang.substring(0, 1).toUpperCase() +
    "</div>";
  if (fotoSekarang && fotoSekarang !== "") {
    avatarHtml =
      '<img src="../upload/' +
      fotoSekarang +
      '" class="avatar-profile" style="width:100px; height:100px; border-radius:50% !important; margin-bottom:15px; object-fit:cover; display:block; margin-left:auto; margin-right:auto;">';
  }

  asideContent.innerHTML =
    `
        <div class="pane-header">
            <h3>Pengaturan Profil</h3>
            <button class="close-pane-btn" onclick="closePreviewPane()">✕</button>
        </div>
        <div style="margin-top:20px;">
            ` +
    avatarHtml +
    `
            <form action="../auth/prosesEditProfile.php" method="POST" enctype="multipart/form-data" class="admin-form-inside">
                <div class="form-group">
                    <label>Username Baru</label>
                    <input type="text" name="username" value="` +
    usernameSekarang +
    `" required>
                </div>
                <div class="form-group">
                    <label>Ganti Foto Profil</label>
                    <input type="file" name="foto" accept="image/*" style="border:3px solid #1a1a1a; background:#fff; padding:6px;">
                </div>
                <button type="submit" class="btn-admin-submit" style="background:#ffff00;">Simpan</button>
            </form>
        </div>
    `;
  previewPane.classList.add("open");
  if (inventoryGrid) inventoryGrid.classList.add("split-view-active");
  itemCardsGlobal.forEach((c) => c.classList.remove("selected-card"));
}
