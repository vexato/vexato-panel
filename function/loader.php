<div id="loader-settings">
                <h2>Paramètres du Loader et de Minecraft</h2>
                <form method="post" action="settings#loader-settings">
                    <div class="form-group">
                        <label for="minecraft_version">Version de Minecraft :</label>
                        <input type="text" class="form-control" name="minecraft_version"
                            value="<?php echo $row["minecraft_version"]; ?>">
                        <div class="form-group">
                            <label for="loader-type">Type de Loader :</label>
                            <select class="form-control" id="loader-type" name="loader_type">
                                <option value="forge" <?php if ($row["loader_type"] == "forge") echo "selected"; ?>>
                                    Forge</option>
                                <option value="fabric" <?php if ($row["loader_type"] == "fabric") echo "selected"; ?>>
                                    Fabric</option>
                                <option value="legacyfabric"
                                    <?php if ($row["loader_type"] == "legacyfabric") echo "selected"; ?>>LegacyFabric
                                </option>
                                <option value="neoForge"
                                    <?php if ($row["loader_type"] == "neoForge") echo "selected"; ?>>NeoForge</option>
                                <option value="quilt" <?php if ($row["loader_type"] == "quilt") echo "selected"; ?>>
                                    Quilt</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="loader-build-version">Version de Build du loader :</label>
                            <input type="text" class="form-control" id="loader-build-version"
                                name="loader_build_version" value="<?php echo $row["loader_build_version"]; ?>">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="loader-activation"
                                name="loader_activation" <?php if ($row["loader_activation"] == 1) echo "checked"; ?>>
                            <label class="form-check-label" for="loader-activation">Activer</label>
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" name="submit_loader_settings"
                            value="Enregistrer">
                </form>
            </div>