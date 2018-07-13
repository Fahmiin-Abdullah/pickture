<template>
	<div class="container">
		<div class="row">
			<!--Signup section-->
			<div class="col-md-5">
				<div class="card">
					<div class="card-body pb-5">
						<h5 class="card-title text-center mb-3">Don't have an account yet? Sign up now!</h5>
						<form>
							<input type="hidden" name="_token" :value="csrf">
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
							<div :class="{loader: loaderSignup}"></div>
						</form>
					</div>
				</div>	
			</div>

			<!--Login section-->
			<div class="col-md-7">
				<div class="card mb-4">
					<div class="card-body pb-5">
						<h5 class="card-title text-center mb-3">Already have an account? Just login!</h5>
						<form>
							<input type="hidden" name="_token" :value="csrf">
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
								<a href="#" class="float-right" @click.prevent="showPasswordResetForm = !showPasswordResetForm">I forgot my password</a>
							</div>
							<div class="form-group text-center">
								<button class="btn btn-block btn-success text-white" @click.prevent="register('/login')">Login</button>
							</div>
							<div :class="{loader: loaderLogin}"></div>
						</form>
					</div>
				</div>

				<!--Reset password section-->
				<div class="card" v-if="showPasswordResetForm">
					<div class="card-body pb-5">
						<form>
							<input type="hidden" name="_token" :value="csrf">
							<div class="form-group mb-4" :class="{'has-error': hasResetErrors}">
								<label for="email">Email</label>
		     					<input type="email" class="form-control" v-model="passwordResetEmail.email" required>
		     					<span v-if="hasResetErrors" class="help-block">
										<strong>{{errorResetMessage}}</strong>
									</span>
							</div>
							<div class="form-group">
								<button class="btn btn-success btn-block text-white" @click.prevent="resetEmail()">Send reset mail</button>
							</div>
						</form>
						<div :class="{loader: loaderReset}"></div>
						<div class="text-center">{{emailSentMessage}}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'register',
		data() {
			return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                hasResetErrors: false,
                errorResetMessage: null,
                loaderSignup: false,
                loaderLogin: false,
                loaderReset: false,
                showPasswordResetForm: false,
                passwordResetEmail: {email: null},
                emailSentMessage: null
			}
		},
		methods: {
			register(url) {
				const _this = this;
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
				url === '/register' ? this.loaderSignup = true : this.loaderLogin = true;

				axios.post(url, data)
				.then(() => {
					_this.$router.push('/');
					location.reload();
				})
				.catch(err => {
					const errors = err.response.data.errors;
					if (err.response.statusText === 'Unprocessable Entity') {
                        if (errors) {
                        	if (url === '/register') {
                        		if (errors.name) {
	                            	_this.loaderSignup = false;
	                               _hasErrors.name = true;
	                               _errMessage.name = _.isArray(errors.name) ? errors.name[0] : errors.name;  
	                            } else if (errors.email) {
	                            	_this.loaderSignup = false;
	                            	_hasErrors.email = true;
	                            	_errMessage.email = _.isArray(errors.email) ? errors.email[0] : errors.email;
	                            } else if (errors.password) {
	                            	_this.loaderSignup = false;
	                            	_hasErrors.password = true;
	                            	_errMessage.password = _.isArray(errors.password) ? errors.password[0] : errors.password;
	                            }
                        	} else if (url === '/login') {
                        		if (errors.name) {
	                            	_this.loaderLogin = false;
	                               _hasLoginErrors.name = true;
	                               _errLoginMessage.name = _.isArray(errors.name) ? errors.name[0] : errors.name;  
	                            } else if (errors.password) {
	                            	_this.loaderLogin = false;
	                            	_hasLoginErrors.password = true;
	                            	_errLoginMessage.password = _.isArray(errors.password) ? errors.password[0] : errors.password;
	                            }
                        	}
                        }
                    }
				});
			},
			resetEmail() {
				const _this = this;
				this.loaderReset = true;
				this.hasResetErrors = false;
				this.errorResetMessage = null;
				axios.post('/password/email', _this.passwordResetEmail)
				.then(res => {
					_this.loaderReset = false;
					_this.passwordResetEmail.email = null;
					_this.emailSentMessage = 'Success! Please check your email';
				})
				.catch(err => {
					const errors = err.response.data.errors;
					if (err.response.statusText === 'Unprocessable Entity') {
                        if (errors) {
                        	_this.loaderReset = false;
                        	_this.hasResetErrors = true;
	                        _this.errorResetMessage = _.isArray(errors.email) ? errors.email[0] : errors.email;
                        }
                    }
				});
			}
		}
	}
</script>

<style lang="scss" scoped>
	.has-error{
		input {
			border: 1px solid red;
		}
	}

	.help-block {
		color: red;
	}

	.loader {
		position: absolute;
		left: 47%;
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