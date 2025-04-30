<x-guest-layout>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <h2>Admin Register</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
</x-guest-layout>
