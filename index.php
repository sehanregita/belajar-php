
<?php

$nama_wahana = "Waterboom Ceria";

$harga_tiket = [
    "Anak-anak" => 25000,
    "Dewasa" => 40000
];

echo "================================\n";
echo "   PEMBELIAN TIKET WATERBOOM\n";
echo "================================\n\n";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = trim($_POST["nama"] ?? "");
    $jenis = $_POST["jenis"] ?? "";
    $jumlah = filter_var(
        $_POST["jumlah"] ?? "",
        FILTER_VALIDATE_INT
    );
    $uang = filter_var(
        $_POST["uang"] ?? "",
        FILTER_VALIDATE_INT
    );

    if (
        $nama === "" ||
        !isset($harga_tiket[$jenis]) ||
        $jumlah === false || $jumlah < 1 ||
        $uang === false || $uang < 0
    ) {
        echo "Data tidak valid. Periksa kembali pesanan Anda.";
    } else {
        $total = $harga_tiket[$jenis] * $jumlah;

        echo "Nama Pembeli: " .
            htmlspecialchars($nama) . "<br>";
        echo "Jenis Tiket: " .
            htmlspecialchars($jenis) . "<br>";
        echo "Harga Tiket: Rp" .
            number_format($harga_tiket[$jenis], 0, ',', '.') . "<br>";
        echo "Jumlah Tiket: " . $jumlah . "<br>";
        echo "Total Pembayaran: Rp" .
            number_format($total, 0, ',', '.') . "<br>";
        echo "Uang Pembayaran: Rp" .
            number_format($uang, 0, ',', '.') . "<br>";

        if ($uang >= $total) {
            $kembalian = $uang - $total;
            echo "Kembalian: Rp" .
                number_format($kembalian, 0, ',', '.') . "<br>";
            echo "Status: Pembelian berhasil!";
        } else {
            $kurang = $total - $uang;
            echo "Uang kurang: Rp" .
                number_format($kurang, 0, ',', '.') . "<br>";
            echo "Status: Pembayaran belum lunas.";
        }
    }

} else {
?>

<form method="post">
    Nama Pembeli:<br>
    <input type="text" name="nama" required>
    <br><br>

    Jenis Tiket:<br>
    <select name="jenis" required>
        <option value="Anak-anak">Anak-anak - Rp25.000</option>
        <option value="Dewasa">Dewasa - Rp40.000</option>
    </select>
    <br><br>

    Jumlah Tiket:<br>
    <input type="number" name="jumlah" min="1" required>
    <br><br>

    Uang Pembayaran (Rp):<br>
    <input type="number" name="uang" min="0" required>
    <br><br>

    <button type="submit">Beli Tiket</button>
</form>

<?php
}
?>
