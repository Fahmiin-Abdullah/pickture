<template>
	<div class="row">
		<!--Profile section-->
		<div class="col-sm-3 mb-3">
			<div class="card mb-3">
				<div class="card-body">
					<h4 class="text-center mb-3"><strong><span class="float-left" v-if="user != null && user.id == id"><i class="fas fa-star pointer" @click="fetchFavourites()"></i></span><span v-if="user != null && user.id == id">Hi, </span>{{update.name}}</strong><span class="float-right"><a data-toggle="modal" data-target="#editModal" v-if="user != null && user.id == id"><i class="fas fa-pen pointer"></i></a></span></h4>
					<div class="card-image text-center">
						<img :src="`http://pickture.me/images/uploads/profilepic/${update.profilepic}`" v-model="update.profilepic" class="profilepic">
					</div>
					<hr>
					<h6 class="text-center py-2"><em>"{{update.tagline}}"</em></h6>
				</div>
			</div>
			<h6 class="text-center">Catch me on social media</h6>
			<ul class="list-group">
				<li class="list-group-item" v-for="social in update.socials">
					<div class="row">
						<div class="col-2 text-center">
							<i :class="social.social"></i>
						</div>
						<div class="col-10 text-truncate">
							<a :href="social.link" v-model="social.link" target="_blank">{{social.link}}</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="col-sm-9">
			<div class="row">
				<div class="col-7 col-sm-4">
					<h2>{{headerMessage}} ({{posts.total}})</h2>
				</div>
				<div class="col-sm-4 d-none d-sm-block">
					<ul class="pagination">
						<li class="page-item" :class="{disabled: !posts.prev_page_url}"><a class="page-link bg-dark text-white" href="#" @click="fetchPosts(posts.prev_page_url)">Previous</a></li>
						<li class="page-item disabled"><a href="#" class="page-link">Page {{posts.current_page}} of {{posts.last_page}}</a></li>
						<li class="page-item" :class="{disabled: !posts.next_page_url}"><a class="page-link bg-dark text-white" href="#" @click="fetchPosts(posts.next_page_url)">Next</a></li>
						<div id="pagination" class="ml-3" :class="{loader: loader}"></div>
					</ul>
				</div>
				<div class="col-5 col-sm-4 text-lg-right">
					<a class="btn btn-success text-white" data-toggle="modal" data-target="#postModal" v-if="user != null && user.id == id && favouriteList == false">Add new photo</a>
				</div>
			</div>
			<hr class="my-2">
			<div class="row ">
				<div class="col-sm-4" v-for="post in posts.data" v-if="!favouriteList">
					<div class="card card-post mb-3">
						<a href="#photoModal" data-toggle="modal" @click="modalOpen(post.id)">
							<img class="card-img-top" :src="`http://pickture.me/images/uploads/postphoto/${post.postphoto}`">
							<div class="text">
								<h1><strong><i class="fas fa-heart pr-3"></i>{{post.likes_count}}</strong></h1>
								<h1><strong><i class="fas fa-star pr-3"></i>{{post.favourites_count}}</strong></h1>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-4" v-for="post in posts.data" v-if="favouriteList">
					<div class="card card-post mb-3">
						<a href="#photoModal" data-toggle="modal" @click="modalOpen(post.post.id)">
							<img class="card-img-top" :src="`http://pickture.me/images/uploads/postphoto/${post.post.postphoto}`">
							<div class="text">
								<h1><strong><i class="fas fa-heart pr-3"></i>{{post.likes_count}}</strong></h1>
								<h1><strong><i class="fas fa-star pr-3"></i>{{post.favourites_count}}</strong></h1>
							</div>
						</a>
					</div>
				</div>
			</div>

			<div class="col-sm-4 d-block d-sm-none">
				<ul class="pagination justify-content-center">
					<li class="page-item" :class="{disabled: !posts.prev_page_url}"><a class="page-link bg-dark text-white" href="#" @click="fetchPosts(posts.prev_page_url)">Previous</a></li>
					<li class="page-item disabled"><a href="#" class="page-link">Page {{posts.current_page}} of {{posts.last_page}}</a></li>
					<li class="page-item" :class="{disabled: !posts.next_page_url}"><a class="page-link bg-dark text-white" href="#" @click="fetchPosts(posts.next_page_url)">Next</a></li>
					<div id="pagination" class="ml-3" :class="{loader: loader}"></div>
				</ul>
			</div>
		</div>




		<!--Edit profile section-->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit profile</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-row">
								<div class="col mb-2">
									<div class="form-group">
										<input type="text" class="form-control" v-model="update.name">
										<span class="float-right mb-1">{{update.name.length}}/20</span>
									</div>
									<div class="form-group">
										<input type="email" class="form-control" v-model="update.email">
									</div>
									<div class="form-group">
										<textarea class="form-control" v-model="update.tagline"></textarea>
										<span class="float-right mb-1">{{update.tagline.length}}/50</span>
									</div>
								</div>
								<div class="col text-center">
									<img :src="`http://pickture.me/images/uploads/profilepic/${update.profilepic}`" class="profilepic mb-3" v-model="update.profilepic">
									<div class="custom-file">
										<input type="file" name="profilepic" @change="openFile" class="hidden" id="fileUpload">
										<label for="fileUpload">
											<a class="btn btn-outline-success">Upload image</a>
										</label>
									</div>
								</div>
							</div>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-facebook"></i></div>
								</div>
								<input type="text" class="form-control" placeholder="Add your facebook link here" v-model="update.socials[0].link">
							</div>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-instagram"></i></div>
								</div>
								<input type="text" class="form-control" placeholder="Add your instagram link here" v-model="update.socials[1].link">
							</div>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fas fa-globe-americas"></i></div>
								</div>
								<input type="text" class="form-control" placeholder="Add your website link here" v-model="update.socials[2].link">
							</div>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fab fa-whatsapp"></i></div>
								</div>
								<input type="text" class="form-control" placeholder="Add your contact number here" v-model="update.socials[3].link">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div id="update" class="mr-3" :class="{loader: loader}" v-if="text"></div>
						<button class="btn btn-dark" data-dismiss="modal" @click.prevent="cancelUpdate('.profilepic')">Cancel</button>
						<button class="btn btn-success" @click.prevent="profileAction('#update')">Save changes</button>
					</div>
				</div>
			</div>
		</div>




		<!--Create post section-->
		<div class="modal fade" id="postModal" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="row">
						<div class="col-sm-8">
							<img id="postphoto" v-model="postData.postphoto">
						</div>
						<div class="col-sm-4">
							<div class="modal-header">
								<h5 class="modal-title">Create a new post</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="custom-file text-center mb-3">
									<input type="file" name="postphoto" @change="openFile" class="hidden" id="fileUpload2">
									<label for="fileUpload2">
										<a class="btn btn-outline-success">Upload image</a>
									</label>
								</div>
								<form class="mb-4">
									<div class="form-group" :class="{'has-error': hasErrors.title}">
										<input type="text" class="form-control" placeholder="Title" v-model="postData.title">
										<span class="float-right mb-1" v-if="postData.title != null">{{postData.title.length}}/50</span>
										<span v-if="hasErrors.title" class="help-block">
		                                    <strong>{{errorMessage.title}}</strong>
		                                </span>
									</div>
									<div class="form-group" :class="{'has-error': hasErrors.description}">
										<textarea class="form-control" rows="4" placeholder="Tell the world what's on your mind" v-model="postData.description"></textarea>
										<span class="float-right mb-1" v-if="postData.description != null">{{postData.description.length}}/200</span>
										<span v-if="hasErrors.description" class="help-block">
		                                    <strong>{{errorMessage.description}}</strong>
		                                </span>
									</div>
									<div class="input-group mb-2" :class="{'has-error': hasErrors.category}">
										<div class="input-group-prepend">
											<label class="input-group-text" for="inputGroupSelect">Select a category</label>
										</div>
										<select class="custom-select" id="inputGroupSelect" v-model="postData.category">
											<option v-for="category in categories" :key="category.id">{{category.category}}</option>
										</select>
										<span v-if="hasErrors.category" class="help-block">
		                                    <strong>{{errorMessage.category}}</strong>
		                                </span>
									</div>
									<div :class="{'has-error': hasErrors.status}">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="downloadable" v-model="postData.status">
											<label class="form-check-label" for="inlineRadio1">Downloadable</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="purchasable" v-model="postData.status">
											<label class="form-check-label" for="inlineRadio2">Purchasable</label>
										</div>
									</div>
									<span v-if="hasErrors.status" class="help-block">
	                                    <strong>{{errorMessage.status}}</strong>
	                                </span>
								</form>
								<p class="mb-0"><em>Please ensure that your photo is in accordance to our <a href="#" @click="goToLicence()">terms of licences</a> before uploading.</em></p>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<span v-if="hasErrors.postphoto" class="help-block float-left mr-4">
	                        <strong>{{errorMessage.postphoto}}</strong>
	                    </span>
						<div id="post" class="mr-3" :class="{loader: postLoader}" v-if="text"></div>
						<button class="btn btn-success white-text text-right" @click.prevent="profileAction('#post')">Create</button>
					</div>
				</div>
			</div>
		</div>




		<!--Edit and view post section-->
		<div class="modal fade" id="photoModal" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="row">
						<div class="col-sm-8">
							<img alt="Card image cap" :src="`http://pickture.me/images/uploads/postphoto/${modalInfo.postphoto}`" class="rounded-left">
						</div>
						<div class="col-sm-4 pr-4">
							<template v-if="!edit">
								<div class="modal-header">
									 <h5 class="modal-title">{{modalInfo.title}}</h5>
									<button type="button" class="close" data-dismiss="modal">
										<span>&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<h6><strong>Description</strong></h6>
									<p>{{modalInfo.description}}</p>
								</div>
								<template v-if="!deleteP">
									<div class="row mb-2 container ml-0" v-if="user != null">
										<div class="col-6 pl-0">
											<button class="btn btn-danger text-white btn-block" @click.prevent="postSocial('like')" :class="{'btn-dark': like}">{{likeMessage}}</button>
										</div>
										<div class="col-6 pr-0">
											<button class="btn btn-primary text-white btn-block"@click.prevent="postSocial('favourite')" :class="{'btn-dark': favourite}">{{favouriteMessage}}</button>
										</div>
									</div>
									<div class="modal-footer" v-if="modalInfo.status == 'downloadable'">
										<button class="btn btn-info text-white btn-block mb-2" @click="download(modalInfo.postphoto)" v-if="user == null || user.id != id">Download</button>
									</div>
								</template>
							</template>
							<template v-if="user != null && user.id == id">
								<div class="container ml-0">
									<button class="btn btn-success text-white btn-block my-2" @click="edit = !edit" v-if="!deleteP">Edit</button>
									<button class="btn btn-dark texxt-white btn-block" @click="deleteP = !deleteP" v-if="!edit">Delete</button>
									<br>
									<form v-if="edit">
										<h5 class="modal-title mb-2">Edit post details</h5>
										<div class="form-group" :class="{'has-error': hasErrors.title}">
											<input type="text" class="form-control" v-model="modalInfo.title">
											<span class="float-right mb-1" v-if="modalInfo.title.length != null">{{modalInfo.title.length}}/50</span>
											<span v-if="hasErrors.title" class="help-block">
			                                    <strong>{{errorMessage.title}}</strong>
			                                </span>
										</div>
										<div class="form-group" :class="{'has-error': hasErrors.description}">
											<textarea class="form-control" rows="4" v-model="modalInfo.description"></textarea>
											<span class="float-right mb-1" v-if="modalInfo.description.length != null">{{modalInfo.description.length}}/200</span>
											<span v-if="hasErrors.description" class="help-block">
			                                    <strong>{{errorMessage.description}}</strong>
			                                </span>
										</div>
										<div class="input-group mb-4" :class="{'has-error': hasErrors.category}">
											<div class="input-group-prepend">
												<label class="input-group-text" for="inputGroupSelect">Select a category</label>
											</div>
											<select class="custom-select" id="inputGroupSelect" v-model="modalInfo.category" >
												<option v-for="category in categories">{{category.category}}</option>
											</select>
											<span v-if="hasErrors.category" class="help-block">
			                                    <strong>{{errorMessage.category}}</strong>
			                                </span>
										</div>
										<div :class="{'has-error': hasErrors.status}">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="downloadable" v-model="modalInfo.status">
												<label class="form-check-label" for="inlineRadio1">Downloadable</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="purchasable" v-model="modalInfo.status">
												<label class="form-check-label" for="inlineRadio2">Purchasable</label>
											</div>
										</div>
										<span v-if="hasErrors.status" class="help-block">
		                                    <strong>{{errorMessage.status}}</strong>
		                                </span>
										<div class="modal-footer">
											<div id="updatePost" class="mr-3" :class="{loader: loader}" v-if="text"></div>
											<button class="btn btn-success" @click.prevent="postAction(modalInfo.id, 'update')">Save changes</button>
										</div>
									</form>
									<form v-if="deleteP">
										<div class="text-center">
											<h5 class="mb-3">Are you sure you want to delete this post?</h5>
											<div class="modal-footer">
												<div id="deletePost" class="mr-3" :class="{loader: loader}" v-if="text"></div>
												<button class="btn btn-dark" @click.prevent="postAction(modalInfo.id, 'delete')">Yes, delete</button>
											</div>
										</div>
									</form>
								</div>
							</template>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'profile',
		props: ['id', 'user'],
		data() {
			return {
				categories: [],
				posts: [],
				favouriteList: false,
				headerMessage: 'My works',
				total: 0,
				update: {
					profilepic: null,
					profilepicURL: null,
					name: null,
					tagline: null,
					email: null,
					socials: [
						{social: 'fab fa-facebook', link: null},
						{social: 'fab fa-instagram', link: null},
						{social: 'fas fa-globe-americas', link: null},
						{social: 'fab fa-whatsapp', link: null},
					]
				},
				postData: {
					title: null,
					description: null,
					category: null,
					status: null,
					postphoto: null,
					postphotoURL: null
				},
				hasErrors: {
					title: false,
					description: false,
					category: false,
					status: false,
					postphoto: false
				},
				errorMessage: {
					title: null,
					description: null,
					category: null,
					status: null,
					postphoto: null
				},
				loader: false,
				postLoader: false,
				text: false,
				modalInfo: [],
				edit: false,
				deleteP: false,
				like: false,
				likeMessage: 'Loading...',
				favourite: false,
				favouriteMessage: 'Loading...'
			}
		},
		created() {
			this.fetchCategories();
			this.fetchUser();
			this.fetchPosts();
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
			fetchUser() {
				const _this = this;
				axios.get(`/profile/${_this.id}`)
				.then(res => {
					_this.update.profilepic = res.data.profilepic;
					_this.update.name = res.data.name;
					_this.update.tagline = res.data.tagline;
					_this.update.email = res.data.email;
					res.data.socials.forEach(social => {
						if (social.social == 'fab fa-facebook') {
							_this.update.socials[0].link = social.link;
						} else if (social.social == 'fab fa-instagram') {
							_this.update.socials[1].link = social.link;
						} else if (social.social == 'fas fa-globe-americas') {
							_this.update.socials[2].link = social.link;
						} else if (social.social == 'fab fa-whatsapp') {
							_this.update.socials[3].link = social.link;
						}
					});
				})
				.catch(err => console.log(err));
			},
			fetchPosts(page) {
				const _this = this;
				this.loader = true;
				page = page || `/posts/${this.id}`;
				axios.get(page)
				.then(res => {
					_this.posts = res.data;
					_this.loader = false;
				})
				.catch(err => console.log(err));
			},
			fetchFavourites() {
				this.favouriteList = !this.favouriteList;
				if (this.favouriteList == true) {
					const page = `/posts/favourites/${this.id}`;
					this.headerMessage = 'My favourites';
					this.fetchPosts(page);
				} else {
					this.headerMessage = 'My works';
					this.fetchPosts();
				}
					
			},
			openFile(e) {
				const input = e.target;
				const reader = new FileReader();
				reader.onload = (e) => {
					const dataURL = reader.result;
					const upload = input.id == 'fileUpload' ? '.profilepic' : '#postphoto';
					$(upload).attr('src', dataURL);
					if (upload === '.profilepic') {
						this.update.profilepicURL = dataURL;
					} else {
						this.postData.postphotoURL = dataURL;
					}
				}
				reader.readAsDataURL(input.files[0]);
			},

			//Handles profile update and post create
			profileAction(action) {
				this.text = true;
				action == '#update' ? this.loader = true : this.postLoader = true;
				const _this = this;
				const _hasErrors = this.hasErrors;
				const _errMessage = this.errorMessage;

				for (const key of Object.keys(this.hasErrors)) {
				    this.hasErrors[key] = false;
				}

				for (const key of Object.keys(this.errorMessage)) {
				    this.errorMessage[key] = null;
				}

				const url = action === '#update' ? `/profile/update/${_this.id}` : '/post/create';
				const data = action === '#update' ? _this.update : _this.postData;
				axios.post(url, data)
				.then(res => {
					const message = action === '#update' ? 'Saved!' : 'Created!';
					_this.loader = _this.postLoader = false;
					$(action).text(message);
					setTimeout(() => {
						_this.text = false;
						$(action).text('');
						if (action !== '#update') {
							_this.posts.data.unshift(res.data);
							_this.posts.data.length > 6 ? _this.posts.data.pop() : '';
							$('#postModal').modal('hide');
							for (const key of Object.keys(_this.postData)) {
								_this.postData[key] = '';
							}
							$('#postphoto').removeAttr('src');
						} else {
							$('#editModal').modal('hide');
						}
					}, 2000);
				})
				.catch(err => {
					const errors = err.response.data.errors;
					if (err.response.statusText === 'Unprocessable Entity') {
						if (errors) {
							if (errors.title) {
								_this.text = false;
								_hasErrors.title = true;
		                        _errMessage.title = _.isArray(errors.title) ? errors.title[0] : errors.title; 
							} else if (errors.description) {
								_this.text = false;
								_hasErrors.description = true;
		                        _errMessage.description = _.isArray(errors.description) ? errors.description[0] : errors.description; 
							} else if (errors.category) {
								_this.text = false;
								_hasErrors.category = true;
		                        _errMessage.category = _.isArray(errors.category) ? errors.category[0] : errors.category; 
							} else if (errors.status) {
								_this.text = false;
								_hasErrors.status = true;
								_errMessage.status = _.isArray(errors.status) ? errors.status[0] : errors.status;
							}
						}
					}
					if (err.response.statusText === 'Internal Server Error') {
						if (_this.postData.postphotoURL == null) {
							_this.text = false;
							_hasErrors.postphoto = true;
							_errMessage.postphoto = 'It seems you forgot to add a photo!';
						}
					}
				});
			},
			cancelUpdate(upload) {
				$(upload).attr('src', `http://pickture.me/images/uploads/profilepic/${this.update.profilepic}`);
			},
			modalOpen(id) {
				const _this = this;
				axios.get(`/post/${id}`)
				.then(res => {
					_this.modalInfo = res.data;
					if (_this.user != null) {
						_this.postSocial('isLiked', res.data.id);
						_this.postSocial('isFaved', res.data.id);
					}
				})
				.catch(err => console.log(err));
			},

			//Handles post edit and delete
			postAction(id, params) {
				this.params = false;
				this.text = true;
				this.loader = true;
				const _this = this;
				const _hasErrors = this.hasErrors;
				const _errMessage = this.errorMessage;

				for (const key of Object.keys(this.hasErrors)) {
				    this.hasErrors[key] = false;
				}

				for (const key of Object.keys(this.errorMessage)) {
				    this.errorMessage[key] = null;
				}

				axios.post(`/post/${params}/${id}`, _this.modalInfo)
				.then(res => {
					_this.loader = false;
					if (params == 'update') {
						$('#updatePost').text('Saved!');
					} else {
						$('#deletePost').text('Deleted!');
					}
					setTimeout(() => {
						_this.text = false;
						_this.edit = false;
						_this.deletePost = false;
						$('#photoModal').modal('hide');
						_this.fetchPosts();
					}, 2000);
				})
				.catch(err => {
					const errors = err.response.data.errors;
					if (err.response.statusText === 'Unprocessable Entity') {
						if (errors) {
							if (errors.title) {
								_this.text = false;
								_hasErrors.title = true;
		                        _errMessage.title = _.isArray(errors.title) ? errors.title[0] : errors.title; 
							} else if (errors.description) {
								_this.text = false;
								_hasErrors.description = true;
		                        _errMessage.description = _.isArray(errors.description) ? errors.description[0] : errors.description; 
							} else if (errors.category) {
								_this.text = false;
								_hasErrors.category = true;
		                        _errMessage.category = _.isArray(errors.category) ? errors.category[0] : errors.category; 
							}
						}
					}
				});
			},

			//Handles likes, isLiked, favourites and isFaved
			postSocial(params, id) {
				const _this = this;
				const url = id == null ? axios.get(`/${params}/${_this.modalInfo.id}`) : axios.get(`/${params}/${id}`)
				url
				.then(res => {
					if (res.data == 1) {
						params == 'like' || params == 'isLiked' ? _this.like = true : _this.favourite = true;
						params == 'like' || params == 'isLiked' ? _this.likeMessage = 'Unlike' : _this.favouriteMessage = 'Unfavourite';
					} else {
						params == 'like' || params == 'isLiked' ? _this.like = false : _this.favourite = false;
						params == 'like' || params == 'isLiked' ? _this.likeMessage = 'Like' : _this.favouriteMessage = 'Favourite';
					}
				})
				.catch(err => console.log(err));
			},
			goToLicence() {
				$('#postModal').modal('hide');
				this.$router.push('/licence');
			},
			download(params) {
				axios({
					url: `http://pickture.me/images/uploads/postphoto/${params}`,
					method: 'GET',
					responseType: 'blob'
				}).then(res => {
					const url = window.URL.createObjectURL(new Blob([res.data]));
					const link = document.createElement('a');
					link.href = url;
					link.setAttribute('download', params);
					document.body.appendChild(link);
					link.click();
				});
			}
		}
	}
</script>

<style lang="scss" scoped>
	.profilepic {
		width: 10vw;
		height: 20vh;
		border-radius: 50%;
		object-fit: cover;
	}

	.pointer {
		cursor: pointer;
	}

	.has-error {
		input, textarea, select {
			border: 1px solid red;
		}
	} 

	.help-block {
		color: red;
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

	#postModal, #photoModal {
		width: 80vw !important;
		margin: auto;

		.modal-lg, .modal-dialog {
			max-width: none !important;
		}

		img {
			width: 54vw;
			max-height: 80vh;
			object-fit: contain;
		}
	}

	.card-post {
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

	.card-post:hover{
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

	@media only screen and (max-width: 600px) {
		.profilepic {
			width: 26vw !important;
		}

		.card-post {
			height: 45vh !important;

			img {
				height: 45vh !important;
			}
		}

		#photoModal, #postModal {
			width: 100vw !important;
			margin: auto;

			.modal-lg, .modal-dialog {
				max-width: none !important;
			}

			img {
				width: 100% !important;
				max-height: 80vh;
				object-fit: contain;
			}
		}
	}
</style>