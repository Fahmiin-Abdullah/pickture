<template>
	<div class="row">
		<div class="col-md-3">
			<div class="card mb-3">
				<div class="card-body">
					<h4 class="text-center mb-3"><strong>Hi, {{user.name}}</strong><span class="float-right"><a data-toggle="modal" data-target="#editModal"><i class="fas fa-pen"></i></a></span></h4>
					<div class="card-image text-center">
						<img :src="require(`../../img/profile/${user.profilepic}`)" class="profilePic">
					</div>
					<hr>
					<h6 class="text-center py-2"><em>"{{user.tagline}}"</em></h6>
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

		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
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
										<textarea class="form-control" v-model="update.tagline">{{update.tagline}}</textarea>
									</div>
									<a href="#" @click="addSocial()">Add social media links</a>
								</div>
								<div class="col text-center">
									<img :src="require(`../../img/profile/${update.profilepic}`)" class="profilePic mb-3" id="profilepic" v-model="update.profilepic">
									<div class="custom-file">
										<input type="file" name="profilepic" @change="openFile()" class="hidden" id="fileUpload">
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
						<button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-success">Save changes</button>
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
					name: this.user.name,
					tagline: this.user.tagline,
					email: this.user.email,
					social: [
						{social: 'fab fa-facebook-square', link: 'lorem ipsum'},
						{social: 'fab fa-instagram', link: 'lorem tab'},
						{social: 'fab fa-twitter', link: 'lorem posum'},
						{social: 'fas fa-globe-americas', link: 'lorem vidius'}
					]
				}
			}
		},
		methods: {
			openFile(e) {
				const input = e.target;
				console.log(input);
				const reader = new FileReader();
				reader.onload = () => {
					const dataURL = reader.result;
					$('#profilepic').attr('src', dataURL);
				}
				reader.readAsDataURL(input.files[0]);
			},
			addSocial() {

			}
		}
	}
</script>

<style scoped>
	.profilePic {
		width: 10vw;
		height: 20vh;
		border-radius: 50%;
	}

	.fa-pen {
		cursor: pointer;
	}
</style>