<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['firstname']) && isset($_POST['lastname']) &&
        isset($_POST['username']) && isset($_POST['emailaddress']) &&
        isset($_POST['password']) && isset($_POST['phonenumber']) &&
        isset($_POST['country']) && isset($_POST['accountnumber']) &&
        isset($_POST['bankname'])) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $emailaddress = $_POST['emailaddress'];
        $password = $_POST['password'];
        $phonenumber = $_POST['phonenumber'];
        $country = $_POST['country'];
        $accountnumber = $_POST['accountnumber'];
        $bankname = $_POST['bankname'];
        

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "epiz_33216162_epaycash";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $epiz_33216162_epaycash);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(firstname, lastname, username, emailaddress, password, phonenumber, country, accountnumber, bankname) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssssisis",$firstname, $lastname, $username, $emailaddress, $password, $phonenumber, $country, $accountnumber, $bankname);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>