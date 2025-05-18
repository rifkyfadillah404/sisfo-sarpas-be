final pengembalian = Pengembalian(
  namaPengembali: _namaController.text,
  peminjamanId: _selectedPeminjaman!.id,
  tanggalKembali: _tanggalController.text,
  jumlahDikembalikan: int.parse(_jumlahController.text),
  kondisi: _kondisiController.text,
  denda: _calculateDenda(_kondisiController.text),
  status: 'pending',
  hariTerlambat: 0, // Will be calculated on the server
  dendaKeterlambatan: 0, // Will be calculated on the server
  totalDenda: 0, // Will be calculated on the server
); 