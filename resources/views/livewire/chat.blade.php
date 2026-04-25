{{-- <div wire:poll>
    <style>
        .container-fluid {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }

        .sidebar {
            width: 22%;
            margin-right: 20px;
            border: 2px solid #007bff;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .chat-container {
            width: 45%;
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-color: #fff;
            position: relative; /* Important for positioning the input area */
        }

        .messaging {
            height: 400px;
            overflow-y: auto;
        }

        .input_msg_write {
            position: absolute;
            bottom: 0; /* Stick to the bottom */
            width: 100%;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            display: flex;
        }

        .write_msg {
            flex: 1; /* Take up remaining space */
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        .btn-primary {
            margin-left: 10px;
        }

        /* Make sure the chat history doesn't overlap the input field */
        .msg_history {
            padding-bottom: 60px; /* Space for input field */
        }
    </style>

    <div class="container-fluid">
        <!-- Bouton pour afficher/masquer le chat -->
        <button id="toggleChatButton" class="btn btn-info">Afficher le Chat</button>

        <!-- Chat (45%) -->
        <div class="chat-container" id="chatContainer">
            <h3 class="text">
                @if (auth()->user()->email == 'contact@example.com')
                    <a class="btn-warning" href="{{ Url('delete_chat') }}">Effacer</a>
                @endif
                Chat
            </h3>

            <div class="messaging">
                <div class="inbox_msg">
                    <div class="mesgs">
                        <div id="chat" class="msg_history">
                            @forelse ($messages as $message)
                                @if ($message->user->name == auth()->user()->name)
                                    <!-- Reciever Message-->
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <p>{{ $message->message_text }}</p>
                                            <span class="time_date">{{ $message->created_at->diffForHumans(null, false, false) }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="incoming_msg">{{ $message->user->name }}
                                        <div class="incoming_msg_img">
                                            <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                                        </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p>{{ $message->message_text }}</p>
                                                <span class="time_date">{{ $message->created_at->diffForHumans(null, false, false) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <h5 style="text-align:center; color:red;">Aucun message précédent</h5>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input area -->
            <div class="input_msg_write">
                <form wire:submit.prevent="sendMessage">
                    <input onkeydown='scrollDown()' wire:model.defer="messageText" type="text" class="write_msg" placeholder="Tapez votre message" />
                    <button class="btn btn-primary" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleChatButton').addEventListener('click', function() {
            var chatContainer = document.getElementById('chatContainer');
            if (chatContainer.style.display === 'none' || chatContainer.style.display === '') {
                chatContainer.style.display = 'block'; // Afficher le chat
                this.textContent = 'Cacher le Chat'; // Changer le texte du bouton
            } else {
                chatContainer.style.display = 'none'; // Cacher le chat
                this.textContent = 'Afficher le Chat'; // Changer le texte du bouton
            }
        });
    </script>
</div> --}}



<div wire:poll>
    
    <style>
        .container-fluid {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }

        .sidebar {
            width: 22%;
            margin-right: 20px;
            border: 2px solid #007bff;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .chat-container {
            width: 70%;
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 39px;
            background-color: #fff;
            position: relative; 
        }

        .messaging {
            height: 400px;
            overflow-y: auto;
        }

        .input_msg_write {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            display: flex;
        }

        .write_msg {
            flex: 1; 
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        .btn-primary {
            margin-left: 10px;
        }

        .msg_history {
            padding-bottom: 60px; 
        }

        .outgoing_msg {
            text-align: right;
            margin: 10px 0;
        }

        .sent_msg {
            background-color: #05aa81; 
            color: black;
            padding: 10px;
            border-radius: 15px;
            display: inline-block;
            max-width: 80%;
            word-wrap: break-word;
        }

        .incoming_msg {
            display: flex;
            align-items: flex-start;
            margin: 10px 0;
        }

        .incoming_msg_img {
            margin-right: 10px;
        }

        .incoming_msg_img img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .received_msg {
            display: flex;
            flex-direction: column;
        }

        .received_withd_msg {
            background-color: #f1f1f1; 
            color: black;
            padding: 10px;
            border-radius: 15px;
            display: inline-block;
            max-width: 80%;
            word-wrap: break-word;
        }

        .time_date {
            display: block;
            font-size: 12px;
            margin-top: 5px;
            color: #747474;
        }
    </style>
@if (session()->has('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

    <div class="container-fluid">
        <button id="toggleChatButton" class="btn btn-info">@lang('messages.Afficher le Chat')</button>

        <div class="chat-container" id="chatContainer">
           
            <h3 class="text">
                @if (auth()->user()->email == 'contact@example.com')
                    <button wire:click="deleteChat" class="btn btn-primary">@lang('messages.Effacer')</button>
                @endif
                @lang('messages.Chat')
            </h3>
            

            <div class="messaging">
                <div class="inbox_msg">
                    <div class="mesgs">
                        <div id="chat" class="msg_history">
                            @forelse ($messages as $message)
                                @if ($message->user->name == auth()->user()->name)
                                    <div class="outgoing_msg">
                                        <div class="sent_msg">
                                            <p>{{ $message->message_text }}</p>
                                            <span class="time_date">{{ $message->created_at->diffForHumans(null, false, false) }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="incoming_msg">{{ $message->user->name }}
                                        <div class="incoming_msg_img">
                                            <img src="https://ptetutorials.com/images/user-profile.png" alt="user">
                                        </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <p>{{ $message->message_text }}</p>
                                                <span class="time_date">{{ $message->created_at->diffForHumans(null, false, false) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <h5 style="text-align:center; color:red;">@lang('messages.Aucun message précédent')</h5>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input area -->
            <div class="input_msg_write">
                <form wire:submit.prevent="sendMessage">
                    <input onkeydown='scrollDown()' wire:model.defer="messageText" type="text" class="write_msg" placeholder="@lang('messages.Tapez votre message')" />
                    <button class="btn btn-primary" type="submit">@lang('messages.Envoyer')</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleChatButton').addEventListener('click', function() {
            var chatContainer = document.getElementById('chatContainer');
            if (chatContainer.style.display === 'none' || chatContainer.style.display === '') {
                chatContainer.style.display = 'block';
                this.textContent = 'Cacher le Chat'; 
            } else {
                chatContainer.style.display = 'none'; 
                this.textContent = 'Afficher le Chat'; 
            }
        });
    </script>
</div>


