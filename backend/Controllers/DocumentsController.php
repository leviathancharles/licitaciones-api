<?php

require_once('Models\OfferDocuments.php');
class DocumentsController {


    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
        require_once('config/server.php');
        new connectionDb();
    }
    public function list($idOffert)
    {
        try {
                $documents = OfferDocuments::where('licitacion_id', $idOffert);
                $countDocuments = $documents->count();
                if($countDocuments > 0){
                    $documents = $documents->get();
                    $response = $this->responseMessage(200, 'Success', $documents);
                    echo $response;
                }else{
                    $response = $this->responseMessage(404, 'Not Found');
                }
        } catch (\Exception $e) {
            $response = $this->responseMessage(500, 'Error');
        }
        echo $response;
    }

    public function saveDocument($idOffert)
    {
        $response = "";
        try {
            if(isset($_FILES)){
                $data = $this->validateCamps($_POST);
                $file = $this->validateFiles($idOffert, $_FILES);
                if($file != 0){
                    $data['archivo'] = $file;
                    $data['licitacion_id'] = $idOffert;
                    if(OfferDocuments::create($data)){
                        $response = $this->responseMessage(200, 'Success');
                    }
                }else{
                    $response = $this->responseMessage(500, 'No se pudo guardar');
                }
            }else{
                $response = $this->responseMessage(404, 'Not Found');
            }
        } catch (\Exception $e) {
            $response = $this->responseMessage(500, 'Error');
        }
        echo $response;

    }

    public function validateCamps($data)
    {
        $campsArray = ['titulo','descripcion'];
        $info = array();
        
        foreach($data as $campo => $valor){
            if(!in_array($campo, $campsArray)){
                return 0;
            }
            $info[$campo]= $valor; 
        }
        return $info;
    }
    public function validateFiles($idOffert, $data)
    {
        $file = $data['archivo'];
        //Detalles del archivo
        $name = $file['name'];
        $temp = $file['tmp_name'];

        $dir ='documents/'.$idOffert."/";
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $url = $dir.basename($name);
        if (move_uploaded_file($temp, $url)) {
            return $url;
        } else {
            return 0;
        }
    }

    public function responseMessage($code, $msg, $data = null)
    {
        $responseArray = array();
        $responseArray['code'] = $code;
        $responseArray['message'] = $msg;
        if(!empty($data)){
            $responseArray['data'] = $data;
        }else{
            $responseArray['data'] = "No hay informacion";
        }
        $response = json_encode($responseArray);
        return $response;
        
    }

}