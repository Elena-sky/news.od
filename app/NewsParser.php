<?php

namespace App;

use duzun\hQuery;
use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;


class NewsParser
{

    /**
     * Get id of the news
     *
     * @param $item
     * @return mixed
     */
    public function getNewsId($item)
    {
        $news = explode('_', $item->find(' .views ')->attr('id'));

        return $news[5];
    }


    /**
     * Get date
     * Check and update format of date.
     *
     * @param $item
     * @return array|bool|mixed|string
     */
    public function getDate($item)
    {
        $months = [
            'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря', 'Сегодня', 'Вчера',
        ];

        $number = [
            '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', Carbon::now()->toDateString(), Carbon::yesterday()->toDateString(),
        ];

        $date = explode(',', $item->find('.date'));

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
     * @param $item
     * @return mixed
     */
    public function getTitle($item)
    {
        return $item->find('.description h3')->text();

    }


    /**
     * Get link of the news
     *
     * @param $item
     * @return mixed
     */
    public function getLink($item)
    {
        return $item->find('a')->attr('href');
    }


    /**
     * Get tags of the news
     *
     * @param $link
     * @return array|string
     */
    public function getTags($link)
    {
        $doc = \hQuery::fromUrl($link, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);

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
     * @param $id
     * @return mixed
     */
    public function getViews($id)
    {
        $news = "https://www.segodnya.ua/exec/ajax/sunsite.php?article=$id&articles[$id]=$id";

        $guzzle = new Guzzle();
        $body = $guzzle->get($news)->getBody();
        $body = json_decode($body);

        return $body->articleviews->{$id};
    }

}