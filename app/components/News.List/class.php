<?php


class NewsList extends Component
{
    public function __construct($name, $template, array $params = array())
    {
        parent::__construct($name, $template, $params);
    }

    public function executeComponent()
    {
        $countElements = 0;
        $this->prepareParams();
        $this->arrResult = $this->getResult($this->getPageNumber(), $countElements);
        $this->includeTemplate();
        echo "<div class = 'pagination'>";
        $max = (int)$countElements / $this->params['count'];

        echo "<a href=\"/news/page-1/\" ".($this->getPageNumber()==1 ?" class = 'active'":"").">1</a>";
        if ($this->getPageNumber() > (int)$max / 2) {
            echo "<a href=\"/news/page-1" . (int)(((int)$max / 2 - 1) / 2) . "/\" >...</a>";;
        }
        for ($i = $this->getPageNumber() - 2; $i < $this->getPageNumber() + 1 && $i < $max - 1; $i++) {
            if ($i > 0)
                if ($this->getPageNumber() != $i + 1) {
                    ?><a href="/news/page-<?= $i + 1 ?>/" ><?= $i + 1 ?></a> <?php
                } else {
                    ?><a class='active'><?= $i + 1 ?></a> <?php
                }
        }
        if ($this->getPageNumber() < (int)$max / 2) {

            echo "<a href=\"/news/page-" . (int)(((int)$max+$this->getPageNumber()) / 2) . "/\" >...</a>";
        }
        echo "<a href=\"/news/page-" . $max . "/\"".($this->getPageNumber()==$max?" class = 'active'":"")." >" . $max . "</a>";
        echo "</div>";
    }


    protected function getResult($pageNumber, &$countItems = 0)
    {
        $array = array();
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $this->params['data'])) {
            $xmlString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $this->params['data']);
            $xml = new SimpleXMLElement($xmlString);
            $countItems = count($xml->item);
            $i = 0;
            foreach ($xml->item as $item) {
                $array[$i]['title'] = $item->title->__toString();
                $array[$i]['picture'] = $item->picture->__toString();;
                $array[$i]['description'] = $item->description->__toString();;
                $array[$i]['link'] = $item->link->__toString();;
                $array[$i]['pubDate'] = $item->pubDate->__toString();;
                $i++;
            }
        }
        return array_splice($array, ($pageNumber - 1) * $this->params['count'], $this->params['count']);

    }
}