<?php
if( isset( $_GET[ 'Login' ] ) ) {
    // CWE-20: Improper Input Validation
        // Get username
        $user = $_GET[ 'username' ];
        // Get password
        $pass = $_GET[ 'password' ];
        // CWE-326: Inadequate Encryption Strength
        // CWE-327: Use of a Broken or Risky Cryptographic Algorithm
	    // CWE-328: Use of Weak Hash
        $pass = md5( $pass );
        // CWE-257: Storing Passwords in a Recoverable Format
        // CWE-89 : Improper Neutralization of Special Elements used in an SQL Command ('SQL Injection')
        // CWE-306: Missing Authentication for Critical Function
        // CWE-307: Improper Restriction of Excessive Authentication Attempts
        // CWE-799: Improper Control of Interaction Frequency
        // Check the database
        $query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
        // CWE-312: Cleartext Storage of Sensitive Information
        // CWE-319: Cleartext Transmission of Sensitive Information
        $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
        // CWE-209: Information Exposure Through an Error Message
        if( $result && mysqli_num_rows( $result ) == 1 ) {
                // Get users details
                $row    = mysqli_fetch_assoc( $result );
                $avatar = $row["avatar"];
                // Login successful
                $html .= "<p>Welcome to the password protected area {$user}</p>";
                $html .= "<img src=\"{$avatar}\" />";
        }
        else {
                // Login failed
                $html .= "<pre><br />Username and/or password incorrect.</pre>";
        }
        ((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
}
?>
