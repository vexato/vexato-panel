<div id="ignored-folders-settings" class="mt-5">
                    <h2>Paramètres des Dossiers Ignorés</h2>
                    <form method="post" action="settings#ignored-folders-settings">
                        <div class="form-group">
                            <label for="ignored-folder">Dossiers ignorés (séparés par des virgules) :</label>
                            <input type="text" class="form-control" id="ignored-folder" name="ignored_folder" value="<?php
                                $sql = "SELECT folder_name FROM ignored_folders"; 
                                $stmt = $pdo->query($sql);
                                $folders = array();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $folders[] = $row["folder_name"];
                                }
                                echo implode(', ', $folders);
                            ?>">
                        </div>
                        <input type="submit" class="btn btn-primary mt-3 mt-3" name="submit_ignored_folder_data" value="Enregistrer">
                    </form>
                </div>