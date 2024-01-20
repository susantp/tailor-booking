<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Schema;
use Carbon\Carbon;
use Mail;
use Session;
//# for excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Faker;
use Hash;

class SwapController extends Controller {

    /**
     * TEST Controller for testing the things.
     * @param Request $request
     * @param type $method
     * @return type
     */
    public function index(Request $request, $method = 'swap', $query = '') {
//        pr('DISPERSE');
        return $this->$method($request, $query);
    }

    /**
     * :: Only Notes here::
     */
    function swap() {
        echo 'DISPERSE';
        ##########::NOTES::##########
        //# database bata aayeko data format garne and list garne >>
//    dd($product->created_at); // matra garyo bhane object aaucha
//    dd($product->created_at->format('Y-m-d H:i:s')); // yo format ma dekhaucha
//    dd($product->created_at->timestamp);// timestamp format ma dehaucha
        //# Route::any('/view/{type?}/{sort?}', ['uses' => 'Frontend\ProductController@view','as' => 'view']); //#ref, deletable
        ##########::NOTES::##########
    }

    #########################################################################################
    #################################::FUNCTIONS DOWN::######################################
    #########################################################################################

    function go() {
        echo 'GET SET GO!';
    }

    function col($request, $table) {
        pr($table);
//        dd( Schema::getColumnListing($table));//# this is also working fine byb!
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        $data = '';
        foreach ($columns as $col) {
            $data .= "'$col',\n";
        }
        dd(substr($data, 0, -5));
    }

    function path() {
        dd(config('site.root'));
    }

    public function userinfo() {
        dd(auth()->user()->name);  //# get the current user info
        return $this->edit();
    }

    /**
     * excel write test
     */
    function xlw() {
// Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
// Set document properties
        $spreadsheet->getProperties()->setCreator('bkesh')
                ->setLastModifiedBy('bkesh')
                ->setTitle('Office 2007 XLSX Swap Document')
                ->setSubject('Office 2007 XLSX Swp Document')
                ->setDescription('Swap document for Office 2007 XLSX, generated using PHP classes.')
                ->setKeywords('office 2007 openxml php')
                ->setCategory('Swap result file');

// Add some data
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Hello')
                ->setCellValue('B2', 'world!')
                ->setCellValue('C1', 'Hello')
                ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A4', 'Miscellaneous glyphs')
                ->setCellValue('A5', 'Things are just weird');

        $spreadsheet->getActiveSheet()
                ->setCellValue('A8', "Hello\nWorld");
        $spreadsheet->getActiveSheet()
                ->getRowDimension(8)
                ->setRowHeight(-1);
        $spreadsheet->getActiveSheet()
                ->getStyle('A8')
                ->getAlignment()
                ->setWrapText(true);

        $value = "-ValueA\n-Value B\n-Value C";
        $spreadsheet->getActiveSheet()
                ->setCellValue('A10', $value);
        $spreadsheet->getActiveSheet()
                ->getRowDimension(10)
                ->setRowHeight(-1);
        $spreadsheet->getActiveSheet()
                ->getStyle('A10')
                ->getAlignment()
                ->setWrapText(true);
        $spreadsheet->getActiveSheet()
                ->getStyle('A10')
                ->setQuotePrefix(true);

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
// Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('bkesh');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="bkesh.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * excel read test
     */
    function xlr() {
        $inputFileType = 'Xlsx';
        $inputFileName = 'excel-sample/example.xlsx';

        /**  Create a new Reader of the type defined in $inputFileType  * */
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Advise the Reader that we only want to load cell data  * */
        $reader->setReadDataOnly(true);
        /**  Load $inputFileName to a Spreadsheet Object  * */
        $spreadsheet = $reader->load($inputFileName);

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
//        dd($sheetData);
        echo '<table width="75%" border="1" cellpadding="10" cellspacing="0">';
        foreach ($sheetData as $km => $vm) {
            if ($km == 1) {
                echo '<tr>';
                foreach ($vm as $k => $v) {
                    ;
                    echo '<td><strong>' . $v . '</strong></td> ';
//                if ($date && $k != 'A' && $v != '') {
//                    echo '<td>' . $this->format_datex($v) . ' </td> ';
//                } else if ($time && $k != 'A' && $v != '') {
//                    echo '<td>' . $this->format_datex($v, 'time') . ' </td> ';
//                } else {
//                    echo '<td>' . ($v) . ' </td> ';
//                }
                }
                echo '</tr>';
            } else {
                echo '<tr>';
                $date = $km == '5' ? true : false;
                $time = $km == '6' ? true : false;
                foreach ($vm as $k => $v) {
                    echo '<td>' . $v . ' </td> ';
//                if ($date && $k != 'A' && $v != '') {
//                    echo '<td>' . $this->format_datex($v) . ' </td> ';
//                } else if ($time && $k != 'A' && $v != '') {
//                    echo '<td>' . $this->format_datex($v, 'time') . ' </td> ';
//                } else {
//                    echo '<td>' . ($v) . ' </td> ';
//                }
                }
                echo '</tr>';
            }
        }
        echo '</table>';
    }

    function format_datex($value, $type = 'date', $process = 'simple') {
        if ($process == 'simple') {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
            if ($type == 'date') {
                $return = date('Y-m-d H:i:s', $date);
            } else {
                $return = date('H:i:s', $date);
            }
        } else {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            $return = $date->date;
        }
        return $return;
    }

    function mailer() {
        $to = "limited.sky710@gmail.com";
        $subject = "hello bouy";
        $txt = "Hello world!";
        $headers = "From: hello@hellohimalayanhomes.com";
        dd(mail($to, $subject, $txt, $headers));
    }

    /**
     * Ref-link:: https://stackoverflow.com/questions/26546824/multiple-mail-configurations
     */
    function mailalter() {
        // Backup your default mailer
        $backup = Mail::getSwiftMailer();
        // Setup your gmail mailer
        $transport = new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
        $transport->setUsername('bkesh.swap@gmail.com');
        $transport->setPassword('tlobdcqppxyvxtbw');
        // Any other mailer configuration stuff needed...
        $gmail = new \Swift_Mailer($transport);
        // Set the mailer as gmail
        Mail::setSwiftMailer($gmail);
        // Send your message
        Mail::send([], [], function($send_mail) {
            $send_mail->from('bikesh.maharjan@idnepal.com', 'Example sender')
                    ->to('limited.sky710@gmail.com', 'bkesh')
                    ->subject('hello swift baby another one')
                    ->setBody('hello siwft body', 'text/html');
        });
        // Restore your original mailer
        Mail::setSwiftMailer($backup);
    }

    function swiftmailer() {
        Mail::send([], [], function($send_mail) {
            $send_mail->from('bikesh.maharjan@idnepal.com', 'Example sender')
                    ->to('limited.sky710@gmail.com', 'bkesh')
                    ->subject('hello swift, you do matter kk ak')
                    ->setBody('hello siwft body', 'text/html');
        });
    }

    function env() {
        $api_url = env('APP_URL') . 'api/media/';
        echo $api_url;
        exit;
    }

    function trunk() {
        //truncate table activity_log;  //# ::ref::
        if (env('APP_URL') == "http://localhost:90/") {
            \App\Models\Resources::truncate();
            \App\Models\PropertyResource::truncate();
            \App\Models\ResourceRolePivot::truncate();
            echo 'done';
        } else {
            echo 'Save it.';
        }
    }

    function nextid() {
        $latest = \App\Models\User::latest('id')->first();
        $id = $latest->id;
        return $id + 1;
    }

    function shell() {
        $a = shell_exec("cd .. && git status 2>&1");
        echo ($a);
    }

    function tap() {
//        pr($user=\App\Models\User::find(7749)->update(['fullname'=>'bkesh cha']));

        $user = \App\Models\User::find(7749);
        $u = tap($user, function($d) {
            $d->update(['fullname' => 'bkesh swapp']);
        });
        pr($u);
    }

    function ap() {
        $products = [
            ['tablets' =>
                ['id' => '1', 'name' => 'Amazon Fire HD', 'price' => '99.99'],
                ['id' => '2', 'name' => 'Samsung Galaxy', 'price' => '149.99'],
                ['id' => '3', 'name' => 'Apple iPad 32GB', 'price' => '499.99'],
            ],
            ['laptops' =>
                ['id' => '11', 'name' => 'Lenovo ThinkPad', 'price' => '299.99'],
                ['id' => '12', 'name' => 'Asus ZenBook', 'price' => '699.99'],
                ['id' => '13', 'name' => 'Microsoft Surface Pro', 'price' => '379.99'],
            ],
        ];

        $laptopNames = array_pluck($products, 'laptops.name');
        pr($laptopNames);
    }

    function roled() {
        DB::table('roles')->delete();
    }

    function pot() {
        $entro_url = \App\Models\PropertyOwner::where('user_id', 7)->get(['entro_url'])->toArray();
        pr($entro_url);
    }

    /**
     * well, this seems working only for update purpose AND STRICTLY NOT for create purpose. :|
     */
    function push() {
        $user = \App\Models\User::find(7774);
//        $user = new \App\Models\User();
        $user->uuid = '9879879';
        $user->username = 'useme';
        $user->fullname = 'go away girl';
        $user->country_id = 90;
        $user->internalUser->uuid = '360969';
        $user->internalUser->street_address = 'fry me';
        $user->internalUser->phone = '360969';
        pr($user->push());
    }

    function lastday() {
//        $lastDateOfThisMonth =strtotime('last day of this month') ;
//        $lastDateOfThisMonth =new Carbon('last day of this month');
        $lastDateOfThisMonth = Carbon::parse('2019-02-8')->daysInMonth;
        pr($lastDateOfThisMonth);
    }

    function tenantx() {
        $propertyUnitIds = \App\Models\PropertyUnits::getPropertyUnitsByUser(6157, 'Tenant', 11);
        pr($propertyUnitIds);
    }

    function loopMails() {
        echo 'BAD';
        exit;
        $faker = Faker\Factory::create();
        $loop = 1;
        while ($loop <= 10) {
            $fullname = $faker->title . ' ' . $faker->name;
            $new_password = $faker->password;
            $verification_code = $faker->ean8;
            $email = 'limited.sky710@gmail.com';
            $subject = $faker->realText($faker->numberBetween(10, 100));
            Mail::send('mails.verifyUser', [
                'fullname' => $fullname,
                'email' => $email,
                'password' => $new_password,
                'client_activation_url' => config('app.client_url') . '/login/' . $verification_code,
                'verification_code' => $verification_code
                    ], function ($mail) use ($email, $fullname, $subject) {
                $mail->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $mail->to($email, $fullname);
                $mail->subject(trim($subject));
            });
            $msg = $loop . '. Email Sent to ' . $email . '<br>';
            echo $msg;
            info($msg);
            $loop++;
        }
    }

    /**
     * Fake text generator for test purpose. UI WEB
     * @param type $request
     * @param type $data
     * @return type
     */
    function fake($request, $data) {
        $get = $request->all();
        $data = $data ? $data : 'name';
        $faker = Faker\Factory::create();
        if (isset($get) && array_key_exists('img', $get)) {
            $available = ['abstract', 'animals', 'business', 'cats', 'city', 'food', 'nightlife', 'fashion', 'people', 'nature', 'sports', 'technics', 'transport'];
            $category = in_array($get['img'], $available) ? $get['img'] : $available[array_rand($available)];
            $img = $faker->imageUrl(1200, 800, $category);
            return "<img src='$img'/>";
        }
        return view('swap', ['data' => $faker->$data]);
    }

    /**
     * Fake text generator API for test purpose.
     * @param type $request
     * @param type $data
     * @return type
     */
    function fakeApi($request, $data) {
        $get = $request->all();
        $data = $data ? explode(',', $data) : 'name';
        $data = (array) $data;
        $output = [];
        foreach ($data as $d) {
            $faker = Faker\Factory::create();
            $output[$d] = $faker->$d;
        }
        return $output;
    }

    /**
     * https://fideloper.com/laravel-raw-queries
     */
    function updatepc() {
        pr('NOT NOW');
        $pr = \App\Models\PropertyResource::pluck('id');
        foreach ($pr as $p) {
            $q = DB::select(DB::raw("SELECT p.property_company_id FROM malling.property_resource pr LEFT JOIN property_units pu ON pr.property_unit_id = pu.id LEFT JOIN property p ON pu.property_id = p.id where pr.id=:prid"), array(
                        'prid' => $p,));
            $pcid = ($q[0]->property_company_id);
            print_r(\App\Models\PropertyResource::where('id', $p)->update(['property_company_id' => $pcid]));
        }
    }

    function res() {
        $property_unit_ids = \App\Models\PropertyUnits::getPropertyUnitsByUser(1, \App\Models\User::INTERNAL, 1);
        $rr = \App\Models\Resources::leftJoin('property_resource', 'resources.id', '=', 'property_resource.resource_id')
                        ->leftJoin('resource_roles', 'resource_roles.id', '=', 'property_resource.resource_role_id')
                        ->leftJoin('property_units', 'property_resource.property_unit_id', '=', 'property_units.id')
                        ->whereIn('property_resource.property_unit_id', array_wrap($property_unit_ids))
//                        ->select('resources.full_name','property_resource.property_company_id', DB::raw("(GROUP_CONCAT(DISTINCT resource_roles.name)) as role_names, GROUP_CONCAT( DISTINCT resource_roles.id) as role_ids,(GROUP_CONCAT(DISTINCT property_units.name)) as buildings"))
                        ->select('property_resource.property_company_id', DB::raw("(GROUP_CONCAT(DISTINCT resource_roles.name)) as role_names, GROUP_CONCAT( DISTINCT resource_roles.id) as role_ids,(GROUP_CONCAT(DISTINCT property_units.name)) as buildings"))
                        ->groupBy('property_resource.property_company_id')
                        ->orderBy('property_resource.property_company_id', 'desc')
//                ->where('property_company_id','181')
                        ->get()->toArray();

        $r = \App\Models\Resources::leftJoin('property_resource', 'resources.id', '=', 'property_resource.resource_id')
                        ->leftJoin('resource_roles', 'resource_roles.id', '=', 'property_resource.resource_role_id')
                        ->leftJoin('property_units', 'property_resource.property_unit_id', '=', 'property_units.id')
                        ->whereIn('property_resource.property_unit_id', array_wrap($property_unit_ids))
                        ->select('resources.*', DB::raw("(GROUP_CONCAT(DISTINCT resource_roles.name)) as role_names, GROUP_CONCAT( DISTINCT resource_roles.id) as role_ids,(GROUP_CONCAT(DISTINCT property_units.name)) as buildings"))
                        ->groupBy('resources.id')
                        ->orderBy('resources.id', 'desc')
                        ->get()->toArray();

        pr($r);
    }

    function resnew() {
        $property_unit_ids = \App\Models\PropertyUnits::getPropertyUnitsByUser(1, \App\Models\User::INTERNAL, 1);
        $r = \App\Models\Resources::with(array('propertyResources' => function ($query) {
                                $query->with(array('propertyUnit' => function ($query) {
                                        $query->select('id', 'name');
                                    }))->with(array('propertyCompany' => function ($query) {
                                        $query->select('id', 'name');
                                    }))->with(array('resourceRoles' => function ($query) {
                                        $query->select('id', 'name');
                                    }));
                            }))
                        ->whereHas('propertyResources', function ($query) use($property_unit_ids) {
                            $query->whereIn('property_unit_id', $property_unit_ids);
                        })
                        ->select('id', 'full_name')
//                        ->whereIn('property_resource.property_unit_id', array_wrap($property_unit_ids))
                        ->get()->toArray();
//        return(count($r));
        return($r);
    }

    function propc() {
        $property_unit_ids = \App\Models\PropertyCompany::with(array('propertyResources' => function ($query) {
                                $query->with(array('propertyUnit' => function ($query) {
                                        $query->select('id', 'name');
                                    }))->with(array('resources' => function ($query) {
                                        $query->select('id', 'full_name as name');
                                    }))->with(array('resourceRoles' => function ($query) {
                                        $query->select('id', 'name');
                                    }));
                            }))
                        ->select('id', 'name', 'email')
                        ->where('id', 181)->get()->toArray();
        return($property_unit_ids);
    }

    //NOT SO USEFUL SEEMS
    function propu() {
        $property_unit_ids = \App\Models\PropertyUnits::with(array('propertyResources' => function ($query) {
                                $query->with(array('resources' => function ($query) {
                                        $query->select('id', 'full_name as name');
                                    }))->with(array('resourceRoles' => function ($query) {
                                        $query->select('id', 'name');
                                    }));
                            }))
                        ->select('id', 'name')
                        ->where('id', 345)->get()->toArray();
        return($property_unit_ids);
    }

    function proprr() {
        $property_unit_ids = \App\Models\PropertyUnits::getPropertyUnitsByUser(1, \App\Models\User::INTERNAL, 1);
        $rr = \App\Models\PropertyResource::where('property_company_id', 18)
                        ->leftJoin('property_units', 'property_resource.property_unit_id', '=', 'property_units.id')
                        ->leftJoin('resource_roles', 'property_resource.resource_role_id', '=', 'resource_roles.id')
                        ->select('property_resource.property_unit_id', 'property_units.*', DB::raw("(GROUP_CONCAT(resource_roles.name)) as role_names"))
                        ->whereIn('property_resource.property_unit_id', $property_unit_ids)
                        ->groupBy('property_resource.property_unit_id')
                        ->get()->toArray();
        pr($rr);
    }

    function testdes() {
        return $pr = \App\Models\PropertyResource::where(['property_company_id' => 2222, 'property_unit_id' => 98798, 'resource_id' => 7879, 'resource_role_id' => 987987])->delete();
    }

    /* backup the db OR just a table */

    function back() {
        $this->backup_tables('localhost', 'root', 'root', 'malling', ['users']);
    }

    function backup_tables($host, $user, $pass, $name, $tables = false, $backup_name = false) {
        $mysqli = new mysqli($host, $user, $pass, $name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables = $mysqli->query('SHOW TABLES');
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }
        if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }
        foreach ($target_tables as $table) {
            $result = $mysqli->query('SELECT * FROM ' . $table);
            $fields_amount = $result->field_count;
            $rows_num = $mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $TableMLine = $res->fetch_row();
            $content = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO " . $table . " VALUES";
                    }
                    $content .= "\n(";
                    for ($j = 0; $j < $fields_amount; $j++) {
                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                        if (isset($row[$j])) {
                            $content .= '"' . $row[$j] . '"';
                        } else {
                            $content .= '""';
                        }
                        if ($j < ($fields_amount - 1)) {
                            $content .= ',';
                        }
                    }
                    $content .= ")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                        $content .= ";";
                    } else {
                        $content .= ",";
                    }
                    $st_counter = $st_counter + 1;
                }
            } $content .= "\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        $backup_name = $backup_name ? $backup_name : $name . ".sql";
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        echo $content;
        exit;
    }

    function backup_tablesNOT($host, $user, $pass, $name, $tables = '*') {

        $link = mysql_connect($host, $user, $pass);
        mysql_select_db($name, $link);

        //get all of the tables
        if ($tables == '*') {
            $tables = array();
            $result = mysql_query('SHOW TABLES');
            while ($row = mysql_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        //cycle through
        foreach ($tables as $table) {
            $result = mysql_query('SELECT * FROM ' . $table);
            $num_fields = mysql_num_fields($result);

            $return .= 'DROP TABLE ' . $table . ';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
            $return .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return .= '"' . $row[$j] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }

        //save file
        $handle = fopen('db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql', 'w+');
        fwrite($handle, $return);
        fclose($handle);
    }

    function timezone() {
        pr(date_default_timezone_get());
    }

    function ev() {
        $events_list = \App\Models\Event::selectRaw('events.id,concat(\'Event: \',title) as title,date(start_date_time) as start_date, start_date_time,date(end_date_time) as end_date, end_date_time, category, description')
                        ->orderBy('id', 'desc')->whereIn('id', [1])->first();
        return $events_list->someField;
    }

    function array_values_test() {
        $a['tm'] = 'apple';
        $a['cm'] = 'ball';
        $a['am'] = 'catmandu';
        pr(array_values($a));
    }

    function that($request, $timestamp) {
        pr(Carbon::createFromTimestamp($timestamp, 'Asia/Kathmandu')->toDateTimeString());
    }

    function taskk() {
        dispatch(new \App\Jobs\SendTaskEmail([], \App::getLocale()));
    }
    function pass(){
        return Hash::make('bkesh');
    }

}
