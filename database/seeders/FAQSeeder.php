<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->insert([
            [
                'question' => 'Apakah DEDE SATOE jualan sambal biasanya menyediakan opsi sambal dengan level kepedasan yang berbeda?',
                'answer' => 'Ya, umumnya DEDE SATOE jualan sambal menawarkan beragam level kepedasan, mulai dari yang lembut hingga sangat pedas, sesuai dengan preferensi konsumen.',
            ],
            [
                'question' => 'Bagaimana DEDE SATOE sambal memastikan keamanan pangan dalam produksi sambal mereka?',
                'answer' => 'DEDE SATOE jualan sambal biasanya memastikan keamanan pangan dengan menjaga kebersihan, menggunakan bahan baku yang segar, dan mengikuti prosedur pengolahan yang higienis.',
            ],
            [
                'question' => 'Apakah DEDE SATOE jualan sambal juga menjual produk sambal organik atau dengan labelnon-GMO?',
                'answer' => 'Beberapa DEDE SATOE mungkin menawarkan varian sambal organik atau dengan label non-GMO, tergantung pada nilai dan fokus bisnis masing-masing.',
            ],
            [
                'question' => 'Apakah DEDE SATOE jualan sambal sering berkolaborasi dengan produsen bahan baku lokal?',
                'answer' => 'Ya, banyak DEDE SATOE sambal mengutamakan kolaborasi dengan produsen bahan baku lokal untuk mendukung ekonomi lokal dan memastikan kualitas bahan baku.',
            ],
            [
                'question' => 'Bagaimana DEDE SATOE jualan sambal biasanya menangani masalah ketersediaan bahan baku musiman?',
                'answer' => 'Untuk mengatasi masalah ketersediaan bahan baku musiman, UMKM sambal sering melakukan stok cadangan, kolaborasi dengan petani lokal, atau mengubah resep agar tetap bisa memproduksi sambal sepanjang tahun.',
            ],
        ]);
    }
}
