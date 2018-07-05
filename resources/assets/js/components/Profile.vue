<template>
	<div class="row">
		<div class="col-md-3">
			<div class="card mb-3">
				<div class="card-body">
					<h4 class="text-center mb-3"><strong>Hi, {{update.name}}</strong><span class="float-right"><a data-toggle="modal" data-target="#editModal"><i class="fas fa-pen"></i></a></span></h4>
					<div class="card-image text-center">
						<img :src="`http://pickture.me/images/uploads/profilepic/${update.profilepic}`" v-model="update.profilepic" class="profilepic">
					</div>
					<hr>
					<h6 class="text-center py-2"><em>"{{update.tagline}}"</em></h6>
				</div>
			</div>
			<h6 class="text-center">Catch me on social media</h6>
			<ul class="list-group">
				<li class="list-group-item" v-for="social in update.social">
					<div class="row">
						<div class="col-md-2">
							<i :class="social.social"></i>
						</div>
						<div class="col-md-10">
							<a href="#">{{social.link}}</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="col-md-9">
			<div class="mb-5">
				<h2 class="float-left">My work (257)</h2>
				<a class="btn btn-success float-right text-white" data-toggle="modal" data-target="#addModal">Add new photo</a>
			</div>
			<hr>
		</div>



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
								<div class="col mt-3 mb-2">
									<div class="form-group">
										<input type="text" class="form-control" v-model="update.name">
									</div>
									<div class="form-group">
										<input type="email" class="form-control" v-model="update.email">
									</div>
									<div class="form-group">
										<textarea class="form-control" v-model="update.tagline"></textarea>
									</div>
									<a href="#" @click="addSocial()">Add social media links</a>
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
							<div class="input-group mb-2" v-for="social in update.social">
								<div class="input-group-prepend">
									<div class="input-group-text"><i :class="social.social"></i></div>
								</div>
								<input type="text" class="form-control" :value="social.link">
							</div>
							<div id="social"></div>
						</form>
					</div>
					<div class="modal-footer">
						<div id="update" class="loader mr-3 hidden"></div>
						<button class="btn btn-dark" data-dismiss="modal" @click.prevent="cancelUpdate('.profilepic')">Cancel</button>
						<button class="btn btn-success" @click.prevent="updateProfile(user.id)">Save changes</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="row">
						<div class="col-md-8">
							<img id="postphoto" v-model="postData.postphoto">
						</div>
						<div class="col-md-4">
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
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Title" v-model="postData.title">
									</div>
									<div class="form-group">
										<textarea class="form-control" placeholder="Tell the world what's on your mind" v-model="postData.description"></textarea>
									</div>
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<label class="input-group-text" for="inputGroupSelect">Select a category</label>
										</div>
										<select class="custom-select" id="inputGroupSelect" v-model="postData.category">
											<option v-for="category in categories" :key="category.id">{{category}}</option>
										</select>
									</div>
									<p><em>Please ensure that all your works have been properly watermarked before submitting it online.</em></p>
								</form>
								<div class="text-center">
									<div id="post" class="loader hidden"></div>
									<button class="btn btn-block btn-success white-text" @click.prevent="createPost()">Create</button>
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
		name: 'profile',
		props: ['user'],
		data() {
			return {
				update: {
					profilepic: this.user.profilepic,
					profilepicURL: '',
					name: this.user.name,
					tagline: this.user.tagline,
					email: this.user.email,
					social: [
						{social: 'fab fa-facebook-square', link: 'lorem ipsum'},
						{social: 'fab fa-instagram', link: 'lorem tab'},
						{social: 'fab fa-twitter', link: 'lorem posum'},
						{social: 'fas fa-globe-americas', link: 'lorem vidius'}
					]
				},
				categories: [
					'Foodtography',
					'Travel and leisure',
					'Our heritage',
					'#OOTD',
					'Wedding',
					'Graphics and illustration'
				],
				postData: {
					postphoto: '',
					title: '',
					description: '',
					category: ''
				}
			}
		},
		methods: {
			openFile(e) {
				const input = e.target;
				const reader = new FileReader();
				reader.onload = (e) => {
					const dataURL = reader.result;
					const upload = input.id == 'fileUpload' ? '.profilepic' : '#postphoto';
					$(upload).attr('src', dataURL);
					this.update.profilepicURL = dataURL;
				}
				reader.readAsDataURL(input.files[0]);
			},
			addSocial() {

			},
			updateProfile(id) {
				$('#update').removeClass('hidden');
				const _this = this;
				axios.post(`/profile/update/${id}`, _this.update)
				.then(res => {
					
					$('#update').removeClass('loader').text('Saved!');
					setTimeout(() => {
						$('#update').addClass('loader hidden').text('');
					}, 2000);
				})
				.catch(err => {
					console.log(err);
				});
			},
			cancelUpdate(upload) {
				$(upload).attr('src', `http://pickture.me/images/uploads/profilepic/${this.update.profilepic}`);
			}
		}
	}
</script>

<style lang="scss" scoped>
	.profilepic {
		width: 10vw;
		height: 20vh;
		border-radius: 50%;
	}

	.fa-pen {
		cursor: pointer;
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

	#addModal {
		width: 80vw !important;
		margin: auto;

		.modal-lg, .modal-dialog {
			max-width: none !important;
		}

		img {
			width: 54vw;
			object-fit: contain;
		}
	}
</style>