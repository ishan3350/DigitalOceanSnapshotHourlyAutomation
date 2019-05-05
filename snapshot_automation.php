<?php

//change default time zone
 date_default_timezone_set('US/Eastern');
 
 
$apiUrl="https://api.digitalocean.com/v2/";

$token = "Your DigitalOcean Token";

$dropletId="Your DigitalOcean DropletID";

//listing all snapshots
 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . 'droplets/' . $dropletId . '/snapshots');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if ($result) {
            //print_r($result->snapshots);
                        
                        //get the snapshot id
                         $snapshot_id= $result->snapshots[0]->id; 
                         //get snapshot name
                         $snapshot_name= $result->snapshots[0]->name; 


        }
       
        
             
//echo $snapshot_id;
//echo $snapshot_name;
    

//get the date and time of old snapshot
$snapshot_time = strtotime($snapshot_name);

//get current date and time
$current_time =  strtotime(date("Y/m/d h:i:sa"));

// check difference between current time an last snapshot time in minutes
$time_difference = ($current_time - $snapshot_time)/60;

$time_difference = round($time_difference);

//echo $time_difference;

// if snapshot id is empty that means no snapshot exist 
if(empty($snapshot_id))
{
    // no snapshots exist
    
    //creating new snapshot
    
    echo "no snapshots found. Creating new snapshot";
    $data = array("type" => "snapshot", "name" => date("Y/m/d h:i:sa"));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . 'droplets/' . $dropletId . '/actions');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_exec($ch);
        curl_close($ch);
        
        return;
        
    
}

// if time different is greater than or equal to 60 minutes create new snapshot and delete old snapshot
if($time_difference>=60)
{
    // if it has been already an hour create a new snapshot and delete old snapshot
    
    
    //creating new snapshot
    
    $data = array("type" => "snapshot", "name" => date("Y/m/d h:i:sa"));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . 'droplets/' . $dropletId . '/actions');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_exec($ch);
        curl_close($ch);
        
        
        //deleting old snapshot
        
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl . 'images/' . $snapshot_id);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_exec($ch);
            curl_close($ch);
        
        
        
        
        
        
}
else
{
    echo "Snapshot is already taken ".$time_difference. " minutes before";
    return;
}

        


?>