<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Layanan Izin Khusus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#ffffff] min-h-screen flex flex-col items-center justify-center font-sans text-[#1f1f1f]">

  <!-- Header -->
  <header class="text-center space-y-4 px-6 mt-20">
    <h1 class="text-4xl font-bold text-[#36393a] tracking-wide">Selamat Datang di</h1>
    <h2 class="text-3xl font-semibold text-[#676868]">Layanan Izin Khusus</h2>
    <p class="max-w-xl mx-auto text-[#7a7a7a] leading-relaxed">
      Sistem ini memudahkan Anda dalam mengajukan izin secara online dengan proses yang cepat, efisien, dan terorganisir.
    </p>
  </header>

  <!-- Features -->
  <section class="w-full max-w-5xl mt-14 px-6">
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Card 1 -->
      <div class="bg-[#f3f3f3] rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-[#e5e5e5]">
        <div class="w-12 h-12 rounded-full bg-[#676868] flex items-center justify-center mb-4 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24" class="w-6 h-6">
            <path d="M12 6v6l4 2"/>
          </svg>
        </div>
        <h3 class="font-semibold text-[#36393a] text-lg">Cepat & Mudah</h3>
        <p class="text-sm text-[#676868] mt-1">Proses pengajuan ringkas, tanpa ribet.</p>
      </div>

      <!-- Card 2 -->
      <div class="bg-[#f3f3f3] rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-[#e5e5e5]">
        <div class="w-12 h-12 rounded-full bg-[#676868] flex items-center justify-center mb-4 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24" class="w-6 h-6">
            <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14l-4-4 1.414-1.414L11 12.172l5.586-5.586L18 8l-7 8z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-[#36393a] text-lg">Terverifikasi</h3>
        <p class="text-sm text-[#676868] mt-1">Data aman dan diverifikasi petugas.</p>
      </div>

      <!-- Card 3 -->
      <div class="bg-[#f3f3f3] rounded-2xl p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-[#e5e5e5]">
        <div class="w-12 h-12 rounded-full bg-[#676868] flex items-center justify-center mb-4 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24" class="w-6 h-6">
            <path d="M3 5h18v2H3zm3 6h12v2H6zm-3 6h18v2H3z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-[#36393a] text-lg">Terorganisir</h3>
        <p class="text-sm text-[#676868] mt-1">Semua persyaratan tertata rapi.</p>
      </div>
    </div>

    <!-- Button -->
    <div class="text-center mt-12">
      <a href="{{ route('pengajuan.izin') }}" 
         class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-[#36393a] text-white hover:bg-[#676868] transition font-medium shadow-md hover:shadow-lg">
        Ajukan Izin Sekarang
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="mt-16 py-6 text-sm text-[#7a7a7a]">
    &copy; {{ date('Y') }} Layanan Izin Khusus. Semua hak dilindungi.
  </footer>

</body>
</html>
