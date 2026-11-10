@props(['username' => 'Tamu'])

<header class="navbar">
    <nav class="nav-links">
        <a href="{{ route('dashboard', ['username' => $username]) }}">Dashboard</a>
        <a href="{{ route('pengelolaan', ['username' => $username]) }}">Pengelolaan</a>
        <a href="{{ route('profile', ['username' => $username]) }}">Profile</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('profile', ['username' => $username]) }}">{{ $username }}</a>
    </nav>
</header>
