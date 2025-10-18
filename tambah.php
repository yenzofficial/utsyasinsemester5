<?php 
include 'koneksi.php';

// Proses simpan data
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $umur = mysqli_real_escape_string($koneksi, $_POST['umur']);
    $jurusan_id = isset($_POST['jurusan_id']) ? mysqli_real_escape_string($koneksi, $_POST['jurusan_id']) : '';

    $cek_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM mahasiswa LIKE 'jurusan_id'");
    if (mysqli_num_rows($cek_kolom) > 0) {
        $query = "INSERT INTO mahasiswa (nama, jurusan_id, umur) VALUES ('$nama', '$jurusan_id', '$umur')";
    } else {
        $jurusan_nama = '';
        if (!empty($jurusan_id)) {
            $getNama = mysqli_query($koneksi, "SELECT nama FROM jurusan WHERE id='$jurusan_id'");
            if ($row = mysqli_fetch_assoc($getNama)) {
                $jurusan_nama = $row['nama'];
            }
        }
        $query = "INSERT INTO mahasiswa (nama, jurusan, umur) VALUES ('$nama', '$jurusan_nama', '$umur')";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil 🎉',
                text: 'Data mahasiswa berhasil ditambahkan!',
                showConfirmButton: false,
                timer: 1600,
                background: '#0f172a',
                color: '#e2e8f0',
            }).then(() => window.location = 'index.php');
        }, 300);
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal 💥',
            text: 'Terjadi kesalahan saat menyimpan data!',
            background: '#0f172a',
            color: '#e2e8f0'
        });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Mahasiswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gradient-to-br from-black via-gray-900 to-blue-900 text-gray-100 min-h-screen flex justify-center items-center p-8">

  <div class="relative w-full max-w-lg">
    <!-- Glow biru halus -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-cyan-600 to-blue-900 rounded-3xl blur-2xl opacity-30"></div>

    <!-- Card utama -->
    <div class="relative bg-gray-800/70 backdrop-blur-xl border border-blue-800/40 rounded-3xl shadow-2xl p-8">
      <h1 class="text-3xl font-bold text-center bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent mb-6 drop-shadow-lg">
        Tambah Mahasiswa
      </h1>

      <form action="" method="POST" class="space-y-5">
        <!-- Nama -->
        <div>
          <label class="block font-semibold mb-2 text-gray-300">Nama Mahasiswa</label>
          <input type="text" name="nama" required
                 class="w-full bg-gray-700/50 border border-blue-800/30 rounded-xl px-4 py-2 text-gray-100
                        focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400"
                 placeholder="Masukkan nama mahasiswa...">
        </div>

        <!-- Jurusan -->
        <div>
          <label class="block font-semibold mb-2 text-gray-300">Jurusan</label>
          <select name="jurusan_id" required
                  class="w-full bg-gray-700/50 border border-blue-800/30 rounded-xl px-4 py-2 text-gray-100
                         focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition-all duration-200">
            <option value="">— Pilih Jurusan —</option>
            <?php
            $jurusan = mysqli_query($koneksi, "SHOW TABLES LIKE 'jurusan'");
            if (mysqli_num_rows($jurusan) > 0) {
                $jurusan_data = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY id ASC");
                if (mysqli_num_rows($jurusan_data) > 0) {
                    while ($row = mysqli_fetch_assoc($jurusan_data)) {
                        echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                    }
                } else {
                    echo "<option disabled>Belum ada data jurusan</option>";
                }
            } else {
                echo "<option disabled>Tabel jurusan belum dibuat</option>";
            }
            ?>
          </select>
        </div>

        <!-- Umur -->
        <div>
          <label class="block font-semibold mb-2 text-gray-300">Umur</label>
          <input type="number" name="umur" required
                 class="w-full bg-gray-700/50 border border-blue-800/30 rounded-xl px-4 py-2 text-gray-100
                        focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition-all duration-200 placeholder-gray-400"
                 placeholder="Masukkan umur mahasiswa...">
        </div>

        <!-- Tombol -->
        <div class="flex justify-between items-center mt-8">
          <a href="index.php" 
             class="text-gray-400 hover:text-cyan-400 transition font-semibold flex items-center gap-1">
            ← Kembali
          </a>
          <button type="submit" name="submit"
                  class="bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-400 hover:from-blue-500 hover:via-cyan-400 hover:to-blue-300 
                         text-white font-semibold px-6 py-2 rounded-xl shadow-lg hover:shadow-cyan-400/40 
                         transition duration-300 transform hover:-translate-y-0.5">
            Simpan Data
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
