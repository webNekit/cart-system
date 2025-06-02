<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        :root {
            --color-primary: #5c61f0;
            --color-primary-dark: #4b50cc;
        }
        .bg-primary {
            background-color: var(--color-primary);
        }
        .hover\:bg-primary-dark:hover {
            background-color: var(--color-primary-dark);
        }
        .focus\:ring-primary:focus {
            --tw-ring-color: var(--color-primary);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<form method="POST" action="{{ url('/register') }}" class="max-w-md w-full bg-white p-6 rounded-xl shadow-md space-y-4">
    @csrf

    <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Регистрация</h2>

    <div>
        <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Имя</label>
        <input type="text" id="name" name="name" placeholder="Введите ваше имя" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
        <input type="email" id="email" name="email" placeholder="Введите email" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Пароль</label>
        <input type="password" id="password" name="password" placeholder="Введите пароль" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Подтверждение пароля</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
    </div>

    <div class="pt-2">
        <button type="submit"
                class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            Зарегистрироваться
        </button>
    </div>
</form>

</body>
</html>
