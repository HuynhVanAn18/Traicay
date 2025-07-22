<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    private function getSystemPromptWithProducts()
    {
        $products = Products::all();
        $productInfo = "";
        foreach ($products as $product) {
            $status = ((int)$product->product_status === 1) ? 'Còn hàng' : 'Hết hàng';
            $productInfo .= "Tên: {$product->product_name}, Giá: {$product->product_price} VND, Mô tả: {$product->product_desc}, Tình trạng: $status. ";
        }

        // Add brand data
        $brands = DB::table('tbl_brand_product')->get();
        $brandInfo = "";
        foreach ($brands as $brand) {
            $brandInfo .= "Tên thương hiệu: {$brand->brand_name}, Tên tiếng Anh: {$brand->brand_name_en}, Mô tả: {$brand->brand_desc}. ";
        }

        // Add category data
        $categories = DB::table('tbl_category_product')->get();
        $categoryInfo = "";
        foreach ($categories as $category) {
            $categoryInfo .= "Tên danh mục: {$category->category_name}, Tên tiếng Anh: {$category->category_name_en}, Mô tả: {$category->category_desc}. ";
        }


        // Add post data (only latest 5 posts for brevity), skip if table does not exist
        $postInfo = "";
        try {
            $posts = DB::table('tbl_posts')->orderBy('post_id', 'desc')->limit(5)->get();
            foreach ($posts as $post) {
                $postInfo .= "Bài viết: {$post->post_title}, Mô tả: {$post->post_desc}. ";
            }
        } catch (\Exception $e) {
            // Table does not exist, skip post info
        }

        $basePrompt = "Bạn là một chatbot chuyên về các loại trái cây và sản phẩm trái cây của cửa hàng Fresh Fruit.\n" .
            "Dưới đây là thông tin về các sản phẩm hiện có: $productInfo\n" .
            "Thông tin các thương hiệu: $brandInfo\n" .
            "Thông tin các danh mục: $categoryInfo\n" .
            "Một số bài viết nổi bật: $postInfo\n" .
            "Hãy trả lời tất cả các câu hỏi liên quan đến trái cây, sản phẩm trái cây, thương hiệu, danh mục, bài viết, nguồn gốc, bảo quản, giá cả, tính sẵn có, hướng dẫn lựa chọn, lợi ích sức khỏe, cách đặt hàng, giao hàng, chương trình khuyến mãi, và các dịch vụ của cửa hàng một cách chi tiết, thân thiện, ngắn gọn và chính xác. Nếu hỏi về website chính thức của cửa hàng thì trả lời là Fresh Fruit Store (Đây là website duy nhất). Nếu hỏi về địa chỉ thì trả lời theo địa chỉ của cửa hàng. Nếu hỏi về liên hệ, số điện thoại hay giờ hoạt động thì trả lời theo thông tin của cửa hàng. Nếu hỏi về ship thì trả lời là phí ship sẽ khác nhau tùy thuộc vào vị trí giao hàng, đơn hàng trên 2 triệu sẽ được miễn phí ship. Nếu hỏi sản phẩm còn hàng hoặc tương tự thì bảo khách hàng kiểm tra lại trên cửa hàng. Nếu câu hỏi không thuộc các chủ đề này, hãy trả lời: 'Xin lỗi, tôi chỉ hỗ trợ thông tin về các sản phẩm trái cây và dịch vụ của Fresh Fruit Store. Bạn muốn hỏi gì về các chủ đề này?' Đảm bảo trả lời bằng tiếng Việt.";
        return $basePrompt;
    }
    public function index()
    {
        return view('chatbot', [
            'meta_title' => 'Chatbot',
            'meta_desc' => 'Chatbot powered by Gemini AI',
            'meta_keywords' => 'chatbot, ai, gemini',
            'url_canonical' => url()->current(),
            'contact_info' => []
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $systemPrompt = $this->getSystemPromptWithProducts();
        $userMessage = $request->input('message');

        $apiKey = env('GEMINI_API_KEY');
        Log::info('[Chatbot] .env GEMINI_API_KEY', ['GEMINI_API_KEY' => $apiKey]);
        Log::info('[Chatbot] Incoming message', ['userMessage' => $userMessage]);
        Log::info('[Chatbot] System prompt', ['systemPrompt' => $systemPrompt]);

        try {
            Log::info('[Chatbot] About to call Gemini API via HTTP');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $apiKey,
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $systemPrompt]
                        ]
                    ],
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $userMessage]
                        ]
                    ]
                ]
            ]);
            $data = $response->json();
            Log::info('[Chatbot] Gemini API HTTP result', ['data' => $data]);
            $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? "Xin lỗi, tôi chỉ hỗ trợ thông tin về các sản phẩm trái cây và dịch vụ của Fresh Fruit Store. Bạn muốn hỏi gì về các chủ đề này?";
        } catch (\Throwable $e) {
            Log::error('[Chatbot] Gemini API error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'env_GEMINI_API_KEY' => $apiKey,
            ]);
            $botReply = "Xin lỗi, hiện tại chatbot đang bận hoặc gặp sự cố. Vui lòng thử lại sau.";
        }
        Log::info('[Chatbot] Bot reply', ['reply' => $botReply]);
        return response()->json(['reply' => $botReply]);
    }
}
