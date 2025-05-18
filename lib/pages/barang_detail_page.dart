import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sisfo_fe/models/barang_model.dart';
import 'package:sisfo_fe/pages/peminjaman_page.dart';

class BarangDetailPage extends StatelessWidget {
  final Barang barang;
  final String token;

  const BarangDetailPage({
    Key? key,
    required this.barang,
    required this.token,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [Color(0xFF4776E6), Colors.white],
            stops: [0.0, 0.3],
          ),
        ),
        child: SafeArea(
          child: Column(
            children: [
              // Custom App Bar
              Padding(
                padding: const EdgeInsets.fromLTRB(16, 16, 16, 24),
                child: Row(
                  children: [
                    Container(
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.3),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: IconButton(
                        onPressed: () {
                          Navigator.pop(context);
                        },
                        icon: const Icon(Icons.arrow_back_ios_new, color: Colors.white),
                      ),
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: Text(
                        "Detail Barang",
                        style: GoogleFonts.poppins(
                          color: Colors.white,
                          fontSize: 20,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                    Container(
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.3),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: IconButton(
                        onPressed: () {
                          // Share functionality
                          ScaffoldMessenger.of(context).showSnackBar(
                            SnackBar(
                              content: const Text('Berbagi info barang'),
                              backgroundColor: Colors.black87,
                              behavior: SnackBarBehavior.floating,
                              shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(10)),
                              margin: const EdgeInsets.all(12),
                            ),
                          );
                        },
                        icon: const Icon(Icons.share, color: Colors.white),
                      ),
                    ),
                  ],
                ),
              ),

              // Main content in a scrollable area
              Expanded(
                child: SingleChildScrollView(
                  child: Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Image and basic info card
                        Card(
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(20),
                          ),
                          elevation: 2,
                          child: Padding(
                            padding: const EdgeInsets.all(16.0),
                            child: Column(
                              children: [
                                // Image section with conditional display
                                if (barang.foto != null)
                                  Container(
                                    height: 200,
                                    width: double.infinity,
                                    decoration: BoxDecoration(
                                      borderRadius: BorderRadius.circular(16),
                                      image: DecorationImage(
                                        image: NetworkImage(barang.foto!),
                                        fit: BoxFit.cover,
                                      ),
                                    ),
                                  )
                                else
                                  Container(
                                    height: 200,
                                    width: double.infinity,
                                    decoration: BoxDecoration(
                                      color: Colors.grey[200],
                                      borderRadius: BorderRadius.circular(16),
                                    ),
                                    child: const Center(
                                      child: Icon(
                                        Icons.image_not_supported,
                                        size: 50,
                                        color: Colors.grey,
                                      ),
                                    ),
                                  ),
                                const SizedBox(height: 16),
                                // Item name and availability
                                Row(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Expanded(
                                      child: Column(
                                        crossAxisAlignment: CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            barang.nama,
                                            style: GoogleFonts.poppins(
                                              fontSize: 22,
                                              fontWeight: FontWeight.bold,
                                            ),
                                          ),
                                          Text(
                                            "Kode: ${barang.kode}",
                                            style: GoogleFonts.poppins(
                                              fontSize: 14,
                                              color: Colors.grey[600],
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                    // Status badge
                                    Container(
                                      padding: const EdgeInsets.symmetric(
                                        horizontal: 12,
                                        vertical: 6,
                                      ),
                                      decoration: BoxDecoration(
                                        color: barang.status == 'baik'
                                            ? Colors.green.withOpacity(0.2)
                                            : Colors.red.withOpacity(0.2),
                                        borderRadius: BorderRadius.circular(12),
                                      ),
                                      child: Text(
                                        barang.status == 'baik' ? "Baik" : "Rusak",
                                        style: GoogleFonts.poppins(
                                          fontSize: 14,
                                          fontWeight: FontWeight.w600,
                                          color: barang.status == 'baik'
                                              ? Colors.green[700]
                                              : Colors.red[700],
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ),
                        
                        const SizedBox(height: 20),
                        
                        // Detail info section
                        Text(
                          "Informasi Detail",
                          style: GoogleFonts.poppins(
                            fontSize: 18,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        const SizedBox(height: 12),
                        
                        // Details card
                        Card(
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(20),
                          ),
                          elevation: 2,
                          child: Padding(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              children: [
                                // Detail items
                                _buildDetailItem(
                                  Icons.category_outlined,
                                  "Kategori",
                                  barang.kategori.namaKategori,
                                ),
                                const Divider(),
                                
                                _buildDetailItem(
                                  Icons.inventory_2_outlined,
                                  "Stok Tersedia",
                                  "${barang.stok} unit",
                                  valueColor: barang.stok > 0 ? Colors.green : Colors.red,
                                ),
                                const Divider(),
                                
                                _buildDetailItem(
                                  barang.status == 'baik' ? Icons.check_circle_outline : Icons.error_outline,
                                  "Status Barang",
                                  barang.status == 'baik' ? "Baik" : "Rusak",
                                  valueColor: barang.status == 'baik' ? Colors.green : Colors.red,
                                ),
                                
                                if (!barang.canBeBorrowed && barang.status == 'rusak')
                                  Padding(
                                    padding: const EdgeInsets.only(top: 8.0),
                                    child: Container(
                                      width: double.infinity,
                                      padding: const EdgeInsets.all(12),
                                      decoration: BoxDecoration(
                                        color: Colors.red.withOpacity(0.1),
                                        borderRadius: BorderRadius.circular(12),
                                        border: Border.all(color: Colors.red.withOpacity(0.3)),
                                      ),
                                      child: Row(
                                        children: [
                                          Icon(Icons.info_outline, color: Colors.red[700], size: 20),
                                          const SizedBox(width: 8),
                                          Expanded(
                                            child: Text(
                                              "Barang ini dalam kondisi rusak dan tidak dapat dipinjam",
                                              style: GoogleFonts.poppins(
                                                fontSize: 12,
                                                color: Colors.red[700],
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                  ),
                                  
                                if (!barang.canBeBorrowed && barang.status == 'baik')
                                  Padding(
                                    padding: const EdgeInsets.only(top: 8.0),
                                    child: Container(
                                      width: double.infinity,
                                      padding: const EdgeInsets.all(12),
                                      decoration: BoxDecoration(
                                        color: Colors.amber.withOpacity(0.1),
                                        borderRadius: BorderRadius.circular(12),
                                        border: Border.all(color: Colors.amber.withOpacity(0.3)),
                                      ),
                                      child: Row(
                                        children: [
                                          Icon(Icons.info_outline, color: Colors.amber[700], size: 20),
                                          const SizedBox(width: 8),
                                          Expanded(
                                            child: Text(
                                              "Stok barang ini sedang kosong",
                                              style: GoogleFonts.poppins(
                                                fontSize: 12,
                                                color: Colors.amber[700],
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                  ),
                              ],
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),

              // Bottom action button
              Padding(
                padding: const EdgeInsets.all(16.0),
                child: ElevatedButton(
                  onPressed: barang.canBeBorrowed
                      ? () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => PeminjamanPage(
                                token: token,
                                selectedBarang: barang,
                              ),
                            ),
                          );
                        }
                      : null,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF4776E6),
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(vertical: 15),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(15),
                    ),
                    minimumSize: const Size(double.infinity, 55),
                    disabledBackgroundColor: Colors.grey.withOpacity(0.3),
                    disabledForegroundColor: Colors.grey[600],
                  ),
                  child: Text(
                    barang.canBeBorrowed
                        ? "Pinjam Barang"
                        : barang.status == 'rusak'
                            ? "Barang Rusak"
                            : "Stok Kosong",
                    style: GoogleFonts.poppins(
                      fontSize: 16,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  // Helper widget to build detail items
  Widget _buildDetailItem(IconData icon, String label, String value, {Color? valueColor}) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Row(
        children: [
          Icon(icon, color: Colors.grey[600], size: 22),
          const SizedBox(width: 12),
          Expanded(
            child: Text(
              label,
              style: GoogleFonts.poppins(
                color: Colors.grey[700],
                fontSize: 14,
              ),
            ),
          ),
          Text(
            value,
            style: GoogleFonts.poppins(
              fontWeight: FontWeight.w500,
              fontSize: 14,
              color: valueColor,
            ),
          ),
        ],
      ),
    );
  }
} 