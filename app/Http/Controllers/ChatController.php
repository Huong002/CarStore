<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Exception;

class ChatController extends Controller
{
    public function index()
    {
        return view('admin.chatbot');
    }

    /**
     * Xử lý tin nhắn gửi đến Gemini API
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = $request->input('message');

 
        $userType = Auth::user()->utype ?? 'USR';
        $isAdmin = $userType === 'ADM';

        try {
            // Lấy API key từ .env
            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'API key chưa được cấu hình.'
                ]);
            }

            // URL API Gemini
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $apiKey;

            // Tạo prompt với context về cửa hàng và vai trò người dùng
            $systemPrompt = "Bạn là trợ lý AI tư vấn cho HTAutoStore - cửa hàng chuyên bán đồ công nghệ và phụ kiện ô tô. 
            
            " . ($isAdmin ?
                "Người dùng hiện tại là ADMIN của hệ thống. Bạn có thể:
                - Hỗ trợ quản lý sản phẩm, đơn hàng
                - Tư vấn chiến lược kinh doanh
                - Giải đáp về báo cáo, thống kê
                - Hướng dẫn sử dụng các tính năng admin"
                :
                "Người dùng hiện tại là KHÁCH HÀNG. Bạn có thể:"
            ) . "
            - Tư vấn sản phẩm công nghệ (điện thoại, laptop, tai nghe, v.v.)
            - Tư vấn phụ kiện ô tô (camera hành trình, cảm biến, đồ trang trí, v.v.)
            - Hỗ trợ khách hàng về chính sách bảo hành, đổi trả
            - Giải đáp thắc mắc về sản phẩm và dịch vụ
            - Trả lời bằng tiếng Việt, thân thiện và chuyên nghiệp
            
            Câu hỏi: " . $message;

            // Data gửi đến Gemini
            $data = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $systemPrompt
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1000,
                ]
            ];

            // Gửi request đến Gemini API
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $data);

            if ($response->successful()) {
                $result = $response->json();

                // Lấy câu trả lời từ response
                $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi không thể trả lời câu hỏi này lúc này.';

                // Log tin nhắn để debug (tùy chọn)
                Log::info('Chatbot - User: ' . $message);
                Log::info('Chatbot - Bot: ' . $reply);

                return response()->json([
                    'success' => true,
                    'message' => $this->formatResponse($reply)
                ]);
            } else {
                Log::error('Gemini API Error: ' . $response->body());

                return response()->json([
                    'success' => false,
                    'message' => 'Xin lỗi, hệ thống AI đang bận. Vui lòng thử lại sau ít phút.'
                ]);
            }
        } catch (Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xử lý yêu cầu. Vui lòng thử lại sau.'
            ]);
        }
    }

    /**
     * Format lại response từ AI để hiển thị đẹp hơn
     */
    private function formatResponse($response)
    {
        // Loại bỏ các ký tự không mong muốn
        $response = trim($response);

        // Thay thế ** thành <strong> để hiển thị bold
        $response = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $response);

        // Thay thế * thành <em> để hiển thị italic  
        $response = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $response);

        // Thay thế xuống dòng
        $response = nl2br($response);

        return $response;
    }

    /**
     * Lấy lịch sử chat (nếu muốn lưu vào database)
     */
    public function getChatHistory(Request $request)
    {
        // Có thể implement lưu chat history vào database
        // và trả về lịch sử chat của user

        return response()->json([
            'success' => true,
            'messages' => []
        ]);
    }

    /**
     * Xóa lịch sử chat
     */
    public function clearChatHistory(Request $request)
    {
        // Implement xóa lịch sử chat

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa lịch sử chat'
        ]);
    }
}
