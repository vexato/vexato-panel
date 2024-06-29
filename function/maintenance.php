<div id="maintenance-settings" class="mt-5">
                <h2>Paramètres de Maintenance</h2>
                <form method="post" action="settings#maintenance-settings">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="maintenance" name="maintenance"
                            <?php if ($row["maintenance"] == 1) echo "checked"; ?>>
                        <label class="form-check-label" for="maintenance">Maintenance</label>
                    </div>
                    <div class="form-group">
                        <label for="maintenance_message">Message de Maintenance :</label>
                        <input type="text" class="form-control" id="maintenance_message" name="maintenance_message"
                            value="<?php echo $row["maintenance_message"]; ?>">
                    </div>
            </div>
            <input type="submit" class="btn btn-primary mt-3 mt-3" name="submit_maintenance" value="Enregistrer">
            </form>
        </div>