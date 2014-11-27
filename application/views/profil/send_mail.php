<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>
                <div class="panel-top container">
                        <h1>Envoyer un Mail</h1>
                </div>
        </div>

        <div class="container content">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form class="form-horizontal" method="POST" role="form" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="description">Message</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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