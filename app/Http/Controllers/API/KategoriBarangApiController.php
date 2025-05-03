<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;

class KategoriBarangApiController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBarang::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Kategori',
            'data' => $kategoris
        ]);
    }
}
