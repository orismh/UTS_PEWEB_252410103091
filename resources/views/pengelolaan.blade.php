@extends('layouts.app')

@section('title', $title ?? 'Pengelolaan Tim')

@section('content')
    <section class="card">
        <h1>Pengelolaan Tim</h1>
        <p>Di halaman ini modul dan proyek bisa ditambah langsung dari tabel, status bisa diubah manual, dan proyek bisa dihapus.</p>
        <a class="btn" href="{{ route('dashboard', ['username' => $username]) }}">Kembali ke Dashboard</a>
        <a class="btn btn-secondary" href="{{ route('profile', ['username' => $username]) }}">Ke Profile</a>
    </section>

    <section class="card">
        <h2>Modul Pembelajaran</h2>
        <table id="module-table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Topik</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="module-tbody">
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module['name'] }}</td>
                        <td>{{ $module['topic'] }}</td>
                        <td>
                            <select class="status-select" aria-label="Status {{ $module['topic'] }}">
                                @foreach(['Selesai', 'Berlangsung', 'Berikutnya', 'Terjadwal'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ $module['status'] === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><input id="new-module-period" class="table-input" type="text" placeholder="Periode (misal: Minggu 1-2)"></td>
                    <td><input id="new-module-topic" class="table-input" type="text" placeholder="Topik"></td>
                    <td>
                        <select id="new-module-status" class="status-select">
                            <option value="Berlangsung">Berlangsung</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Berikutnya">Berikutnya</option>
                            <option value="Terjadwal">Terjadwal</option>
                        </select>
                        <button id="add-module-btn" class="btn" type="button" style="width: 100%; margin-top: 8px;">Tambah Modul</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="card">
        <h2>Proyek Aktif</h2>
        <table id="project-table">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Nama Tim</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="project-tbody">
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project['name'] }}</td>
                        <td>{{ $project['team'] }}</td>
                        <td>
                            <select class="status-select" aria-label="Status {{ $project['name'] }}">
                                @foreach(['Selesai', 'Berlangsung', 'Revisi', 'Berikutnya'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ ($project['status'] ?? 'Berlangsung') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button class="btn delete-project-btn" type="button" style="background: #dc2626;">Hapus</button></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><input id="new-project-name" class="table-input" type="text" placeholder="Nama proyek"></td>
                    <td><input id="new-project-team" class="table-input" type="text" placeholder="Nama Tim"></td>
                    <td>
                        <select id="new-project-status" class="status-select">
                            <option value="Berlangsung">Berlangsung</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Revisi">Revisi</option>
                            <option value="Berikutnya">Berikutnya</option>
                        </select>
                    </td>
                    <td><button id="add-project-btn" class="btn" type="button" style="width: 100%;">Tambah Proyek</button></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <script>
        var projectStorageKey = 'projectList';

        function createStatusSelect(selectedStatus, options) {
            var select = document.createElement('select');
            select.className = 'status-select';
            options.forEach(function (optionValue) {
                var option = document.createElement('option');
                option.value = optionValue;
                option.textContent = optionValue;
                if (optionValue === selectedStatus) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
            return select;
        }

        function createProjectRow(project) {
            var row = document.createElement('tr');

            [project.name, project.team].forEach(function (value) {
                var td = document.createElement('td');
                td.textContent = value;
                row.appendChild(td);
            });

            var statusCell = document.createElement('td');
            statusCell.appendChild(createStatusSelect(project.status, ['Selesai', 'Berlangsung', 'Revisi', 'Berikutnya']));
            row.appendChild(statusCell);

            var actionCell = document.createElement('td');
            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn delete-project-btn';
            deleteButton.style.background = '#dc2626';
            deleteButton.textContent = 'Hapus';
            actionCell.appendChild(deleteButton);
            row.appendChild(actionCell);

            return row;
        }

        function saveProjects() {
            var projects = Array.from(document.querySelectorAll('#project-tbody tr')).map(function (row) {
                var cells = row.querySelectorAll('td');
                return {
                    name: cells[0].textContent.trim(),
                    team: cells[1].textContent.trim(),
                    status: cells[2].querySelector('select').value
                };
            });
            localStorage.setItem(projectStorageKey, JSON.stringify(projects));
        }

        function loadProjects() {
            var saved = null;
            try {
                saved = JSON.parse(localStorage.getItem(projectStorageKey));
            } catch (e) {
                saved = null;
            }

            if (!saved) {
                saveProjects();
                return;
            }

            var tbody = document.getElementById('project-tbody');
            tbody.innerHTML = '';
            saved.forEach(function (project) {
                tbody.appendChild(createProjectRow(project));
            });
        }

        loadProjects();

        document.getElementById('add-module-btn').addEventListener('click', function () {
            var periodInput = document.getElementById('new-module-period');
            var topicInput = document.getElementById('new-module-topic');
            var statusInput = document.getElementById('new-module-status');

            var period = periodInput.value.trim();
            var topic = topicInput.value.trim();
            var status = statusInput.value;

            if (!period || !topic) {
                alert('Lengkapi periode dan topik dulu.');
                return;
            }

            var row = document.createElement('tr');
            [period, topic].forEach(function (value) {
                var td = document.createElement('td');
                td.textContent = value;
                row.appendChild(td);
            });

            var statusCell = document.createElement('td');
            statusCell.appendChild(createStatusSelect(status, ['Selesai', 'Berlangsung', 'Berikutnya', 'Terjadwal']));
            row.appendChild(statusCell);

            document.getElementById('module-tbody').appendChild(row);

            periodInput.value = '';
            topicInput.value = '';
            statusInput.value = 'Berlangsung';
            periodInput.focus();
        });

        document.getElementById('add-project-btn').addEventListener('click', function () {
            var nameInput = document.getElementById('new-project-name');
            var teamInput = document.getElementById('new-project-team');
            var statusInput = document.getElementById('new-project-status');

            var name = nameInput.value.trim();
            var team = teamInput.value.trim();
            var status = statusInput.value;

            if (!name || !team) {
                alert('Lengkapi nama proyek dan nama tim dulu.');
                return;
            }

            document.getElementById('project-tbody').appendChild(createProjectRow({ name: name, team: team, status: status }));
            saveProjects();

            nameInput.value = '';
            teamInput.value = '';
            statusInput.value = 'Berlangsung';
            nameInput.focus();
        });

        document.getElementById('project-tbody').addEventListener('click', function (event) {
            if (event.target.classList.contains('delete-project-btn')) {
                event.target.closest('tr').remove();
                saveProjects();
            }
        });

        document.getElementById('project-tbody').addEventListener('change', function (event) {
            if (event.target.classList.contains('status-select')) {
                saveProjects();
            }
        });
    </script>
@endsection
