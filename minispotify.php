<?php

// ─────────────────────────────────────────────
// 1. Interface – Playable
// ─────────────────────────────────────────────
interface Playable
{
    public function play(): string;
    public function pause(): string;
}

// ─────────────────────────────────────────────
// 2. Abstract Class – Account
// ─────────────────────────────────────────────
abstract class Account
{
    protected string $username;
    protected string $plan;

    public function __construct(string $username, string $plan)
    {
        $this->username = $username;
        $this->plan     = $plan;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPlan(): string
    {
        return $this->plan;
    }

    // Every account must define its ad behaviour
    abstract public function showAd(): string;
}

// ─────────────────────────────────────────────
// 3a. Child Class – PremiumAccount  (no ads)
// ─────────────────────────────────────────────
class PremiumAccount extends Account implements Playable
{
    public function __construct(string $username)
    {
        parent::__construct($username, 'Premium');
    }

    public function play(): string
    {
        return "▶ Playing music in high quality — no interruptions, enjoy!";
    }

    public function pause(): string
    {
        return "⏸ Music paused. Still saving your queue...";
    }

    public function showAd(): string
    {
        return ""; // No ads for premium users
    }
}

// ─────────────────────────────────────────────
// 3b. Child Class – FreeAccount  (shows ads)
// ─────────────────────────────────────────────
class FreeAccount extends Account implements Playable
{
    public function __construct(string $username)
    {
        parent::__construct($username, 'Free');
    }

    public function play(): string
    {
        return "▶ Playing music...";
    }

    public function pause(): string
    {
        return "⏸ Music paused.";
    }

    public function showAd(): string
    {
        return "📢 Advertisement: Upgrade to Premium for an ad-free experience!";
    }
}

// ─────────────────────────────────────────────
// Demo song catalogue (static data)
// ─────────────────────────────────────────────
$songs = [
    ['id' => 1, 'title' => 'Blinding Lights',  'artist' => 'The Weeknd',     'duration' => '3:20', 'cover' => 'https://picsum.photos/seed/song1/80/80'],
    ['id' => 2, 'title' => 'Shape of You',     'artist' => 'Ed Sheeran',     'duration' => '3:53', 'cover' => 'https://picsum.photos/seed/song2/80/80'],
    ['id' => 3, 'title' => 'Levitating',       'artist' => 'Dua Lipa',       'duration' => '3:23', 'cover' => 'https://picsum.photos/seed/song3/80/80'],
    ['id' => 4, 'title' => 'Stay',             'artist' => 'The Kid LAROI',  'duration' => '2:21', 'cover' => 'https://picsum.photos/seed/song4/80/80'],
    ['id' => 5, 'title' => 'Peaches',          'artist' => 'Justin Bieber',  'duration' => '3:18', 'cover' => 'https://picsum.photos/seed/song5/80/80'],
    ['id' => 6, 'title' => 'good 4 u',         'artist' => 'Olivia Rodrigo', 'duration' => '2:58', 'cover' => 'https://picsum.photos/seed/song6/80/80'],
];

// ─────────────────────────────────────────────
// Handle AJAX / POST action
// ─────────────────────────────────────────────
$action   = $_POST['action']   ?? '';
$planType = $_POST['plan']     ?? 'free';
$username = $_POST['username'] ?? 'Guest';

$account  = ($planType === 'premium')
    ? new PremiumAccount($username)
    : new FreeAccount($username);

if ($action && in_array($action, ['play', 'pause'])) {
    header('Content-Type: application/json');
    $msg = ($action === 'play') ? $account->play() : $account->pause();
    $ad  = $account->showAd();
    echo json_encode(['message' => $msg, 'ad' => $ad, 'plan' => $account->getPlan(), 'username' => $account->getUsername()]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mini Spotify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="minispotify.css" />
</head>

<body class="min-h-screen text-white flex flex-col">

    <!-- ═══════════════════ TOP NAV ═══════════════════ -->
    <nav class="glass sticky top-0 z-50 flex items-center justify-between px-6 py-3">
        <div class="flex items-center gap-3">
            <!-- Spotify-ish logo -->
            <svg viewBox="0 0 24 24" class="w-8 h-8 fill-green-500">
                <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z" />
            </svg>
            <span class="text-xl font-bold tracking-tight">Mini<span class="text-green-500">Spotify</span></span>
        </div>

        <!-- Account selector -->
        <div class="flex items-center gap-3">
            <input id="username-input" type="text" value="Koti" placeholder="Your name"
                class="bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-sm focus:outline-none focus:border-green-500 w-32 transition" />

            <div class="flex rounded-full overflow-hidden border border-white/20">
                <button id="btn-free" onclick="setPlan('free')"
                    class="px-4 py-1.5 text-sm font-medium transition bg-white/10 hover:bg-white/20 plan-btn active-plan">
                    Free
                </button>
                <button id="btn-premium" onclick="setPlan('premium')"
                    class="px-4 py-1.5 text-sm font-medium transition bg-white/10 hover:bg-white/20 plan-btn">
                    Premium ✦
                </button>
            </div>

            <div id="avatar" class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold">K</div>
        </div>
    </nav>

    <!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
    <main class="flex flex-1 overflow-hidden">

        <!-- ── Sidebar ── -->
        <aside class="w-64 glass m-3 rounded-2xl p-4 flex flex-col gap-4 hidden md:flex">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Library</p>
                <ul class="space-y-1 text-sm text-gray-300">
                    <li class="flex items-center gap-3 px-3 py-2 rounded-xl bg-green-500/10 text-green-400 cursor-pointer">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55A4 4 0 1014 17V7h4V3h-6z" />
                        </svg> Liked Songs
                    </li>
                    <li class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg> Search
                    </li>
                    <li class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg> Profile
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Playlists</p>
                <ul class="space-y-1 text-sm text-gray-400">
                    <li class="px-3 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">🎧 Chill Vibes</li>
                    <li class="px-3 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">🔥 Hot Hits</li>
                    <li class="px-3 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">🌙 Late Night</li>
                    <li class="px-3 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">💪 Workout</li>
                </ul>
            </div>

            <!-- Account info badge -->
            <div class="mt-auto glass rounded-xl p-3">
                <p id="sidebar-username" class="text-sm font-semibold">Koti</p>
                <p id="sidebar-plan" class="text-xs text-gray-400 mt-0.5">Free Plan</p>
                <div id="upgrade-note" class="mt-2 text-xs text-green-400 cursor-pointer hover:underline">✦ Upgrade to Premium</div>
            </div>
        </aside>

        <!-- ── Song List ── -->
        <div class="flex-1 flex flex-col overflow-hidden m-3 ml-0">

            <!-- Ad banner (free users) -->
            <div id="ad-banner" class="hidden glass rounded-2xl p-4 mb-3 border border-yellow-500/30 ad-slide">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-full flex items-center justify-center text-xl">📢</div>
                        <div>
                            <p id="ad-text" class="text-sm text-yellow-300 font-medium"></p>
                            <p class="text-xs text-gray-500">Sponsored</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('ad-banner').classList.add('hidden')"
                        class="text-gray-500 hover:text-white transition text-lg">✕</button>
                </div>
            </div>

            <!-- Status message -->
            <div id="status-msg" class="hidden glass rounded-2xl px-5 py-3 mb-3 text-green-400 text-sm font-medium ad-slide"></div>

            <!-- Song table -->
            <div class="glass rounded-2xl flex-1 overflow-auto">
                <div class="px-6 py-4 border-b border-white/5">
                    <h2 class="text-lg font-bold">Today's Top Hits</h2>
                    <p class="text-sm text-gray-500 mt-0.5">6 songs · Updated today</p>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-gray-500 text-xs uppercase tracking-widest border-b border-white/5">
                            <th class="px-6 py-3 text-left w-8">#</th>
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left hidden sm:table-cell">Artist</th>
                            <th class="px-6 py-3 text-right pr-8">Duration</th>
                        </tr>
                    </thead>
                    <tbody id="song-list">
                        <?php foreach ($songs as $i => $song): ?>
                            <tr class="song-row cursor-pointer transition-all duration-200"
                                data-id="<?= $song['id'] ?>"
                                data-title="<?= htmlspecialchars($song['title']) ?>"
                                data-artist="<?= htmlspecialchars($song['artist']) ?>"
                                data-cover="<?= $song['cover'] ?>"
                                data-duration="<?= $song['duration'] ?>"
                                onclick="selectSong(this)">
                                <td class="px-6 py-3 text-gray-500 w-8">
                                    <span class="track-num"><?= $i + 1 ?></span>
                                    <svg class="track-icon hidden w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="<?= $song['cover'] ?>" alt="cover" class="w-10 h-10 rounded-lg object-cover" />
                                        <span class="font-medium text-white"><?= htmlspecialchars($song['title']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-400 hidden sm:table-cell"><?= htmlspecialchars($song['artist']) ?></td>
                                <td class="px-6 py-3 text-gray-400 text-right pr-8"><?= $song['duration'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- ═══════════════════ PLAYER BAR ═══════════════════ -->
    <div id="player" class="glass border-t border-white/10 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center gap-4">

            <!-- Current track info -->
            <div class="flex items-center gap-3 w-52 shrink-0">
                <div class="relative">
                    <img id="player-cover" src="https://picsum.photos/seed/default/50/50" alt="cover"
                        class="w-12 h-12 rounded-xl object-cover vinyl-spin paused" />
                </div>
                <div class="overflow-hidden">
                    <p id="player-title" class="text-sm font-semibold truncate">Select a song</p>
                    <p id="player-artist" class="text-xs text-gray-400 truncate">—</p>
                </div>
                <button class="ml-2 text-gray-500 hover:text-green-400 transition text-lg shrink-0">♡</button>
            </div>

            <!-- Controls -->
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="flex items-center gap-5">
                    <button class="text-gray-500 hover:text-white transition" title="Shuffle">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.59 9.17L5.41 4 4 5.41l5.17 5.17 1.42-1.41zM14.5 4l2.04 2.04L4 18.59 5.41 20 17.96 7.46 20 9.5V4h-5.5zm.33 9.41l-1.41 1.41 3.13 3.13L14.5 20H20v-5.5l-2.04 2.04-3.13-3.13z" />
                        </svg>
                    </button>
                    <button class="text-gray-400 hover:text-white transition" title="Previous">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z" />
                        </svg>
                    </button>

                    <!-- Play / Pause button -->
                    <button id="play-pause-btn" onclick="togglePlay()"
                        class="w-12 h-12 bg-green-500 hover:bg-green-400 rounded-full flex items-center justify-center transition glow shadow-lg shadow-green-900">
                        <svg id="icon-play" class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                        <svg id="icon-pause" class="w-6 h-6 text-black hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                        </svg>
                    </button>

                    <button class="text-gray-400 hover:text-white transition" title="Next">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z" />
                        </svg>
                    </button>
                    <button class="text-gray-500 hover:text-white transition" title="Repeat">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 7h10v3l4-4-4-4v3H5v6h2V7zm10 10H7v-3l-4 4 4 4v-3h12v-6h-2v4z" />
                        </svg>
                    </button>
                </div>

                <!-- Progress -->
                <div class="flex items-center gap-2 w-full max-w-md">
                    <span id="current-time" class="text-xs text-gray-500 w-8 text-right">0:00</span>
                    <div class="flex-1 bg-white/10 rounded-full h-1 cursor-pointer" onclick="seekTo(event, this)">
                        <div id="progress-bar" class="bg-green-500 h-1 rounded-full transition-all" style="width:0%"></div>
                    </div>
                    <span id="total-time" class="text-xs text-gray-500 w-8">0:00</span>
                </div>
            </div>

            <!-- Volume -->
            <div class="flex items-center gap-2 w-32 shrink-0 justify-end">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z" />
                </svg>
                <input type="range" min="0" max="100" value="80" class="w-20 accent-green-500 cursor-pointer" oninput="setVolume(this.value)" />
            </div>
        </div>
    </div>

    <!-- ═══════════════════ JAVASCRIPT ═══════════════════ -->
    <script>
        // ── State ──────────────────────────────────────────
        let currentPlan = 'free';
        let isPlaying = false;
        let currentSongRow = null;
        let progressTimer = null;
        let elapsedSecs = 0;
        let totalSecs = 0;

        // ── Plan toggle ─────────────────────────────────────
        function setPlan(plan) {
            currentPlan = plan;
            document.querySelectorAll('.plan-btn').forEach(b => b.classList.remove('bg-green-500', 'text-black'));
            const active = document.getElementById('btn-' + plan);
            active.classList.add('bg-green-500', 'text-black');

            const sidebarPlan = document.getElementById('sidebar-plan');
            sidebarPlan.textContent = plan === 'premium' ? 'Premium Plan ✦' : 'Free Plan';
            sidebarPlan.className = plan === 'premium' ? 'text-xs text-green-400 mt-0.5' : 'text-xs text-gray-400 mt-0.5';
            document.getElementById('upgrade-note').style.display = plan === 'premium' ? 'none' : 'block';

            // If currently playing, re-send play to get updated message
            if (isPlaying) sendAction('play');
        }

        // ── Select song ─────────────────────────────────────
        function selectSong(row) {
            // Deactivate previous
            if (currentSongRow) {
                currentSongRow.classList.remove('active');
                currentSongRow.querySelector('.track-num').classList.remove('hidden');
                currentSongRow.querySelector('.track-icon').classList.add('hidden');
            }

            currentSongRow = row;
            row.classList.add('active');
            row.querySelector('.track-num').classList.add('hidden');
            row.querySelector('.track-icon').classList.remove('hidden');

            // Update player UI
            document.getElementById('player-title').textContent = row.dataset.title;
            document.getElementById('player-artist').textContent = row.dataset.artist;
            document.getElementById('player-cover').src = row.dataset.cover;

            // Parse duration
            const parts = row.dataset.duration.split(':');
            totalSecs = parseInt(parts[0]) * 60 + parseInt(parts[1]);
            document.getElementById('total-time').textContent = row.dataset.duration;

            // Auto-play
            elapsedSecs = 0;
            isPlaying = false;
            togglePlay();
        }

        // ── Toggle play/pause ───────────────────────────────
        function togglePlay() {
            if (!currentSongRow) return;
            const action = isPlaying ? 'pause' : 'play';
            sendAction(action);
        }

        // ── AJAX call to PHP ─────────────────────────────────
        function sendAction(action) {
            const username = document.getElementById('username-input').value || 'Guest';
            document.getElementById('sidebar-username').textContent = username;
            document.getElementById('avatar').textContent = username.charAt(0).toUpperCase();

            const fd = new FormData();
            fd.append('action', action);
            fd.append('plan', currentPlan);
            fd.append('username', username);

            fetch(window.location.href, {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(data => {
                    showStatus(data.message);

                    if (data.ad) {
                        document.getElementById('ad-text').textContent = data.ad;
                        const banner = document.getElementById('ad-banner');
                        banner.classList.remove('hidden');
                        banner.classList.add('ad-slide');
                    } else {
                        document.getElementById('ad-banner').classList.add('hidden');
                    }

                    if (action === 'play') {
                        isPlaying = true;
                        startProgress();
                        document.getElementById('icon-play').classList.add('hidden');
                        document.getElementById('icon-pause').classList.remove('hidden');
                        document.getElementById('player-cover').classList.remove('paused');
                    } else {
                        isPlaying = false;
                        stopProgress();
                        document.getElementById('icon-play').classList.remove('hidden');
                        document.getElementById('icon-pause').classList.add('hidden');
                        document.getElementById('player-cover').classList.add('paused');
                    }
                });
        }

        // ── Progress bar ─────────────────────────────────────
        function startProgress() {
            clearInterval(progressTimer);
            progressTimer = setInterval(() => {
                if (!isPlaying) {
                    clearInterval(progressTimer);
                    return;
                }
                elapsedSecs = Math.min(elapsedSecs + 1, totalSecs);
                const pct = totalSecs > 0 ? (elapsedSecs / totalSecs) * 100 : 0;
                document.getElementById('progress-bar').style.width = pct + '%';
                document.getElementById('current-time').textContent = formatTime(elapsedSecs);
                if (elapsedSecs >= totalSecs) {
                    isPlaying = false;
                    clearInterval(progressTimer);
                    document.getElementById('icon-play').classList.remove('hidden');
                    document.getElementById('icon-pause').classList.add('hidden');
                    document.getElementById('player-cover').classList.add('paused');
                }
            }, 1000);
        }

        function stopProgress() {
            clearInterval(progressTimer);
        }

        function formatTime(s) {
            const m = Math.floor(s / 60);
            const sec = s % 60;
            return m + ':' + String(sec).padStart(2, '0');
        }

        function seekTo(e, bar) {
            const rect = bar.getBoundingClientRect();
            const ratio = (e.clientX - rect.left) / rect.width;
            elapsedSecs = Math.floor(ratio * totalSecs);
            document.getElementById('progress-bar').style.width = (ratio * 100) + '%';
            document.getElementById('current-time').textContent = formatTime(elapsedSecs);
        }

        // ── Volume ───────────────────────────────────────────
        function setVolume(v) {
            /* Real audio would use AudioContext here */
        }

        // ── Status toast ─────────────────────────────────────
        function showStatus(msg) {
            const el = document.getElementById('status-msg');
            el.textContent = msg;
            el.classList.remove('hidden');
            el.classList.add('ad-slide');
            clearTimeout(el._t);
            el._t = setTimeout(() => el.classList.add('hidden'), 3500);
        }

        // ── Init ─────────────────────────────────────────────
        setPlan('free');
    </script>
</body>

</html>