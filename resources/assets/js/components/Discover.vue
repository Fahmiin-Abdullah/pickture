<template>
	<div class="mb-3">
		<div class="row">
			<div class="col-md-6">
				<h3>{{introMessage}}</h3>
			</div>
			<div class="col-md-6">
				<form class="form-inline my-2 my-lg-0 float-right">
					<div class="mr-3" :class="{discover_loader: loader}"></div>
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="searchTerm">
					<button class="btn btn-outline-success my-2 my-sm-0" @click.prevent="getPosts(searchTerm)">Search</button>
				</form>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4 mb-4 discover" v-for="post in posts[0]">
				<div class="card-discover">
					<a href="#postModal" data-toggle="modal" @click="modalOpen(post.id)">
						<img class="card-img-top" :src="`http://pickture.me/images/uploads/postphoto/${post.postphoto}`">
						<div class="text">
							<h1><strong><i class="fas fa-heart pr-3"></i></strong></h1>
							<h1><strong><i class="fas fa-star pr-3"></i></strong></h1>
						</div>
					</a>
				</div>
			</div>

			<div class="modal fade discoverModal" id="postModal" tabindex="-1">
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
		<button class="btn btn-block btn-success text-white" @click="getPosts(next_page_url)">{{message}}</button>
	</div>
</template>

<script>
	export default {
		name: 'discover',
		props: ['search'],
		data() {
			return {
				posts: [],
				modalInfo: [],
				userInfo: {
					id: null,
					name: null
				},
				introMessage: null,
				message: null,
				searchTerm: null,
				next_page_url: null,
				loader: false
			}
		},
		created() {
			const _this = this;
			const url = this.search == 'any' ? axios.get('/discover') : axios.post(`/search/${_this.search}`);
			this.fetchPosts(url);
			this.introMessage = this.search != 'any' ? `You searched for "${this.search}"` : 'Discover';
			this.message = 'Get more!';
		},
		methods: {
			fetchPosts(url) {
				this.loader = true;
				const _this = this;
				url
				.then(res => {
					_this.loader = false;
					_this.next_page_url = res.data.next_page_url;
					_this.message = _this.next_page_url == null ? 'There is no more!' : 'Get more!';
					console.log(_this.posts);
					if (_this.posts.length == 0) {
						_this.posts.push(res.data.data);
					} else {
						res.data.data.forEach(post => {
							_this.posts[0].push(post);
						});
					}
					console.log(_this.posts);
				})
				.catch(err => {
					_this.loader = false;
					console.log(err);
				});
			},
			getPosts(params) {
				let url = '';
				if (params == this.next_page_url) {
					url = axios.get(params);
				} else {
					this.posts = [];
					this.introMessage = `You searched for "${params}"`;
					$('.discover').remove();
					url = axios.post(`/search/${params}`);
				}
				this.fetchPosts(url);
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
				$('.discoverModal').modal('hide');
				this.$router.push(`/profile/${id}`);
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
			width: 50vw;
			max-height: 80vh;
			object-fit: contain;
		}
	}

	.discover_loader {
	    border: 3px solid #f9f9f9; 
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