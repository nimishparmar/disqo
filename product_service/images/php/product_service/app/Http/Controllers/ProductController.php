<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Returns a set of active/available products based on search term
     * 
     * @param Request $request
     * @return JSON
     */
    public function search(Request $request) {
        $searchTerm = $request->input('search_term');

        // Find some products based on a simple text search on the name
        // In real life production systems, depending on the number of products
        // this functionality could be done by something like 
        // ElasticSearch, which is great at text searches and aggregations
        //
        // Only returns active products

        $products = DB::table('products')
                    ->select('id', 'product_name', 'product_description', 'price', 'product_sku')
                    ->where('product_name', 'like', '%' . $searchTerm . '%')
                    ->where('is_active', 1)
                    ->get();
        
        return response()->json([
            'products' => $products
        ], 200);
    }

}
