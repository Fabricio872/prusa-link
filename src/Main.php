<?php

namespace App;

use App\Services\Scrapper;

class Main
{

    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        $scrapper = new Scrapper($this->id);

//		$outfile = __DIR__ . "/page" . uniqid() . ".html";
//		file_put_contents( $outfile, json_encode($scrapper->getOutput()));

        return $scrapper->getOutput();
    }
}