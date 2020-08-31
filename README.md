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

## API usage
### Request
 - Endpoint: ```http://[wordptress_app_url]/wp-json/prusa-link/v1/data``` 
 - Method: ```GET```
 - Parameter: ```link: https://prusaprinters_url```
 
 example: http://localhost:8000/wp-json/prusa-link/v1/data?link=https://www.prusaprinters.org/cs/prints/32714-prusa-pro-face-shield
 
 ### Response example
 ```
{
    "link": "https://www.prusaprinters.org/cs/prints/32714-prusa-pro-face-shield",
    "title": "PRUSA PRO Face Shield",
    "author": "Prusa Research",
    "image": "https://media.prusaprinters.org/thumbs/cover/640x480/media/prints/32714/images/321421_5dab8cf2-73f0-43b4-af7e-e0083ea5ce5c/1e.jpg",
    "author_image": "https://media.prusaprinters.org/thumbs/cover/60x60/media/avatars/16/prusa-research-2018-farma.jpg"
}
```
 