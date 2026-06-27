<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Hak Tanggungan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white flex">

    <!-- LEFT SIDE (Branding) -->
    <div class="hidden lg:flex w-1/2 bg-[#00A39D] text-white flex-col justify-center items-center px-12">
        <div class="max-w-md text-center">
            <h1 class="text-4xl font-bold mb-4">
                Sistem Pengajuan Hak Tanggungan
            </h1>
            <p class="text-lg opacity-90">
                Platform resmi pengelolaan dan monitoring pengajuan Hak Tanggungan secara digital.
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE (Form Area) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ $header ?? '' }}
                </h2>
            </div>

            {{ $slot }}
        </div>
    </div>

</body>
</html>