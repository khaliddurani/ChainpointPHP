<?php
namespace App\Helpers;
include('Chainpoint.php');
use khaliddurani\ChainpointPHP;


class Checkpointverify {
	/**
     * Instantiate a new contentController instance.
     * to check if the API key is valid or not
     * @return void
     */
    public function __construct() {
      
    }
    /*
     *Apply Chain
     */
    public function applychain($pdfname){
     
      
         $c = new Chainpoint();
         $file=public_path()."/docs/".$pdfname;
         $hashfile=hash_file('sha256', $file);
         $url = '';
         try{
               $hashIdNode= $c->submitData($hashfile);
               $url = $c->serverBaseUrl."/proofs/".$hashIdNode['hashes'][0]['proof_id'];
            }
            catch(\Exception $e){}
         
         
         $arr['hash'] = $hashfile;
         $arr['url'] = $url;
         return $arr;
      
      
    }

    public function verifyproof($proof){
       $c = new Chainpoint();
       return $c->verify($proof);
    }
    
}


