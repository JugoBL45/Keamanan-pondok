<?php

namespace Database\Seeders;

use App\Models\MasterPelanggaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterPelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // ADMINISTRASI
            [
                'nama' => 'Merubah foto atau identitas KTK',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ADMINISTRASI',
                'max' => 0
            ],
            [
                'nama' => 'Menyalahgunakan KTK',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ADMINISTRASI',
                'max' => 0
            ],
            [
                'nama' => 'Membuat Atribut dan pungutan tanpa seizin Pengasuh',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ADMINISTRASI',
                'max' => 0
            ],
            [
                'nama' => 'Menunggak pembayaran tanpa ada alasan yang jelas',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ADMINISTRASI',
                'max' => 0
            ],
            [
                'nama' => 'Tidak memakai seragam sesuai yang ditentukan pondok dan madrasah',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ADMINISTRASI',
                'max' => 0
            ],
            [
                'nama' => 'Memalsukan tanda tangan',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ADMINISTRASI',
                'max' => 0
            ],

            // ORGANISASI
            [
                'nama' => 'Menjadi anggota organisasi atau mengikuti kegiatan ekstra yang tidak ada kaitan langsung dengan Pondok Pesantren dan Madrasah, kecuali mendapat izin pengasuh',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ORGANISASI',
                'max' => 0
            ],
            [
                'nama' => 'Menyalahgunakan izin organisasi',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ORGANISASI',
                'max' => 0
            ],
            [
                'nama' => 'Tidak menjalankan tugas ketika menjadi anggota organisasi pondok pesantren seperti jamiyah, musyawaroh dan ekstrakulikuler',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'ORGANISASI',
                'max' => 0
            ],

            // KEAMANAN
            [
                'nama' => 'Melakukan larangan Syar’I seperti Zina, mencuri, taruhan, menggosob, mentato dan lain-lain',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Membawa, Mengkonsumsi, memiliki, menyimpan, atau mengedarkan miras, narkoba dan sejenisnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Menonton Film, bermain PS, Bilyard, karambol, Remi dan sejenisnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Mengakses jejaring sosial dan situs-situs yang berbau pornografi',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Membawa, menyimpan atau menitipkan Senjata Tajam (SAJAM)',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Mengganggu, berkenalan dengan anak putri atau menerimanya sebagai tamu yang bukan mahromnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => '',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Bertengkar dan segala jenis permusuhan lainnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Dikeluarkan dari pondok',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Berambut gondrong, bersemir, berkuku panjang, memakai anting, gelang dan segala aksesoris sejenis',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Renang, rekreasi, melihat konser, pertunjukan bazar dan sejenisnya',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Membawa motor kecuali mendapat izin dari pengasuh',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Merokok bagi santri yang masih duduk di bangku sekolah formal',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Merokok di luar lingkungan Pondok pesantren Salafiyah Sholawat bagi santri yang masih dibawah umur 20 tahun',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Mandi atau mencuci ketika kegiatan pondok atau madrasah berlangsung',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Mandi hujan di luar lingkungan Pondok',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Makan di luar pondok dan selain kantin dzuriah',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Tidur di tempat yang tidak pada semestinya',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Menyalahgunakan surat izin',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Surat menyurat antar lawan jenis yang bukan mahromnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Berada di luar lingkungan pondok tanpa izin pengasuh',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Memakai celana tiga perempat atau setinggi lutut, baju robek, dan sejenisnya',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Memiliki, menyimpan, melihat, membaca dan mengedarkan buku atau gambar yang berbau porno di kalangan pondok',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Memiliki, menyimpan, membaca dan mengedarkan novel, komik, majalah dan tabloid',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Mengikuti, mengadakan demonstrasi, unjuk rasa dan sejenisnya',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Menyimpan dan membawa flasdisk, Sim Card HP dan sejenisnya',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Menyimpan, membawa dan menitipkan alat-alat musik dan sejenisnya, seperti Radio, Tape Recorder, HP, dan alat elektronik lainnya',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Berada di luar lingkungan Pondok Pesantren Salafiyah Sholawat di atas pkl 22.00 WIB',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Membawa dan memiliki flasdisk di atas 4 Gb, untuk tingkatan mahasiswa',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Membawa sepeda motor bagi tingkatan tsanawiyah dan SMK kecuali ada izin dari pengasuh',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Membuka wirausaha atau bisnis untuk kepentingan pribadi',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Melakukan tindakan bullying, perundungan dan sejenisnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Melakukan pelecehan seksual dan sejenisnya',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Mengintip santri putri atau lawan jenis',
                'level' => 3,
                'denda' => 5000000,
                'hukuman' => 'Surat Peringatan / Dikeluarkan dari pondok (Pertimbangan Pengasuh)',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],
            [
                'nama' => 'Menitipkan uang kepada pengurus yang telah ditunjuk oleh pengasuh bagi santri yang membawa uang lebih dari RP.50.000,-',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'KEAMANAN',
                'max' => 0
            ],

            // ETIKA
            [
                'nama' => 'Bergurau atau duduk di tepi jalan dan tempat-tempat yang tidak semestinya',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.', 
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Menghina atau melawan Pengasuh, pengurus dan guru',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Mencaci atau menghina tamu',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Mengumpat (misuh), berkata jorok dan memanggil dengan kata yang tidak pantas',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis,Gundul,Berdiri pada setiap kegiatan selama satu minggu,Membersihkan WC,Disita barang buktinya.',
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Membuat gaduh di jadang',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita',
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Mengotori, bermain dan gaduh di masjid',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita',
                'larangan' => 'ETIKA',
                'max' => 0
            ],
            [
                'nama' => 'Menggosob sendal atau barang tamu',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita',
                'larangan' => 'ETIKA',
                'max' => 0
            ],

             // KEBERSIHAN, KESEHATAN, DAN FASILITAS
             [
                'nama' => 'Membuang sampah tidak pada tempatnya',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Buang air kecil / besar di selain tempat yang sudah disediakan',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Corat-coret pada dinding, lantai, lemari dll',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Menempatkan sepeda motor tidak pada tempatnya',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Merusak dan memindah inventaris Pondok dan Madrasah',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Memelihara binatang',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Menaiki atap dan pagar',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Menelantarkan pakaian',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Membuat laporan palsu',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Merusak fasilitas',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Nongkrong/ngobrol, dan tidur di ruang tamu',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Menggunakan kamar mandi tamu',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Memasukan sesuatu kedalam air yang dapat merubah warna, rasa, dan bau',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Membuang bekas peralatan mandi di dalam jeding',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Merubah dan menambah instalansi atau tegangan listrik',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Merusak instalansi listrik atau fasilitas Pondok yang berkaitan dengan listrik dan pengairan',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],
            [
                'nama' => 'Mencuri fasilitas Pondok',
                'level' => 2,
                'denda' => 1000000,
                'hukuman' => 'Menulis, Gundul, Berdiri pada setiap kegiatan selama satu minggu, Membersihkan WC, Disita barang buktinya',
                'larangan' => 'KEBERSIHAN, KESEHATAN, DAN FASILITAS',
                'max' => 0
            ],

            // PENDIDIKAN DAN IBADAH
            [
                'nama' => 'Membolos atau keluar dari kelas sebelum pelajaran selesai',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Tidak mengikuti jami`yah',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Tidak mengikuti musyawaroh dan segala kegiatan yang diadakan oleh pondok dan madrasah',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Menghilangkan kitab pelajaran',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Menambal kitab dengan makna yang tidak semestinya',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Mencoret, menggambar, dan merusak kitab atau buku pelajaran',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Bermalas-malasan',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Tidak tepat waktu',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Membuat gaduh saat di kelas',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Pulang dari madrasah sebelum waktu yang ditentukan',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Tidur saat mengikuti kegiatan yang diadakan oleh pondok dan madrasah',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Tidak mengikuti jamaah',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Tidak memperhatikan guru',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Mengotori, mencoret-coret atau merusak kelas',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
                'nama' => 'Membuka pakaian dan kopiyah ketika KBM sedang berlangsung',
                'level' => 1,
                'denda' => 150000,
                'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',
                'larangan' => 'PENDIDIKAN DAN IBADAH',
                'max' => 0
            ],
            [
            'nama' => 'Terlambat kembali dari izin',
            'level' => 1,  // Sesuaikan dengan level yang sesuai
            'denda' => 150000,  // Sesuaikan dengan nilai yang sesuai
            'hukuman' => 'Menulis dan menghapal, Berdiri membaca Al-Qur`an, Disita barang buktinya',  // Sesuaikan dengan nilai yang sesuai
            'larangan' => 'KEAMANAN',
            'max' => 0
        ]
        
        ];

        foreach ($data as $key => $value) {
            MasterPelanggaran::create($value);  
        }
    }
}
