<?php

  // if($_GET['reference'] = "") {

  //   header("location: index.php");
  // }

  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$_GET['reference'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_fd20ca4e220a38750623dcd5bb9b39ab3c484336",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    
    $row = json_decode($response);
  }

    if ($row->data->status == 'success') {

        $status = $row->data->status;
        $reference = $row->data->reference;
        $fname = $row->data->customer->first_name;
        $lname = $row->data->customer->last_name;
        $email = $row->data->customer->email;
        $fulname = $fname . ' ' . $lname;
        date_default_timezone_get();
        $date_time = date('m/d/Y h:i:s a', time());

        require 'dbconnect.php';

        $db = new dbconnect();
        $query = "INSERT INTO paystack(id, full_name, email, statuss, reference, date_purchased) 
                  VALUES('', :full_name, :email, :statuss, :reference, :date_purchased)";

        $stmt = $db->connector()->prepare($query);

        $stmt->bindParam(':full_name', $fulname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':statuss', $status);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':date_purchased', $date_time);

        $stmt->execute();

        if(!$stmt) {

          echo 'Your code has problem';
        } else {

            header("Location: success.php?status=success");
        }
    } else {

      header("Location: error.html");
    }
 
?>