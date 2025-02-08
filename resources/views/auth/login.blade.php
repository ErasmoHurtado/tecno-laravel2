<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-gray-900">
        <!-- Tarjeta de Login -->
        <div class="w-full max-w-md bg-gray-800 p-8 rounded-lg shadow-lg">
            <!-- Título -->
            <h2 class="text-2xl font-bold text-center text-gray-100">Iniciar Sesión</h2>
            <p class="text-sm text-gray-400 text-center mt-1">Accede con tus credenciales</p>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-label for="email" class="text-gray-300" value="Correo Electrónico" />
                    <x-input id="email" class="block mt-2 w-full px-4 py-2 rounded-md bg-gray-700 text-gray-200 border border-gray-600 focus:ring-blue-400 focus:border-blue-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <!-- Contraseña -->
                <div class="mt-4">
                    <x-label for="password" class="text-gray-300" value="Contraseña" />
                    <x-input id="password" class="block mt-2 w-full px-4 py-2 rounded-md bg-gray-700 text-gray-200 border border-gray-600 focus:ring-blue-400 focus:border-blue-400" type="password" name="password" required autocomplete="current-password" />
                </div>

                <!-- Recordar sesión -->
                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center text-gray-300">
                        <x-checkbox id="remember_me" name="remember" class="bg-gray-700 border-gray-600" />
                        <span class="ms-2 text-sm">Recordarme</span>
                    </label>
                </div>

                <!-- Acciones -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-400 hover:text-blue-300" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    <x-button class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-md">
                        Ingresar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
