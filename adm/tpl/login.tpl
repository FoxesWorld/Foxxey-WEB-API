		<div class="section-authentication-login d-flex align-items-center justify-content-center">
			<div id="authBox" class="row animate__animated">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card radius-15">
						<div class="row no-gutters">
							<div class="col-lg-6">
								<div class="card-body p-md-5">
									<div class="text-center">
										<img src="assets/images/logo-icon.png" width="80" alt="">
										<h3 class="mt-4 font-weight-bold">Foxxey Adminpanel</h3>
									</div>

									<div class="login-separater text-center"> <span>LOGIN WITH ADMIN CREDENCIALS</span>
										<hr/>
									</div>
									<div class="form-group mt-4">
										<label>Email Address</label>
										<input type="text" class="form-control" id="login" placeholder="Enter your login" />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="password" placeholder="Enter your password" />
									</div>
									<input type="hidden" id="action" value="logIn" />
									<div class="form-row">
										<div class="form-group col">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="rememberMe" checked>
												<label class="custom-control-label" for="rememberMe">Remember Me</label>
											</div>
										</div>

									</div>
									<div class="btn-group mt-3 w-100">
										<button type="button" onclick="login($(this)); return false;" class="animate__animated btn btn-light btn-block">Log In <i class="lni lni-arrow-right float-right"></i></button>
									</div>
									<hr>

								</div>
							</div>
							<div class="col-lg-6 d-none d-xl-block">
								<img src="assets/images/login-images/login-frent-img.jpg" class="card-img login-img h-100" alt="AidenFox">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>