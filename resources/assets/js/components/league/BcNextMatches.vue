<template>
    <div id="next-matches" class="row">
        <BcLoader></BcLoader>

        <div v-show="!isLoading">
            <div class="col-md-4 col-xs-12" v-for="league in leagues">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>{{ league.leagueName }}</strong></div>

                    <div class="panel-body text-center">
                        <i v-show="league.nextMatches === undefined" class="fa fa-refresh fa-spin fa-3x fa-fw margin-bottom"></i>
                        
                        <div v-show="league.nextMatches !== undefined">
                            <span class="link-match" v-for="match in league.nextMatches">
                                {{ match.Team1.TeamName }}
                                <img :src="match.Team1.TeamIconUrl" class="team-icon" alt="">
                                x
                                <img :src="match.Team2.TeamIconUrl" class="team-icon" alt="">
                                {{ match.Team2.TeamName }}
                                <br/>
                            </span>
                        </div>

                        <br/>
                        <br/>
                        <router-link :to="{ path: '/leagues/' + league.leagueShortcut }">
                            See others matches <i class="fa fa-arrow-right"></i></router-link>
                    </div>

                    <div class="panel-footer text-center" v-show="league.nextMatches !== undefined">
                        <a href="#" @click.prevent="goToTeams(league)">
                            See league teams</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .link-match{
        display: block;
        padding: 3px 0;
        text-decoration: none;
        cursor: pointer;
    }
    .team-icon{
        max-width: 20px;
    }
</style>

<script>
    import BcLoader from './../root/BcLoader'
    import axios from 'axios'
    import Queue from 'promise-queue'
    import { indexOf } from 'lodash'
    import bootbox from 'bootbox'
    import router from './../../router'

    export default {
        components: {
            BcLoader
        },

        data: () => {
            return {
                leagues: []
            }
        },

        watch: {
            '$route': 'initPage'
        },

        created () {
            this.initPage()
        },

        computed: {
            isLoading() {
                return this.$store.state.showLoading
            }
        },

        methods: {
            initPage() {
                this.$store.commit('showLoading', true)
                this.getCurrentSport(sport => {
                    axios.get('/leagues', { 
                        params: {
                            sport: sport.sportsID,
                            session: this.getCurrentSession()
                        }
                    }).then(response => {
                        if (response.data.length) {
                            let queueNextMatches = new Queue(2, response.data.length);
                            const _self = this

                            response.data.forEach(function(league, index) {
                                if (indexOf(['bl1', 'bl2', 'bl3'], league.leagueShortcut) === -1) {
                                    return;
                                }
                                queueNextMatches.add(() => {
                                    const deferred = $.Deferred()
                                    axios.get('/leagues/matches/upcoming', { 
                                        params: { 
                                            league: league.leagueShortcut
                                        }
                                    }).then(response => {
                                        if (response.data.matchID !== -1) {
                                            league.nextMatches = response.data
                                            _self.leagues.push(league)
                                        }
                                        deferred.resolve()
                                        if (queueNextMatches.getPendingLength() == 1) {
                                            _self.$store.commit('showLoading', false)
                                        }
                                    })
                                    return deferred.promise()
                                })
                            })
                        }
                    })
                })
            },

            getCurrentSport(callback) {
                if (this.$store.state.currentSport == null) {
                    return axios.get('/sports/default').then(response => {
                        this.$store.commit('setDefaultSport', response.data)

                        callback(this.$store.state.currentSport)
                    })
                } else {
                    callback(this.$store.state.currentSport)
                }
            },

            getCurrentSession() {
                const now = new Date();

                return (now.getMonth() <= 5 ? now.getFullYear() - 1 : now.getFullYear());
            },

            goToTeams(league) {
                this.$store.commit('setCurrentLeague', league)
                
                router.push('/teams')
            }
        }
    }
</script>
