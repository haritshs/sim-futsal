<template>
    <li class="nav-item dropdown" id="markasread">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge" id="count-notif">{{jabatans.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" >
                <i class="fas fa-envelope mr-2"></i> {{ jabatan.data['jabatan']['jabatan'] }}
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <a class="dropdown-item" v-if="jabatans.length == 0">
                No Notification
            </a>
        </div>
    </li>
</template>

<script>
    export default {
        props:['jabatans'],
        /*data(){
            return{
                unreadNotifications:this.unreads
            }
        },
        mounted() {
            console.log('Component mounted.');
            Echo.private('App.Admin.' + this.adminid)
                .notification((notification) => {
                console.log(notification);
            });
        }*/
    }
</script>
