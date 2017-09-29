const routes = [
    {
        path: '/',
        component: require('../components/league/BcNextMatches')
    },
    {
        path: '/teams',
        component: require('../components/team/BcListTeams')
    },
    {
        path: '/leagues',
        component: require('../components/league/BcLeagues')
    }
]

export default routes