<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="settings#general-settings">
                <div id="general-settings">
                    <h2>Général</h2>
                    <div class="form-group">
                        <label for="azuriom">URL du site Azuriom :</label>
                        <input type="text" class="form-control" id="azuriom" name="azuriom"
                            value="<?php echo $row["azuriom"]; ?>">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Mods :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="mods_enabled"
                            <?php if ($row["mods_enabled"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Vérification des Fichiers :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="file_verification"
                            <?php if ($row["file_verification"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Version Préembarquée de Java :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="embedded_java"
                            <?php if ($row["embedded_java"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Affichage du rôle :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="role"
                            <?php if ($row["role"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="mr-2">Affichage des points :</label>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="money"
                            <?php if ($row["money"] == 1) echo "checked"; ?>>
                        <label class="form-check-label">Activer</label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="game_folder_name">Nom du Dossier du Répertoire du Jeu :</label>
                    <input type="text" class="form-control" id="game_folder_name" name="game_folder_name"
                        value="<?php echo $row["game_folder_name"]; ?>">
                </div>

                <input type="submit" class="btn btn-primary mt-3" name="submit_general_settings" value="Enregistrer">
            </form>
        </div>
    </div>
</div>