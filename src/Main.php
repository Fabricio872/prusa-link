<?php

namespace App;

use App\Services\Scrapper;

class Main {

	private string $link;

	public function __construct( string $link ) {
		$this->link = $link;
	}

	public function __toString() {
		$scrapper = new Scrapper( $this->link );

		$outfile = __DIR__ . "/page" . uniqid() . ".html";
		file_put_contents( $outfile, json_encode($scrapper->getOutput()));

		return $this->link;
	}
}