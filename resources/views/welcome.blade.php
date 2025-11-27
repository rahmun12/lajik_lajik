<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Layanan Izin Khusus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out both;
        }

        @keyframes floatingLight {
            0% {
                transform: translate(0, 0);
                opacity: 0.4;
            }

            50% {
                transform: translate(40px, -30px);
                opacity: 0.9;
            }

            100% {
                transform: translate(0, 0);
                opacity: 0.4;
            }
        }

        .floating-light {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.6;
            animation: floatingLight 10s ease-in-out infinite;
        }

        /* Pola gelombang abstrak yang lebih kontras */
        .strong-pattern {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background: linear-gradient(to bottom right, #e5e7eb, #f9fafb);
            overflow: hidden;
        }

        .wave {
            position: absolute;
            width: 300%;
            height: 300%;
            top: -50%;
            left: -100%;
            background: linear-gradient(to bottom,
                    rgba(80, 80, 80, 0.18) 0%,
                    rgba(100, 100, 100, 0.12) 20%,
                    transparent 40%,
                    rgba(70, 70, 70, 0.14) 60%,
                    rgba(90, 90, 90, 0.12) 80%,
                    transparent 100%);
            background-size: 100% 240px;
            animation: waveFlow 45s linear infinite;
            opacity: 0.4;
            transform: rotate(5deg);
        }

        .wave:nth-child(2) {
            opacity: 0.3;
            animation-duration: 65s;
            transform: rotate(-4deg);
        }

        .wave:nth-child(3) {
            opacity: 0.2;
            animation-duration: 85s;
            transform: rotate(6deg);
        }

        @keyframes waveFlow {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 0 200px;
            }

            100% {
                background-position: 0 0;
            }
        }
    </style>
</head>

<body
    class="relative overflow-x-hidden bg-gradient-to-br from-gray-100 via-gray-100 to-gray-50 min-h-screen font-sans text-[#1a1a1a] tracking-wide">

    <!-- Background gelombang -->
    <div class="strong-pattern">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Cahaya lembut tapi kontras -->
    <div class="floating-light w-96 h-96 bg-gray-600/50 top-32 left-20"></div>
    <div class="floating-light w-[30rem] h-[30rem] bg-gray-700/40 bottom-0 right-10"></div>

    <main class="relative flex flex-col items-center justify-start z-10">

        <!-- Header -->
        <header class="text-center space-y-5 px-6 mt-24 fade-in">

            <!-- Tambahkan gambar di sini -->
            <img src="{{ asset('images/lajik.png') }}" alt="Logo LAJIK"
                class="mx-auto w-60 h-auto fade-in drop-shadow-xl rounded-xl [animation-delay:0.1s]" />

            <h1 class="text-5xl font-extrabold text-gray-700 tracking-tight drop-shadow-md">SELAMAT DATANG </h1>
            <h2 class="text-4xl font-semibold text-gray-600 fade-in [animation-delay:0.2s]">Layanan Antar Jemput Izin
                Khusus</h2>
            <h2 class="text-4xl font-bold text-gray-700 fade-in [animation-delay:0.2s]">LAJIK</h2>
            <p
                class="max-w-2xl mx-auto text-lg text-gray-500 leading-relaxed font-medium fade-in [animation-delay:0.4s]">
                Sistem pengajuan izin khusus secara online untuk kaum rentan (lansia, difabel, dan ibu hamil) di
                Kabupaten Magetan.
            </p>
        </header>

        <!-- Divider -->
        <div class="w-28 h-1.5 bg-gray-400 rounded-full mt-10 mb-4 fade-in [animation-delay:0.5s]"></div>

        <!-- Features -->
        <section class="w-full max-w-7xl mt-10 px-8 fade-in [animation-delay:0.7s]">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Box 1 -->
                <div
                    class="bg-white border border-gray-300 rounded-2xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5"
                            viewBox="0 0 24 24" class="w-7 h-7">
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-xl mb-2">APLIKASI LAJIK</h3>
                    <div class="relative group flex-grow">
                        <p id="desc-1"
                            class="text-base text-gray-700 font-medium line-clamp-4 transition-all duration-300">
                            Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (DPMPTSP) Kabupaten Magetan memiliki
                            peran strategis dalam mendorong pertumbuhan ekonomi inklusif melalui kemudahan perizinan
                            berusaha. Dalam upaya meningkatkan kemudahan berusaha dan pemerataan akses layanan
                            perizinan, DPMPTSP Kabupaten Magetan menginisiasi program “Layanan Antar Jemput Izin Khusus
                            (LAJIK)” melalui SISTEM INFORMASI/ APLIKASI LAJIK sebagai bentuk pendekatan proaktif dan
                            inklusif dalam pelayanan publik khususnya kaum rentan seperti penyandang disabilitas,
                            lansia, ibu hamil.
                        </p>
                        <button onclick="toggleReadMore('desc-1', this)"
                            class="text-blue-600 hover:text-blue-800 text-sm font-semibold mt-2 focus:outline-none">
                            Selengkapnya
                        </button>
                    </div>
                </div>

                <!-- Box 2 -->
                <div
                    class="bg-white border border-gray-300 rounded-2xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5"
                            viewBox="0 0 24 24" class="w-7 h-7">
                            <path
                                d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14l-4-4 1.414-1.414L11 12.172l5.586-5.586L18 8l-7 8z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-xl mb-2">TUJUAN APLIKASI LAJIK</h3>
                    <div class="relative group flex-grow">
                        <p id="desc-2"
                            class="text-base text-gray-700 font-medium line-clamp-4 transition-all duration-300 whitespace-pre-line">
                            • Mempermudah akses layanan perizinan bagi kaum rentan (Lansia, Penyandang disabilitas dan
                            ibu hamil).
                            • Meningkatkan partisipasi kelompok rentan (Lansia, Penyandang disabilitas dan ibu hamil)
                            dalam kegiatan ekonomi formal.
                            • Mewujudkan pelayanan publik yang inklusif, merata, dan berkeadilan.
                            • Mendukung target nasional kemudahan berusaha (ease of doing business) terutama pada sektor
                            UMKM.
                            • Mendorong kemandirian ekonomi masyarakat rentan (Lansia, Penyandang disabilitas dan ibu
                            hamil) melalui legalitas usaha.
                        </p>
                        <button onclick="toggleReadMore('desc-2', this)"
                            class="text-blue-600 hover:text-blue-800 text-sm font-semibold mt-2 focus:outline-none">
                            Selengkapnya
                        </button>
                    </div>
                </div>

                <!-- Box 3 -->
                <div
                    class="bg-white border border-gray-300 rounded-2xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5"
                            viewBox="0 0 24 24" class="w-7 h-7">
                            <path d="M3 5h18v2H3zm3 6h12v2H6zm-3 6h18v2H3z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-xl mb-2">LAYANAN PERIZINAN</h3>
                    <div class="relative group flex-grow">
                        <p id="desc-3"
                            class="text-base text-gray-700 font-medium line-clamp-4 transition-all duration-300">
                            PENERBITAN NIB (Nomor Induk Berusaha)
                        </p>
                        <button onclick="toggleReadMore('desc-3', this)"
                            class="text-blue-600 hover:text-blue-800 text-sm font-semibold mt-2 focus:outline-none hidden">
                            Selengkapnya
                        </button>
                    </div>
                </div>

                <!-- Box 4 -->
                <div
                    class="bg-white border border-gray-300 rounded-2xl p-6 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5"
                            viewBox="0 0 24 24" class="w-7 h-7">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-xl mb-2">PERSYARATAN</h3>
                    <div class="relative group flex-grow">
                        <p id="desc-4"
                            class="text-base text-gray-700 font-medium line-clamp-4 transition-all duration-300 whitespace-pre-line">
                            1. KTP
                            2. Email Aktif
                            3. Nomor HP
                            4. NPWP (Jika ada)
                            5. BPJS Kesehatan/ BPJS Ketenagakerjaan
                            6. Luas Usaha Kurang dari 100 m2
                        </p>
                        <button onclick="toggleReadMore('desc-4', this)"
                            class="text-blue-600 hover:text-blue-800 text-sm font-semibold mt-2 focus:outline-none">
                            Selengkapnya
                        </button>
                    </div>
                </div>

            </div>

            <script>
                function toggleReadMore(elementId, btn) {
                    const el = document.getElementById(elementId);
                    if (el.classList.contains('line-clamp-4')) {
                        el.classList.remove('line-clamp-4');
                        btn.textContent = 'Sembunyikan';
                    } else {
                        el.classList.add('line-clamp-4');
                        btn.textContent = 'Selengkapnya';
                    }
                }
            </script>

            <!-- Button -->
            <div class="text-center mt-16 fade-in [animation-delay:1s]">
                <a href="{{ route('pengajuan.izin') }}"
                    class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl bg-gray-700 text-white hover:bg-gray-800 transition font-semibold text-lg shadow-lg hover:shadow-2xl">
                    Ajukan Izin Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2"
                        viewBox="0 0 24 24" class="w-6 h-6 transition-transform">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer
            class="mt-20 py-8 text-base text-gray-700 font-medium border-t border-gray-300 w-full text-center fade-in [animation-delay:1.2s]">
            &copy; {{ date('Y') }} <span class="text-gray-800 font-semibold">Layanan Izin Khusus</span>. Semua hak
            dilindungi.
        </footer>

    </main>
</body>

</html>
