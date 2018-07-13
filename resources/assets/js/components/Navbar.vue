<template>
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark">
		<div class="container">
			<a class="navbar-brand text-white" href="/">Pickture</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSmall" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon text-white"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSmall">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item pr-3 pl-3">
						<router-link class="nav-link text-white" to="/">Home</router-link>
					</li>
					<li class="nav-item pr-3 pl-3">
						<router-link class="nav-link text-white" to="/discover/any">Discover</router-link>
					</li>
					<li class="nav-item pr-3 pl-3 dropdown" :class="{hidden: validRoute}">
						<a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<router-link to="/categories/Foodtography" class="dropdown-item" href="#">Foodtography</router-link>
							<router-link to="/categories/Travel and leisure" class="dropdown-item" href="#">Travel and leisure</router-link>
							<router-link to="/categories/Our heritage" class="dropdown-item" href="#">Our heritage</router-link>
							<router-link to="/categories/OOTD" class="dropdown-item" href="#">#OOTD</router-link>
							<router-link to="/categories/Wedding" class="dropdown-item" href="#">Wedding</router-link>
							<router-link to="/categories/Graphics and illustrations" class="dropdown-item" href="#">Graphics and illustrations</router-link>
						</div>
					</li>
					<li class="nav-item pr-3 pl-3" v-if="validRoute">
						<a class="nav-link text-white" href="#">Categories</a>
					</li>
					<li class="nav-item dropdown pr-3 pl-3">
						<a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Join us</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<router-link to="/register" class="dropdown-item" v-if="!user">Login/Signup</router-link>
							<a class="dropdown-item" href="/logout" v-if="user">Logout</a>
						</div>
					</li>
					<template v-if="user && validUser">
						<li class="nav-item px-3">
							<router-link :to="`/profile/${user.id}`" class="nav-link text-white" href="#"><i class="fas fa-user"></i><p class="white-text float-right pl-3 mb-0">Welcome, {{user.name}}</p></router-link>
						</li>
					</template>
				</ul>
				
				<!--Search bar-->
				<form class="form-inline my-2 my-lg-0" :class="{hidden: validDiscovery}">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="searchTerm">
					<button class="btn btn-outline-success my-2 my-sm-0" @click.prevent="search()">Search</button>
				</form>
			</div>
		</div>
	</nav>
</template>

<script>
	export default {
		name: 'navbar',
		props: ['user'],
		data() {
			return {
				validRoute: false,
				validDiscovery: false,
				validUser: true,
				searchTerm: null
			}
		},
		watch: {
		    '$route'(from, to) {
		    	this.validRoute = this.$route.params.category ? true : false;
		    	this.validDiscovery = this.$route.matched[0].path == '/discover/:search' ? true : false;
		    	this.validUser = this.$route.params.id ? false : true;
		    }
		},
		methods: {
			search() {
				this.$router.push(`/discover/${this.searchTerm}`);
				this.searchTerm = null;
			}
		}
	}
</script>

<style lang="scss" scoped>
	.navbar-nav li:hover {
		ul.dropdown-menu {
		    display: block;
		}
	}

	.dropdown-submenu {
	    position:relative;
	}

	.dropdown-submenu {
		.dropdown-menu {
		    top:0;
		    left:100%;
		    margin-top:-6px;
		}
	}
</style>