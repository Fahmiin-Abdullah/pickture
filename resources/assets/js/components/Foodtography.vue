<template>
	<div class="container">
		<div class="row">
			<div class="col-md-4 mb-4">
				<div class="card">
					<a href="#modal" data-toggle="modal" @click="modal(1)">
						<img class="card-img-top" :src="require('../../img/food/food_1.jpg')" alt="Card image cap">
						<div class="text">
							<h1><strong><i class="fas fa-heart pr-3"></i>63</strong></h1>
							<h1><strong><i class="fas fa-star pr-3"></i>24</strong></h1>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<a href="#modal" data-toggle="modal" @click="modal(2)">
						<img class="card-img-top" :src="require('../../img/food/food_2.jpg')" alt="Card image cap">
					</a>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<a href="#modal" data-toggle="modal" @click="modal(3)">
						<img class="card-img-top" :src="require('../../img/food/food_3.jpg')" alt="Card image cap">
					</a>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<a href="#modal" data-toggle="modal" @click="modal(4)">
						<img class="card-img-top" :src="require('../../img/food/food_4.jpg')" alt="Card image cap">
					</a>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<a href="#modal" data-toggle="modal" @click="modal(5)">
						<img class="card-img-top" :src="require('../../img/food/food_5.jpg')" alt="Card image cap">
					</a>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<a href="#modal" data-toggle="modal" @click="modal(6)">
						<img class="card-img-top" :src="require('../../img/food/food_6.jpg')" alt="Card image cap">
					</a>
				</div>
			</div>

			<div class="modal fade" id="modal" tabindex="-1">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="row">
							<div class="col-md-8">
								<img alt="Card image cap" id="modalImg" class="rounded-left">
							</div>
							<div class="col-md-4 pr-4">
								<div class="modal-header">
									 <h5 class="modal-title">Salad</h5>
									<button type="button" class="close" data-dismiss="modal">
										<span>&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<h6><strong>Description</strong></h6>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem voluptate numquam laborum, id sint nobis. Laborum nisi labore sapiente corporis quos eligendi minima a, officiis eveniet inventore expedita similique necessitatibus harum enim explicabo dolor natus tenetur, veritatis, aliquid fugit facilis.</p>
									<br>
									<h6><strong>Captured by:</strong></h6>
									<p><em>Lorem ipsum dolor sit amet</em></p>
								</div>
								<button class="btn btn-success text-white btn-block mb-2">Buy</button>
								<button class="btn btn-dark text-white btn-block mb-2">Connect</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'foodtography',
		methods: {
			modal(id) {
				$('#modalImg').attr('src', `/images/food_${id}.jpg`);
			}
		}
	}
</script>

<style scoped>
	.card, .card img {
		background-color: #fff;
		height: 38vh !important;
		border-radius: 5px;
	}

	.card img {
		transition: 0.5s;
	}

	.card:hover img{
		opacity: 0.5;
	}

	.card:hover .text {
		opacity: 1;
	}

	.text {
		transition: 0.5s;
		color: #000;
		opacity: 0;
		font-size: 20px;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		text-align: center;
	}

	.card img {
		object-fit: cover;
	}

	.modal {
		width: 80vw !important;
		margin: auto;
	}

	.modal-lg, .modal-dialog {
		max-width: none !important;
	}

	.modal img {
		width: 54vw;
		object-fit: contain;
	}
</style>