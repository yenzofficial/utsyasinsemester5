<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn 0.5s ease-in-out; }
  </style>
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-blue-900 text-gray-100 min-h-screen py-10 px-5">

  <div class="max-w-6xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-blue-800/40 rounded-3xl shadow-2xl p-10 fade-in">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-10">
      <h1 class="text-4xl font-extrabold text-center md:text-left bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent drop-shadow-lg">
        Data Mahasiswa
      </h1>
      <a href="tambah.php"
         class="mt-4 md:mt-0 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500
                hover:from-blue-500 hover:via-cyan-400 hover:to-blue-400
                text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg
                hover:shadow-cyan-400/40 transition-all duration-300 transform hover:-translate-y-0.5">
        + Tambah Data
      </a>
    </div>

    <!-- Notifikasi -->
    <?php if (isset($_GET['pesan'])): ?>
      <div class="mb-6 p-4 rounded-xl text-center font-medium backdrop-blur-lg
        <?= $_GET['pesan'] === 'sukses'
          ? 'bg-green-900/40 text-green-300 border border-green-700/70'
          : 'bg-red-900/40 text-red-300 border border-red-700/70' ?>">
        <?= $_GET['pesan'] === 'sukses' ? '✅ Data berhasil disimpan!' : '❌ Terjadi kesalahan!' ?>
      </div>
    <?php endif; ?>

    <!-- Tabel -->
    <div class="overflow-hidden rounded-2xl border border-blue-800/40 shadow-xl">
      <table class="w-full text-sm text-gray-300">
        <thead class="bg-gradient-to-r from-blue-800 via-blue-700 to-cyan-600 text-gray-100 uppercase tracking-wider">
          <tr>
            <th class="py-3 px-4 text-left">ID</th>
            <th class="py-3 px-4 text-left">Nama</th>
            <th class="py-3 px-4 text-left">Jurusan</th>
            <th class="py-3 px-4 text-left">Umur</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-blue-900/40">
          <?php
          $query = "SELECT m.id, m.nama, m.umur, j.nama AS jurusan 
                    FROM mahasiswa m 
                    LEFT JOIN jurusan j ON m.jurusan_id = j.id
                    ORDER BY m.id ASC";
          $result = mysqli_query($koneksi, $query);

          if (!$result) {
            echo "<tr><td colspan='5' class='text-center py-6 text-red-400'>
                    ⚠️ Terjadi kesalahan query: " . htmlspecialchars(mysqli_error($koneksi)) . "
                  </td></tr>";
          } else {
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $jurusan = $row['jurusan'] ?? '-';
                echo "
                <tr class='hover:bg-blue-900/30 transition-all duration-200'>
                  <td class='py-3 px-4'>{$row['id']}</td>
                  <td class='py-3 px-4 font-medium text-gray-100'>{$row['nama']}</td>
                  <td class='py-3 px-4 text-blue-300'>{$jurusan}</td>
                  <td class='py-3 px-4'>{$row['umur']}</td>
                  <td class='py-3 px-4 text-center'>
                    <a href=\"edit.php?id={$row['id']}\"
                       class=\"text-cyan-400 hover:text-cyan-300 font-semibold transition\">Edit</a>
                    <span class=\"text-gray-500 mx-1\">|</span>
                    <a href=\"hapus.php?id={$row['id']}\"
                       onclick=\"return confirm('Yakin mau dihapus nih serius? 🥺')\"
                       class=\"text-red-400 hover:text-red-300 font-semibold transition\">Hapus</a>
                  </td>
                </tr>";
              }
            } else {
              echo "<tr><td colspan='5' class='text-center py-8 text-gray-500 italic'>
                      Belum ada data mahasiswa 💤
                    </td></tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Footer -->
    <div class="mt-10 text-center text-gray-500 text-sm">
      <p>© <?= date('Y'); ?> UTS Pemrograman Web 3 | by 
        <span class="font-semibold text-blue-400">Yasin Umar Sardi Amelz</span>
      </p>
    </div>

  </div>

</body>
</html>
