<?php

require_once("bootstrap.inc.php");
require_once("include_pouet/box-modalmessage.php");
require_once("include_pouet/box-board-submit.php");

if ($currentUser && !$currentUser->CanSubmitItems()) {
    redirect("index.php");
    exit();
}

$TITLE = "submit a board";

$form = new PouetFormProcessor();

$form->SetSuccessURL("boards.php?which={%NEWID%}", true);

$form->Add("board", new PouetBoxSubmitBoard());

if ($currentUser && $currentUser->CanSubmitItems()) {
    $form->Process();
}

require_once("include_pouet/header.php");
require("include_pouet/menu.inc.php");

echo "<div id='content'>\n";

if (get_login_id()) {
    $form->Display();
    /*
    ?>
    <script>
    document.observe("dom:loaded",function(){
      NameWarning({"ajaxURL":"./ajax_parties.php","linkURL":"party.php?which="});
    });
    </script>
    <?php
    */
} else {
    require_once("include_pouet/box-login.php");
    $box = new PouetBoxLogin();
    $box->Render();
}

echo "</div>\n";

require("include_pouet/menu.inc.php");
require_once("include_pouet/footer.php");
