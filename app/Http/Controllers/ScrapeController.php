<?php

namespace App\Http\Controllers;

use App\Skill;

use App\Book;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;

class ScrapeController extends Controller
{
    //
    public function scrape(Request $request)
    {
    	if (!$request->input('skill')) 
    	{
    		return view('scrape.index');
    	}

    	$skill = $request->input('skill');
    	$default = ini_get('max_execution_time');
		set_time_limit(1000);
    	
    	$skill = trim($skill);
    	$URL = "https://www.amazon.com/s/?field-keywords=" . strtolower($skill);
    	libxml_use_internal_errors(true);
		$webPage = $this->downloadURL($URL);
		if ($webPage) 
		{
			Skill::updateOrCreate(array('name' => $skill), array('name' => $skill, 'crawled_at' => Carbon::now()));
			$skillModel = Skill::where('name', $skill)->first();
			$results = $this->extractResults($webPage);
			foreach ($results as $result)
			{
				$searchKey = array('title'=>$result['title'], 'author'=>$result['author'], 'skill'=>$skillModel->id);
				Book::updateOrCreate($searchKey, $result);
			}
			return redirect('/book?skill='.$skill);
		}
		else 
		{
		  return view('scrape.index', ['error' => 'Error occurred scraping Amazon']);
		}
		set_time_limit($default);
    }

    private function extractResults($webPage) 
    {
		$dom = new \DOMDocument;
		if ($dom->loadHTML($webPage)) 
		{
			$finder = new \DOMXpath($dom);
			$results = array();
			$i = 0;
			$resultId = "result_" . $i;
			while($element = $dom->getElementById($resultId)) 
			{
				$bookURL = "";
				$imgURL = "";
				$title = "";
				$author = "";
				$authorURL = "";
				$price = "";
				$rating = "";
				$authorBio = "";
				$description = "";

				$result = array();
				$element = $dom->getElementById($resultId);
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-left")]/div/div/a', $element);
				foreach($elements as $container) 
				{
				    $bookURL = $container->getAttribute("href");
				    $result['book_url'] = $bookURL;
				}
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-left")]/div/div/a/img', $element);
				foreach($elements as $container) 
				{
				    $imgURL = $container->getAttribute("src");
				    $result['img_url'] = $imgURL;
				}
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-right")]/div[contains(@class," a-spacing-small")]/a', $element);
				foreach($elements as $container) 
				{
				    $title = $container->getAttribute("title");
				    $result['title'] = $title;
				}
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-right")]/div[contains(@class," a-spacing-small")]/div/span', $element);
				$authorElement = $elements->item(1);
				$authorLinks = $authorElement->getElementsByTagName('a');
				if ($authorLinks->length < 1) 
				{
					$author = $authorElement->textContent;
					$result['author'] = $author;
				}
				else
				{
					foreach($authorLinks as $container) 
					{
					    $author = $container->textContent;
					    $result['author'] = $author;
					}
				}				
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-right")]/div[contains(@class," a-spacing-small")]/div/span/a', $element);
				foreach($elements as $container) 
				{
				    $authorURL = 'https://www.amazon.com' . $container->getAttribute("href");
				}
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-right")]/div[@class="a-row"]/div[contains(@class," a-span7")]/div', $element);
				$inner = $finder->query('.//a/span', $elements->item(1));			
				foreach($inner as $container) 
				{
				    $price = $container->textContent;
				    echo $price;
				    if (!empty($price) && $price != 'to rent') {
				    	$result['price'] = substr($price, 1);
				    }
				}
				$elements = $finder->query('.//div/div/div/div[contains(@class," a-col-right")]/div[@class="a-row"]/div[contains(@class," a-span-last")]/div[contains(@class,"a-row ")]', $element);
				$inner = $finder->query('.//span/span/a/i/span', $elements->item(0));
				foreach($inner as $container) 
				{
				    $rating = $container->textContent;
				    $result['rating'] = $rating;
				}
				if (isset($authorURL) && !empty($authorURL)) 
				{
					$dom2 = new \DOMDocument;
					$authorPage = $this->downloadURL($authorURL);
					if ($authorPage) {
						if ($dom2->loadHTML($authorPage)) 
						{
							$finder2 = new \DOMXpath($dom2);
							$bioElement = $dom2->getElementById('ap-bio');

							$elements = $finder2->query('.//div/div[contains(@class,"a-expander-content ")]/span', $bioElement);
							foreach($elements as $container) 
							{
							    $authorBio = $container->textContent;
							    $result['author_bio'] = $authorBio;
							}
						}
					}
				}
				if (isset($bookURL) && !empty($bookURL)) 
				{
					$dom2 = new \DOMDocument;
					$bookPage = $this->downloadURL($bookURL);
					if ($bookPage) {
						if ($dom2->loadHTML($bookPage)) 
						{
							$finder2 = new \DOMXpath($dom2);
							$descripElement = $dom2->getElementById('bookDescription_feature_div');
							$elements = $descripElement->getElementsByTagName('noscript');
							foreach($elements as $container) 
							{
							    $description = $container->textContent;
							    $result['description'] = $description;
							}
							
						}
					}
				}
				array_push($results, $result);
				$i++;
				$resultId = "result_" . $i;
			}
			return $results;
		}
		return FALSE;
	}

	private function downloadURL($URL) 
	{
		$webPage = file_get_contents ($URL);
		return $webPage;
	}
}
