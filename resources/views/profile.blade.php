@extends('layouts.app')

@section('title', $title ?? 'Profile')

@section('content')
    <section class="card">
        <h1>{{ $profile['name'] }}</h1>
        <p>{{ $profile['program'] }} • {{ $profile['semester'] }} • {{ $profile['focus'] }}</p>
        <p>Email: {{ $profile['email'] }}</p>
        <a class="btn" href="{{ route('dashboard', ['username' => $username]) }}">Kembali ke Dashboard</a>
        <a class="btn btn-secondary" href="{{ route('pengelolaan', ['username' => $username]) }}">Ke Pengelolaan</a>
    </section>

    <div class="grid">
        <section class="card">
            <h2>Keahlian</h2>
            <div id="skill-list">
                @foreach($skills as $skill)
                    <span class="badge skill-item" style="margin: 0 6px 8px 0;">
                        <span class="skill-text">{{ $skill }}</span>
                        <button class="btn btn-secondary skill-edit" type="button" style="padding: 4px 8px; margin-left: 6px; font-size: 12px;">Edit</button>
                        <button class="btn skill-delete" type="button" style="padding: 4px 8px; margin-left: 4px; font-size: 12px; background: #dc2626;">Hapus</button>
                    </span>
                @endforeach
            </div>
            <div style="display: flex; gap: 8px; margin-top: 12px;">
                <input id="new-skill" class="table-input" type="text" placeholder="Keahlian baru" style="flex: 1;">
                <button id="add-skill-btn" class="btn" type="button">Tambah</button>
            </div>
        </section>

        <section class="card">
            <h2>Aktivitas Terbaru</h2>
            <div id="activity-list">
                @foreach($activities as $activity)
                    <article class="activity-item" style="display: flex; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <strong class="activity-label">{{ $activity['label'] }}</strong><br>
                            <span class="small activity-time">{{ $activity['time'] }}</span>
                        </div>
                        <div style="display: flex; gap: 6px; align-items: flex-start;">
                            <button class="btn activity-edit" type="button" style="padding: 6px 10px; font-size: 12px;">Edit</button>
                            <button class="btn activity-delete" type="button" style="padding: 6px 10px; font-size: 12px; background: #dc2626;">Hapus</button>
                        </div>
                    </article>
                @endforeach
            </div>
            <div style="margin-top: 12px;">
                <input id="new-activity-label" class="table-input" type="text" placeholder="Aktivitas baru" style="margin-bottom: 8px;">
                <input id="new-activity-time" class="table-input" type="text" placeholder="Waktu (misal: Hari ini)" style="margin-bottom: 8px;">
                <button id="add-activity-btn" class="btn" type="button" style="width: 100%;">Tambah Aktivitas</button>
            </div>
        </section>
    </div>

    <script>
        var storageKey = 'profileDataOris';

        function createSkillItem(value) {
            var item = document.createElement('span');
            item.className = 'badge skill-item';
            item.style.margin = '0 6px 8px 0';

            var text = document.createElement('span');
            text.className = 'skill-text';
            text.textContent = value;
            item.appendChild(text);

            var editButton = document.createElement('button');
            editButton.type = 'button';
            editButton.className = 'btn btn-secondary skill-edit';
            editButton.style.cssText = 'padding: 4px 8px; margin-left: 6px; font-size: 12px;';
            editButton.textContent = 'Edit';
            item.appendChild(editButton);

            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn skill-delete';
            deleteButton.style.cssText = 'padding: 4px 8px; margin-left: 4px; font-size: 12px; background: #dc2626;';
            deleteButton.textContent = 'Hapus';
            item.appendChild(deleteButton);

            return item;
        }

        function createActivityItem(label, time) {
            var item = document.createElement('article');
            item.className = 'activity-item';
            item.style.cssText = 'display: flex; justify-content: space-between; gap: 12px; margin-bottom: 14px;';

            var info = document.createElement('div');
            var labelEl = document.createElement('strong');
            labelEl.className = 'activity-label';
            labelEl.textContent = label;
            var timeEl = document.createElement('span');
            timeEl.className = 'small activity-time';
            timeEl.textContent = time;
            info.appendChild(labelEl);
            info.appendChild(document.createElement('br'));
            info.appendChild(timeEl);
            item.appendChild(info);

            var actions = document.createElement('div');
            actions.style.cssText = 'display: flex; gap: 6px; align-items: flex-start;';

            var editButton = document.createElement('button');
            editButton.type = 'button';
            editButton.className = 'btn activity-edit';
            editButton.style.cssText = 'padding: 6px 10px; font-size: 12px;';
            editButton.textContent = 'Edit';
            actions.appendChild(editButton);

            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn activity-delete';
            deleteButton.style.cssText = 'padding: 6px 10px; font-size: 12px; background: #dc2626;';
            deleteButton.textContent = 'Hapus';
            actions.appendChild(deleteButton);

            item.appendChild(actions);
            return item;
        }

        function saveData() {
            var skills = Array.from(document.querySelectorAll('#skill-list .skill-text')).map(function (el) {
                return el.textContent.trim();
            });

            var activities = Array.from(document.querySelectorAll('#activity-list .activity-item')).map(function (item) {
                return {
                    label: item.querySelector('.activity-label').textContent.trim(),
                    time: item.querySelector('.activity-time').textContent.trim()
                };
            });

            localStorage.setItem(storageKey, JSON.stringify({ skills: skills, activities: activities }));
        }

        function loadSavedData() {
            var saved = null;
            try {
                saved = JSON.parse(localStorage.getItem(storageKey));
            } catch (e) {
                saved = null;
            }

            if (!saved) {
                saveData();
                return;
            }

            var skillList = document.getElementById('skill-list');
            skillList.innerHTML = '';
            (saved.skills || []).forEach(function (skill) {
                skillList.appendChild(createSkillItem(skill));
            });

            var activityList = document.getElementById('activity-list');
            activityList.innerHTML = '';
            (saved.activities || []).forEach(function (activity) {
                activityList.appendChild(createActivityItem(activity.label, activity.time));
            });
        }

        loadSavedData();

        document.getElementById('add-skill-btn').addEventListener('click', function () {
            var input = document.getElementById('new-skill');
            var value = input.value.trim();

            if (!value) {
                alert('Isi keahlian baru dulu.');
                return;
            }

            document.getElementById('skill-list').appendChild(createSkillItem(value));
            saveData();
            input.value = '';
            input.focus();
        });

        document.getElementById('add-activity-btn').addEventListener('click', function () {
            var labelInput = document.getElementById('new-activity-label');
            var timeInput = document.getElementById('new-activity-time');
            var label = labelInput.value.trim();
            var time = timeInput.value.trim();

            if (!label || !time) {
                alert('Lengkapi aktivitas dan waktu dulu.');
                return;
            }

            document.getElementById('activity-list').appendChild(createActivityItem(label, time));
            saveData();
            labelInput.value = '';
            timeInput.value = '';
            labelInput.focus();
        });

        document.getElementById('skill-list').addEventListener('click', function (event) {
            var item = event.target.closest('.skill-item');
            if (!item) {
                return;
            }

            if (event.target.classList.contains('skill-delete')) {
                item.remove();
                saveData();
                return;
            }

            if (event.target.classList.contains('skill-edit')) {
                var text = item.querySelector('.skill-text');
                var newSkill = prompt('Ubah keahlian', text.textContent.trim());
                if (newSkill !== null && newSkill.trim() !== '') {
                    text.textContent = newSkill.trim();
                    saveData();
                }
            }
        });

        document.getElementById('activity-list').addEventListener('click', function (event) {
            var item = event.target.closest('.activity-item');
            if (!item) {
                return;
            }

            if (event.target.classList.contains('activity-delete')) {
                item.remove();
                saveData();
                return;
            }

            if (event.target.classList.contains('activity-edit')) {
                var label = item.querySelector('.activity-label');
                var time = item.querySelector('.activity-time');

                var newLabel = prompt('Ubah aktivitas', label.textContent.trim());
                if (newLabel !== null && newLabel.trim() !== '') {
                    label.textContent = newLabel.trim();
                    saveData();
                }

                var newTime = prompt('Ubah waktu', time.textContent.trim());
                if (newTime !== null && newTime.trim() !== '') {
                    time.textContent = newTime.trim();
                    saveData();
                }
            }
        });
    </script>
@endsection
