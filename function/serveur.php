<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="settings#server-info-settings">
                <div id="server-info-settings">
                    <h2>Paramètres du Serveur</h2>
                    <div class="form-group">
                        <label for="server_name">Nom du Serveur :</label>
                        <input type="text" class="form-control" id="server_name" name="server_name"
                            value="<?php echo $row["server_name"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="server_ip">IP du Serveur :</label>
                        <input type="text" class="form-control" id="server_ip" name="server_ip"
                            value="<?php echo $row["server_ip"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="server_port">Port du Serveur :</label>
                        <input type="text" class="form-control" id="server_port" name="server_port"
                            value="<?php echo $row["server_port"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="server_img">Image du statut de serveur:</label>
                        <input type="text" class="form-control" id="server_img" name="server_img"
                            value="<?php echo $row["server_img"]; ?>">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-3" name="submit_server_info" value="Enregistrer">
            </form>
        </div>
    </div>
</div>