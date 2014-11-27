<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $site_name ?></title>

    <!-- Le styles -->
    <link rel="stylesheet" href="<?php echo $base_url.$assets ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url.$assets ?>css/login.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default" id="formlogin">
                    <div class="panel-heading">
                        <strong>Connexion</strong>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $base_url ?>account/login" method="post" class="form-horizontal" id="login" role="form">
                            <div class="form-group error"><?php echo \system\Session::getFlash(); ?></div>
                            <div class="form-group">
                                <label for="cemail" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="cemail" name="cemail" placeholder="Email / Pseudo" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cpassword" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group last">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-sm">Connecte toi</button>
                                    <button type="reset" class="btn btn-default btn-sm">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        Pas enregistré? <a href="#" id="toregister">Inscris toi</a>
                    </div>
                </div>

                <div class="panel panel-default" id="formregister">
                    <div class="panel-heading">
                        <strong>Inscription</strong>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $base_url ?>account/register" method="post" class="form-horizontal" id="register" role="form">
                            <div class="form-group error"></div>
                            <div class="form-group">
                                <label for="rpseudo" class="col-sm-3 control-label">Pseudo</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rpseudo" name="rpseudo" placeholder="Pseudo" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rnom" class="col-sm-3 control-label">Nom</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rnom" name="rnom" placeholder="Nom" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rprenom" class="col-sm-3 control-label">Prénom</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rprenom" name="rprenom" placeholder="Prénom" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rbirthday" class="col-sm-3 control-label">Anniversaire</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="rbirthday" name="rbirthday" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rville" class="col-sm-3 control-label">Ville</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rville" name="rville" placeholder="Lyon" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rdep" class="col-sm-3 control-label">Département</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rdep" name="rdep" placeholder="Haut-Rhin" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rregion" class="col-sm-3 control-label">Région</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rregion" name="rregion" placeholder="Alsace" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rpays" class="col-sm-3 control-label">Pays</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rpays" name="rpays" placeholder="France" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="remail" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="remail" name="remail" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rsexe1" class="col-sm-3 control-label">Sexe</label>
                                <div class="col-sm-9">
                                    Homme: <input type="radio" id="rsexe1" name="rsexe" value="M" checked>
                                    Femme: <input type="radio" id="rsexe2" name="rsexe" value="F">
                                    Autre: <input type="radio" id="rsexe3" name="rsexe" value="A">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rpassword" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="rpassword" name="rpassword" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rpassword2" class="col-sm-3 control-label">Confirmation</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="rpassword2" name="rpassword2" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group last">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-sm">Inscrit toi</button>
                                    <button type="reset" class="btn btn-default btn-sm">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        Déjà enregistré? <a href="#" id="tologin">Connecte toi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($environment == 'development'): ?>
        <pre>debug:</pre>
        <pre><?php print_r($this); ?></pre>
    <?php endif; ?>

    <div class="hidden" id="base_url"><?php echo $base_url ?></div>
    <!-- Le javascript -->
    <script src="<?php echo $base_url.$assets ?>js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/jquery.velocity.min.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/velocity.ui.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/bootstrap.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/login.js"></script>
</body>
</html>
