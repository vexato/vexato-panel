<div id="rpc-settings" class="mt-5">
                <h2>Paramètres du RPC</h2>
                <form method="post" action="settings#rpc-settings">
                    <?php
        $rpcFields = array(
            "rpc_id" => "ID Client pour le RPC",
            "rpc_details" => "Message de détails",
            "rpc_state" => "Message de l'état",
            "rpc_large_text" => "Message pour la grande image",
            "rpc_small_text" => "Message pour la petite image",
            "rpc_button1" => "Nom du 1er bouton",
            "rpc_button1_url" => "URL du 1er bouton",
            "rpc_button2" => "Nom du 2ème bouton",
            "rpc_button2_url" => "URL du 2ème bouton",
        );

        foreach ($rpcFields as $fieldName => $fieldLabel) {
            ?>
                    <div class="form-group">
                        <label for="<?php echo $fieldName; ?>"><?php echo $fieldLabel; ?>:</label>
                        <input type="text" class="form-control" id="<?php echo $fieldName; ?>"
                            name="<?php echo $fieldName; ?>" value="<?php echo $row[$fieldName]; ?>">
                    </div>
                    <?php
        }
        ?>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="rpc-activation" name="rpc_activation"
                            <?php if ($row["rpc_activation"] == 1) echo "checked"; ?>>
                        <label class="form-check-label" for="rpc-activation">Activer</label>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" name="submit_rpc_settings" value="Enregistrer">
                </form>
            </div>