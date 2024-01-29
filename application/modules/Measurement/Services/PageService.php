<?php

namespace Modules\Measurement\Services;

use App\Models\Menu;

class PageService
{
    /**
     * @param Menu $menu
     * @param array $data
     * @return array
     */
    public function getPageData(Menu $menu, array &$data)
    {
        $data['menu'] = $menu;
        $data['page_title'] = "Measurement Guide";
        $data['form_data'] = $this->getFormData();
        $data['page_banner'] = $menu->image ? $menu->image : config('site.page_banner');
        return $data;
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        return [
            "title" => "Measurement Guide/Booking Form",
            "sections" => [
                [
                    "title" => "",
                    "inputs" => [
                        $this->getInput("Booking Date", "booking_date", "col-md-6", "datetime"),
                        $this->getInput("Event or wedding party name", "wedding_or_party_name", "col-md-6"),
                    ]
                ],
                [
                    "title" => "Contact Details",
                    "inputs" => [
                        $this->getInput("First Name", "first_name", "col-md-6"),
                        $this->getInput("Last Name", "last_name", "col-md-6"),
                        $this->getInput("Address", "address", "col-md-8"),
                        $this->getInput("City", "city", "col-md-4"),
                        $this->getInput("Suite/Apt", "suite_apt", "col-md-3"),
                        $this->getInput("Post Code", "post_code", "col-md-3 offset-md-3"),
                        $this->getInput("Phone Number", "phone_number", "col-md-6", "number"),
                        $this->getInput("Driver licence No", "driver_license_no", "col-md-6"),
                        $this->getInput("Email", "email", "col-md-6", "email"),
                        $this->getInput("Verify Email", "verify_email", "col-md-6", "email")
                    ]
                ],
                [
                    "title" => "Measurement Details",
                    "inputs" => [
                        $this->getInput("Neck", "neck", "", "number"),
                        $this->getInput("Chest", "chest", "", "number"),
                        $this->getInput("Arm Length", "arm_length", "", "number"),
                        $this->getInput("Navel", "navel", "", "number"),
                        $this->getInput("Waist", "waist", "", "number"),
                        $this->getInput("Trouser Length", "trouser_length", "", "number"),
                    ]
                ]
            ]
        ];
    }

    /**
     * @param string $label
     * @param string $name
     * @param string $className
     * @param string $type
     * @return string[]
     */
    private function getInput(string $label, string $name, string $className, string $type = "text")
    {
        return [
            "label" => $label,
            "name" => $name,
            "type" => $type,
            "class" => $className
        ];
    }

    /**
     * @return array
     */
    public function getRules()
    {
        $rules = [];
        foreach (array_get($this->getFormData(), 'sections') as $section) {
            foreach (array_get($section, 'inputs') as $input) {
                $ruleString = 'required';
                switch ($input['type']){
                    case "number":
                        $ruleString .= "|integer";
                        break;
                    case "datetime":
                        $ruleString .= "|date";
                        break;
                    case "email":
                        $ruleString .= "|email";
                        break;
                    default:
                }
                $rules[$input['name']] = $ruleString;
            }
        }
        return $rules;
    }
}