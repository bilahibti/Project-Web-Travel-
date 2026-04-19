<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota; 
use App\Models\User; 
use App\Models\Destinasi;
use App\Models\Hotel;
use App\Models\Transportasi;
use App\Models\Paket;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $adminRole = Role::where('slug', 'admin')->firstOrFail();
        $staffRole = Role::where('slug', 'staff')->firstOrFail();
        $customerRole = Role::where('slug', 'customer')->firstOrFail();
        $financeRole = Role::where('slug', 'finance')->firstOrFail();

        User::create([ 
            'nama' => 'Administrator', 
            'email' => 'admin@gmail.com',  
            'status' => 1, 
            'role_id' => $adminRole?->id,
            'hp' => '0812345678901', 
            'password' => bcrypt('P@55word'), 
        ]); 

        User::create([ 
            'nama' => 'Sopian Aji', 
            'email' => 'sopian4ji@gmail.com',  
            'status' => 2, 
            'role_id' => $staffRole?->id,
            'hp' => '081234567892', 
            'password' => bcrypt('P@55word'), 
        ]); 
        
        User::create([ 
            'nama' => 'Karina Adya', 
            'email' => 'adyarin@gmail.com',  
            'status' => 1, 
            'role_id' => $adminRole?->id,
            'hp' => '085678916598', 
            'password' => bcrypt('K@rin4'), 
        ]); 

        User::create([ 
            'nama' => 'Aditya Rayhan Pratama', 
            'email' => 'pratamayhan@gmail.com',  
            'status' => 1, 
            'role_id' => $customerRole?->id,
            'hp' => '089873456120', 
            'password' => bcrypt('Rayh4ntam@'), 
        ]); 

        User::create([ 
            'nama' => 'Naufal Aksa Pranaya', 
            'email' => 'aksanaya@gmail.com', 
            'status' => 1, 
            'role_id' => $financeRole?->id,
            'hp' => '087856432690', 
            'password' => bcrypt('Pranayaksa5^'), 
        ]); 

        #data destinasi
        Destinasi::create([ 
            'nama_destinasi' => 'Zurich', 
            'negara' => 'Switzerland', 
            'deskripsi' => 'Swiss adalah negara federal di Eropa Tengah yang terkenal akan netralitasnya, keindahan alam pegunungan Alpen, demokrasi langsung yang unik, ekonomi kuat di sektor perbankan dan farmasi, serta keragaman bahasa (Jerman, Prancis, Italia, Romansh) dengan ibu kota Bern, serta kota penting seperti Zürich dan Jenewa.', 
            'lokasi' => 'Eropa', 
            'harga_tiket' => '70000000', 
            'status' => 'Tersedia', 
        ]); 

        Destinasi::create([ 
            'nama_destinasi' => 'Tokyo', 
            'negara' => 'Jepang', 
            'deskripsi' => 'Jepang adalah negara kepulauan maju di Asia Timur yang terkenal dengan kombinasi unik antara budaya tradisional (seperti kimono, sumo, hanami) dan teknologi canggih (Shinkansen, robotik).', 
            'lokasi' => 'Asia Timur', 
            'harga_tiket' => '56800000', 
            'status' => 'Tersedia', 
        ]);
        
        Destinasi::create([ 
            'nama_destinasi' => 'Almaty', 
            'negara' => 'Kazakhstan', 
            'deskripsi' => 'Kazakhstan adalah negara lintas benua terbesar kesembilan di dunia, sebagian besar di Asia Tengah, dikenal karena wilayahnya yang luas, sumber daya alam melimpah (minyak, gas, mineral), ekonomi yang bergantung pada energi, dan sejarahnya sebagai bekas Uni Soviet.', 
            'lokasi' => 'Asia Tengah', 
            'harga_tiket' => '16000000', 
            'status' => 'Tersedia', 
        ]);

        Destinasi::create([ 
            'nama_destinasi' => 'Daegu', 
            'negara' => 'Korea Selatan', 
            'deskripsi' => 'Korea Selatan (Republik Korea) adalah negara maju di Asia Timur yang terkenal dengan ekonomi kuat (elektronik, otomotif), budaya pop global (K-pop, K-drama/Gelombang Korea), sistem pemerintahan demokrasi presidensial, ibu kota Seoul yang padat, serta penekanan tinggi pada pendidikan.', 
            'lokasi' => 'Asia Timur', 
            'harga_tiket' => '23000000', 
            'status' => 'Tersedia', 
        ]);

        Destinasi::create([ 
            'nama_destinasi' => 'Paris', 
            'negara' => 'Prancis', 
            'deskripsi' => 'Prancis adalah negara maju di Eropa Barat yang terkenal dengan budaya kaya, seni, mode, dan kuliner (seperti 400+ jenis keju), dengan ibu kota Paris, bahasa resmi Prancis, dan ekonomi kuat didukung pariwisata serta industri.', 
            'lokasi' => 'Eropa Barat', 
            'harga_tiket' => '75000000', 
            'status' => 'Tersedia', 
        ]);

        #data hotel
        Hotel::create([ 
            'nama_hotel' => 'Hotel Monte Rosa', 
            'alamat' => 'Bahnhofstrasse, Switzerland', 
            'deskripsi' => 'Hotel Monte Rosa merupakan hotel klasik bersejarah yang terletak di jantung Zermatt, Swiss, tepat di sepanjang Bahnhofstrasse dengan pemandangan indah Pegunungan Alpen yang ikonik. Hotel ini menawarkan suasana hangat dan elegan khas Swiss yang dipadukan dengan kenyamanan modern, menjadikannya pilihan ideal bagi wisatawan yang mencari pengalaman menginap tenang dan berkelas. Setiap kamar dirancang dengan detail yang nyaman dan fungsional, dilengkapi fasilitas lengkap untuk menunjang istirahat setelah menjelajahi keindahan alam Zermatt. Dengan lokasi strategis yang dekat dengan stasiun, area wisata, dan jalur ski, Hotel Monte Rosa menghadirkan pengalaman menginap yang autentik, nyaman, dan penuh suansa eksklusif.', 
            'rating' => '4.9', 
            'harga_per_malam' => '2800000', 
            'status' => 'Tersedia', 
        ]); 

        Hotel::create([ 
            'nama_hotel' => 'Hotel Shinjuku Sakura', 
            'alamat' => 'Shinjuku City, Japan', 
            'deskripsi' => 'Hotel Shinjuku Sakura merupakan hotel pilihan favorit yang terletak di kawasan strategis Shinjuku City, Jepang, salah satu pusat hiburan dan aktivitas paling ramai di Tokyo. Hotel ini menawarkan kenyamanan modern dengan akses yang sangat mudah ke berbagai moda transportasi umum, pusat perbelanjaan, area kuliner, serta tempat hiburan terkenal di Shinjuku. Setiap kamar dirancang dengan suasana hangat dan fungsional, dilengkapi fasilitas yang menunjang kenyamanan tamu selama menginap. Dengan lokasi yang praktis dan pelayanan yang ramah, Hotel Shinjuku Sakura menjadi pilihan ideal bagi wisatawan yang ingin menjelajahi Tokyo dengan mudah dan nyaman.', 
            'rating' => '4.8', 
            'harga_per_malam' => '1800000', 
            'status' => 'Tersedia', 
        ]);
        
        Hotel::create([ 
            'nama_hotel' => 'Lotte Hotel Daegu', 
            'alamat' => 'Daegu, South Korea', 
            'deskripsi' => 'Lotte Hotel Daegu merupakan hotel bintang lima yang menghadirkan kemewahan dan kenyamanan di pusat kota Daegu, Korea Selatan. Dengan lokasi strategis yang memudahkan akses ke kawasan bisnis, pusat perbelanjaan, dan destinasi wisata populer, hotel ini menjadi pilihan ideal bagi wisatawan maupun pelaku perjalanan bisnis. Setiap kamar dirancang dengan interior modern dan elegan, dilengkapi fasilitas lengkap untuk menunjang kenyamanan maksimal selama menginap. Didukung oleh layanan profesional, fasilitas premium, serta suasana yang eksklusif, Lotte Hotel Daegu menawarkan pengalaman menginap berkelas yang sejalan dengan standar kualitas.', 
            'rating' => '4.8', 
            'harga_per_malam' => '1700000', 
            'status' => 'Tersedia', 
        ]);

        Hotel::create([ 
            'nama_hotel' => 'Hotel Pullman Paris Tour Eiffel', 
            'alamat' => '18 Avenue de Suffren,Paris', 
            'deskripsi' => 'Hotel Pullman Paris Tour Eiffel merupakan hotel modern berkelas yang berlokasi strategis di jantung kota Paris, hanya beberapa langkah dari ikon dunia Menara Eiffel. Menghadirkan desain elegan dan suasana kontemporer, hotel ini menawarkan pengalaman menginap yang nyaman dan eksklusif bagi wisatawan yang ingin menikmati pesona romantis Paris. Setiap kamar dirancang dengan interior modern, dilengkapi fasilitas lengkap serta jendela besar yang memungkinkan tamu menikmati pemandangan kota Paris yang memukau. Didukung dengan layanan profesional, fasilitas premium, serta akses mudah ke destinasi wisata populer dan pusat kuliner, Hotel Pullman Paris Tour Eiffel menjadi pilihan sempurna untuk liburan romantis maupun perjalanan bisnis.', 
            'rating' => '4.8', 
            'harga_per_malam' => '2800000', 
            'status' => 'Tersedia', 
        ]);

        Hotel::create([ 
            'nama_hotel' => 'Hotel Rixos President Astana', 
            'alamat' => ' Dostyk Street 7, Kazakhstan', 
            'deskripsi' => 'Hotel Rixos President Astana merupakan hotel mewah berkelas internasional yang berlokasi strategis di pusat kota Astana, Kazakhstan. Hotel ini menawarkan perpaduan desain elegan dan kenyamanan modern, menjadikannya pilihan ideal bagi wisatawan maupun perjalanan bisnis. Setiap kamar dirancang dengan interior eksklusif dan fasilitas lengkap untuk memberikan pengalaman menginap yang nyaman dan berkelas. Didukung oleh berbagai fasilitas premium, layanan profesional, serta akses mudah ke kawasan pemerintahan, pusat bisnis, dan destinasi wisata utama, Hotel Rixos President Astana menghadirkan pengalaman menginap prestisius yang selaras dengan kualitas.', 
            'rating' => '4.8', 
            'harga_per_malam' => '1900000', 
            'status' => 'Tersedia', 
        ]);

        #data transportasi
        Transportasi::create([ 
            'jenis_transportasi' => 'Pesawat', 
            'nama_transportasi' => 'Qatar airways', 
            'kota_keberangkatan' => 'CGK - Jakarta', 
            'kota_tujuan' => 'Zurich - Swiss', 
            'waktu_berangkat' => '2026-01-26 08:45:00', 
            'waktu_tiba' => '2026-01-26 23:30:00', 
            'harga' => '5960000', 
            'status' => 'Tersedia', 
        ]); 

        Transportasi::create([ 
            'jenis_transportasi' => 'Pesawat', 
            'nama_transportasi' => 'AirAsia Indonesia', 
            'kota_keberangkatan' => 'CGK - Jakarta', 
            'kota_tujuan' => 'Almaty - Kazakhstan ', 
            'waktu_berangkat' => '2026-02-14 06:30:00', 
            'waktu_tiba' => '2026-02-14 21:00:00', 
            'harga' => '6700000', 
            'status' => 'Tersedia', 
        ]); 

        Transportasi::create([ 
            'jenis_transportasi' => 'Pesawat', 
            'nama_transportasi' => 'Japan Airlines', 
            'kota_keberangkatan' => 'CGK - Jakarta', 
            'kota_tujuan' => 'Tokyo - Jepang', 
            'waktu_berangkat' => '2026-02-05 21:25:00', 
            'waktu_tiba' => '2026-02-16 04:15:00', 
            'harga' => '6150000', 
            'status' => 'Tersedia', 
        ]); 

        Transportasi::create([ 
            'jenis_transportasi' => 'Pesawat', 
            'nama_transportasi' => 'Korean Air', 
            'kota_keberangkatan' => 'CGK - Jakarta', 
            'kota_tujuan' => 'Incheon - Korea Selatan', 
            'waktu_berangkat' => '2026-01-29 23:30:00', 
            'waktu_tiba' => '2026-01-30 05:40:00', 
            'harga' => '5500000', 
            'status' => 'Tersedia', 
        ]); 

        Transportasi::create([ 
            'jenis_transportasi' => 'Pesawat', 
            'nama_transportasi' => 'Turkish Airlines', 
            'kota_keberangkatan' => 'CGK - Jakarta ', 
            'kota_tujuan' => 'Orly - Paris', 
            'waktu_berangkat' => '2026-03-21 06:40:00', 
            'waktu_tiba' => '2026-03-20 19:15:00', 
            'harga' => '7355000', 
            'status' => 'Tersedia', 
        ]); 
    }
}
