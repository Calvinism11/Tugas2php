<?php

// Array produk
$produk = array(
    "TV" => array(
        "harga" => 5499000,
        "diskon" => 0.2
    ),
    "Kulkas" => array(
        "harga" => 3599000,
        "diskon" => 0.2
    ),
    "Mesin Cuci" => array(
        "harga" => 3700000,
        "diskon" => 0.2
    ),
    "AC" => array(
        "harga" => 2700000,
        "diskon" => 0.2
    )
);

// Initialize variables with default values
$nama = "";
$produkPilihan = "";
$jumlahBeli = 0;

// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST["nama"];
  $produkPilihan = $_POST["produk"];
  $jumlahBeli = (int)$_POST["jumlahBeli"]; // Ensure integer value for quantity
}

// Calculations (assuming data is valid)
if (isset($produk[$produkPilihan])) { // Check if selected product exists
  $totalBelanja = $produk[$produkPilihan]["harga"] * $jumlahBeli;
  $diskon = $totalBelanja * $produk[$produkPilihan]["diskon"];
  $ppn = 0.1 * ($totalBelanja - $diskon);
  $hargaBersih = $totalBelanja - $diskon + $ppn;
} else {
  // Handle invalid product selection (optional, provide user feedback)
  $hargaBersih = "Produk tidak ditemukan."; // Or a more informative message
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Belanja Barang Elektronik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Form Belanja Barang Elektronik</h1>
    <div class="form-container">
        <form method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pelanggan:</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama; ?>">
                <?php
                if (empty($nama)) {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">Nama Pelanggan harus diisi!</div>";
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="produk" class="form-label">Produk:</label>
                <select name="produk" id="produk" class="form-select">
                    <?php
                    foreach ($produk as $namaProduk => $dataProduk) {
                        echo "<option value=\"$namaProduk\">$namaProduk</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlahBeli" class="form-label">Jumlah Beli:</label>
                <input type="number" name="jumlahBeli" id="jumlahBeli" class="form-control" value="<?php echo $jumlahBeli; ?>"> (angka bulat)
                <?php
                if (empty($jumlahBeli)) {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">Jumlah Beli harus diisi!</div>";
                }
                ?>
            </div>
            <br>
            <br>
            <input type="submit" value="Hitung" class="btn btn-primary">
        </form>

        <?php
        // Display results only if all data is submitted and product is valid
        if (isset($nama) && isset($produkPilihan) && isset($jumlahBeli) && isset($totalBelanja)) {
            ?>
            <h2>Hasil Perhitungan</h2>
            <ul class="list-group">
                <li class="list-group-item">Nama Pelanggan: <?php echo $nama; ?></li>
                <li class="list-group-item">Produk: <?php echo $produkPilihan; ?></li>
                <li class="list-group-item">Jumlah Beli: <?php echo $jumlahBeli; ?></li>
                <li class="list-group-item">Total Belanja: Rp <?php echo number_format($totalBelanja, 0, ',', '.'); ?></li>
                <li class="list-group-item">Diskon: Rp <?php echo number_format($diskon, 0, ',', '.'); ?></li>
                <li class="list-group-item">PPN: Rp <?php echo number_format($ppn, 0, ',', '.'); ?></li>
                <li class="list-group-item">Harga Bersih: Rp <?php echo number_format($hargaBersih, 0, ',', '.'); ?></li>
            </ul>
            <?php
        } else {
            // Display a message if no results are available
            if (isset($nama) && isset($produkPilihan) && isset($jumlahBeli)) {
                echo "<p>Produk tidak ditemukan atau belum dihitung.</p>";
            }
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
