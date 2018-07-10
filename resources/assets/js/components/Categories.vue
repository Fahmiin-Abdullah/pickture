<template>
	<div class="row">
		<div class="col-md-3">
			<h5 class="text-center mb-3">Pick one to begin</h5>
			<div class="list-group mb-5">
				<template v-for="category in categories">
					<a href="#" class="list-group-item list-group-item-action" @click="fetchPosts('category', `${category.category}`)">{{category.category}}</a>
				</template>
			</div>
		</div>
		<div class="col md-9">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<h2>Total posts ({{posts.total}})</h2>
					</div>
					<div class="col-md-9">
						<ul class="pagination">
							<li class="page-item" :class="{disabled: !posts.prev_page_url}"><a class="page-link bg-dark text-white" href="#" @click="fetchPosts('pagination', posts.prev_page_url)">Previous</a></li>
							<li class="page-item disabled"><a href="#" class="page-link">Page {{posts.current_page}} of {{posts.last_page}}</a></li>
							<li class="page-item" :class="{disabled: !posts.next_page_url}"><a class="page-link bg-dark text-white" href="#" @click="fetchPosts('pagination', posts.next_page_url)">Next</a></li>
							<div id="pagination" class="ml-3" :class="{loader: loader}"></div>
						</ul>
					</div>
				</div>
				<hr class="my-2">
				<div class="row">
					<div class="col-md-4 mb-4" v-for="post in posts.data">
						<div class="card">
							<a href="#postModal" data-toggle="modal" @click="modalOpen(post.id)">
								<img class="card-img-top" :src="`http://pickture.me/images/uploads/postphoto/${post.postphoto}`">
								<div class="text">
									<h1><strong><i class="fas fa-heart pr-3"></i></strong></h1>
									<h1><strong><i class="fas fa-star pr-3"></i></strong></h1>
								</div>
							</a>
						</div>
					</div>


					<div class="modal fade" id="postModal" tabindex="-1">
						<div class="modal-dialog modal-dialog-centered modal-lg">
							<div class="modal-content">
								<div class="row">
									<div class="col-md-8">
										<img alt="Card image cap" :src="`http://pickture.me/images/uploads/postphoto/${modalInfo.postphoto}`" class="rounded-left">
									</div>
									<div class="col-md-4 pr-4">
										<div class="modal-header">
											 <h5 class="modal-title">{{modalInfo.title}}</h5>
											<button type="button" class="close" data-dismiss="modal">
												<span>&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<h6><strong>Description</strong></h6>
											<p>{{modalInfo.description}}</p>
											<br>
											<h6><strong>Captured by:</strong></h6>
											<p><em>{{userInfo.name}}</em></p>
										</div>
										<button class="btn btn-success text-white btn-block mb-2">Buy</button>
										<button class="btn btn-dark text-white btn-block mb-2" @click="connect(userInfo.id)">Connect</button>
									</div>
								</div>
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
		name: 'categories',
		props: ['category'],
		data() {
			return {
				categories: [],
				posts: [],
				modalInfo: [],
				userInfo: {
					id: null,
					name: null
				},
				loader: false,
			}
		},
		created() {
			this.category = this.category === 'OOTD' ? '#OOTD' : this.category;
			this.fetchCategories();
			this.fetchPosts('category', this.category);
		},
		methods: {
			fetchCategories() {
				const _this = this;
				axios.get('/categories')
				.then(res => {
					_this.categories = res.data;
				})
				.catch(err => console.log(err));
			},
			fetchPosts(action, page) {
				const _this = this;
				this.loader = true;
				page = action === 'category' ? `/posts/category/${page}` : page;
				axios.get(page)
				.then(res => {
					_this.posts = res.data;
					_this.loader = false;
				})
				.catch(err => console.log(err));
			},
			modalOpen(id) {
				const _this = this;
				axios.get(`/post/${id}`)
				.then(res => {
					_this.modalInfo = res.data;
					_this.userInfo.id = res.data.user.id;
					_this.userInfo.name = res.data.user.name;
				})
				.catch(err => console.log(err));
			},
			connect(id) {
				$('#postModal').modal('hide');
				this.$router.push(`/profile/${id}`);
			}
		}
	}
</script>

<style lang="scss" scoped>
	.list-group-item:hover {
		background-color: #28a745;
		color: #fff;
	}

	.card {
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

	.card:hover{
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

	#postModal {
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

	.loader {
	    border: 3px solid #fff; 
	    border-top: 3px solid #28a745;
	    border-bottom: 3px solid #28a745;
	    border-radius: 50%;
	    width: 30px;
	    height: 30px;
	    animation: spin 2s linear infinite;
	}

	@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>