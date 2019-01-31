<?php
    function convertBase64ToImage($base64,$fileOutPut){

        try{
            $file_picture="../images/".$fileOutPut;
            $getBase64=explode(',',$base64);
            $converterBase64=base64_decode($getBase64[1]);
            $file=fopen($file_picture,"wb");
            fwrite($file,$converterBase64);
            fclose($file);
        
        }catch(Exception $e){
            return false;
        }

        return $fileOutPut;
}

?>