class Barang {
  final int id;
  final String nama;
  final String kode;
  final int stok;
  final int idKategori;
  final String status;
  final String? foto;
  final Kategori kategori;

  Barang({
    required this.id,
    required this.nama,
    required this.kode,
    required this.stok,
    required this.idKategori,
    required this.status,
    this.foto,
    required this.kategori,
  });

  factory Barang.fromJson(Map<String, dynamic> json) {
    return Barang(
      id: json['id'],
      nama: json['nama'] ?? '',
      kode: json['kode'] ?? '',
      stok: json['stok'] ?? 0,
      idKategori: json['id_kategori'] ?? 0,
      status: json['status'] ?? 'baik',
      foto: json['foto']?.toString(),
      kategori: Kategori.fromJson(json['kategori'] ?? {}),
    );
  }
  
  bool get canBeBorrowed => status == 'baik' && stok > 0;
} 