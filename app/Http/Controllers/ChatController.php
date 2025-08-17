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

        $user = Auth::user();
        $userType = $user ? ($user->utype ?? 'USR') : 'GUEST';
        $isAdmin = $userType === 'ADM';

        try {
            // Lấy API key từ conig thay vì env trực tiếp
            $apiKey = config('services.gemini.api_key');
            Log::info('API Key exists: ' . ($apiKey ? 'Yes' : 'No'));
            Log::info('API Key length: ' . strlen($apiKey));

            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'API key chưa được cấu hình.'
                ]);
            }

            // URL API Gemini - sử dụng model mới nhất
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

            $systemPrompt = "Bạn là trợ lý AI tư vấn cho HTAutoStore - cửa hàng chuyên bán đồ công nghệ và phụ kiện ô tô. 
            
            " . ($isAdmin ?
                "Người dùng hiện tại là ADMIN của hệ thống. Bạn có thể:
                - Hỗ trợ quản lý sản phẩm, đơn hàng
                - Tư vấn chiến lược kinh doanh
                - Giải đáp về báo cáo, thống kê
                - Hướng dẫn sử dụng các tính năng admin"
                : ($userType === 'GUEST' ?
                    "Người dùng hiện tại là KHÁCH VÃNG LAI (chưa đăng nhập). Bạn có thể:" :
                    "Người dùng hiện tại là KHÁCH HÀNG. Bạn có thể:"
                )
            ) . "
            - Tư vấn bán hàng dựa trên nhu cầu của người dùng
            - Tư vấn ô tô (thông tin kĩ thuật chi tiết về sản phẩm v.v.)
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

            // Gửi request đến Gemini API với cấu hình SSL và header mới
            $response = Http::withOptions([
                'verify' => false, 
                'timeout' => 30,
                'connect_timeout' => 10,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 3,
                ]
            ])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey, 
                    'User-Agent' => 'Laravel-ChatBot/1.0',
                ])
                ->post($url, $data);
            if ($response->successful()) {
                $result = $response->json();

                $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi không thể trả lời câu hỏi này lúc này.';

                Log::info('Chatbot - User: ' . $message);
                Log::info('Chatbot - Bot: ' . $reply);

                return response()->json([
                    'success' => true,
                    'message' => $this->formatResponse($reply)
                ]);
            } else {
                Log::error('Gemini API Error Response: Status ' . $response->status());
                Log::error('Gemini API Error Body: ' . $response->body());

                return response()->json([
                    'success' => false,
                    'message' => 'Xin lỗi, hệ thống AI đang bận. Vui lòng thử lại sau ít phút.',
                    'debug' => app()->environment('local') ? [
                        'status' => $response->status(),
                        'error' => $response->body()
                    ] : null
                ]);
            }
        } catch (Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());
            Log::error('Chatbot Error Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xử lý yêu cầu. Vui lòng thử lại sau.',
                'debug' => app()->environment('local') ? $e->getMessage() : null
            ]);
        }
    }

    /**
     * Format lại response từ AI để hiển thị đẹp hơn
     */
    private function formatResponse($response)
    {
        $response = trim($response);

        $response = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $response);

        $response = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $response);

        $response = nl2br($response);

        return $response;
    }

    /**
     * Lấy lịch sử chat (nếu muốn lưu vào database)
     */
    public function getChatHistory(Request $request)
    {

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

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa lịch sử chat'
        ]);
    }
}
