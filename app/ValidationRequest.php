<?php

namespace App;

use Rakit\Validation\Validator;

class ValidationRequest
{
    protected $validator;
    protected $validation;
    protected $errors = [];

    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->validator = new Validator();
        $this->validation = $this->validator->make($data, $rules, $messages);
        $this->validation->validate();
        if ($this->validation->fails()) {
            $this->errors = $this->validation->errors()->all();
        }
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function validated()
    {
        return $this->validation->getValidData();
    }
}
