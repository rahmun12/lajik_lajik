<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Layanan Izin Khusus</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .fade-in { animation: fadeIn 0.8s ease-in-out both; }

  @keyframes floatingLight {
    0% { transform: translate(0, 0); opacity: 0.4; }
    50% { transform: translate(40px, -30px); opacity: 0.9; }
    100% { transform: translate(0, 0); opacity: 0.4; }
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
    background: linear-gradient(
      to bottom,
      rgba(80, 80, 80, 0.18) 0%,
      rgba(100, 100, 100, 0.12) 20%,
      transparent 40%,
      rgba(70, 70, 70, 0.14) 60%,
      rgba(90, 90, 90, 0.12) 80%,
      transparent 100%
    );
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
    0% { background-position: 0 0; }
    50% { background-position: 0 200px; }
    100% { background-position: 0 0; }
  }
  </style>
</head>

<body class="relative overflow-x-hidden bg-gradient-to-br from-gray-200 via-gray-100 to-gray-50 min-h-screen font-sans text-[#1a1a1a] tracking-wide">

  <!-- Background gelombang -->
  <div class="strong-pattern">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="wave"></div>
  </div>

  <!-- Cahaya lembut tapi kontras -->
  <div class="floating-light w-96 h-96 bg-gray-500/40 top-32 left-20"></div>
  <div class="floating-light w-[30rem] h-[30rem] bg-gray-700/30 bottom-0 right-10"></div>

  <main class="relative flex flex-col items-center justify-start z-10">

    <!-- Header -->
    <header class="text-center space-y-5 px-6 mt-24 fade-in">
      <h1 class="text-5xl font-extrabold text-gray-700 tracking-tight drop-shadow-md">Selamat Datang di</h1>
      <h2 class="text-4xl font-semibold text-gray-600 fade-in [animation-delay:0.2s]">Layanan Izin Khusus</h2>
      <p class="max-w-2xl mx-auto text-lg text-gray-500 leading-relaxed font-medium fade-in [animation-delay:0.4s]">
        Sistem ini memudahkan Anda mengajukan izin secara online dengan proses cepat, efisien, dan tertata.
      </p>
    </header>

    <!-- Divider -->
    <div class="w-28 h-1.5 bg-gray-600 rounded-full mt-10 mb-4 fade-in [animation-delay:0.6s]"></div>

    <!-- Features -->
    <section class="w-full max-w-6xl mt-10 px-8 fade-in [animation-delay:0.8s]">
      <div class="grid md:grid-cols-3 gap-10">

        <div class="bg-white border border-gray-300 rounded-2xl p-8 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300">
          <div class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24" class="w-7 h-7">
              <path d="M12 6v6l4 2"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 text-xl">Cepat & Mudah</h3>
          <p class="text-base text-gray-700 mt-2 font-medium">Proses pengajuan ringkas tanpa ribet.</p>
        </div>

        <div class="bg-white border border-gray-300 rounded-2xl p-8 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300">
          <div class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24" class="w-7 h-7">
              <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 14l-4-4 1.414-1.414L11 12.172l5.586-5.586L18 8l-7 8z"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 text-xl">Terverifikasi</h3>
          <p class="text-base text-gray-700 mt-2 font-medium">Data aman dan diverifikasi petugas.</p>
        </div>

        <div class="bg-white border border-gray-300 rounded-2xl p-8 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition duration-300">
          <div class="w-14 h-14 rounded-full bg-gray-600 flex items-center justify-center mb-5 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24" class="w-7 h-7">
              <path d="M3 5h18v2H3zm3 6h12v2H6zm-3 6h18v2H3z"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 text-xl">Terorganisir</h3>
          <p class="text-base text-gray-700 mt-2 font-medium">Semua persyaratan tertata rapi.</p>
        </div>
      </div>

      <!-- Button -->
      <div class="text-center mt-16 fade-in [animation-delay:1s]">
        <a href="{{ route('pengajuan.izin') }}" 
          class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl bg-gray-700 text-white hover:bg-gray-800 transition font-semibold text-lg shadow-lg hover:shadow-2xl">
          Ajukan Izin Sekarang
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 transition-transform">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </a>
      </div>
    </section>

    <!-- Footer -->
    <footer class="mt-20 py-8 text-base text-gray-700 font-medium border-t border-gray-300 w-full text-center fade-in [animation-delay:1.2s]">
      &copy; {{ date('Y') }} <span class="text-gray-800 font-semibold">Layanan Izin Khusus</span>. Semua hak dilindungi.
    </footer>

  </main>
</body>
</html>
