<?php

namespace App\Services;

use Browser\Casper;
use Sunra\PhpSimple\HtmlDomParser;

class Scrapper {
	private string $page;

	public function __construct( string $page ) {
		$this->page = $page;
	}

	public function getOutput() {
		$casper = new Casper();
		$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
		$casper->start($this->page);
		$casper->wait(5000);
		$output = $casper->getOutput();

		$outfile = __DIR__ . "/output" . uniqid() . ".html";
		file_put_contents( $outfile, $output);
		$casper->run();
		$html = $casper->getHtml();

		$outfile = __DIR__ . "/html" . uniqid() . ".html";
		file_put_contents( $outfile, $html);
		$dom = HtmlDomParser::str_get_html( $html );
		$elems = $dom->find("a");

		return $elems;
	}
}