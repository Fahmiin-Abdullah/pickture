<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-dark">
		<div class="container">
			<a class="navbar-brand text-white" href="/">Pickture</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSmall" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon text-white"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSmall">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active pr-3 pl-3">
						<router-link class="nav-link text-white" to="/">Home</router-link>
					</li>
					<li class="nav-item  pr-3 pl-3">
						<a class="nav-link text-white" href="#">Discover</a>
					</li>
					<li class="nav-item dropdown pr-3 pl-3">
						<a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<router-link class="dropdown-item" to="/foodtography">Foodtography</router-link>
							<a class="dropdown-item" href="#">Travel and leisure</a>
							<a class="dropdown-item" href="#">Our Heritage</a>
							<a class="dropdown-item" href="#">#OOTD</a>
							<a class="dropdown-item" href="#">Wedding</a>
							<a class="dropdown-item" href="#">Graphics and illustrations</a>
						</div>
					</li>
					<li class="nav-item dropdown pr-3 pl-3">
						<a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Join us</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Looking to buy pictures</a>
							<a class="dropdown-item" href="#">Looking to sell pictures</a>
							<a class="dropdown-item" href="#">Looking to hire creative people</a>
							<div class="dropdown-divider"></div>
							<router-link to="/register" class="dropdown-item" v-if="!user">Login/Signup</router-link>
							<a class="dropdown-item" href="/logout" v-if="user">Logout</a>
						</div>
					</li>
					<template v-if="user">
						<li class="nav-item pr-3 pl-3">
							<router-link to="/profile" class="nav-link text-white" href="#"><i class="fas fa-user"></i><p class="white-text float-right pl-3">Welcome, {{user.name}}</p></router-link>
						</li>
					</template>
				</ul>
				
				<form class="form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</div>
	</nav>
</template>

<script>
	export default {
		name: 'navbar',
		props: ['user']
	}
</script>

<style>
	.navbar-brand {
		font-size: 30px;
	}

	.navbar-nav li:hover > ul.dropdown-menu {
	    display: block;
	}

	.dropdown-submenu {
	    position:relative;
	}

	.dropdown-submenu>.dropdown-menu {
	    top:0;
	    left:100%;
	    margin-top:-6px;
	}
</style>