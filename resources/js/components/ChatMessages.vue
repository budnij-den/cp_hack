<template>
    <div class="card">
        <div class="card-header clearfix">
            <a class="text-left align-self-center">
                Чат
            </a>
            <a class="float-right btn dropdown-toggle" id="users" type="button"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Кто здесь
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="users">
                <a class="dropdown-item" v-for="(user, index) in users" :key="index">
                    <img :src="'/svg/' + user.id + '.jpg'" width="55"
                         class="img-thumbnail rounded-circle" alt="...">
                </a>
            </div>
        </div>
        <div class="card-body" style="height: 300px; overflow-y:scroll" v-chat-scroll="{always: false}"
             @scroll-top="loadPreviousMessages()">
            <div class="shadow text-center rounded" v-if="messages.length < allMessages.length" @click.prevent="loadPreviousMessages()">
                Предыдущие сообщения
            </div>
            <div class="rounded p-2 mb-1" style="background-color: lightblue"
                 v-for="(message, index) in messages" :key="index">
                <div class="clearfix">
                    <strong class="text-left" v-if="message.user.sname">
                        {{ message.user.sname }}
                    </strong>
                    <strong v-else="message.user.name">
                        {{ message.user.name }}
                    </strong>
                    <span class="text-left">
                        :
                    </span>
                    <a class="mb-1 text-muted text-left">
                        {{ message.create_At }}
                    </a>
                    <a class="float-right btn dropdown-toggle" id="mark" type="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"
                       v-if="message.user_id === user.id">
                        ...
                    </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="mark">
                            <a class="dropdown-item" @click="deleteMessage(message.id)">
                                Удалить
                            </a>
                        </div>
                </div>
                <div class="text-break">
                    {{ message.message }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="clearfix row">
                <input
                    role="textbox"
                    id="btn-input"
                    aria-multiline="true"
                    contenteditable="true"
                    name="message"
                    class="form-control input-sm col-9"
                    placeholder="Сообщение..."
                    v-model="newMessage"
                    @keyup="sendTypingEvent()">
                <a class="ml-3 btn btn-outline-info col-2" @click.prevent="sendMessage()">
                    ✉️
                </a>
            </div>
        </div>
        <span v-if="activeUser" class="text-muted"> {{ activeUser.name }} перебирает буковки...</span>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                allMessages: [],
                messages: [],
                newMessage: '',
                users: [],
                activeUser: false,
                typingTimer: false,
            }
        },
        created() {
            this.fetchMessages();
            setInterval(() => this.fetchMessages(), 60 * 1000);
            setInterval(() => this.loadPreviousMessages , 60 * 1000);
            moment.locale('ru');
            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;
                    if(this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false
                    }, 3000)
                    })
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                })
        },
        methods: {
            fetchMessages() {
                axios.get('messages').then(response => {
                    this.messages = response.data.slice(-5);
                    this.messages.forEach(function (item, i) {
                        item.create_At = moment(item.created_at).startOf('second').fromNow();
                    });
                    this.allMessages = response.data;
                });
            },
            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            },
            sendMessage() {
                axios.post('/messages', {message: this.newMessage})
                    .then(responce => {
                        this.fetchMessages();
                            this.newMessage = ''
                    });
            },
            deleteMessage(messageId) {
                axios.get('/messageDelete/' + messageId)
                    .then(responce => {
                        this.fetchMessages()
                });
            },
            loadPreviousMessages() {
                axios.get('messages').then((response) => {
                    let k = this.messages.length;
                    k = k + 5;
                    this.messages = response.data.slice(-k);
                    this.messages.forEach(function (item, i) {
                        item.create_At = moment(item.created_at).startOf('minute').fromNow();
                    });
                });
            }
        }
    };
</script>