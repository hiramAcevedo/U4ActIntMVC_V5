<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h2 class="text-lg font-semibold text-blue-800 mb-2">Credenciales de acceso:</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-3 bg-white rounded-lg shadow-sm">
                <h3 class="font-medium text-primary-700">Administrador</h3>
                <p class="text-sm text-gray-600">Email: <span class="font-medium">admin@example.com</span></p>
                <p class="text-sm text-gray-600">Contraseña: <span class="font-medium">admin123</span></p>
            </div>
            <div class="p-3 bg-white rounded-lg shadow-sm">
                <h3 class="font-medium text-primary-700">Usuario</h3>
                <p class="text-sm text-gray-600">Email: <span class="font-medium truncate block max-w-[180px]">hiram@u4actint.com</span></p>
                <p class="text-sm text-gray-600">Contraseña: <span class="font-medium">WokiWoki</span></p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />

            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <div class="flex flex-col items-end space-y-2">
                @if (Route::has('register'))
                    <a class="text-sm text-primary-600 hover:text-primary-700 hover:underline" href="{{ route('register') }}">
                        {{ __('¿No tienes cuenta? Regístrate') }}
                    </a>
                @endif

                @if (Route::has('password.request'))
                    <a class="text-sm text-primary-600 hover:text-primary-700 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="ms-3">
                <i class="fas fa-sign-in-alt mr-1"></i>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
