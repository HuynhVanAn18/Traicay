<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use App\Models\Products;

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
        $basePrompt = "Bạn là một chatbot chuyên về các loại trái cây và sản phẩm trái cây của cửa hàng Fresh Fruit. Dưới đây là thông tin về các sản phẩm hiện có: $productInfo Hãy trả lời tất cả các câu hỏi liên quan đến trái cây, sản phẩm trái cây, nguồn gốc, bảo quản, giá cả, tính sẵn có, hướng dẫn lựa chọn, lợi ích sức khỏe, cách đặt hàng, giao hàng, chương trình khuyến mãi, và các dịch vụ của cửa hàng một cách chi tiết, thân thiện, ngắn gọn và chính xác. Nếu hỏi về website chính thức của cửa hàng thì trả lời là Fresh Fruit Store (Đây là website duy nhất). Nếu hỏi về địa chỉ thì trả lời theo địa chỉ của cửa hàng. Nếu hỏi về liên hệ, số điện thoại hay giờ hoạt động thì trả lời theo thông tin của cửa hàng. Nếu hỏi về ship thì trả lời là phí ship sẽ khác nhau tùy thuộc vào vị trí giao hàng, đơn hàng trên 2 triệu sẽ được miễn phí ship. Nếu hỏi sản phẩm còn hàng hoặc tương tự thì bảo khách hàng kiểm tra lại trên cửa hàng. Nếu câu hỏi không thuộc các chủ đề này, hãy trả lời: 'Xin lỗi, tôi chỉ hỗ trợ thông tin về các sản phẩm trái cây và dịch vụ của Fresh Fruit Store. Bạn muốn hỏi gì về các chủ đề này?' Đảm bảo trả lời bằng tiếng Việt.";
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

        // Use Gemini Laravel Facade for API call
        $result = Gemini::geminiFlash25()->generateContent([
            $systemPrompt,
            $userMessage
        ]);
        $botReply = $result->text() ?? "Xin lỗi, tôi chỉ hỗ trợ thông tin về các sản phẩm trái cây và dịch vụ của Fresh Fruit Store. Bạn muốn hỏi gì về các chủ đề này?";
        return response()->json(['reply' => $botReply]);
    }
}
