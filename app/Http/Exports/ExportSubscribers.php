<?php

namespace App\Http\Exports;

use App\Models\Subscriber;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportSubscribers 
{
    protected $filename = 'subscribers.csv';

    protected $chunk_number = 600;
    
    protected $fileHandle;
    
    public function export()
    {
        return new StreamedResponse(function () {
            $this->openFile();
            $this->addBomUtf8();
            $this->addContentHeaderInFile();
            $this->processSubscribers();
            $this->closeFile();
            
        }, Response::HTTP_OK, $this->headers());
    }
    
    private function openFile()
    {
        $this->fileHandle = fopen('php://output', 'w');
    }
    
    private function addBomUTf8 (){
        fwrite($this->fileHandle, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));
    }
    
    private function addContentHeaderInFile()
    {
        $columns = ['id', 'firstname', 'lastname', 'email', 'birthday', 'city', 'country'];
        $this->putRowInCsv($columns);
    }
    
    private function processSubscribers()
    {
        Subscriber::chunk($this->chunk_number, function($subscribers){
            $subscribers->each(function($subscriber) {
                $this->addSubscriberLine($subscriber);
            });
        });
    }
    
    private function addSubscriberLine(Subscriber $subscriber)
    {
        $this->putRowInCsv([
            $subscriber->id,
            $subscriber->firstname,
            $subscriber->lastname,
            $subscriber->email,
            $subscriber->birthday,
            $subscriber->city,
            $subscriber->country,
        ]);
    }
    
    private function putRowInCsv (array $data){
        fputcsv($this->fileHandle, $data);
    }
    
    private function closeFile()
    {
        fclose($this->fileHandle);
    }
    
    private function headers()
    {
        return [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$this->filename.'"',
        ];
    }
}
