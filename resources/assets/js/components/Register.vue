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
								<button class="btn btn-block btn-success text-white" @click.prevent="register()">Signup</button>
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
								<div class="col" :class="{'has-error': hasLoginErrors}">
									<input type="text" class="form-control" placeholder="Username" v-model="loginData.name" required>
									<span v-if="hasLoginErrors.name" class="help-block">
										<strong>{{errorLoginMessage.name}}</strong>
									</span>
								</div>
								<div class="col" :class="{'has-error': hasLoginErrors}">
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
								<button class="btn btn-block btn-success text-white" @click.prevent="login()">Login</button>
							</div>
						</form>
					</div>
				</div>	
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'register',
		props: ['auth'],
		data() {
			return {
				registerData: {
					name: '',
					email: '',
					password: ''
				},
				loginData: {
					name: '',
					password: '',
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
                }
			}
		},
		methods: {
			register() {
				const _this = this;
				const _hasErrors = this.hasErrors;
				const _errMessage = this.errorMessage;

				axios.post('/register', _this.registerData)
				.then(() => {_this.$router.push('/');})
				.then(() => {location.reload();})
				.catch(err => {
					const errors = err.response;
					if (errors.statusText === 'Unprocessable Entity') {
                        if (errors.data) {
                            if (errors.data.name) {
                               _hasErrors.name = true;
                               _errMessage.name = _.isArray(errors.data.name) ? errors.data.name[0]: errors.data.name;
                            }
                            if (errors.data.email) {
                            	_hasErrors.email = true;
                            	_errMessage.email = _.isArray(errors.data.email) ? errors.data.email[0]: errors.data.email;
                            }
                            if (errors.data.password) {
                            	_hasErrors.password = true;
                            	_errMessage.password = _.isArray(errors.data.password) ? errors.data.password[0]: errors.data.password;
                            }
                        }
                    }
				});
			},
			login() {
				const _this = this;
				const _hasErrors = this.hasLoginErrors;
				const _errMessage = this.errorLoginMessage;

				axios.post('/login', _this.loginData)
				.then(() => {_this.$router.push('/');})
				.then(() => {location.reload();})
				.catch(err => {
					const errors = err.response;
					if (errors.statusText ===  'Unprocessable Entity') {
						if (errors.data) {
							if (errors.data.name) {
								_hasErrors.name = true;
								_errMessage.name = _.isArray(errors.data.name) ? errors.data.name[0] : errors.data.name;
							}
							if (errors.data.password) {
								_hasErrors.password = true;
								_errMessage.password = _.isArray(errors.data.password) ? erros.data.password[0] : errors.data.password;
							}
						}
					}
				});
			}
		}
	}
</script>

<style scoped>
	
</style>