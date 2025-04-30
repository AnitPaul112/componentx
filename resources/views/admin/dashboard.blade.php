<x-app-layout>
    <h1>Welcome Admin!</h1>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</x-app-layout>
