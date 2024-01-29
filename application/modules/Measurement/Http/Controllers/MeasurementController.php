<?php

namespace Modules\Measurement\Http\Controllers;

use App\Http\Controllers\Frontend\MyFrontController as AppFrontController;
use App\Models\Menu;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Modules\Measurement\Http\Requests\MeasurementRequest;
use Modules\Measurement\Mail\MeasurementSend;
use Modules\Measurement\Services\PageService;

class MeasurementController extends AppFrontController
{
    protected PageService $pageService;

    public function __construct()
    {
        parent::__construct();
        $this->pageService = new PageService();
    }

    /**
     * @return Factory|Application|View|string
     */
    public function index($data = [], Menu $menuData = null)
    {
        if (count($data) > 0 && !is_null($menuData)) {
            $data = $this->pageService->getPageData($menuData, $data);
            return view("measurement::page", $data);
        }
        return "404";
    }

    public function sendEmail(MeasurementRequest $request)
    {
        $request->validate();
        $data = $request->except('_token', 'verify_email');

        Mail::to($this->data['settings']->email, 'Scott Ferguson')->send(new MeasurementSend($data));
        return back()->withInput()->with('success', 'Mail Sent Successfully');
    }
}