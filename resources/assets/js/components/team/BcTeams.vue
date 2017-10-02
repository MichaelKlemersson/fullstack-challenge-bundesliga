<template>
    <div id="teams">
        <BcLoader></BcLoader>

        <h2>{{ league.leagueName }}</h2>
        
        <div class="row" v-show="!showLoading">
            <div class="col-md-4 team" v-for="(team, index) in teams">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ team.TeamName }}</div>
                    <div class="panel-body">
                        # {{ team.TeamId }}
                        <p v-if="team.TeamIconUrl !== ''">
                            <strong>Icon </strong> <img :src="team.TeamIconUrl" alt="-" class="team-icon">
                        </p>
                        <p>
                            <strong>Name </strong> {{ team.TeamName }}
                        </p>
                        <p>
                            <strong>Short name </strong> {{ team.ShortName }}
                        </p>
                        <div v-if="team.Results !== undefined" class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Win</th>
                                        <th class="text-center">Lost</th>
                                        <th class="text-center">Draw</th>
                                        <th class="text-center">Poins</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">{{ team.Results.victories }}</td>
                                        <td class="text-center">{{ team.Results.defeats }}</td>
                                        <td class="text-center">{{ team.Results.draws }}</td>
                                        <td class="text-center">{{ team.Results.points }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-block btn-primary" @click="getTeamResults(team, index)">See team results</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .team-icon{
        max-width: 16px;
    }
    .table{
        margin-bottom: 5px;
    }
    .panel-heading, table > thead > th{
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>


<script>
    import BcLoader from './../root/BcLoader'
    import Queue from 'promise-queue'
    import bootbox from 'bootbox'
    import jquery from 'jquery'

    export default {
        components: {
            BcLoader
        },

        data() {
            return {
                teams: [],
                currentLeagueGroup: null
            }
        },

        mounted() {
            this.initPage()
        },

        computed: {
            showLoading() {
                return this.$store.state.showLoading
            },

            league() {
                return this.$store.state.currentLeague
            }
        },

        methods: {
            initPage() {
                this.getCurrentLeagueGroup(this.league.leagueShortcut)
                    .then(response => response.data)
                    .then(data => {
                        this.currentLeagueGroup = data
                    })

                this.fetchTeamsFromLeague(
                    this.league.leagueShortcut,
                    this.league.leagueSaison
                )
                .then(response => response.data)
                .then(data => {
                    this.teams = data
                })
            },

            getCurrentLeagueGroup(league) {
                return axios.get('/leagues/groups/current', {
                    params: { league }
                })
            },

            fetchTeamsFromLeague(league, session) {
                return axios.get('/teams', {
                    params: { league, session }
                })
            },

            fetchTeamResults(league, session, group, team) {
                return axios.get('/results/team', {
                    params: { league, session, group, team }
                })
            },

            getTeamResults(team, index) {
                const dialog = bootbox.dialog({
                    title: team.TeamName,
                    message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
                })
                dialog.init(() => {
                    this.fetchTeamResults(
                        this.league.leagueShortcut,
                        this.league.leagueSaison,
                        this.currentLeagueGroup.GroupOrderID,
                        team.TeamId
                    )
                    .then(response => response.data)
                    .then(data => {
                        const $content = $('<table/>', { 'class': 'table' }).append(
                            $('<thead/>').append(
                                $('<tr/>')
                                    .append($('<th/>', { 'class': 'text-center', 'text': 'Win' }))
                                    .append($('<th/>', { 'class': 'text-center', 'text': 'Lost' }))
                                    .append($('<th/>', { 'class': 'text-center', 'text': 'Draws' }))
                                    .append($('<th/>', { 'class': 'text-center', 'text': 'Points' }))
                            )
                        ).append(
                            $('<tbody/>').append(
                                $('<tr/>')
                                    .append($('<td/>', { 'class': 'text-center', 'text': data.victories }))
                                    .append($('<td/>', { 'class': 'text-center', 'text': data.defeats }))
                                    .append($('<td/>', { 'class': 'text-center', 'text': data.draws }))
                                    .append($('<td/>', { 'class': 'text-center', 'text': data.points }))
                            )
                        )

                        dialog.find('.bootbox-body').html($content)
                    })
                })
            }
        }
    }
</script>
