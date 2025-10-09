<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Layanan Izin Khusus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fffff] min-h-screen flex flex-col items-center justify-center font-sans text-[#1a1a1a] tracking-wide">

  <!-- Header -->
<header class="text-center space-y-5 px-6 mt-24">
  <h1 class="text-5xl font-extrabold text-gray-500 drop-shadow-sm">Selamat Datang di</h1>
  <h2 class="text-4xl font-bold text-gray-400">Layanan Izin Khusus</h2>
  <p class="max-w-2xl mx-auto text-lg text-gray-900/80 leading-relaxed font-medium">
    Sistem ini memudahkan Anda dalam mengajukan izin secara online dengan proses yang cepat, efisien, dan terorganisir.
  </p>
</header>

<!-- Features -->
<section class="w-full max-w-6xl mt-16 px-8">
  <div class="grid md:grid-cols-3 gap-10">
    
    <!-- Card 1 -->
    <div class="bg-gray-300 rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300 border border-gray-300">
      <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center mb-5 shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="gray" stroke-width="2.5" viewBox="0 0 24 24" class="w-7 h-7">
          <path d="M12 6v6l4 2"/>
        </svg>
      </div>
      <h3 class="font-semibold text-gray-900 text-xl">Cepat & Mudah</h3>
      <p class="text-base text-gray-900/75 mt-2 font-medium">Proses pengajuan ringkas, tanpa ribet.</p>
    </div>

    <!-- Card 2 -->
    <div class="bg-gray-300 rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300 border border-gray-400/50">
      <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center mb-5 shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="gray" stroke-width="2.5" viewBox="0 0 24 24" class="w-7 h-7">
          <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14l-4-4 1.414-1.414L11 12.172l5.586-5.586L18 8l-7 8z"/>
        </svg>
      </div>
      <h3 class="font-semibold text-gray-900 text-xl">Terverifikasi</h3>
      <p class="text-base text-gray-900/75 mt-2 font-medium">Data aman dan diverifikasi petugas.</p>
    </div>

    <!-- Card 3 -->
    <div class="bg-gray-300 rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300 border border-gray-400/50">
      <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center mb-5 shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="gray" stroke-width="2.5" viewBox="0 0 24 24" class="w-7 h-7">
          <path d="M3 5h18v2H3zm3 6h12v2H6zm-3 6h18v2H3z"/>
        </svg>
      </div>
      <h3 class="font-semibold text-gray-900 text-xl">Terorganisir</h3>
      <p class="text-base text-gray-900/75 mt-2 font-medium">Semua persyaratan tertata rapi.</p>
    </div>
  </div>

  <!-- Button -->
  <div class="text-center mt-16">
    <a href="{{ route('pengajuan.izin') }}" 
       class="inline-flex items-center gap-3 px-9 py-4 rounded-2xl bg-gray-500 text-white hover:bg-gray-400 transition font-semibold text-lg shadow-md hover:shadow-xl">
      Ajukan Izin Sekarang
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
        <path d="M5 12h14M12 5l7 7-7 7"/>
      </svg>
    </a>
  </div>
</section>

<!-- Footer -->
<footer class="mt-20 py-8 text-base text-gray-900/60 font-medium">
  &copy; {{ date('Y') }} <span class="text-gray-500 font-semibold">Layanan Izin Khusus</span>. Semua hak dilindungi.
</footer>


</body>
</html>
