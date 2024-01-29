<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\AccommodationClientData;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Traits\FileUploadTrait;

class FormProcessController extends MyFrontController {

    use FileUploadTrait;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        $Name = $request->get('full_name');
        $Email = $request->get('email');
        $Address = $request->get('address');
        $Phone = $request->get('phone');
        $Message = $request->get('message');
        if ($Name == '') {
            $return['status'] = "error";
            $return['msg'] = "Full Name is required";
            return response()->json([$return]);
        }
        if ($Email == '') {
            $return['status'] = "error";
            $return['msg'] = "Email is required";
            return response()->json([$return]);
        }
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $return['status'] = "error";
            $return['msg'] = "Invalid Email";
            return response()->json([$return]);
        }
        if ($Message == '') {
            $return['status'] = "error";
            $return['msg'] = "Message is required";
            return response()->json([$return]);
        }
        $subject = 'Scott Ferguson - Contact Form Details';
        $boundary = str_replace(' ', '', 'scottfergusonformalwear.com.au') . date("ymd");
        $message = '';
        $message.="Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n";
        $message.="Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message.= "<br/><h4><u>Contact Form Details </u></h4><br/>\r\n";
        foreach ($_POST as $key => $value) {
            if ($key == "submit" || $key == "_token") {
                continue;
            }
            if (!empty($value)) {
                $message.= "<b>" . ucfirst(str_replace("_", " ", $key)) . ": </b> " . $value . "<br/>";
            }
        }
        $message.="<br/><br/>--" . $boundary . "--\r\n";
        $headers = 'X-Mailer: PHP/' . phpversion() . "\r\n";
        $headers.='MIME-Version: 1.0' . "\r\n";
        $headers.="From: " . $Name . " <noreply@scottfergusonformalwear.com.au>\r\n";
        $headers.="Reply-To: " . $Name . " <" . $Email . ">\r\n";
        $headers.="Content-Type: multipart/related; \r\n\tboundary=\"" . $boundary . "\"\r\n\r\n";
//        mail($this->data['settings']->email, $subject, $message, $headers);
//        mail('limited.sky710@gmail.com', $subject, $message, $headers);
         Mail::send([], [], function($send_mail) use ($subject, $message,$Name) {
          $send_mail->from('noreply@scottfergusonformalwear.com.au', $Name)
          ->to($this->data['settings']->email, 'Scott Ferguson')
          ->bcc('limited.sky710@gmail.com', 'superadmin')
          ->subject($subject)
          ->setBody($message, 'text/html');
          });
        $insert = new Inquiry;
        $insert->name = $Name;
        $insert->email = $Email;
        $insert->address = $Address;
        $insert->phone = $Phone;
        $insert->message = $Message;
        $insert->ip_address = $_SERVER['REMOTE_ADDR'];
        $insert->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'No User Agent';
        $insert->save();
        $return['status'] = "success";
        $return['msg'] = "Message Sent Successfully...";
        return response()->json([$return]);
    }



}
