@extends('layouts.app')

@section('title', $title ?? 'Login')

@section('content')
    <section class="card">
        <h1>Login Academic Task Tracker</h1>
        <p>Masukkan username untuk masuk ke dashboard. Username akan diteruskan sebagai request parameter.</p>

        <form method="GET" action="{{ route('dashboard') }}">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" placeholder="Masukkan Username" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Masukkan password" required>

            <button class="btn" type="submit">Login</button>
            <a class="btn btn-secondary" href="{{ route('dashboard', ['username' => 'Tamu']) }}">Coba Dashboard</a>
        </form>
    </section>

    <div class="grid">
        @foreach($features as $feature)
            <article class="card">
                <h2>{{ $feature['title'] }}</h2>
                <p>{{ $feature['description'] }}</p>
            </article>
        @endforeach
    </div>
@endsection
