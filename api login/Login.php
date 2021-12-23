<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json;");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    function msg($success,$status,$message,$extra=[]){
        return array_merge([
            'success'=>$success,
            'status'=>$status,
            'message'=>$message
        ],$extra);
    }

    require __DIR__.'/Classes/DataBase.php';
    require __DIR__.'/Classes/JWTHandeller.php';

    $db_connection=new DataBase();
    $conn=$db_connection->Connection();

    $data=json_decode(file_get_contents("php://input"));

    $returnData=[];

    if($_SERVER["REQUEST_METHOD"]!="POST"):
        $returnData=msg(0,404,"Page Not Found !");
    
    elseif(
        !isset($data->email) ||
        !isset($data->password) ||
        empty($data->email) ||
        empty($data->password)
    ):
        $fields=['fields'=>['email','password']];
        $returnData=msg(0,422,"Pleas Fill all The Required Fields !",$fields);

    else:
        $email=trim($data->email);
        $password=trim($data->password);

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)):
            $returnData=msg(0,422,'Invalid Email Forma !');
        
        elseif(strlen($password)<8):
            $returnData=msg(0,422,'Your Password must be at least 8 characters !');

        else:
            try{

                $fetch_user='SELECT * FROM admin WHERE email=:email and password=:pass';
                $query_stmt=$conn->prepare($fetch_user);
                $query_stmt->bindValue(':email',$email,PDO::PARAM_STR);
                $query_stmt->bindValue(':pass',$password,PDO::PARAM_STR);
                

                $query_stmt->execute();

                if($query_stmt->rowCount()):
                    $returnData=[
                        'success'=>1,
                        'message'=>'You Have successfully logged in .',
                        'email'=>$email
                    ];

                else:
                    $returnData=msg(0,422,"Invalid Email Or Password !");
                endif;

            }
            catch(PDOException $e)
            {
                $returnData=msg(0,500,$e->getMessage());
            }

        endif;
    endif;
    echo json_encode($returnData);

?>