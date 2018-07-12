import Vue from 'vue'
import VueRouter from 'vue-router'

import MainPage from './components/MainPage'
import Licence from './components/Licence'
import Discover from './components/Discover'
import Categories from './components/Categories'
import Register from './components/Register'
import Profile from './components/Profile'

Vue.use(VueRouter)

export default new VueRouter ({
	routes: [
		{
			path: '/',
			component: MainPage
		},
		{
			path: '/licence',
			component: Licence
		},
		{
			path: '/discover/:search',
			component: Discover,
			props: true
		},
		{
			path: '/categories/:category',
			component: Categories,
			props: true
		},
		{
			path: '/register',
			component: Register
		},
		{
			path: '/profile/:id',
			component: Profile,
			props: true
		}
	]
});