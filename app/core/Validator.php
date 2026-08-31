<?php

namespace App\Core;

class Validator
{
    private array $errors = [];
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): self
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesList = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;

            foreach ($rulesList as $rule) {
                $this->applyRule($field, $rule);
            }
        }
        return $this;
    }

    private function applyRule(string $field, string $rule): void
    {
        $value = $this->data[$field] ?? null;

        if (str_starts_with($rule, 'required')) {
            if ($value === null || $value === '') {
                $this->errors[$field][] = "{$field} est obligatoire.";
            }
        }

        if ($value === null || $value === '') return;

        if (str_starts_with($rule, 'min:')) {
            $min = (int) substr($rule, 4);
            if (strlen($value) < $min) {
                $this->errors[$field][] = "{$field} doit contenir au moins {$min} caractères.";
            }
        }

        if (str_starts_with($rule, 'max:')) {
            $max = (int) substr($rule, 4);
            if (strlen($value) > $max) {
                $this->errors[$field][] = "{$field} ne doit pas dépasser {$max} caractères.";
            }
        }

        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "{$field} n'est pas un email valide.";
        }

        if ($rule === 'numeric' && !is_numeric($value)) {
            $this->errors[$field][] = "{$field} doit être numérique.";
        }

        if (str_starts_with($rule, 'in:')) {
            $allowed = explode(',', substr($rule, 3));
            if (!in_array($value, $allowed)) {
                $this->errors[$field][] = "{$field} n'est pas valide.";
            }
        }

        if ($rule === 'file') {
            $file = $_FILES[$field] ?? null;
            if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
                $this->errors[$field][] = "{$field} est obligatoire.";
            }
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): ?string
    {
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0];
        }
        return null;
    }

    public function getErrorsFor(string $field): array
    {
        return $this->errors[$field] ?? [];
    }
}
