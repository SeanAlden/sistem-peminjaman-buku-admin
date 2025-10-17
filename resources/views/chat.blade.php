@extends('layouts.app')

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
@endsection

@section('scripts')
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



    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

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
    </script>
@endsection