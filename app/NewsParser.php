<?php

namespace App;

use duzun\hQuery;
use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;

class NewsParser
{
    private $item;
    private $link;
    private $id;


    /**
     * Set item
     *
     * @param $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * Prepare data for database
     *
     * @return array
     */
    public function prepareData()
    {
        $news_id = $this->getNewsId(); // get id of news
        $link = $this->getLink(); // get link
        $date = $this->getDate(); // get date
        $title = $this->getTitle(); // get title
        $tags = $this->getTags(); // get tags
        $views = $this->getViews();  // get views*/

        $newsData = compact('news_id', 'title', 'link', 'tags', 'date', 'views');
        return $newsData;
    }

    /**
     * Get id of the news
     *
     * @return mixed
     */
    private function getNewsId()
    {
        $news = explode('_', $this->item->find(' .views ')->attr('id'));
        $this->id = $news[5];
        
        return $this->id;
    }

    /**
     * Get date
     * Check and update format of date.
     *
     * @return array|bool|mixed|string
     */
    private function getDate()
    {
        $months = [
            'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря', 'Сегодня', 'Вчера',
        ];

        $number = [
            '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', Carbon::now()->toDateString(), Carbon::yesterday()->toDateString(),
        ];

        $date = explode(',', $this->item->find('.date'));

        /**
         * Check and update format of date.
         *
         */
        if ($date[0] != 'Сегодня' && $date[0] != 'Вчера') {
            $date = str_replace($months, $number, $date);

            $md = explode(' ', $date[0]);
            $hs = explode(':', $date[1]);

            // update format of date
            $date = Carbon::create(null, $md[1], $md[0], $hs[0], $hs[1])->toDateTimeString();

            $current_date = Carbon::now()->startOfDay();
            $formatted_date = Carbon::parse($date)->startOfDay();

            $diff = $current_date->diffInDays($formatted_date);
            if ($diff >= 5) {
                return false ;
            }
        }
        if ($date[0] == 'Сегодня' || $date[0] == 'Вчера') {
            $date = str_replace($months, $number, $date);
            $md = explode('-', $date[0]);
            $hs = explode(':', $date[1]);

            // update format of date
            $date = Carbon::create($md[0], $md[1], $md[2], $hs[0], $hs[1])->toDateTimeString();
        }

        return $date;
    }

    /**
     * Get title of the news
     *
     * @return mixed
     */
    private function getTitle()
    {
        return $this->item->find('.description h3')->text();
    }

    /**
     * Get link of the news
     *
     * @return mixed
     */
    private function getLink()
    {
        $this->link = $this->item->find('a')->attr('href');
        return $this->link;
    }

    /**
     * Get tags of the news
     *
     * @return array|string
     */
    private function getTags()
    {
        $doc = \hQuery::fromUrl($this->link, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);

        // Get tags
        $tags = trim($doc->find('div.tag ')->text());

        // Convert tp string
        $tags = preg_split('/\s+/', $tags);
        $tags = implode(' ', $tags);

        return $tags;
    }

    /**
     * Get count views of the news
     *
     * @return mixed
     */
    private function getViews()
    {
        $id = $this->id;
        $news = "https://www.segodnya.ua/exec/ajax/sunsite.php?article=$id&articles[$id]=$id";

        $guzzle = new Guzzle();
        $body = $guzzle->get($news)->getBody();
        $body = json_decode($body);

        return $body->articleviews->{$id};
    }

}