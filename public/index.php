<?php
    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/config/config.php');

    /**
     * Partials
     */
    include($partials_directory.'head.php');
    include($partials_directory.'content.php');
    include($partials_directory.'foot.php');
?>