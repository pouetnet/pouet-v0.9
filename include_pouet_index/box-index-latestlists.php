<?php

class PouetBoxIndexLatestLists extends PouetBoxCachable
{
    use PouetFrontPage;
    public $data;
    public $prods;
    public $limit;
    public function __construct()
    {
        parent::__construct();
        $this->uniqueID = "pouetbox_latestlists";
        $this->title = "latest added lists";

        $this->limit = 10;
    }

    public function LoadFromCachedData($data)
    {
        $this->data = unserialize($data);
    }

    public function GetData()
    {
        return $this->data;
    }

    public function GetCacheableData()
    {
        return serialize($this->data);
    }
    public function SetParameters($data)
    {
        if (isset($data["limit"])) {
            $this->limit = $data["limit"];
        }
    }
    public function GetParameterSettings()
    {
        return array(
          "limit" => array("name" => "number of lists visible","default" => 5,"min" => 1,"max" => POUET_CACHE_MAX),
        );
    }

    public function LoadFromDB()
    {
        $s = new BM_Query();
        $s->AddField("lists.id as id");
        $s->AddField("lists.name as name");
        $s->AddTable("lists");
        $s->attach(array("lists" => "owner"), array("users as user" => "id"));
        $s->AddOrder("lists.addedDate desc");
        $s->SetLimit(POUET_CACHE_MAX);
        $this->data = $s->perform();
        PouetCollectPlatforms($this->data);
    }

    public function RenderBody()
    {
        echo "<ul class='boxlist boxlisttable'>\n";
        $n = 0;
        foreach ($this->data as $l) {
            echo "<li>\n";
            printf("  <span><a href='lists.php?which=%d'>%s</a></span>\n", $l->id, _html($l->name));
            echo "  <span class='rowuser'>".$l->user->PrintLinkedAvatar()."</span>\n";
            echo "</li>\n";
            if (++$n == $this->limit) {
                break;
            }
        }
        echo "</ul>\n";
    }
    public function RenderFooter()
    {
        echo "  <div class='foot'><a href='lists.php'>more</a>...</div>\n";
        echo "</div>\n";
    }
};

$indexAvailableBoxes[] = "LatestLists";
