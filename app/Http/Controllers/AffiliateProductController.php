<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\AffiliateProductController;
use App\Models\AffiliateProduct;
use App\Models\AffiliateFlipkartCateoryUrl;
use App\Models\Brand;
use App\Models\FlipkartProduct;
use Session;
use DB;
use Illuminate\Contracts\Auth\Guard;

class AffiliateProductController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Guard $auth)
	{
		$affiliateProducts = new AffiliateProduct();
		$listaffiliateProducts = $affiliateProducts::get();
		return view('affilateProduct/affiliateProduct', ['listaffiliateProducts' => $listaffiliateProducts ]);
	}

	public function update(Guard $auth, $id) {
		if($id){
			$affiliateProducts = new AffiliateProduct();
			$getaffiliateProduct = $affiliateProducts::find($id);
			return view('affilateProduct/updateAffiliateProduct', ['getaffiliateProduct' => $getaffiliateProduct ]);
		}
	}

	public function importAffiliateProducts(){
		$csvProductFeedOutputDirectory = storage_path('app/flipkartDataFeed/mobiles_17Jan2018.csv');
		if(file_exists($csvProductFeedOutputDirectory)){
			$file = fopen($csvProductFeedOutputDirectory, 'r');
			$counter=0;
			$product = array();
			$affiliateProducts = new AffiliateProduct();
			while(($data = fgetcsv($file, 100, ",")) !== false){
				if($counter != 0){
					if($this->checkExistingAffiliateproduct($data[0])){
						$existingaffiliateProducts = $affiliateProducts::where('affiliate_product_id', $data[0])->first();
						//$existingaffiliateProducts->affiliate_product_id = $data[0];
						//$existingaffiliateProducts->title = $data[1];
						if(empty($existingaffiliateProducts->description)){
							$existingaffiliateProducts->description = $data[2];
						}
						//$existingaffiliateProducts->image_url = $data[3];
						$existingaffiliateProducts->mrp = $data[4];
						$existingaffiliateProducts->price = $data[5];
						$existingaffiliateProducts->product_url = $data[6];
						//$affiliateProducts->category_id = $data[7];
						//$affiliateProducts->brand_id = $data[8];
						$existingaffiliateProducts->delivery_time = $data[9];
						$existingaffiliateProducts->color = $data[17];
						$existingaffiliateProducts->save();
					} else {
						$affiliateProducts->affiliate_product_id = $data[0];
						$affiliateProducts->title = $data[1];
						$affiliateProducts->description = $data[2];
						$affiliateProducts->image_url = $data[3];
						$affiliateProducts->mrp = $data[4];
						$affiliateProducts->price = $data[5];
						$affiliateProducts->product_url = $data[6];
						//$affiliateProducts->category_id = $data[7];
						//$affiliateProducts->brand_id = $data[8];
						$affiliateProducts->delivery_time = $data[9];
						$affiliateProducts->color = $data[17];
						$affiliateProducts->save();
					}
				}
				$counter ++;
			}
		}

	}

	public function checkExistingAffiliateproduct($productId){
		if($productId){
			$affiliateProducts = new AffiliateProduct();
			$existing = $affiliateProducts::where('affiliate_product_id', $productId)->count();
			if($existing > 0){
				return true;
			}
		}
	}
	
	public function getFlipkartCategoriesUrl(){
		$url = "https://affiliate-api.flipkart.net/affiliate/api/souriraj.json";
		$ch = curl_init();
			$headers = array(
	    	        'Cache-Control: no-cache',
	        	    'Fk-Affiliate-Id: souriraj',
	            	'Fk-Affiliate-Token: 7ae532f5bb4649bb981fb4052d6ecedd'
		            );
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, $headers);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$result = curl_exec($ch);
			$data = json_decode($result, true);			
			$affiliateFlipkartCateoryUrl = new AffiliateFlipkartCateoryUrl();
				foreach($data['apiGroups']['affiliate']['apiListings'] as $category){
					if($this->checkExistingFlipkartCategoriesUrl($category['availableVariants']['v0.1.0']['resourceName'])){		
						$existngAffiliateFlipkartCateoryUrl = new AffiliateFlipkartCateoryUrl();		
						$existngAffiliateFlipkartCateory = $existngAffiliateFlipkartCateoryUrl::where('category_name', $category['availableVariants']['v0.1.0']['resourceName'])->first();
						$existngAffiliateFlipkartCateory->category_url = $category['availableVariants']['v0.1.0']['get'];
						$existngAffiliateFlipkartCateory->save();						
					} else {
						$affiliateFlipkartCateoryUrl = new AffiliateFlipkartCateoryUrl();
						$affiliateFlipkartCateoryUrl->category_name = $category['availableVariants']['v0.1.0']['resourceName'];
						$affiliateFlipkartCateoryUrl->category_url = $category['availableVariants']['v0.1.0']['get'];
						$affiliateFlipkartCateoryUrl->save();		
					}
				}
	}
	
	public function checkExistingFlipkartCategoriesUrl($categoryName){
		$existngAffiliateFlipkartCateoryUrl = new AffiliateFlipkartCateoryUrl();		
		$existngAffiliateFlipkartCateory = $existngAffiliateFlipkartCateoryUrl::where('category_name', $categoryName)->count();
		if($existngAffiliateFlipkartCateory > 0){
			return true;
		}
	}
	
	public function callflipkartCategoriesUrl(){
		$AffiliateFlipkartCateoryUrl = new AffiliateFlipkartCateoryUrl();		
		$getAffiliateFlipkartCateoryUrls = $AffiliateFlipkartCateoryUrl::where('is_active', true)->where('cron_status', "not_started")->orderBy('id', 'DESC')->first();
		if($getAffiliateFlipkartCateoryUrls){
			$products = $this->getFlipkartProducts($getAffiliateFlipkartCateoryUrls->category_url);			
		}
		
	}	

	public function getFlipkartProducts($url){	
			$headers = array(
	            'Cache-Control: no-cache',
	            'Fk-Affiliate-Id: souriraj',
	            'Fk-Affiliate-Token: 7ae532f5bb4649bb981fb4052d6ecedd'
	            );

	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-ClusterDev-Flipkart/0.1');
	        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	        $result = curl_exec($ch);
	        curl_close($ch);			
			$data = json_decode($result, true);	

			foreach($data['productInfoList'] as $flipkartproduct){
				if($this->checkExistingFlipkartProduct($flipkartproduct['productBaseInfo']['productIdentifier']['productId'])){
					$existingProduct = FlipkartProduct::where('flipkart_product_id', $flipkartproduct['productBaseInfo']['productIdentifier']['productId'])->first();							
					$existingProduct->product_url = $flipkartproduct['productBaseInfo']['productAttributes']['productUrl'];
					$existingProduct->maximum_retail_price = $flipkartproduct['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount'];
					$existingProduct->maximum_retail_price_currency = $flipkartproduct['productBaseInfo']['productAttributes']['maximumRetailPrice']['currency'];				
					$existingProduct->selling_price = $flipkartproduct['productBaseInfo']['productAttributes']['sellingPrice']['amount'];
					$existingProduct->selling_price_currency = $flipkartproduct['productBaseInfo']['productAttributes']['sellingPrice']['currency'];
					$existingProduct->discount_percentage = $flipkartproduct['productBaseInfo']['productAttributes']['discountPercentage'];				
					$existingProduct->save();					
				} else {
					$flipkart = new FlipkartProduct();
					$flipkart->flipkart_product_id = $flipkartproduct['productBaseInfo']['productIdentifier']['productId'];
					$flipkart->category_title = $flipkartproduct['productBaseInfo']['productIdentifier']['categoryPaths']['categoryPath'][0][0]['title'];
					$flipkart->product_title = $flipkartproduct['productBaseInfo']['productAttributes']['title'];
					$flipkart->slug = str_slug($flipkartproduct['productBaseInfo']['productAttributes']['title'], '-');
					$flipkart->product_description = $flipkartproduct['productBaseInfo']['productAttributes']['productDescription'];
					$flipkart->product_url = $flipkartproduct['productBaseInfo']['productAttributes']['productUrl'];
					$flipkartimage = array_keys($flipkartproduct['productBaseInfo']['productAttributes']['imageUrls']);
						$image = $flipkartimage[0];
					$flipkart->product_image_url = $flipkartproduct['productBaseInfo']['productAttributes']['imageUrls'][$image];									
					$flipkart->maximum_retail_price = $flipkartproduct['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount'];
					$flipkart->maximum_retail_price_currency = $flipkartproduct['productBaseInfo']['productAttributes']['maximumRetailPrice']['currency'];				
					$flipkart->selling_price = $flipkartproduct['productBaseInfo']['productAttributes']['sellingPrice']['amount'];
					$flipkart->selling_price_currency = $flipkartproduct['productBaseInfo']['productAttributes']['sellingPrice']['currency'];
					$flipkart->brand_id = $this->findOrCreateBrand($flipkartproduct['productBaseInfo']['productAttributes']['productBrand']);
					$flipkart->discount_percentage = $flipkartproduct['productBaseInfo']['productAttributes']['discountPercentage'];				
					$flipkart->save();
				}			
			}	
			if($data['nextUrl']){
				$this->saveOrUpdateNextUrl($data['nextUrl']);
				$this->getFlipkartProducts($data['nextUrl']);
			} else {
				$cronLast = DB::table('flipkart_next_url_cron_status')->where('status', 'not_started')->orderBy('id', 'DESC')->first();
				DB::table('flipkart_next_url_cron_status')->where('id', $cronLast->id)->update(['status' => 'completed']);
			}
	}
	
	public function checkExistingFlipkartProduct($flipkartProductId){
		$existingProduct = FlipkartProduct::where('flipkart_product_id', $flipkartProductId)->count();
		if($existingProduct > 0){
			return true;
		}
		return false;
	}
	
	public function saveOrUpdateNextUrl($url){
		$nextUrlCount = DB::table('flipkart_next_url_cron_status')->where('status', 'not_started')->count();
		if($nextUrlCount > 0){
			$cronLast = DB::table('flipkart_next_url_cron_status')->where('status', 'not_started')->orderBy('id', 'DESC')->first();
			DB::table('flipkart_next_url_cron_status')->where('id', $cronLast->id)->update(['next_url' => $url]);			
		} else {
			DB::table('flipkart_next_url_cron_status')->insert(['next_url' => $url, 'status' => 'not_started']);
		}
	}
	
	public function checkAndRunNextUrl(){
		$next_url = DB::table('flipkart_next_url_cron_status')->where('status', 'not_started')->orderBy('id', 'DESC')->first();
		if($next_url){
			$this->getFlipkartProducts($next_url->next_url);
		}
		
	}
	public function findOrCreateBrand($brandName)
    {
    	$brandExist = false;
        if($brandName)
        {
        	$brand = Brand::where('brand_name', $brandName)->first();
	        if(isset($brand->id) && $brand->id) {
				$brandExist = true;
	            return $brand->id;
	        }
	    }

		if(!$brandExist) {           
            if($brand = Brand::where('brand_name', $brandName)->orWhere('slug', str_slug($brandName, '-'))->first())
			{
                return $brand;
            }
			else
			{
                if(empty($brandName))
				{
                    return null;
                }

                $brand = new Brand;
                $brand->brand_name = $brandName;
                $brand->slug = str_slug($brand->name, '-');
                $brand->save();
                return $brand->id;
            }
        }
        return null;
    }

}
