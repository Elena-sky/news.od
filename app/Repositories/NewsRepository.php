<?php

namespace App\Repositories;

use App\NewsParser;
use duzun\hQuery;

class NewsRepository
{


    public function parserAction()
    {
        $url = 'https://www.segodnya.ua/regions/odessa.html';

        $doc = \hQuery::fromUrl($url, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);


        foreach ($doc->find('div.news-block ') as $item)
        {

            if ($item->find('a')){

                $worker = new NewsParser();

                $id = $worker->getNewsId($item); // get id of news
                $date = $worker->getDate($item); // get date
                $title = $worker->getTitle($item); // get title
                $link = $worker->getLink($item); // get link
                $tags = $worker->getTags($link); // get tags
                $views = $worker->getViews($id);  // get views


                $newsData = [
                    'news_id' => $id,
                    'title' => $title,
                    'link' => $link,
                    'tags' => $tags,
                    'date' => $date,
                    'views' => $views

                ];

            }
        }
    }

}