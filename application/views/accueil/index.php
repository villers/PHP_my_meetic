<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>

		<div class="header-content container">
			<div class="left" id="desc">
				<h2>Ecris ton histoire d'amour.</h2>
				<p>Décris ton histoire d'amour parfaite que tu aimerais vivre.</p>
				<a href="<?php echo $base_url ?>profil/get/<?php echo $_SESSION['user_id']?>" class="btn btn-primary">Mon profil</a>
			</div>
			<div class="right" id="img"></div>
		</div>

		<div class="panel-top container">
			<h1>Rencontres</h1>
		</div>
	</div>

	<div class="container content">
		<div class="row">
			<div class="col-md-9">
				<ul class="thumbnails list-unstyled">
					<?php foreach($users as $user): ?>
					<li class="col-md-4 seachlist">
						<div class="thumbnail">
							<div>
								<img alt="300x200" height="200" src="<?php echo system\helper\Input::getAvatar($base_url.$assets.'upload/', $user->user_id) ?>">
							</div>
							<a href="<?php echo $base_url ?>profil/get/<?php echo $user->user_id ?>">
								<div class="caption">
									<h2><?php echo $user->nom.' '.$user->prenom; ?></h2>
									<p class="ville"><?php echo $user->ville ?></p>
									<p class="region"><?php echo $user->region ?></p>
									<p class="departement"><?php echo $user->departement ?></p>
									<p class="pays"><?php echo $user->pays ?></p>
									<p class="age"><?php echo system\helper\input::getAge($user->anniversaire) ?></p>
									<p class="sexe"><?php echo $user->sexe ?></p>
								</div>
							</a>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="col-md-3">
				<div class="search">
					<h2>Recherche</h2>
					<form class="form-horizontal" role="form" id="search">
						<div class="form-group">
							<label for="ssexe" class="col-sm-3 control-label">Cherche</label>
							<div class="col-sm-9">
								<select name="ssexe" class="form-control" id="ssexe">
									<option value="T">Tous</option>
									<option value="M">Un homme</option>
									<option value="F">Une femme</option>
									<option value="A">Autre</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="age" class="col-sm-3 control-label">age</label>
							<div class="col-sm-4">
								<input type="number" class="form-control" id="age" name="sagebegin" value="18" min="18">
							</div>
							<div class="col-sm-4">
								<input type="number" class="form-control" id="age2" name="sageend" value="25" min="18">
							</div>
						</div>

						<div class="form-group">
							<label for="pays" class="col-sm-3 control-label">Pays</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="pays" name="spays" placeholder="France">
							</div>
						</div>

						<div class="form-group">
							<label for="region" class="col-sm-3 control-label">Région</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="region" name="sregion" placeholder="Alsace">
							</div>
						</div>

						<div class="form-group">
							<label for="departement" class="col-sm-3 control-label">Département</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="departement" name="sdepartement" placeholder="Haut-Rhin">
							</div>
						</div>

						<div class="form-group">
							<label for="ville" class="col-sm-3 control-label">Ville</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="ville" name="sville" placeholder="Saint-louis">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" id="submit" class="btn btn-info">Rechercher</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>