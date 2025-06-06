<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body
    class="bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-8 bg-white/10 backdrop-blur-md rounded-2xl shadow-xl text-white">
        <h2 class="text-3xl font-bold text-center mb-6">Welcome Back</h2>
        <form action="{{ route('loginFromDashboard') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block mb-1 text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="you@example.com">
            </div>
            <div>
                <label for="password" class="block mb-1 text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="••••••••">
            </div>
            <button type="submit"
                class="w-full py-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 transition-colors duration-300 font-semibold text-white">
                Login
            </button>
        </form>
    </div>

</body>

</html>