<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="settings#splash-settings">
                <div id="splash-settings">
                    <h2>Paramètres du Splash</h2>
                    <div class="form-group">
                        <label for="splash">Message Splash :</label>
                        <input type="text" class="form-control" id="splash" name="splash"
                            value="<?php echo $row["splash"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="splash_author">Auteur du Splash :</label>
                        <input type="text" class="form-control" id="splash_author" name="splash_author"
                            value="<?php echo $row["splash_author"]; ?>">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-3" name="submit_splash_info" value="Enregistrer">
            </form>
        </div>
    </div>
</div>