<?php
$states = ["done","not done","in progress"];

class task 
{
    public int $id;
    public string $name;
    public string $status = "not done";    
    
    
    public function __construct(string $name)
    {        
        $this->name = $name;        
    }
    



}