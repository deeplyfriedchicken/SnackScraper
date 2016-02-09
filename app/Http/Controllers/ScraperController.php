<?php //the menu seems to change on Monday of the new week

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Goutte\Client;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ScraperController extends Controller
{
    public function scrape() {
      $client = new Client();
      $crawler = $client->request('GET', 'http://collins-cmc.cafebonappetit.com/cafe/collins/');
      $status_code = $client->getResponse()->getStatus();
      if($status_code==200) {
          echo '200 OK<br>';
      }
      $link = "";
      $link = $crawler->filter('div.cafe-hours span a')->link()->getUri();
      $client2 = new Client();
      $crawler2 = $client2->request('GET', "{$link}"); // use "" so it can interpret variable
      if($status_code==200) {
          echo '200 OK<br>';
      }
      $dt = Carbon::today()->dayOfWeek; //get the day of the week
      $snack = $crawler2->filter("table td#td-2051-{$dt}")->text(); //html is associated with this id and day is determined by the integer following the "-"
    }
}
