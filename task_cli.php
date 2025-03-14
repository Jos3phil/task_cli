<?php


class task 
{
    public static int $counter = 0;
    public int $id;
    public string $name;
    public string $status = "not done";        
    
    public function __construct(string $name)
    {   
        self::$counter++;
        $this->id = self::$counter;
        $this->name = $name;        
    }
    public function markAsDone()
    {
       
        $this->status = "done";
    }
    public function markAsInProgress()
    {
        
        $this->status = "in progress";
    }   
    public function __destruct()
    {
        unset($this->id);
    }
    // Para serialización JSON
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status
        ];
    }
}
