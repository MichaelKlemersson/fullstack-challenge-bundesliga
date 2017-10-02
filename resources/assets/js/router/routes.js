const routes = [
    {
        path: '/',
        component: require('../components/league/BcNextMatches')
    },
    {
        path: '/leagues/:id',
        component: require('../components/league/BcLeagueMatches')
    },
    {
        name: 'leagueTeams',
        path: '/teams',
        component: require('../components/team/BcTeams')
    }
]

export default routes