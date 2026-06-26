<?php


require_once('Models\Offerts.php');
class OffertsController {

    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
        require_once('config/server.php');
        new connectionDb();
    }

    public function list()
    {
        try {
            $offerts = Offerts::get();
            $response = $this->responseMessage(200, 'Success', $offerts); 
            echo $response;
        } catch (\Exception $e) {
            $response = $this->responseMessage(500, 'Error del servidor');
            echo $response;
        }
        exit();
    }

    public function create()
    {
        try {
            $activities = $this->getActivities();
            $response = $this->responseMessage(200, 'Success', $activities); 
            echo $response;
        } catch (\Exception $e) {
            $response = $this->responseMessage(500, 'Error del servidor');
            echo $response;
        }
        exit();
    }
    public function save()
    {
        $data = $this->validateCamps($_POST);
        $consecutive = $this->getConsecutive();
        $data['consecutivo'] = $consecutive;
        $data['estado'] = 'creado';
        if(Offerts::create($data)){
            $response = $this->responseMessage(200, 'Success'); 
        }else{
            $response = $this->responseMessage(500, 'Error');
        }
        echo $response;
        exit();
    }

    public function getOffert($id)
    {
        $offert = Offerts::find($id);
        if(!empty($offert)){
            $activities = $this->getActivities();
            $response = $this->responseMessage(200, 'Success', ['offert' => $offert, 'activities' => $activities]); 
        }else{
            $response = $this->responseMessage(404,'No hay información'); 
        }
        echo $response;
        exit();
    }

    public function update($id)
    {
        $offert = Offerts::find($id);

        if(!empty($offert)){
            $data = $this->validateCamps($_POST);
            if($data != 0){
                $data['estado'] = 'actualizado';
                if($offert->update($data)){
                    $response = $this->responseMessage(200, 'Success'); 
                }else{
                    $response = $this->responseMessage(500, 'Error'); 
                }
            }else{
                $response = $this->responseMessage(304, 'No se completado la información'); 
            }
        }else{
            $response = $this->responseMessage(404, 'No hay información relacionada'); 
        }
        echo $response;
        exit();
    }

    public function getConsecutive()
    {
        $dataConsecutive = Offerts::select('consecutivo')->orderBy('id', 'DESC')->first();
        $consecutive = "";
        $year = date('y');
        if(!empty($dataConsecutive)){
            $divData = explode('-', $dataConsecutive->consecutivo);
            if(is_array($divData)){
                //Primer valor es O, el segundo valor es el numero, la idea es obtener el valor absoluto pra limpiar el valor y obtener el numero 
                $numConsecutive = abs($divData[1]);
                $numConsecutive = $numConsecutive+1;
                $consecutive = "O-000".$numConsecutive."-".$year;
            }
        }else{
            $consecutive = "O-0001-".$year;
        }
        return $consecutive;
    }
    public function validateCamps($data)
    {
        $campsArray = ['objeto','descripcion', 'moneda', 'presupuesto', 'actividad_id', 'fecha_inicio', 'hora_inicio', 'fecha_cierre', 'hora_cierre'];
        $info = array();
        
        foreach($data as $campo => $valor){
            if(!in_array($campo, $campsArray)){
                return 0;
            }
            $info[$campo]= $valor; 
        }
        return $info;
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

    public function getActivities()
    {
        require_once('Models\Activities.php');
        $activities = Activities::select('id', 'segmento');
        $countActivities = $activities->count();
        if($countActivities > 0){
            $activities = $activities->get();
            return $activities;
        }
    }

}