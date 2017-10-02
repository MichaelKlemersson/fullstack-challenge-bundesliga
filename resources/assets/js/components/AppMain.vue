<template>
    <div id="body-wrapper" style="padding: 80px 0 100px;">
        <BcRootHeader></BcRootHeader>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import BcRootHeader from './root/BcRootHeader'
    import axios from 'axios'

    export default {
        components: {
            BcRootHeader
        }
    }
</script>
