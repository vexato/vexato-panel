<div id="whitelist-settings" class="mt-5">
        <h2>Paramètres de la Whitelist</h2>
        <form method="post" action="settings#whitelist-settings">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="whitelist-activation" name="whitelist_activation"
                    <?php if ($row["whitelist_activation"] == 1) echo "checked"; ?>>
                <label class="form-check-label" for="whitelist-activation">Activer</label>
            </div>
            <div class="form-group">
                <label for="whitelist-users">Noms d'utilisateurs (séparés par des virgules) :</label>
                <input type="text" class="form-control" id="whitelist-users" name="whitelist_users" value="<?php
                $sql = "SELECT users FROM whitelist"; 
                $stmt = $pdo->query($sql);

                $userNames = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $userNames[] = $row["users"];
                }
                echo implode(', ', $userNames);
            ?>">
            </div>
            <input type="submit" class="btn btn-primary mt-3 mt-3" name="submit_whitelist" value="Enregistrer">
        </form>
    </div>