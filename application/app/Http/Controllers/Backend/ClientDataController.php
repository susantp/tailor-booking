<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Inquiry;
use App\Models\AccommodationClientData;
use Auth;

class ClientDataController extends Controller {

    use FileUploadTrait;

    protected $fields = [];
    protected $model;
    protected $img_folder;
    protected $module = 'client-data';
    protected $page_title = 'Client Data Management';
    protected $item = 'Data';
    protected $field_id = 'id';
    protected $has_elfinder = true;
    protected $has_ckeditor = true;

    function __construct() {
        $model = new AccommodationClientData;
        $this->fields = $model->getFillable();
        $this->model = $model;
        $this->img_folder = 'client_data';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = $this->essentials();
        $data['button'] = 'Add New ' . $this->item;
//        $data['button_action'] = config('site.admin') . $this->module . '/create';
        $data['fields'] = array('SN', 'Person Name', 'Accommodation Name', 'Type', 'Action','Date');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $sn = ($page != 1) ? (($page - 1) * config('site.per_page') + 1) : 1;
        $data['sn'] = $sn;
        $data['permissions'] = 'XDXV';
//        <--->
        $data['datas'] = AccommodationClientData::orderBy('id')->select('id', 'person_name', 'accommodation_name', 'type','created_at')->paginate(config('site.per_page'));
        return view('backend.partials._list', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = $this->essentials();
        $data['record'] = $d = AccommodationClientData::findorfail($id);
        $data['panel_title'] = 'View ' . $this->item . ' Details form: ' . $d->person_name. ' on date: ' . $d->created_at;
        return view('backend.partials._client_data', $data);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $record = AccommodationClientData::findorfail($id);
        //delete images>>
        $old_logo = json_decode($record['logo'],true);
        $this->deleteOldImage($old_logo[0]);
        $old_attachments = json_decode($record['attachments']);
        foreach($old_attachments as $att){
            $this->deleteOldImage($att);
        }
        //delete images<<
        $record->delete();
        return redirect()->back()->withSuccess($this->item . ' is successfully deleted');
    }

}
