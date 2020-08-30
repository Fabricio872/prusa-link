# Prusa Link
Widget for caching and showing data from web
## Installation
 1. go to plugin directory ([wordpress-dir]/wp-content/plugins)
 1. clone project
    ```
    git clone https://github.com/Fabricio872/prusa-link.git
    ```
 1. go to project dir
    ```
    cd prusa-link
    ```
 1. build Docker Container 
    ```
    docker run -d -p 4444:4444 -v /dev/shm:/dev/shm selenium/standalone-firefox:4.0.0-alpha-7-prerelease-20200826
    ```
 1. install plugin dependencies
    ```
    composer install
    ```
 1. create table in database for caching
    ```
    vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
    ```
## Usage
 > [pp-link https://prusaprinters_url]

 example:
 > [pp-link https://www.prusaprinters.org/cs/prints/32714-prusa-pro-face-shield]
    