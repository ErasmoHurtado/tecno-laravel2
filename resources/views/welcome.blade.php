<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>⚕️ Clínica La Guardia SRL - Presentación</title>
    
    <!-- Favicon -->        
    <link rel="shortcut icon" type="image/png" href="{{ asset('/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #1a202c; /* Fondo oscuro */
            color: #e2e8f0; /* Texto claro */
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    
    <!-- Barra superior con "Ingresar" -->
    <nav class="w-full p-4 bg-gray-900 text-right">
        @if (Route::has('login'))
            <div class="container mx-auto">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white text-lg">Ir a la plataforma</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-lg">Ingresar</a>
                @endauth
            </div>
        @endif
    </nav>

    <!-- Sección Hero -->
    <section class="flex flex-col md:flex-row items-center justify-center max-w-7xl mx-auto py-20 px-6">
        <!-- Texto -->
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-5xl font-bold text-blue-400 leading-tight">
                Cuidamos de tu salud con excelencia
            </h1>
            <p class="mt-4 text-lg text-gray-400">
                En Clínica La Guardia SRL, combinamos tecnología avanzada con un equipo médico especializado para brindarte la mejor atención.
            </p>
        </div>
        <!-- Imagen -->
        <div class="md:w-1/2 mt-6 md:mt-0">
            <img src="https://cdn.pixabay.com/photo/2017/08/06/11/27/people-2593750_1280.jpg" alt="Atención Médica" class="rounded-lg shadow-lg">
        </div>
    </section>

    <!-- Sección de Servicios -->
    <section class="bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-semibold text-blue-400">Nuestros Servicios</h2>
            <p class="text-lg text-gray-400 mt-2">
                Contamos con una amplia variedad de servicios médicos especializados.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-12">
                <!-- Servicio 1 -->
                <div class="p-6 bg-gray-900 rounded-lg shadow-md">
                    <img src="https://cdn.pixabay.com/photo/2016/11/14/03/06/doctor-1821917_1280.jpg" alt="Consulta médica" class="mx-auto w-24">
                    <h3 class="text-xl font-semibold mt-4 text-blue-300">Consultas Médicas</h3>
                    <p class="text-gray-400 mt-2">Atención personalizada con nuestros especialistas.</p>
                </div>

                <!-- Servicio 2 -->
                <div class="p-6 bg-gray-900 rounded-lg shadow-md">
                    <img src="https://cdn.pixabay.com/photo/2018/04/09/17/33/laboratory-3303822_1280.jpg" alt="Laboratorio clínico" class="mx-auto w-24">
                    <h3 class="text-xl font-semibold mt-4 text-blue-300">Laboratorio Clínico</h3>
                    <p class="text-gray-400 mt-2">Pruebas diagnósticas con equipos de última tecnología.</p>
                </div>

                <!-- Servicio 3 -->
                <div class="p-6 bg-gray-900 rounded-lg shadow-md">
                    <img src="https://cdn.pixabay.com/photo/2017/09/30/09/05/ambulance-2800996_1280.jpg" alt="Emergencias 24/7" class="mx-auto w-24">
                    <h3 class="text-xl font-semibold mt-4 text-blue-300">Emergencias 24/7</h3>
                    <p class="text-gray-400 mt-2">Atención de urgencias médicas en cualquier momento.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Informativa -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center">
            <!-- Imagen -->
            <div class="md:w-1/2">
                <img src="https://cdn.pixabay.com/photo/2016/03/30/19/50/doctor-1299996_1280.jpg" alt="Equipo Médico" class="rounded-lg shadow-lg">
            </div>
            <!-- Texto -->
            <div class="md:w-1/2 md:ml-12 text-center md:text-left mt-6 md:mt-0">
                <h2 class="text-4xl font-semibold text-blue-400">Tu Salud, Nuestra Prioridad</h2>
                <p class="text-lg text-gray-400 mt-4">
                    Contamos con un equipo de profesionales altamente capacitados que trabajan día a día para brindarte la mejor atención médica.
                </p>
            </div>
        </div>
    </section>

</body>
</html>
