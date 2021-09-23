					<div class="user-profile-page">
						<div class="card radius-15">
							<div class="card-body">
								<div class="row">
									<div class="col-12 col-lg-7 border-right">
										<div class="d-md-flex align-items-center">
											<div class="mb-md-0 mb-3">
												<img src="<?=$_SESSION['foto']?>" class="rounded-circle shadow" width="130" height="130" alt="<?=$_SESSION['fullname']?>">
											</div>
											<div class="ml-md-4 flex-grow-1">
												<div class="d-flex align-items-center mb-1">
													<h4 class="mb-0"><?=$_SESSION['fullname']?></h4>
													<p class="mb-0 ml-auto"></p>
												</div>
												<p class="mb-0"><?=$_SESSION['info']?></p>
												<p>Registered: <?=admFunctions::unixToReal($_SESSION['reg_date'])?></p>
												
											<!--	<button type="button" class="btn btn-light">Connect</button>
												<button type="button" class="btn btn-light ml-2">Resume</button> -->
											</div>
										</div>
									</div>
									<div class="col-12 col-lg-5">
										<table class="table table-sm table-borderless mt-md-0 mt-3">
											<tbody>
												<tr>
													<th>Two Factor (Alpha):</th>
													<td><span class="badge badge-light">NonAvialable</span>
													</td>
												</tr>
												<tr>
													<th>Age:</th>
													<td>21</td>
												</tr>
												<tr>
													<th>Location:</th>
													<td><?=$_SESSION['land'] ?></td>
												</tr>
												<tr>
													<th>Last login:</th>
													<td><?=admFunctions::unixToReal($_SESSION['lastdate'])?></td>
												</tr>
											</tbody>
										</table>
										<div class="mb-3 mb-lg-0"> <a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-github'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-twitter'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-facebook'></i></a>
											<a href="javascript:;" class="btn btn-sm btn-link"><i class='bx bxl-stack-overflow'></i></a>
										</div>
									</div>
								</div>
								<!--end row
								<ul class="nav nav-pills">
									<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Experience"><span class="p-tab-name">Experience</span><i class='bx bx-donate-blood font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Biography"><span class="p-tab-name">Biography</span><i class='bx bxs-user-rectangle font-24 d-sm-none'></i></a>
									</li>
									<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Edit-Profile"><span class="p-tab-name">Edit Profile</span><i class='bx bx-message-edit font-24 d-sm-none'></i></a>
									</li>
								</ul>-->
							</div>
						</div>
					</div>