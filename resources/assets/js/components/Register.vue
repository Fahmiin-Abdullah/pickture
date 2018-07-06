<template>
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title text-center mb-3">Don't have an account yet? Sign up now!</h5>
						<form>
							<div class="form-group" :class="{'has-error': hasErrors.name}">
								<label for="name">Username</label>
		     					<input type="text" class="form-control" v-model="registerData.name" required>
		     					<span v-if="hasErrors.name" class="help-block">
                                    <strong>{{errorMessage.name}}</strong>
                                </span>
							</div>
							<div class="form-group" :class="{'has-error': hasErrors.email}">
								<label for="email">Email</label>
		     					<input type="email" class="form-control" v-model="registerData.email" required>
		     					<span v-if="hasErrors.email" class="help-block">
                                    <strong>{{errorMessage.email}}</strong>
                                </span>
							</div>
							<div class="form-group mb-4" :class="{'has-error': hasErrors.password}">
								<label for="password">Password</label>
								<input type="password" class="form-control" v-model="registerData.password" required>
								<span v-if="hasErrors.password" class="help-block">
                                    <strong>{{errorMessage.password}}</strong>
                                </span>
							</div>
							<div class="form-group text-center">
								<button class="btn btn-block btn-success text-white" @click.prevent="register('/register')">Signup</button>
							</div>
						</form>
					</div>
				</div>	
			</div>
			<div class="col-md-7">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title text-center mb-3">Already have an account? Just login!</h5>
						<form>
							<div class="form-row mb-2">
								<div class="col" :class="{'has-error': hasLoginErrors.name}">
									<input type="text" class="form-control" placeholder="Username" v-model="loginData.name" required>
									<span v-if="hasLoginErrors.name" class="help-block">
										<strong>{{errorLoginMessage.name}}</strong>
									</span>
								</div>
								<div class="col" :class="{'has-error': hasLoginErrors.password}">
									<input type="password" class="form-control" placeholder="Password" v-model="loginData.password" required>
									<span v-if="hasLoginErrors.password" class="help-block">
										<strong>{{errorLoginMessage.password}}</strong>
									</span>
								</div>
							</div>
							<div class="form-check mb-4">
								<input class="form-check-input float-left" type="checkbox" id="rememberMe" v-model="loginData.remember">
								<label class="form-check-label" for="rememberMe">Remember me</label>
								<a href="#" class="float-right">I forgot my password</a>
							</div>
							<div class="form-group text-center">
								<button class="btn btn-block btn-success text-white" @click.prevent="register('/login')">Login</button>
							</div>
						</form>
					</div>
				</div>
				<div :class="{loader: loader}"></div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'register',
		data() {
			return {
				registerData: {
					name: null,
					email: null,
					password: null
				},
				loginData: {
					name: null,
					password: null,
					remember: true
				},
				hasErrors:{
                    name:false,
                    email:false,
                    password:false
                },
                errorMessage:{
                    name:null,
                    email:null,
                    password:null
                },
                hasLoginErrors: {
                	name: false,
                	password: false
                },
                errorLoginMessage: {
                	name: null,
                	password: null
                },
                loader: false
			}
		},
		methods: {
			register(url) {
				const _this = this;
				this.loader = true;
				let _hasErrors = this.hasErrors;
				let _errMessage = this.errorMessage;
				let _hasLoginErrors = this.hasLoginErrors;
				let _errLoginMessage = this.errorLoginMessage;

				for (const key of Object.keys(this.hasErrors)) {
				    this.hasErrors[key] = false;
				}

				for (const key of Object.keys(this.errorMessage)) {
				    this.errorMessage[key] = null;
				}

				for (const key of Object.keys(this.hasLoginErrors)) {
				    this.hasLoginErrors[key] = false;
				}

				for (const key of Object.keys(this.errorLoginMessage)) {
				    this.errorLoginMessage[key] = null;
				}

				const data = url === '/register' ? _this.registerData : _this.loginData;

				axios.post(url, data)
				.then(() => {location.reload();})
				.catch(err => {
					const errors = err.response.data.errors;
					if (err.response.statusText === 'Unprocessable Entity') {
                        if (errors) {
                        	if (url === '/register') {
                        		if (errors.name) {
	                            	_this.loader = false;
	                               _hasErrors.name = true;
	                               _errMessage.name = _.isArray(errors.name) ? errors.name[0] : errors.name;  
	                            } else if (errors.email) {
	                            	_this.loader = false;
	                            	_hasErrors.email = true;
	                            	_errMessage.email = _.isArray(errors.email) ? errors.email[0] : errors.email;
	                            } else if (errors.password) {
	                            	_this.loader = false;
	                            	_hasErrors.password = true;
	                            	_errMessage.password = _.isArray(errors.password) ? errors.password[0] : errors.password;
	                            }
                        	} else if (url === '/login') {
                        		if (errors.name) {
	                            	_this.loader = false;
	                               _hasLoginErrors.name = true;
	                               _errLoginMessage.name = _.isArray(errors.name) ? errors.name[0] : errors.name;  
	                            } else if (errors.password) {
	                            	_this.loader = false;
	                            	_hasLoginErrors.password = true;
	                            	_errLoginMessage.password = _.isArray(errors.password) ? errors.password[0] : errors.password;
	                            }
                        	}
                        }
                    }
				});
			}
		}
	}
</script>

<style scoped>
	.has-error input {
		border: 1px solid red;
	}

	.help-block {
		color: red;
	}

	.loader {
		position: absolute;
		left: 50%;
		top: 50%;
		z-index: 1;
		width: 150px;
		height: 150px;
		margin: 90px 0 0 -75px;
		border: 16px solid #f9f9f9;
		border-radius: 50%;
		border-top: 16px solid #28a745;
		border-bottom: 16px solid #28a745;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite;
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