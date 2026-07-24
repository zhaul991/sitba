<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SITBA</title>
    <body class="bg-gray-100">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100">


<div class="flex min-h-screen">


    <!-- Sidebar -->

    <aside class="w-64 bg-gray-900 text-white">


        <div class="p-5 text-2xl font-bold border-b border-gray-700">

            ✈️ SITBA

        </div>



        <nav class="p-4 space-y-2">


            <a href="/dashboard"
               class="block px-4 py-3 rounded hover:bg-gray-700">

                Dashboard

            </a>



            <p class="text-gray-400 text-sm mt-5">
                MASTER DATA
            </p>


            <a href="{{ route('bandara.index') }}"
   class="block px-4 py-3 rounded hover:bg-gray-700">
    ✈️ Data Bandara
</a>


            <a href="{{ route('petugas.index') }}"
   class="block px-4 py-3 rounded hover:bg-gray-700">

    👷 Data Inspektur

</a>

<a href="{{ route('inspeksi.index') }}"
   class="block px-4 py-3 rounded hover:bg-gray-700">
    🔍 Inspeksi
</a>

<a href="{{ route('temuan.index') }}"
   class="block px-4 py-3 rounded hover:bg-gray-700">
    📋 Data Temuan
</a>



            <p class="text-gray-400 text-sm mt-5">
                INSPEKSI
            </p>


            <a href="#"
               class="block px-4 py-3 rounded hover:bg-gray-700">

                📝 Inspeksi

            </a>


            <a href="#"
               class="block px-4 py-3 rounded hover:bg-gray-700">

                ⚠️ Temuan

            </a>



            <p class="text-gray-400 text-sm mt-5">
                LAPORAN
            </p>


            <a href="{{ route('laporan.index') }}"
               class="block px-4 py-3 rounded hover:bg-gray-700">

                📊 Laporan

            </a>



        </nav>


    </aside>




    <!-- Content -->


    <main class="flex-1">


        <header class="bg-white shadow p-4 flex justify-between">

            <h1 class="font-bold">
                Sistem Informasi Teknis Bandar Udara
            </h1>


            <div>

                {{ Auth::user()->name }}

            </div>


        </header>



        @yield('content')



    </main>


</div>


</body>

</html>