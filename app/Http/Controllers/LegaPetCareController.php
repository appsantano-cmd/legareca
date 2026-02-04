<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegaPetCareController extends Controller
{
    /**
     * Menampilkan halaman Lega Pet Care
     */
    public function index()
    {
        $data = [
            'title' => 'Lega Pet Care - Layanan Perawatan Hewan Peliharaan',
            'tagline' => 'Perawatan Terbaik untuk Sahabat Berbulu Anda',
            'services' => [
                [
                    'id' => 'grooming',
                    'title' => 'Grooming',
                    'description' => 'Layanan grooming profesional untuk menjaga kesehatan dan kecantikan bulu hewan peliharaan Anda.',
                    'icon' => 'fas fa-bath',
                    'features' => [
                        'Mandiprofesional dengan shampoo khusus',
                        'Potong dan styling bulu',
                        'Pembersihan telinga dan kuku',
                        'Sikat gigi dan perawatan mulut',
                        'Relaxing pet spa treatment'
                    ],
                    'price_range' => 'Rp 50.000 - Rp 300.000',
                    'image' => 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7'
                ],
                [
                    'id' => 'daycare',
                    'title' => 'Day Care',
                    'description' => 'Tempat penitipan hewan harian dengan pengawasan 24 jam dan aktivitas menyenangkan.',
                    'icon' => 'fas fa-sun',
                    'features' => [
                        'Pengawasan penuh oleh pet sitter profesional',
                        'Aktivitas bermain dan sosialisasi',
                        'Makan teratur sesuai jadwal',
                        'Area bermain indoor dan outdoor',
                        'Laporan harian untuk pemilik'
                    ],
                    'price_range' => 'Rp 75.000 - Rp 150.000/hari',
                    'image' => 'https://images.unsplash.com/photo-1450778869180-41d0601e046e'
                ],
                [
                    'id' => 'dog-hotel',
                    'title' => 'Dog Hotel',
                    'description' => 'Akomodasi mewah untuk anjing Anda dengan fasilitas lengkap dan kenyamanan maksimal.',
                    'icon' => 'fas fa-dog',
                    'features' => [
                        'Kamar private dengan AC',
                        'Tempat tidur nyaman dan bersih',
                        'Jadwal makan dan olahraga teratur',
                        'Play area dengan mainan',
                        'CCTV monitoring 24 jam'
                    ],
                    'price_range' => 'Rp 100.000 - Rp 250.000/malam',
                    'image' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1'
                ],
                [
                    'id' => 'cat-hotel',
                    'title' => 'Cat Hotel',
                    'description' => 'Tempat menginap yang aman dan nyaman untuk kucing dengan perhatian khusus.',
                    'icon' => 'fas fa-cat',
                    'features' => [
                        'Ruang khusus dengan privacy tinggi',
                        'Litter box bersih dan terawat',
                        'Mainan dan scratching post',
                        'Area tinggi untuk memanjat',
                        'Pengawasan kamera 24 jam'
                    ],
                    'price_range' => 'Rp 80.000 - Rp 200.000/malam',
                    'image' => 'https://images.unsplash.com/photo-1513360371669-4adf3dd7dff8'
                ],
                [
                    'id' => 'pet school',
                    'title' => 'Pet School',
                    'description' => 'Pet School untuk melatih Pet sehingga menjadi lebih cerdas.',
                    'icon' => 'fas fa-sun',
                    'features' => [
                        'Sekolah untuk Pet',
                        'Litter box bersih dan terawat',
                        'Area tinggi untuk memanjat',
                        'Pengawasan kamera 24 jam'
                    ],
                    'price_range' => 'Rp 80.000 - Rp 200.000/malam',
                    'image' => 'https://unsplash.com/photos/a-man-standing-in-the-grass-with-three-dogs--j9_JMDCUxY'
                ] 

            ],
            'testimonials' => [
                [
                    'name' => 'Budi Santoso',
                    'pet' => 'Max (Golden Retriever)',
                    'text' => 'Max selalu senang ke Lega Pet Care untuk grooming. Pet groomer-nya sangat sabar dan profesional!',
                    'rating' => 5
                ],
                [
                    'name' => 'Sari Dewi',
                    'pet' => 'Milo (Persian Cat)',
                    'text' => 'Cat hotel-nya nyaman banget! Milo betah menginap selama saya liburan. Terima kasih!',
                    'rating' => 5
                ],
                [
                    'name' => 'Ahmad Rizki',
                    'pet' => 'Rocky (Poodle)',
                    'text' => 'Day care service-nya sangat membantu saat saya kerja. Rocky dapat teman baru dan selalu happy!',
                    'rating' => 4
                ]
            ],
            'contact' => [
                'phone' => '6281122334455',
                'email' => 'petcare@legareca.com',
                'address' => 'Jl. Animal Care No. 123, Kota Pet Friendly',
                'hours' => [
                    'weekdays' => '07:00 - 21:00',
                    'weekends' => '08:00 - 20:00'
                ]
            ],
            'faqs' => [
                [
                    'question' => 'Apakah perlu reservasi terlebih dahulu?',
                    'answer' => 'Ya, kami sarankan reservasi minimal 1 hari sebelumnya untuk memastikan ketersediaan slot.'
                ],
                [
                    'question' => 'Vaksinasi apa saja yang diperlukan?',
                    'answer' => 'Hewan harus sudah divaksin rabies dan DHLPP (untuk anjing) atau FVRCP (untuk kucing).'
                ],
                [
                    'question' => 'Bolehkah membawa makanan sendiri?',
                    'answer' => 'Tentu! Anda bisa membawa makanan kesukaan peliharaan Anda, atau menggunakan makanan kami.'
                ]
            ]
        ];

        return view('lega-pet-care.index', $data);
    }
}