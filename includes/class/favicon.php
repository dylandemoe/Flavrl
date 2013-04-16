<?php
    //This class is guessed to strip a domain from
    // a url and grab the favicon, powered by google services.
    // The choice to use google over saving them locally was 
    //because of how google caches the icons, making this a 
    //faster choice
    class iconGrabber{
        
        var $url;
        
        public function getIcon($imgTag, $class){
            $url = $this->url;
            $gs = 'http://www.google.com/s2/u/0/favicons?domain=';
            
            $parsed = parse_url($url, PHP_URL_HOST);
            $output = $gs.$parsed;
            
            if($imgTag == true){
                return '<img class="'.$class.'" src="'.$output.'"/>';
            }
            else{
                return $output;
            }
        }
        
        public function getTitle(){
            //This function will grab the title of a web page
            $url = $this->url;
            //add an user agent to curl so sites with browser redirection don't redirect me
            $ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.16 (KHTML, like Gecko) \ 
                    Chrome/24.0.1304.0 Safari/537.16';
            //curl to get the info
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        
            $data = curl_exec($ch);
            curl_close($ch);
            
            if($data == false){ //if there is an error, the title will be the url
               $title = $url; 
            }
            else{
                //then we parse it
                $doc = new DOMDocument();
                @$doc->loadHTML($data);
                $nodes = $doc->getElementsByTagName('title');
                $title = $nodes->item(0)->nodeValue;
                
                if($title == ''){
                    $title = $url;
                }
            }
            
            return $title;

        }
    }
?>