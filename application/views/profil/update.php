<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>
				<div class="panel-top container">
						<h1>Profil de <?php echo $user->pseudo ?></h1>
				</div>
		</div>

		<div class="container content">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<form class="form-horizontal" method="POST" role="form" enctype="multipart/form-data">
							<fieldset>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="password">Password</label>
									<div class="col-sm-10">
										<input type="text" placeholder="Password" id="password" name="password" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="ville">Ville</label>
									<div class="col-sm-10">
										<input type="text" placeholder="Saint-Louis" id="ville" name="ville" value="<?php echo $user->ville ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="departement">Département</label>
									<div class="col-sm-10">
										<input type="text" placeholder="Haut-Rhin" id="departement" name="departement" value="<?php echo $user->departement ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="region">Région</label>
									<div class="col-sm-10">
										<input type="text" placeholder="Alsace" id="region" name="region" value="<?php echo $user->region ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="pays">Pays</label>
									<div class="col-sm-10">
										<input type="text" placeholder="France" id="pays" name="pays" value="<?php echo $user->pays ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="nom">Nom</label>
									<div class="col-sm-10">
										<input type="text" placeholder="Villers" id="nom" name="nom" value="<?php echo $user->nom ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="prenom">Prenom</label>
									<div class="col-sm-10">
										<input type="text" placeholder="mickael" id="prenom" name="prenom" value="<?php echo $user->prenom ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="pseudo">Pseudo</label>
									<div class="col-sm-10">
										<input type="text" placeholder="mickael" id="pseudo" name="pseudo" value="<?php echo $user->pseudo ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="email">Email</label>
									<div class="col-sm-10">
										<input type="text" placeholder="mickael" id="email" name="email" value="<?php echo $user->email ?>" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="description">Déscription</label>
									<div class="col-sm-10">
										<textarea class="form-control" id="description" name="description" rows="3"><?php echo $user->description ?></textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="email">Avatar</label>
									<div class="col-sm-10">
										<input type="file" name="avatar" />
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="pull-right">
											<button type="submit" class="btn btn-default">Cancel</button>
											<button type="submit" class="btn btn-primary">Save</button>
										</div>
									</div>
								</div>

							</fieldset>
						</form>
					</div>


				</div>
		</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>