<!-- resources/views/clientes/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Cliente</title>
    @vite('resources/css/app.css') <!-- Para carregar o Tailwind CSS -->
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-xl font-bold">Editar Cliente</h1>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Nome</label>
                <input type="text" name="name" id="name" value="{{ $cliente->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                <input type="email" name="email" id="email" value="{{ $cliente->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-white">Função</label>
                <input type="text" name="role" id="role" value="{{ $cliente->role }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-white">Status</label>
                <input type="text" name="status" id="status" value="{{ $cliente->status }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>
