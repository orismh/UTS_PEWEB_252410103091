@extends('layouts.app')

@section('title', $title ?? 'Dashboard')

@section('content')
    <section class="card">
        <h1>Selamat datang, {{ $username }}</h1>
        <p>Ini adalah halaman dashboard. Daftar proyek di bawah ini menampilkan data yang sama dengan yang ditambahkan di halaman Pengelolaan.</p>
        <a class="btn" href="{{ route('pengelolaan', ['username' => $username]) }}">Ke Pengelolaan</a>
        <a class="btn btn-secondary" href="{{ route('profile', ['username' => $username]) }}">Ke Profile</a>
    </section>

    <div class="grid-4">
        @foreach($stats as $stat)
            <article class="card stat">
                <strong>{{ $stat['value'] }}</strong>
                <span>{{ $stat['label'] }}</span>
            </article>
        @endforeach
    </div>

    <section class="card">
        <h2>Daftar Projek</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Nama Tim</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="project-tbody">
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project['name'] }}</td>
                        <td>{{ $project['team'] }}</td>
                        <td><span class="badge">{{ $project['status'] ?? 'Berlangsung' }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p id="empty-project-note" class="small" style="display: none;">Belum ada proyek. Tambah proyek di halaman <a class="link" href="{{ route('pengelolaan', ['username' => $username]) }}">Pengelolaan</a>.</p>
    </section>

    <script>
        var projectStorageKey = 'projectList';

        function renderProjects() {
            var projects = [];
            try {
                projects = JSON.parse(localStorage.getItem(projectStorageKey)) || [];
            } catch (e) {
                projects = [];
            }

            var tbody = document.getElementById('project-tbody');
            tbody.innerHTML = '';

            if (projects.length === 0) {
                document.getElementById('empty-project-note').style.display = 'block';
                return;
            }

            document.getElementById('empty-project-note').style.display = 'none';

            projects.forEach(function (project) {
                var row = document.createElement('tr');

                var nameCell = document.createElement('td');
                nameCell.textContent = project.name;
                row.appendChild(nameCell);

                var teamCell = document.createElement('td');
                teamCell.textContent = project.team;
                row.appendChild(teamCell);

                var statusCell = document.createElement('td');
                var badge = document.createElement('span');
                badge.className = 'badge';
                badge.textContent = project.status;
                statusCell.appendChild(badge);
                row.appendChild(statusCell);

                tbody.appendChild(row);
            });
        }

        renderProjects();
    </script>
@endsection
