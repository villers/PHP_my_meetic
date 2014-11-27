<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>
		<div class="panel-top container">
			<h1>Profil de <?php echo $user->pseudo ?></h1>
		</div>
	</div>

	<div class="container content">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $user->nom.' '.$user->prenom; ?></h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3 col-lg-3 ">
								<img alt="User Pic" src="<?php echo system\helper\Input::getAvatar($base_url.$assets.'upload/', $id_prifile) ?>" class="img-circle">
							</div>

							<div class=" col-md-9 col-lg-9 ">
								<table class="table table-user-information">
									<tbody>
											<tr>
												<td>Description</td>
												<td><?php echo $user->description ?></td>
											</tr>
											<tr>
												<td>Ville:</td>
												<td><?php echo $user->ville ?></td>
											</tr>
											<tr>
												<td>Région:</td>
												<td><?php echo $user->region ?></td>
											</tr>
											<tr>
												<td>Département:</td>
												<td><?php echo $user->departement ?></td>
											</tr>
											<tr>
												<td>Pays:</td>
												<td><?php echo $user->pays ?></td>
											</tr>
										<tr>
											<td>Age:</td>
											<td><?php echo system\helper\input::getAge($user->anniversaire) ?> ans</td>
										</tr>
										<tr>
											<td>Genre</td>
											<td><?php echo $user->sexe == 'M' ? 'Homme' : 'Femme' ?></td>
										</tr>
										<tr>
											<td>Email</td>
											<td><a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a href="<?php echo $base_url ?>profil/send_mail/<?php echo $user->user_id ?>" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
						<?php if($member->user_id == $user->user_id): ?>
							<span class="pull-right">
								<a href="<?php echo $base_url ?>profil/update/<?php echo $user->user_id ?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="<?php echo $base_url ?>profil/delete/<?php echo $user->user_id ?>" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
							</span>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>

		<?php if($member->user_id == $user->user_id): ?>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Messages reçus</h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed table-hover">
						<thead>
							<tr>
								<th class="span2">Expediteur</th>
								<th class="span9">Message</th>
								<th class="span2">Date</th>
								<th class="span2">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($messages_received as $message):?>
							<tr>
								<td><?php echo ($message->state) ? $message->pseudo : "<strong>".$message->pseudo."</strong>"; ?></td>
								<td><?php echo ($message->state) ? $message->body : "<strong>".$message->body."</strong>"; ?></td>
								<td><?php echo ($message->state) ? $message->created : "<strong>".$message->created."</strong>"; ?></td>
								<td>
									<a href="<?php echo $base_url ?>profil/send_mail/<?php echo $message->from_user_id ?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-transfer"></i></a>
									<a href="<?php echo $base_url ?>profil/delete_mail/<?php echo $user->user_id.'/'.$message->messages_id ?>" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Messages envoyés</h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed table-hover">
						<thead>
							<tr>
								<th class="span2">Expediteur</th>
								<th class="span9">Message</th>
								<th class="span2">Date</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($messages_send as $message):?>
							<tr>
								<td><?php echo $message->pseudo; ?></td>
								<td><?php echo $message->body; ?></td>
								<td><?php echo $message->created ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php endif; ?>
	</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>