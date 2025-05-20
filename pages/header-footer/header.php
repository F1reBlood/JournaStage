<header>
    <div class="content header-content">
        <div class="navlogo-container">
            <a href="accueil.php" class="navlogo">
            <img src="../assets/img/logo.png" alt="logo" />
            <span>JournaStage</span>
            </a>
            <p>|</p>

            <?php
            if ($_SESSION['type'] == 1){
            ?>
            <p>Espace étudiant</p>
            <?php
            }
            elseif($_SESSION['type'] == 2){
            ?>
            <p>Espace professeur</p>
            <?php
            }
            ?>

        </div>
        <nav>
            <a href="informations.php" class="navlink">Mes informations</a>
            <form action="../index.php" id="none" method="post" class="inlineform">
            <a><button type="submit" class="navlink" name="deconnexion" id="buttonNavNone">Déconnexion</button></a>
            </form>
        </nav>
    </div>
</header>