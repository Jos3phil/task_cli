<?php


class task 
{
    public static int $counter = 0;
    public int $id;
    public string $description;
    public string $status = "todo";        
    //add date of create and update
    public string $createAt;
    public string $updatedAt;

    public function __construct(string $name)
    {   
        self::$counter++;
        $this->id = self::$counter;
        $this->name = $name;      
        $this->createAt = date("Y-m-d H:i:s");  
        $this->updatedAt = date("Y-m-d H:i:s");
    }
    public function markAsDone()
    {
       
        $this->status = "done";
        $this->updatedAt = date("Y-m-d H:i:s");
    }
    public function markAsInProgress()
    {
        
        $this->status = "in-progress";
        $this->updatedAt = date("Y-m-d H:i:s");
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
