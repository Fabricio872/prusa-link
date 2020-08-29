<?php

namespace App\Services;


use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class Scrapper
{
    private string $link;
    private string $title;
    private string $image;
    private string $authorImage;
    private string $author;

    public function __construct(string $link)
    {
        $this->link = $link;
    }

    public function getOutput(): string
    {
        $attempts = 0;
        do {
            $success = $this->generateData();
            $attempts++;
        } while ( ! $success || $_ENV['ATTEMPTS'] < $attempts);

        return json_encode([
            'data' => [
                'title'       => $this->title,
                'image'       => $this->image,
                'authorImage' => $this->authorImage,
                'author'      => $this->author,
            ],
            'time' => []
        ]);
    }

    private function generateData()
    {
        try {
            $browser      = $_ENV["SELENIUM_BROWSER"];
            $capabilities = DesiredCapabilities::$browser();
            $driver       = RemoteWebDriver::create($_ENV["SELENIUM_HOST"], $capabilities);

            $driver->get($this->link);

            $image       = $driver->findElement(
                WebDriverBy::cssSelector('div.ngx-gallery-image-size-640x480 > div > div.ngx-gallery-image')
            );
            $authorImage = $driver->findElement(
                WebDriverBy::cssSelector('img.position-relative, .rounded-circle')
            );
            $author      = $driver->findElement(
                WebDriverBy::cssSelector('span.username-text')
            );

            $this->title       = substr($driver->getTitle(), 0, -strlen(" | PrusaPrinters"));
            $this->image       = substr($image->getAttribute('style'), strlen('background-image: url("'),
                -strlen('");'));
            $this->authorImage = $authorImage->getAttribute('src') ?? '';
            $this->author      = $author->getText();

            $driver->close();
        } catch (\Exception $exception) {
            if ($exception->getMessage() != 'Unable to locate element: div.ngx-gallery-image-size-640x480 > div > div.ngx-gallery-image') {
                throw $exception;
            }

            return false;
        }

        return true;
    }
}