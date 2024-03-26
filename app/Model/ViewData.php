<?php
declare(strict_types=1);

namespace Model;

class ViewData
{

    public array $data = [];

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function addData(array $data): void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function getData(string $name): mixed
    {
        return $this->data[$name]??'';
    }
}