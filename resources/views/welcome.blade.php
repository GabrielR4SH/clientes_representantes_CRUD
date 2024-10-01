<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/tailwind.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    @yield('content')
    <div class="container mx-auto px-4 py-8">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead class="bg-gray-200 dark:bg-gray-700">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                            Name
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                            Role
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                            Email
                        </th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 dark:text-white uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-4 px-4">John Doe</td>
                        <td class="py-4 px-4">Administrator</td>
                        <td class="py-4 px-4">john@example.com</td>
                        <td class="py-4 px-4">Active</td>
                    </tr>
                    <tr class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-700">
                        <td class="py-4 px-4">Jane Smith</td>
                        <td class="py-4 px-4">Editor</td>
                        <td class="py-4 px-4">jane@example.com</td>
                        <td class="py-4 px-4">Inactive</td>
                    </tr>
                    <tr class="border-b dark:border-gray-700">
                        <td class="py-4 px-4">Emily Johnson</td>
                        <td class="py-4 px-4">Author</td>
                        <td class="py-4 px-4">emily@example.com</td>
                        <td class="py-4 px-4">Pending</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <button class="btn btn-danger">Button Test</button>
        </div>
    </div>
</body>

</html>