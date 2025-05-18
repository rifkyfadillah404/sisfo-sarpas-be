import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sisfo_fe/models/barang_model.dart';
import 'package:sisfo_fe/service/barang_service.dart';
import 'package:sisfo_fe/pages/barang_detail_page.dart';

class BarangPage extends StatefulWidget {
  final String token;
  const BarangPage({Key? key, required this.token}) : super(key: key);

  @override
  State<BarangPage> createState() => _BarangPageState();
}

class _BarangPageState extends State<BarangPage> {
  List<Barang> _allBarangList = [];
  List<Barang> _filteredBarangList = [];
  List<String> _kategoriList = [];
  String? _selectedKategori;
  String _searchQuery = '';
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchBarang();
  }

  void _fetchBarang() async {
    try {
      final list = await BarangService().fetchBarang(widget.token);
      setState(() {
        _allBarangList = list;
        _filteredBarangList = list;
        _kategoriList = _getKategoriList(list);
        _kategoriList.insert(0, 'Semua');
        _isLoading = false;
      });
    } catch (e) {
      setState(() {
        _filteredBarangList = [];
        _isLoading = false;
      });
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Gagal memuat barang: $e'),
          backgroundColor: Colors.redAccent,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
          margin: const EdgeInsets.all(12),
        ),
      );
    }
  }

  List<String> _getKategoriList(List<Barang> barangList) {
    Set<String> kategoriSet = {};
    for (var barang in barangList) {
      kategoriSet.add(barang.kategori.namaKategori);
    }
    return kategoriSet.toList();
  }

  void _filterBarang() {
    setState(() {
      _filteredBarangList = _allBarangList.where((barang) {
        final matchKategori = _selectedKategori == null ||
            _selectedKategori == 'Semua' ||
            barang.kategori.namaKategori == _selectedKategori;
        final matchSearch = barang.nama
            .toLowerCase()
            .contains(_searchQuery.toLowerCase());
        return matchKategori && matchSearch;
      }).toList();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        // Search & Filter Area
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16),
          child: Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  blurRadius: 20,
                  offset: const Offset(0, 5),
                ),
              ],
            ),
            child: Column(
              children: [
                // Search Bar
                Container(
                  decoration: BoxDecoration(
                    color: Colors.grey.shade100,
                    borderRadius: BorderRadius.circular(15),
                  ),
                  child: TextField(
                    onChanged: (value) {
                      setState(() {
                        _searchQuery = value;
                        _filterBarang();
                      });
                    },
                    decoration: InputDecoration(
                      hintText: 'Cari barang...',
                      hintStyle: GoogleFonts.poppins(
                        color: Colors.grey.shade500,
                        fontSize: 14,
                      ),
                      prefixIcon: Icon(
                        Icons.search,
                        color: Colors.grey.shade500,
                      ),
                      border: InputBorder.none,
                      contentPadding: const EdgeInsets.symmetric(vertical: 15),
                    ),
                  ),
                ),
                const SizedBox(height: 16),
                // Category Filter
                SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: _kategoriList.map((kategori) {
                      final isSelected = _selectedKategori == kategori;
                      return Padding(
                        padding: const EdgeInsets.only(right: 10),
                        child: InkWell(
                          onTap: () {
                            setState(() {
                              _selectedKategori = isSelected ? null : kategori;
                              _filterBarang();
                            });
                          },
                          child: Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 16,
                              vertical: 10,
                            ),
                            decoration: BoxDecoration(
                              color: isSelected
                                  ? const Color(0xFF4776E6)
                                  : Colors.grey.shade100,
                              borderRadius: BorderRadius.circular(30),
                            ),
                            child: Text(
                              kategori,
                              style: GoogleFonts.poppins(
                                color: isSelected
                                    ? Colors.white
                                    : Colors.grey.shade700,
                                fontWeight: isSelected
                                    ? FontWeight.w600
                                    : FontWeight.normal,
                                fontSize: 14,
                              ),
                            ),
                          ),
                        ),
                      );
                    }).toList(),
                  ),
                ),
              ],
            ),
          ),
        ),
        // Results Area
        Expanded(
          child: _isLoading
              ? const Center(child: CircularProgressIndicator())
              : _filteredBarangList.isEmpty
                  ? Center(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Image.asset(
                            'assets/images/empty.png',
                            width: 120,
                            height: 120,
                            fit: BoxFit.contain,
                          ),
                          const SizedBox(height: 16),
                          Text(
                            'Tidak ada barang ditemukan',
                            style: GoogleFonts.poppins(
                              fontSize: 16,
                              fontWeight: FontWeight.w600,
                              color: Colors.grey.shade700,
                            ),
                          ),
                          Text(
                            'Coba pencarian atau filter lain',
                            style: GoogleFonts.poppins(
                              fontSize: 14,
                              color: Colors.grey.shade500,
                            ),
                          ),
                        ],
                      ),
                    )
                  : GridView.builder(
                      padding: const EdgeInsets.all(16),
                      gridDelegate:
                          const SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: 2,
                        childAspectRatio: 0.75,
                        crossAxisSpacing: 16,
                        mainAxisSpacing: 16,
                      ),
                      itemCount: _filteredBarangList.length,
                      itemBuilder: (context, index) {
                        final barang = _filteredBarangList[index];
                        return _buildItemCard(barang);
                      },
                    ),
        ),
      ],
    );
  }

  Widget _buildItemCard(Barang barang) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => BarangDetailPage(
              barang: barang,
              token: widget.token,
            ),
          ),
        );
      },
      child: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(20),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.05),
              blurRadius: 10,
              offset: const Offset(0, 5),
            ),
          ],
        ),
        child: ClipRRect(
          borderRadius: BorderRadius.circular(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Item Image with Status Indicator
              Stack(
                children: [
                  // Image
                  Container(
                    height: 150,
                    width: double.infinity,
                    color: Colors.grey.shade200,
                    child: barang.foto != null
                        ? Image.network(
                            barang.foto!,
                            fit: BoxFit.cover,
                            errorBuilder: (context, error, stackTrace) {
                              // Error fallback
                              return const Center(
                                child: Icon(
                                  Icons.broken_image_outlined,
                                  size: 40,
                                  color: Colors.grey,
                                ),
                              );
                            },
                          )
                        : const Center(
                            child: Icon(
                              Icons.image_outlined,
                              size: 40,
                              color: Colors.grey,
                            ),
                          ),
                  ),
                  // Status Tag
                  Positioned(
                    top: 10,
                    right: 10,
                    child: Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 10,
                        vertical: 5,
                      ),
                      decoration: BoxDecoration(
                        color: barang.status == 'baik'
                            ? Colors.green.withOpacity(0.9)
                            : Colors.red.withOpacity(0.9),
                        borderRadius: BorderRadius.circular(30),
                      ),
                      child: Text(
                        barang.status == 'baik' ? 'Baik' : 'Rusak',
                        style: GoogleFonts.poppins(
                          color: Colors.white,
                          fontSize: 12,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ),
                  // Stock badge if stock is low or empty
                  if (barang.stok <= 5)
                    Positioned(
                      bottom: 10,
                      left: 10,
                      child: Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 10,
                          vertical: 5,
                        ),
                        decoration: BoxDecoration(
                          color: barang.stok == 0
                              ? Colors.red.withOpacity(0.9)
                              : Colors.amber.withOpacity(0.9),
                          borderRadius: BorderRadius.circular(30),
                        ),
                        child: Text(
                          barang.stok == 0
                              ? 'Stok Habis'
                              : 'Stok: ${barang.stok}',
                          style: GoogleFonts.poppins(
                            color: Colors.white,
                            fontSize: 12,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ),
                    ),
                ],
              ),
              // Item Info
              Padding(
                padding: const EdgeInsets.all(12),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Item Name
                    Text(
                      barang.nama,
                      style: GoogleFonts.poppins(
                        fontWeight: FontWeight.w600,
                        fontSize: 14,
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                    const SizedBox(height: 4),
                    // Item Category
                    Text(
                      barang.kategori.namaKategori,
                      style: GoogleFonts.poppins(
                        fontSize: 12,
                        color: Colors.grey.shade600,
                      ),
                    ),
                    const SizedBox(height: 8),
                    // Borrow Button or Status
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.symmetric(
                        vertical: 8,
                      ),
                      decoration: BoxDecoration(
                        color: barang.canBeBorrowed
                            ? const Color(0xFF4776E6)
                            : Colors.grey.shade300,
                        borderRadius: BorderRadius.circular(10),
                      ),
                      alignment: Alignment.center,
                      child: Text(
                        barang.canBeBorrowed
                            ? 'Pinjam'
                            : barang.status == 'rusak'
                                ? 'Rusak'
                                : 'Stok Habis',
                        style: GoogleFonts.poppins(
                          color: barang.canBeBorrowed
                              ? Colors.white
                              : Colors.grey.shade700,
                          fontWeight: FontWeight.w500,
                          fontSize: 12,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
} 