<?php
/**
 * Nikba - A PHP Framework For Directus API
 *
 * @package  Nikba
 * @author   Bargan Nicolai <office@nikba.com>
 */

namespace Controllers;

use Flight;
use Flight\template\View;
use Gilbitron\Util\SimpleCache;

class Home extends App
{

    #Get News
    public function getPortfolio() {
        $collection = "portfolio";
        $cache_file = $collection."_home_".$this->langue;
        $response = array();
        
        if($data = $this->checkCache($cache_file)){
			$results = $data;
		} else {
			$fields = "id, title_{$this->langue}, image, cat.title_{$this->langue}";
            $results = Flight::api()->items($collection)->_fields($fields)->get();
        
			if(Flight::api()->isError($results)) {
				$this->errors[] = array_merge(array("module"=>$collection), (array)$results->error);
			}
			else {
				$results = $results->data;
				$this->setCache($cache_file, $results);
			}
		}

        foreach($results as $row) {
            $response[$row->id]['id'] = $row->id;
            $response[$row->id]['title'] = $row->{'title_'.$this->langue};
            $response[$row->id]['cat'] = $row->cat->{'title_'.$this->langue};
            $response[$row->id]['thumb'] = (!empty($row->image->id))?$this->getImage($row->image->id, ["width"=>450, "height"=>450]):false;
            $response[$row->id]['image'] = (!empty($row->image->id))?$this->getImage($row->image->id, ["width"=>800, "height"=>600]):false;
        }
        
        return $response;
    }

    #Render Data
    public function index() {	
        
        #Set Default Language
        $this->langue = Flight::get('language');

        #Render
        Flight::view()->display("index.twig", [
			"locales"   => $this->getLocales($this->langue),
			"langue"    => $this->langue,
            "url"       => "/",
			"errors"    => $this->errors,

            "portfolio" => $this->getPortfolio(),
        ]);
    }
    
}
