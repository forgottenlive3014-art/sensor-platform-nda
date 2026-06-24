<?php
class ChatController {
    
    private $apiKey = "";
    private $model = "llama-3.3-70b-versatile";
    private $url = "https://api.groq.com/openai/v1/chat/completions";
    
    public function send() {
        $input = json_decode(file_get_contents('php://input'), true);
        $message = $input['message'] ?? '';
        
        if (empty($message)) {
            jsonResponse(['reply' => 'Please write your question about natural disasters.']);
            return;
        }
        
        $systemPrompt = "You are the NDA assistant, expert in earthquakes in El Salvador. 
        Respond in a FRIENDLY and helpful way. If asked something inappropriate, redirect to disaster prevention.
        Respond ALWAYS in Spanish.";
        
        $payload = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $message]
            ],
            'temperature' => 0.7,
            'max_tokens' => 500
        ];
        
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            jsonResponse(['reply' => "Connection error: $error"]);
            return;
        }
        
        $data = json_decode($response, true);
        $reply = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response.';
        
        jsonResponse(['reply' => $reply]);
    }
}
?>