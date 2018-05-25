<?php

namespace App\Repositories;

use App\News;
use App\NewsParser;
use duzun\hQuery;

class NewsRepository
{
    protected $url = 'https://www.segodnya.ua/regions/odessa.html';
    public $start = 1;
    public $end = 4;

    /**
     * Parse pages from $start to $end
     *
     * @param $start
     * @param $end
     */
    public function parserAction($start, $end)
    {
        if($start < $end){
            $doc = \hQuery::fromUrl($this->url, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);
            ini_set('max_execution_time', 900);
            $worker = new NewsParser();

            foreach ($doc->find('div.news-block ') as $item)
            {
                if ($item->find('a')){
                    $worker->setItem($item);
                    $newsData = $worker->prepareData();

                    News::create($newsData);
                }
            }

            $next = $doc->find('.pages > li a')->next()->attr('href');

            if(!empty($next)){
                $this->start++;

                $this->url = 'https://www.segodnya.ua/regions/odessa/p' . $this->start . '.html';
                $this->parserAction($this->start, $this->end);
            }
        }
    }

    /**
     * Start parsing from 1 page
     */
    public function parserStart()
    {
        // Delete old articles
        if($this->check()){
            News::truncate();
        }

        $this->parserAction($this->start, $this->end);
    }

    /**
     * Check the table on empty
     *
     * @return mixed
     */
    public function check()
    {
        return News::first();
    }

    /**
     * Get all content
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getNews()
    {
        return News::all();
    }

}