{{-- @extends('layouts.app')

@section('content')
    <div class="container mx-auto flex flex-col h-[80vh]">
        <h2 class="mb-4 text-xl font-bold dark:text-white">Chat with {{ $user->name }}</h2>

        <div id="messages" class="flex-1 p-4 mb-4 overflow-y-auto bg-gray-100 rounded dark:bg-gray-500"></div>

        <form id="chatForm" class="flex">
            @csrf
            <input type="text" id="message" name="message" class="flex-1 px-4 py-2 border rounded-l dark:text-white"
                placeholder="Type your message...">
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-r">Send</button>
        </form>
    </div>
@endsection --}}

{{-- @section('scripts') --}}
    {{--
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="/js/echo.js"></script>
    <script>
        const userId = {{ $user-> id }};
        const messagesDiv = document.getElementById('messages');

        // Setup Echo + Pusher
        Echo.channel('chat.' + userId)
            .listen('.message.sent', (e) => {
                const msg = document.createElement('div');
                msg.textContent = e.message.from + ": " + e.message.body;
                messagesDiv.appendChild(msg);
            });

        // Kirim pesan
        document.getElementById('chatForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const message = document.getElementById('message').value;
            fetch("{{ route('chat.send', $user->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ message })
            });
            document.getElementById('message').value = '';
        });
    </script> --}}

    {{--
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Setup Pusher instance
        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true,
        });

        // Buat wrapper mirip Echo sederhana
        const Echo = {
            channel: (name) => pusher.subscribe(name)
        };

        const userId = {{ $user-> id }};
        const messagesDiv = document.getElementById('messages');

        Echo.channel('chat.' + userId)
            .bind('message.sent', (e) => {
                const msg = document.createElement('div');
                msg.textContent = e.message.from + ": " + e.message.body;
                messagesDiv.appendChild(msg);
            });

        // Kirim pesan
        document.getElementById('chatForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const message = document.getElementById('message').value;
            fetch("{{ route('chat.send', $user->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ message })
            });
            document.getElementById('message').value = '';
        });
    </script> --}}



    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        const userId = {{ $user->id }};
        const myId = {{ auth()->id() }};
        const messagesDiv = document.getElementById('messages');

        // helper: render pesan ke DOM
        function appendMessage(payload, meSide = false) {
            // payload: { id, from_id, from, to_id, body, created_at }
            const wrapper = document.createElement('div');
            wrapper.className = meSide ? 'text-right mb-2' : 'text-left mb-2';

            const bubble = document.createElement('div');
            bubble.className = (meSide ? 'inline-block bg-green-500 text-white px-3 py-1 rounded' : 'inline-block bg-gray-200 px-3 py-1 rounded');
            bubble.textContent = (payload.from ? payload.from + ': ' : '') + payload.body;

            const time = document.createElement('div');
            time.className = 'text-xs text-gray-500 dark:text-gray-200 mt-1';
            time.textContent = payload.created_at;

            wrapper.appendChild(bubble);
            wrapper.appendChild(time);
            messagesDiv.appendChild(wrapper);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // 0) load history pesan
        async function loadHistory() {
            try {
                const res = await fetch("{{ route('chat.messages', $user->id) }}");
                const data = await res.json(); // array of Message models
                // norm: message fields might be { sender_id, receiver_id, message, created_at, ... }
                data.forEach(m => {
                    appendMessage({
                        id: m.id,
                        from_id: m.sender_id,
                        from: (m.sender ? m.sender.name : (m.sender_id === myId ? '{{ auth()->user()->name }}' : '{{ $user->name }}')),
                        to_id: m.receiver_id,
                        body: m.message,
                        created_at: m.created_at
                    }, m.sender_id === myId);
                });
            } catch (err) {
                console.error('Failed to load chat history', err);
            }
        }

        loadHistory();

        // 1) Setup Pusher (simple wrapper, tanpa Laravel Echo)
        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });

        const channel = pusher.subscribe('chat.' + myId); // subscribe ke channel admin sendiri agar menerima pesan dari user
        channel.bind('message.sent', function (e) {
            // e.message sesuai broadcastWith()
            const payload = e.message;
            // Pastikan bukan pesan yang kita kirim sendiri (karena kita pakai toOthers() di server)
            appendMessage(payload, payload.from_id === myId);
        });

        // 2) Kirim pesan
        document.getElementById('chatForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const input = document.getElementById('message');
            const message = input.value.trim();
            if (!message) return;

            // kirim ke server
            try {
                const res = await fetch("{{ route('chat.send', $user->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ message })
                });

                if (!res.ok) {
                    const txt = await res.text();
                    console.error('Server error while sending message', res.status, txt);
                    return;
                }

                const json = await res.json();

                // append pesan lokal menggunakan payload yang dikembalikan server
                if (json.message) {
                    appendMessage(json.message, json.message.from_id === myId);
                } else {
                    // fallback: tambahkan manual
                    appendMessage({
                        from_id: myId,
                        from: '{{ auth()->user()->name }}',
                        to_id: {{ $user->id }},
                        body: message,
                        created_at: new Date().toISOString()
                    }, true);
                }

                input.value = '';

            } catch (err) {
                console.error('Failed to send message', err);
            }
        });
    </script> --}}
{{-- @endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto flex flex-col h-[80vh]">
        <h2 class="mb-4 text-xl font-bold dark:text-white">Chat with {{ $user->name }}</h2>

        <div id="messages" class="flex flex-col flex-1 p-4 mb-4 overflow-y-auto bg-gray-100 rounded dark:bg-gray-500"></div>

        <form id="chatForm" class="flex">
            @csrf
            <input type="text" id="message" name="message" class="flex-1 px-4 py-2 border rounded-l dark:text-white"
                placeholder="Type your message...">
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-r">Send</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        const userId = {{ $user->id }};
        const myId = {{ auth()->id() }};
        const messagesDiv = document.getElementById('messages');
        
        // Variable untuk melacak tanggal terakhir yang dirender
        let lastRenderedDate = null; 

        // Helper: Format Jam (HH:mm) WIB/Lokal
        function formatTime(isoString) {
            const date = new Date(isoString);
            // Otomatis convert ke zona waktu browser (WIB)
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
        }

        // Helper: Format Tanggal (Hari, dd Month yyyy)
        function formatDateDetail(isoString) {
            const date = new Date(isoString);
            return date.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        }

        // Helper: Cek Tanggal (YYYY-MM-DD) untuk grouping
        function getDateString(isoString) {
            const date = new Date(isoString);
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        }

        // FUNGSI UTAMA RENDER PESAN
        function appendMessage(payload, meSide = false) {
            // 1. Logic Header Tanggal
            const msgDate = getDateString(payload.created_at);
            if (lastRenderedDate !== msgDate) {
                const dateWrapper = document.createElement('div');
                dateWrapper.className = 'flex justify-center my-4'; // margin vertikal biar ada jarak
                
                const dateBadge = document.createElement('span');
                dateBadge.className = 'bg-gray-300 text-gray-700 text-xs px-3 py-1 rounded-full dark:bg-gray-600 dark:text-gray-200';
                dateBadge.textContent = formatDateDetail(payload.created_at);
                
                dateWrapper.appendChild(dateBadge);
                messagesDiv.appendChild(dateWrapper);
                
                lastRenderedDate = msgDate;
            }

            // 2. Container Flex untuk baris pesan
            const wrapper = document.createElement('div');
            // Jika saya: justify-end (kanan), Jika dia: justify-start (kiri)
            // items-end: agar jam sejajar dengan bagian bawah bubble
            wrapper.className = meSide 
                ? 'flex justify-end items-end mb-2 gap-2' 
                : 'flex justify-start items-end mb-2 gap-2';

            // 3. Elemen Bubble Chat
            const bubble = document.createElement('div');
            // Styling bubble agar lebar menyesuaikan konten (max-w-[70%])
            bubble.className = meSide 
                ? 'bg-green-500 text-white px-4 py-2 rounded-l-lg rounded-tr-lg max-w-[70%]' 
                : 'bg-gray-200 text-black px-4 py-2 rounded-r-lg rounded-tl-lg max-w-[70%] dark:bg-gray-700 dark:text-white';
            
            // Isi pesan (Nama pengirim opsional, tapi biasanya chat modern menghilangkan nama jika 1-on-1, tapi saya biarkan sesuai kode asli)
            // Untuk kerapian, saya sarankan hilangkan "From:" jika chat 1-on-1, tapi ini opsional.
            // bubble.textContent = (payload.from ? payload.from + ': ' : '') + payload.body; 
            bubble.textContent = payload.body; // Modern style: hanya isi pesan

            // 4. Elemen Waktu (Jam saja)
            const time = document.createElement('div');
            time.className = 'text-[10px] text-gray-500 dark:text-gray-300 min-w-fit mb-1'; // mb-1 agar sedikit naik dari dasar
            time.textContent = formatTime(payload.created_at);

            // 5. Penyusunan Layout (Jam di luar bubble)
            if (meSide) {
                // SAYA: [Waktu] [Bubble]
                wrapper.appendChild(time);
                wrapper.appendChild(bubble);
            } else {
                // ORANG LAIN: [Bubble] [Waktu]
                wrapper.appendChild(bubble);
                wrapper.appendChild(time);
            }

            messagesDiv.appendChild(wrapper);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // 0) load history pesan
        async function loadHistory() {
            try {
                const res = await fetch("{{ route('chat.messages', $user->id) }}");
                const data = await res.json();
                
                // Reset lastRenderedDate saat reload history
                lastRenderedDate = null; 

                data.forEach(m => {
                    appendMessage({
                        id: m.id,
                        from_id: m.sender_id,
                        from: (m.sender ? m.sender.name : (m.sender_id === myId ? '{{ auth()->user()->name }}' : '{{ $user->name }}')),
                        to_id: m.receiver_id,
                        body: m.message,
                        created_at: m.created_at
                    }, m.sender_id === myId);
                });
            } catch (err) {
                console.error('Failed to load chat history', err);
            }
        }

        loadHistory();

        // 1) Setup Pusher
        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });

        const channel = pusher.subscribe('chat.' + myId);
        channel.bind('message.sent', function (e) {
            const payload = e.message;
            appendMessage(payload, payload.from_id === myId);
        });

        // 2) Kirim pesan
        document.getElementById('chatForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const input = document.getElementById('message');
            const message = input.value.trim();
            if (!message) return;

            try {
                const res = await fetch("{{ route('chat.send', $user->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ message })
                });

                if (!res.ok) {
                    const txt = await res.text();
                    console.error('Server error', res.status, txt);
                    return;
                }

                const json = await res.json();

                if (json.message) {
                    appendMessage(json.message, json.message.from_id === myId);
                } else {
                    // fallback
                    appendMessage({
                        from_id: myId,
                        from: '{{ auth()->user()->name }}',
                        to_id: {{ $user->id }},
                        body: message,
                        created_at: new Date().toISOString()
                    }, true);
                }
                input.value = '';

            } catch (err) {
                console.error('Failed to send message', err);
            }
        });
    </script>
@endsection