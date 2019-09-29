<template>
    <div class="d-flex flex-row">
        <div class="w-75 mb-1 img">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a class="h2 float-left">
                        Имя
                    </a>
                    <a class="h2 float-right">
                        Пройденное расстояние
                    </a>
                </li>
            </ul>
            <ul class="list-group list-group-flush" v-for="(user, index) in users" :key="index">
                <li class="list-group-item">
                    <a class="h5 float-left">
                        {{ user.name }}
                    </a>
                    <a class="h5 float-right">
                        {{ user.distance}}
                    </a>
                </li>
            </ul>
        </div>
        <div class="w-25 ml-1 mb-1 img">
            <div class="card">
                <div class="card-header clearfix">
                    <a class="text-left align-self-center">
                        Последняя активность
                    </a>
                </div>
                <div class="card-body" style="height: 300px; overflow-y:scroll" v-chat-scroll="{always: false}">
                    <div class="shadow text-center rounded">
                        Предыдущие сообщения
                    </div>
                    <div class="rounded p-2 mb-1" style="background-color: lightblue">
                        <div class="clearfix">
                            <strong>
                            </strong>
                            <span class="text-left">
                                :
                            </span>
                            <a class="mb-1 text-muted text-left">
                            </a>
                        </div>
                        <div class="text-break">
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['users'],
        data() {
            return {
                updatedUsers: []
            }
        },
        created() {
            this.fetchDistance();
            setInterval(() => this.fetchDistance(), 25 * 1000);
            // setInterval(() => this.loadPreviousMessages , 60 * 1000);
            moment.locale('ru');
            /*Echo.join('photo')
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                })*/
        },
        methods: {
            fetchDistance() {
                axios.get('activity').then(response => {
                    /*this.users.forEach(function (item, i) {
                        item.distance = moment(item.created_at).startOf('second').fromNow();
                    });*/
                    this.updatedUsers = response.data;
                });
            },
            /*sendMessage() {
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
            },*/
            /*loadPreviousMessages() {
                axios.get('messages').then((response) => {
                    let k = this.messages.length;
                    k = k + 5;
                    this.messages = response.data.slice(-k);
                    this.messages.forEach(function (item, i) {
                        item.create_At = moment(item.created_at).startOf('minute').fromNow();
                    });
                });
            }*/
        }
    };
</script>