<?php


class NewsList extends Component
{
    public function __construct($name, $template, array $params = array())
    {
        parent::__construct($name, $template, $params);
    }

    public function executeComponent()
    {
        $this->prepareParams();
        $this->arrResult = $this->getResult($this->getPageNumber());
        $this->includeTemplate();
    }

    protected function getResult($pageNumber)
    {
        $array = array();
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $this->params['data'])) {
            $xmlString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $this->params['data']);
            $xml = new SimpleXMLElement($xmlString);
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