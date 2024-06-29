<div id="roles-settings" class="mt-5">
                    <h2>Paramètres des Rôles</h2>
                    <form method="post" action="settings#roles-settings">
                        <?php
                        $sql = "SELECT * FROM roles";
                        $stmt = $pdo->query($sql);

                        $roleData = array();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $roleData[$row['id']] = $row;
                        }
                        for ($i = 1; $i <= 8; $i++) {
                            $roleName = "";
                            $backgroundUrl = "";
                            if (isset($roleData[$i])) {
                                $roleName = $roleData[$i]['role_name'];
                                $backgroundUrl = $roleData[$i]['role_background'];
                            }

                            echo '<div class="form-group">';
                            echo '<label for="role' . $i . '_name">Nom du rôle ' . $i . ':</label>';
                            echo '<input type="text" class="form-control" id="role' . $i . '_name" name="role' . $i . '_name" value="' . $roleName . '">';

                            echo '<label for="role' . $i . '_background">URL de l\'image de fond du rôle ' . $i . ':</label>';
                            echo '<input type="text" class="form-control" id="role' . $i . '_background" name="role' . $i . '_background" value="' . $backgroundUrl . '">';
                            echo '</div>';
                        }
                        ?>
                        <input type="submit" class="btn btn-primary mt-3" name="submit_roles_settings" value="Enregistrer">
                    </form>
                </div>