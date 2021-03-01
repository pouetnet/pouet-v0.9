<?php
require_once("bootstrap.inc.php");

class PouetBoxAwards extends PouetBox {
  function __construct() {
    parent::__construct();
    $this->uniqueID = "pouetbox_awards";
    $this->title = "awards";
  }

  function LoadFromDB()
  {
    $s = new BM_Query("awards");
    $s->AddField("awards.awardType");
    $s->AddField("awards.categoryID");
    $s->attach(array("awards"=>"prodID"),array("prods as prod"=>"id"));
    $s->AddOrder("date_format(awards_prod.releaseDate,'%Y') DESC");
    $s->AddOrder("awards.categoryID");
    $s->AddOrder("awards.awardType");
    $this->prods = $s->perform();

    $a = array();
    foreach($this->prods as $v) $a[] = &$v->prod;
    PouetCollectPlatforms($a);
  }

  function RenderBody()
  {
    global $AWARDS_CATEGORIES;
    
    echo "\n\n";
    echo "<table class='boxtable'>\n";
    $lastYear = 0;
    $lastCategory = "";
    foreach ($this->prods as $row)
    {
      $year = substr($row->prod->releaseDate,0,4);
      if ($lastYear != $year)
      {
        $lastYear = $year;
        printf("<tr><th colspan='3' class='year'>%d</th></tr>\n",$lastYear);
      }
      $category = $AWARDS_CATEGORIES[$row->categoryID];
      if ($lastCategory != $row->categoryID)
      {
        $lastCategory = $row->categoryID;
        printf("<tr id='%s'><th colspan='3' class='category'>%s</th></tr>\n",hashify($category->series." ".$year." ".$category->category),$category->series." - ".$category->category);
      }
      $p = $row->prod;
      if (!$p) continue;
      echo "<tr>\n";
      echo "<td>\n";
      
      //echo "<img src='".POUET_CONTENT_URL."gfx/sceneorg/".$row->type.".gif' alt='".$row->type."'/>&nbsp;";
      printf( "<span class='icon %s %s'></span>\n",$category->cssClass,$row->awardType);
      echo $p->RenderTypeIcons();
      echo "<span class='prod'>".$p->RenderLink()."</span>\n";
      echo "</td>\n";

      echo "<td>\n";
      echo $p->RenderGroupsShortProdlist();
      echo "</td>\n";

      echo "<td>\n";
      echo $p->RenderPlatformIcons();
      echo "</td>\n";
      echo "</tr>\n";
    }
    echo "</table>\n";
  }
};

$TITLE = "awards and viewing tips";

require_once("include_pouet/header.php");
require("include_pouet/menu.inc.php");

echo "<div id='content'>\n";

$box = new PouetBoxAwards();
$box->Load();
$box->Render();

echo "</div>\n";

require("include_pouet/menu.inc.php");
require_once("include_pouet/footer.php");

?>
