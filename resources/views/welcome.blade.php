<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Impulsa Local | Alcaldía de Ciudad Nueva</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased">
    <main class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-xl text-center">
            <h1 class="text-4xl font-bold">Impulsa Local</h1>
            <p class="mt-4 text-lg">
                Programa de la Alcaldía de Ciudad Nueva para apoyar a pequeños emprendedores:
                capacitaciones, seguimiento y acompañamiento en un solo lugar.
            </p>

            <div class="mt-8">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="inline-block px-6 py-3 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Ir a mi panel
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block px-6 py-3 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        Iniciar sesión
                    </a>
                @endauth
            </div>

            <p class="mt-6 text-sm text-gray-500">
                ¿Quieres hacer parte del programa? Acércate a la Alcaldía para que un funcionario te registre.
            </p>
        </div>
    </main>
</body>
</html>