<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KamiDaurController extends Controller
{
    /**
     * Menampilkan halaman Kami Daur
     */
    public function index()
    {
        // Data untuk halaman
        $data = [
            'title' => 'Kami Daur - Tentang Kami',
            'description' => 'Kami Daur adalah platform yang berkomitmen untuk mendukung gerakan daur ulang dan pelestarian lingkungan. Melalui berbagai inisiatif dan program, kami bertujuan untuk mengurangi sampah, meningkatkan kesadaran masyarakat, dan menciptakan dampak positif bagi bumi kita.',
            'mission' => [
                'Mengurangi limbah dengan mendorong daur ulang yang efektif',
                'Edukasi masyarakat tentang pentingnya pengelolaan sampah',
                'Membangun komunitas peduli lingkungan',
                'Mengembangkan solusi inovatif untuk pengolahan limbah'
            ],
            'contact' => [
                'phone' => '6281234567890', // Nomor WhatsApp dengan format internasional (tanpa +)
                'email' => 'kami.daur@example.com',
                'address' => 'Jl. Lingkungan Hijau No. 123, Kota Ramah Lingkungan'
            ],
            'features' => [
                [
                    'title' => 'Pengumpulan Sampah',
                    'description' => 'Sistem pengumpulan sampah terpilah yang mudah diakses',
                    'image' => 'waste-collection.jpg'
                ],
                [
                    'title' => 'Pendauran Ulang',
                    'description' => 'Proses daur ulang yang ramah lingkungan dan berkelanjutan',
                    'image' => 'recycling-process.jpg'
                ],
                [
                    'title' => 'Produk Daur Ulang',
                    'description' => 'Hasil kreatif dari bahan daur ulang yang bernilai',
                    'image' => 'recycled-products.jpg'
                ]
            ]
        ];

        return view('kami-daur.index', $data);
    }
}