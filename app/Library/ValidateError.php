<?php


namespace App\Library;


trait ValidateError
{
    public function validateError($message)
    {
        return [
            'class' => 'form-control border-danger',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => $message
        ];
    }
}