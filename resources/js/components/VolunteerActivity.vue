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
                <div class="card-body" style="height: 300px; overflow-y:scroll">
                    <div class="rounded p-2 mb-1" style="background-color: lightblue" v-for="(photo, index) in photos"
                         :key="index">
                        <div class="clearfix">
                            <strong>
                                {{photo.photoId}}
                            </strong>
                            <span class="text-left">
                                :
                            </span>
                            <a class="mb-1 text-muted text-left">
                                {{ photo.create_At}}
                            </a>
                        </div>
                        <div class="text-break">
                            {{ photo.distance }}
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        // props: ['users'],
        data() {
            return {
                users: [],
                photos: []
            }
        },
        created() {
            setInterval(() => this.fetchDistance(), 5 * 1000);
            setInterval(() => this.fetchPhotos(), 5 * 1000);
            // setInterval(() => this.loadPreviousMessages , 60 * 1000);
            moment.locale('ru');
            /*Echo.join('photo')
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                })*/
        },
        methods: {
            fetchDistance() {
                axios.get('/show').then(response => {
                    this.users = response.data;
                });
            },
            fetchPhotos() {
                axios.get('/photos').then(response => {
                    this.photos = response.data;
                    this.photos.forEach(function (item, i) {
                        item.create_At = moment(item.created_at).startOf('second').fromNow();
                    });
                });
            },
        }
    };
</script>