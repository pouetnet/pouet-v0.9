<?
include_once("include_generic/sqllib.inc.php");
include_once("include_pouet/pouet-box.php");
include_once("include_pouet/pouet-prod.php");

class PouetBoxUpcomingParties extends PouetBoxCachable {
  function PouetBoxUpcomingParties($rss) {
    parent::__construct();
    $this->uniqueID = "pouetbox_upcomingparties";
    $this->title = "upcoming parties";
    $this->rss = $rss;
  }

  function LoadFromDB() {
  }
 
  function RenderBody() {
    echo "<ul class='boxlist'>\n";
    for($i=0; $i < 5; $i++) 
    {
    	$st = strtotime($this->rss['items'][$i]['demopartynet:startDate']);
    	$et = strtotime($this->rss['items'][$i]['demopartynet:endDate']);
    	$sd = strtolower( date("M j",$st) );
    	$ed = strtolower( date("M j",$et) );
    	$form = "";
    	if ($sd == $ed)
    	  $form = $sd;
    	else if (substr($sd,0,3)==substr($ed,0,3))
    	  $form = $sd . " - " . substr($ed,4);
    	else
    	  $form = $sd . " - " . $ed;
    	$dist = (int)ceil( ($st - time()) / 60 / 60 / 24 );
    
      echo "<li>\n";
      echo "<a href='".$this->rss['items'][$i]['link']."'>".$this->rss['items'][$i]['demopartynet:title']."</a> ";
      echo " <span class='timeleft'>";
      echo $form;
      if ($dist == 0) echo " (today!)"; 
      else if ($dist == 1) echo " (tomorrow)";
      else echo " (".$dist." days)";
      echo "</span>";
      echo "</li>\n";
    }
    echo "</ul>\n";
  }
  function RenderFooter() {
    echo "  <div class='foot'><a href='http://www.demoparty.net/'>more at demoparty.net</a>...</div>\n";
    echo "</div>\n";
  }
};

?>
