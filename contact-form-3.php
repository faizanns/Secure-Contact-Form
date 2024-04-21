<?php

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    

    $error = $successMessage = "";

    if($_POST) {
        
        if (!$_POST['name']) {
            
            $error .= "An name field is required.<br>";
            
        } else if (!preg_match("/^[a-zA-z ]*$/", $_POST['name']) ) {  
            
            $error .= "The name should have only alphabets and whitespace.<br>";
            
        }
        
        if (!$_POST['email']) {
            
            $error .= "An email address field is required.<br>";
            
        } else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            
            $error .= "The email address is invalid.<br>";
            
        }
        
        if ($_POST['subject'] == "") {
            
            $error .= "The subject field is required.<br>";
            
        }
        
        if (!$_POST['message']) {
            
            $error .= "The content field is required.<br>";
            
        }
        
        if ($error == "") {
            
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            // Create email headers
            $headers .= 'From: '.$_POST['email']."\r\n".
                'Reply-To: '.$_POST['email']."\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $emailTo = "noemail@gmailDoesNotExist.com";

            $subject = $_POST['subject'];
            
            // Compose a simple HTML email message
            $message = '<html>
                <head>
                    <style type="text/css">
                        table, th, td {
                          border: 1px solid black;
                          border-collapse: collapse;
                        }

                        td:first-child{
                            width:20%;
                        }
                        
                        h1{
                            color:#1c1c1c;
                            text-align:center
                        }
                    </style>
                </head>
            <body>';
            $message .= '<h1>Client Message</h1>';
            $message .= '<table style="width:100%">
                            <tr>
                                <th colspan="2">Client Info</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>'.$_POST['name'].'</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>'.$_POST['email'].'</td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td>'.$_POST['company'].'</td>
                            </tr>
                            <tr>
                                <td>Current Website</td>
                                <td>'.$_POST['current_website'].'</td>
                            </tr>
                            <tr>
                                <td>Topic</td>
                                <td>'.$_POST['subject'].'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Message</th>
                            </tr>
                            <tr>
                                <td colspan="2">'.$_POST['message'].'</td>
                            </tr>
                        </table>';
            $message .= '</body></html>';

            if (mail($emailTo, $subject, $message, $headers)) {

                $successMessage = "<div id=\"success-div\">Your message was sent, we'll get back to you ASAP!</div>";

            } else {

                $error = '<div class="alert alert-danger" role="alert">Your message couldn\'t be sent, please try again later!</div>';

            }

        } else {

            $error = "<div id=\"errors-div\"><p>There were error(s) in your form:</p>".$error."</div>";
        }
        
    }

?>

<!DOCTYPE html>

<html lang="en">
    
    <head>
    
        <link rel="stylesheet" href="contact-form-3.css">
        
        
        <script src="jquery.min.js"></script>
    
    </head>
    
    <body>
        
        <div class="container">
            
            <div id="error"><?php echo $error.$successMessage; ?></div>

            <form id="c-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <div class="half-row">
                <p>
                    <label for="name">Your Name&#42;</label>
                </p>

                <input id="name" type="text" name="name" placeholder="Name" value="<?php echo (isset($_POST['name']))?$_POST['name']:'';?>">
            </div>

            <div class="half-row">
                <p>
                    <label for="email">Email Address&#42;</label>
                </p>

                <input id="email" type="text" name="email" placeholder="you@example.com" value="<?php echo (isset($_POST['email']))?$_POST['email']:'';?>">
            </div>

            <div class="half-row">
                <p>
                    <label for="company">Company</label>
                </p>

                <input id="company" type="text" name="company" value="<?php echo (isset($_POST['company']))?$_POST['company']:'';?>">
            </div>

            <div class="half-row">
                <p>
                    <label for="current_website">Current Website</label>
                </p>

                <input id="current_website" type="text" name="current_website" value="<?php echo (isset($_POST['current_website']))?$_POST['current_website']:'';?>">
            </div>

            <div>
                <p>
                    <label for="subject">What can we help you with?&#42;</label>
                </p>

                <select name="subject" id="subject" value="<?php echo (isset($_POST['subject']))?$_POST['subject']:'';?>">
                    <option value="" style="color:gray">Please select</option>
                    <option value="Graphic Design">Graphic Design</option>
                    <option value="Website Design">Website Design</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <p>
                    <label for="message">Message&#42;</label>
                </p>

                <textarea id="message" type="textarea" name="message" rows="6"><?php if(isset($_POST['message'])) { 
                        echo ($_POST['message']); }
                     ?></textarea>
            </div>

            <div>
                <input id="button" class="btn" type="submit">
            </div>

            </form>
            
        </div>
      
    <script type="text/javascript">
        
        
        
        // Changing color of the select input in form
        $(document).ready(function() {
           //$('#subject').css('color','gray');
           $('#subject').change(function() {
              var current = $('#select').val();
              if (current != '') {
                  $('#subject').css('color','black');
              } else {
                  $('#subject').css('color','gray');
              }
           }); 
        });
    
        $("#c-form").submit(function (validateForm) {
            
            $('body').css('background-color','black');
            
            // Initializing Variables With Form Element Values
            var error = "";
            var name = $("#name").val();
            var email = $("#email").val();
            var subject = $("#subject").val();
            var message = $("#message").val();
            
            // Initializing Variables With Regular Expressions
            var name_regex = /^[a-zA-Z ]+$/;
            var email_regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            // Validating Name Field.
            if (name == "") {
                
                error += "The name field is required.<br>"
                
            } else if (!name.match(name_regex)) {
                       
                       error += "The name should have only alphabets and whitespace.<br>";
                       
            }
                       
            // Validating Email Field.
            if (email == "") {
                
                error += "The email address field is required.<br>"
                
            } else if (!email.match(email_regex) || !(email.length > 1 && email.length < 27)) {
                       
                       error += "The email address entered is invalid.<br>";
                       
            }
            
            // Validating Subject Field.
            if (subject == "") {
                
                error += "The selection field is required.<br>";
                
            }
            
            // Validating Message Field.
            if (message == "") {
                
                error += "The message field is required.";
                
            }
            
            if (error != "") {
                
                $("#error").html('<div id="errors-div"><p><strong>There were error(s) in your form:</strong></p>' + error + '</div>');
                
                return false;
                
            } else {
                
                return true;
                
            }
            
        });
      
    </script>

  </body>
</html>