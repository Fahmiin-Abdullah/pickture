import Vue from 'vue'
import VueRouter from 'vue-router'

import MainPage from './components/MainPage'
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
			path: '/discover',
			component: Discover
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
			path: '/profile',
			component: Profile
		}
	]
});