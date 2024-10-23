<?php

namespace Core;

class Response
{
    // send a JSON response
    public function json($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        
        echo json_encode($data);
        exit;// stop script after return response
    }

    // send an error JSON response
    public function error($message, $status = 400)
    {
        $this->json([
            'success' => false,
            'message' => $message,
            'data' => null,
        ], $status);
    }
}
