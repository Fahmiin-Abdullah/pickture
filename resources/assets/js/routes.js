import Vue from 'vue'
import VueRouter from 'vue-router'

import MainPage from './components/MainPage'
import Foodtography from './components/Foodtography'
import Discover from './components/Discover'
import Categories from './components/Categories'

Vue.use(VueRouter)

export default new VueRouter ({
	routes: [
		{
			path: '/',
			component: MainPage
		},
		{
			path: '/foodtography',
			component: Foodtography
		},
		{
			path: '/discover',
			component: Discover
		},
		{
			path: '/categories',
			component: Categories
		}
	]
});