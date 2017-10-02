<template>
    <ul class="nav navbar-nav">
        <router-link tag="li" exact-active-class="active" :to="'/'"><a href="/">Home <span class="sr-only">(current)</span></a></router-link>
        <router-link tag="li" exact-active-class="active" :to="{ path: '/leagues/bl1' }"><a href="#">League bl1</a></router-link>
        <router-link tag="li" exact-active-class="active" :to="{ path: '/leagues/bl2' }"><a href="#">League bl2</a></router-link>
        <router-link tag="li" exact-active-class="active" :to="{ path: '/leagues/bl3' }"><a href="#">League bl3</a></router-link>
    </ul>
</template>
