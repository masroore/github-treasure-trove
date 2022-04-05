<template>


    <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell-o"></i>
            <span class="label label-danger" v-if="unreadNotifications.length>0"> {{unreadNotifications.length}}</span>
        </a>
        <ul class="dropdown-menu">

            <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <li v-for="unread in unreadNotifications">

                        <a href="#" @click="markAsRead(unread)" style="white-space: normal !important;">


                            <div class="pull-left"><i class="fa fa-warning fa-2x text-yellow"></i></div>

                            <small class="pull-right"><i class="fa fa-clock-o"></i> {{unread.created_at}}</small>
                            <p>{{unread.descripcion}}</p>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </li>


</template>

<script>
    export default {
        props: ['unreads'],
        data() {
            return {
                unreadNotifications: this.unreads
            }
        },
        mounted() {
            /*this.getUnreadNotifications();*/
            this.listen();
        },
        methods: {
            listen() {

                Echo.channel('administrator')
                    .listen('RequestedAppointment', (data) => {
                        //this.unreadNotifications.unshift(data);
                        var sound = document.getElementById('soundNotification');
                        sound.play();
                        console.log("ESCUCHA MAMON");

                    });
            }/*,
            getUnreadNotifications() {
                axios.get($("#page").data('url') + '/notificacions/getUnread').then(res => {
                    this.unreadNotifications = res.data;
                });
            },
            markAsRead(unread) {
                axios.get($("#page").data('url') + '/notificacions/' + unread.id + '/markAsRead').then(() => {
                    location.replace(unread.link);
                });
            }*/
        },

    }
</script>
