<template>
	<div class="row">
		<div class="col-md-3">
			<h5 class="text-center mb-3">Pick one to begin</h5>
			<div class="list-group">
				<router-link to="/foodtography" class="list-group-item list-group-item-action">Foodtography</router-link>
				<router-link to="/travel" class="list-group-item list-group-item-action">Travel and leisure</router-link>
				<router-link to="/" class="list-group-item list-group-item-action">Our heritage</router-link>
				<router-link to="/" class="list-group-item list-group-item-action">#OOTD</router-link>
				<router-link to="/" class="list-group-item list-group-item-action">Wedding</router-link>
				<router-link to="/" class="list-group-item list-group-item-action">Graphics and illustrations</router-link>
			</div>
		</div>
		<div class="col md-9">
			<transition name="slider" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'categories'
	}
</script>

<style scoped>
	.list-group-item:hover {
		background-color: #28a745;
		color: #fff;
	}
</style>