<template>
    <nav class="navbar navbar-default">
        <div class="container">
            <BcNavBarBrand></BcNavBarBrand>

            <div class="collapse navbar-collapse" id="bl-challenge-navbar">
                <BcNavBarLeft></BcNavBarLeft>  
            </div>
        </div>
    </nav>
</template>

<script>
    import BcNavBarBrand from './BcNavBarBrand'
    import BcNavBarLeft from './BcNavBarLeft'

    export default {
        components: {
            BcNavBarBrand,
            BcNavBarLeft
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
