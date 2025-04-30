

<x-guest-layout>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <h2>Admin Login</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</x-guest-layout>
