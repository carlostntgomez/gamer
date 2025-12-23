<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Post;
use App\Models\Category;
use App\Models\Review;
use App\Models\Brand; // Added this line for Brand model

class PageController extends Controller
{
    public function home() { return view('home'); }
    public function aboutUs() { return view('about-us'); }
    public function contactUs() { return view('contact-us'); }
    public function loginAccount() { return view('login-account'); }
    public function createAccount() { return view('create-account'); }
    public function termsCondition() { return view('terms-condition'); }
    public function faq() { return view('faq'); }
    public function cartPage() { return view('cart-page'); }

    public function productTemplate($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Get categories of the current product
        $categoryIds = $product->categories->pluck('id')->toArray();

        // Fetch related products from the same categories, excluding the current product
        $trendingProducts = Product::whereHas('categories', function ($query) use ($categoryIds) {
                                    $query->whereIn('categories.id', $categoryIds);
                                })
                                ->where('id', '!=', $product->id) // Exclude the current product
                                ->where('is_visible', true) // Ensure they are visible
                                ->orderBy('created_at', 'desc') // Order by creation date
                                ->limit(8) // Limit to 8 products
                                ->get();

        // Fetch approved reviews for the current product
        $reviews = $product->reviews()->where('is_approved', true)->orderBy('created_at', 'desc')->get();

        // Calculate average rating
        $averageRating = round($reviews->avg('rating'), 1);
        if ($reviews->isEmpty()) {
            $averageRating = 0; // Set to 0 if there are no reviews
        }

        return view('product-template', compact('product', 'trendingProducts', 'reviews', 'averageRating'));
    }

    public function submitReview(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $review = new Review();
        $review->product_id = $product->id;
        // Optionally, if users are authenticated, you can link the user ID
        // $review->user_id = auth()->id();
        $review->author_name = $validatedData['author_name'];
        $review->author_email = $validatedData['author_email'];
        $review->rating = $validatedData['rating'];
        $review->title = $validatedData['title'];
        $review->content = $validatedData['content'];
        $review->is_approved = false; // Reviews need to be approved by an admin
        $review->save();

        return redirect()->route('product.show', $product->slug)->with('success', 'Tu reseña ha sido enviada y está pendiente de aprobación.');
    }

    public function wishlistProduct() { return view('wishlist-product'); }
    public function orderHistory() { return view('order-history'); }
    public function profile() { return view('profile'); }
    public function proAddress() { return view('pro-address'); }
    public function proTickets() { return view('pro-tickets'); }
    public function billingInfo() { return view('billing-info'); }
    public function blogGridRight() { return view('blog-grid-right'); }
    public function blogGridWithout() { return view('blog-grid-without'); }
    public function blogGrid() { return view('blog-grid'); }
    public function cancellation() { return view('cancellation'); }
    public function cartEmpty() { return view('cart-empty'); }
    public function changePassword() { return view('change-password'); }
    public function checkoutStyle() { return view('checkout-style'); }
    public function collectionListWithout() { return view('collection-list-without'); }
    public function collectionWithout() { return view('collection-without'); }
    
    // Updated collection method to handle filters
    public function collection(Request $request)
    {
        $productsQuery = Product::where('is_visible', true);
        $categories = Category::withCount('products')->orderBy('name')->get(); // Get all categories for filter sidebar
        $brands = Brand::orderBy('name')->get(); // Get all brands for filter sidebar

        // Apply category filter
        if ($request->filled('category_id')) {
            $productsQuery->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->input('category_id'));
            });
        }

        // Apply price range filter
        if ($request->filled('min_price')) {
            $productsQuery->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $productsQuery->where('price', '<=', $request->input('max_price'));
        }

        // Apply sorting
        switch ($request->input('sort_by')) {
            case 'best-selling':
                // Assuming you have a 'sold_count' or similar field for best-selling
                $productsQuery->orderBy('sold_count', 'desc'); 
                break;
            case 'title-ascending':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'title-descending':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'price-ascending':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price-descending':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'created-descending':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'created-ascending':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            default:
                $productsQuery->orderBy('created_at', 'desc'); // Default sort
                break;
        }

        $products = $productsQuery->paginate(12);

        // Pass categories and brands to the view
        return view('collection', compact('products', 'categories', 'brands'));
    }

    public function comingSoon() { return view('coming-soon'); }
    public function orderComplete() { return view('order-complete'); }
    public function paymentPolicy() { return view('payment-policy'); }
    public function privacyPolicy() { return view('privacy-policy'); }
    public function returnPolicy() { return view('return-policy'); }
    public function searchBlog() { return view('search-blog'); }
    
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = collect(); // Initialize as an empty collection
        $categories = Category::withCount('products')->orderBy('name')->get(); // Get all categories for filter sidebar
        $brands = Brand::orderBy('name')->get(); // Get all brands for filter sidebar

        $productsQuery = Product::where('is_visible', true);

        // Apply search query filter
        if ($query) {
            $productsQuery->where(function ($qBuilder) use ($query) {
                                   $qBuilder->where('name', 'LIKE', '%' . $query . '%')
                                            ->orWhere('short_description', 'LIKE', '%' . $query . '%');
                               });
        }
        
        // Apply category filter (if present in search results)
        if ($request->filled('category_id')) {
            $productsQuery->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->input('category_id'));
            });
        }

        // Apply price range filter (if present in search results)
        if ($request->filled('min_price')) {
            $productsQuery->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $productsQuery->where('price', '<=', $request->input('max_price'));
        }

        // Apply sorting
        switch ($request->input('sort_by')) {
            case 'best-selling':
                $productsQuery->orderBy('sold_count', 'desc'); 
                break;
            case 'title-ascending':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'title-descending':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'price-ascending':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price-descending':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'created-descending':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'created-ascending':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            default:
                $productsQuery->orderBy('created_at', 'desc'); // Default sort
                break;
        }


        $products = $productsQuery->paginate(12);
        
        // Pass the search query, categories and brands to the view
        return view('collection', compact('products', 'query', 'categories', 'brands'));
    }

    public function shippingPolicy() { return view('shipping-policy'); }
    public function sitemap() { return view('sitemap'); }
    public function trackPage() { return view('track-page'); }
    public function wishlistEmpty() { return view('wishlist-empty'); }
    public function proWishlist() { return view('pro-wishlist'); }
    public function notFound() { return view('404'); }
    public function articlePostRight() { return view('article-post-right'); }
    public function articlePostWithout() { return view('article-post-without'); }
    public function articlePost() { return view('article-post'); }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->where('is_visible', true)->paginate(12); // Using paginate for pagination
        $categories = Category::withCount('products')->get(); // Getting all categories for the filter sidebar
        $brands = Brand::orderBy('name')->get(); // Get all brands for filter sidebar
        return view('category', compact('category', 'products', 'categories', 'brands'));
    }

    // New methods for newly defined routes
    public function proJuiceMachine() { return view('pro-juice-machine'); }
    public function proEarbuds() { return view('pro-earbuds'); }
    public function proPendrive() { return view('pro-pendrive'); }

    public function index2() { return view('index2'); }
    public function index3() { return view('index3'); }
    public function index4() { return view('index4'); }
    public function index5() { return view('index5'); }
    public function index6() { return view('index6'); }
    public function index7() { return view('index7'); }
    public function index8() { return view('index8'); }
    public function index9() { return view('index9'); }

    public function collectionRight() { return view('collection-right'); }
    public function collectionList() { return view('collection-list'); }
    public function collectionListRight() { return view('collection-list-right'); }

    public function blogIndex() { return view('blog-index'); }
    public function checkoutStyle1() { return view('checkout-style1'); }

    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)->whereNotNull('published_at')->firstOrFail();
        // Assuming you have a view called 'blog.show'
        return view('blog.show', compact('post'));
    }

    public function show($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)
                                ->where('is_published', true)
                                ->firstOrFail();

        return view('page.show', compact('page'));
    }
}