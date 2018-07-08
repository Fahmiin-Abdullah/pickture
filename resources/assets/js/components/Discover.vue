<template>
	<div class="mb-3">
		<div class="row result"></div>
		<button class="btn btn-block btn-success text-white" @click="fetchPosts()">Get more!</button>
	</div>
</template>

<script>
	export default {
		name: 'discover',
		created() {
			this.fetchPosts();
		},
		methods: {
			fetchPosts() {
				const _this = this;
				axios.get('/discover')
				.then(res => {
					let result = '';
					res.data.forEach(post => {
						result += `
							<div class="col-md-4 mb-4">
								<div class="card-discover">
									<a href="#postModal${post.id}" data-toggle="modal">
										<img class="card-img-top" src="http://pickture.me/images/uploads/postphoto/${post.postphoto}">
										<div class="text">
											<h1><strong><i class="fas fa-heart pr-3"></i></strong></h1>
											<h1><strong><i class="fas fa-star pr-3"></i></strong></h1>
										</div>
									</a>
								</div>
							</div>

							<div class="modal fade discoverModal" id="postModal${post.id}" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered modal-lg">
									<div class="modal-content">
										<div class="row">
											<div class="col-md-8">
												<img alt="Card image cap" src="http://pickture.me/images/uploads/postphoto/${post.postphoto}" class="rounded-left">
											</div>
											<div class="col-md-4 pr-4">
												<div class="modal-header">
													 <h5 class="modal-title">${post.title}</h5>
													<button type="button" class="close" data-dismiss="modal">
														<span>&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<h6><strong>Description</strong></h6>
													<p>${post.description}</p>
													<br>
													<h6><strong>Captured by:</strong></h6>
													<p><em>${post.user.name}</em></p>
												</div>
												<button class="btn btn-success text-white btn-block mb-2">Buy</button>
												<button class="btn btn-dark text-white btn-block mb-2">Connect</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						`;
					});
					$('.result').append(result);
				})
				.catch(err => console.log(err));
			}
		}
	}
</script>

<style lang="scss">
	.card-discover {
		background-color: #fff;
		height: 33vh !important;
		border-radius: 5px;

		img {
			background-color: #fff;
			height: 33vh !important;
			border-radius: 5px;
			transition: 0.5s;
			object-fit: cover;
		}
	}

	.card-discover:hover{
		img {
			opacity: 0.5;
		}

		.text {
			opacity: 1;
		}
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

	.discoverModal {
		width: 80vw !important;
		margin: auto;

		.modal-lg, .modal-dialog {
			max-width: none !important;
		}

		img {
			width: 54vw;
			height: 80vh;
			object-fit: contain;
		}
	}
</style>