<div id="changelog-settings" class="mt-5">
                <h2>Paramètres du Changelog</h2>
                <form method="post" action="settings#changelog-settings">
                    <div class="form-group">
                        <label for="changelog-version">Numéro de Mise à Jour du Changelog :</label>
                        <input type="text" class="form-control" id="changelog-version" name="changelog_version"
                            value="<?php echo $row["changelog_version"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="changelog-message">Message du Changelog :</label>
                        <textarea class="form-control" id="changelog-message" name="changelog_message" rows="4"
                            cols="50"><?php echo str_replace('<br>', "\n", $row["changelog_message"]); ?></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" name="submit_changelog" value="Enregistrer">
                </form>
            </div>