<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('address_model');  
        $this->load->model('auth_model');  
        $this->load->library('csvimport');  
        $this->load->model('setting_model');     
    }

    public function update_orderinfo() {
        $user_id = $this->session->userdata('logged_in')['users_id'];
        $data = array(
            'setting_order' => $this->input->get('order'),            
        );        
        $this->auth_model->update(array('id' => $user_id), $data);
		echo json_encode(array("status" => TRUE));
    }

    /**
     * address Page
     */
    public function index() {        
        
        $list = $this->setting_model->getAllList();
        $title = [];        
        foreach($list as $item)
        {
            $title[] = $item->name;            
        }
        
        
        $data = array(
            'data' => $list,
            'param' => $title,            
        );
        //var_dump($data);
        $this->load->view('address/index',$data);
    }

    public function settinginfo() {
        $row = $this->address_model->get_by_id_from_person();
        $data = explode(',',$row->settings);

        $user_id = $this->session->userdata('logged_in')['users_id'];
        $user = $this->auth_model->get_by_id($user_id);
        if($user->setting_order == null || $user->setting_order == '' || strlen($user->setting_order)==0)
            $user->setting_order = '0,2,3,4,5,6,7,8,1,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40';
        
        $param = array(
            'data' => $data,
            'order' => $user->setting_order
        );
        echo json_encode($param);
    }

    public function savesetting() {
        $idx = $this->input->get('idx');
        $data = array(
            'settings' => $idx,                 
        );
        $this->auth_model->update(array('id' => $this->session->userdata('logged_in')['users_id']), $data);
        echo json_encode(array("status" => TRUE));
    }
    /**
     * Get address list
     */
    public function ajax_list()
    {
        $list = $this->address_model->getAddress();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {            
            $no++;
            $row = array();
            
            $row[] = $person->identify;
            $row[] = $person->street_number;
            $row[] = $person->street_name;
            //$row[] = $person->street_suffix;
            $row[] = $person->city;
            $row[] = $person->state;
            $row[] = $person->zipcode;
            $row[] = $person->data_addtime;
            $row[] = $person->data_starttime;
            $xml = $person->xml;
            
            if($xml != '' && strlen($xml)!= 0) {
                $xml = simplexml_load_string($xml);
                $xml = json_decode(json_encode($xml),true);            
                
                $row[] = isset($xml['response']['results']['result']['zpid'])?$xml['response']['results']['result']['zpid']:'';//zpid
                $row[] = isset($xml['response']['results']['result']['links']['homedetails'])?$xml['response']['results']['result']['links']['homedetails']:'';//homedetails
                $row[] = isset($xml['response']['results']['result']['links']['graphsanddata'])?$xml['response']['results']['result']['links']['graphsanddata']:'';//graphsanddata
                $row[] = isset($xml['response']['results']['result']['links']['mapthishome'])?$xml['response']['results']['result']['links']['mapthishome']:'';//mapthishome
                $row[] = isset($xml['response']['results']['result']['links']['comparables'])?$xml['response']['results']['result']['links']['comparables']:'';//comparables
                $row[] = isset($xml['response']['results']['result']['address']['latitude'])?$xml['response']['results']['result']['address']['latitude']:'';//latitude
                $row[] = isset($xml['response']['results']['result']['address']['longitude'])?$xml['response']['results']['result']['address']['longitude']:'';//longitude
                $row[] = isset($xml['response']['results']['result']['FIPScounty'])?$xml['response']['results']['result']['FIPScounty']:'';//FIPScounty
                $row[] = isset($xml['response']['results']['result']['useCode'])?$xml['response']['results']['result']['useCode']:'';//useCode
                $row[] = isset($xml['response']['results']['result']['taxAssessmentYear'])?$xml['response']['results']['result']['taxAssessmentYear']:'';//taxAssessmentYear
                $row[] = isset($xml['response']['results']['result']['taxAssessment'])?('$'.number_format($xml['response']['results']['result']['taxAssessment'],2)):'';//taxAssessment
                $row[] = isset($xml['response']['results']['result']['yearBuilt'])?$xml['response']['results']['result']['yearBuilt']:'';//yearBuilt
                $row[] = isset($xml['response']['results']['result']['lotSizeSqFt'])?$xml['response']['results']['result']['lotSizeSqFt']:'';//lotSizeSqFt
                $row[] = isset($xml['response']['results']['result']['finishedSqFt'])?$xml['response']['results']['result']['finishedSqFt']:'';//finishedSqFt
                $row[] = isset($xml['response']['results']['result']['bathrooms'])?$xml['response']['results']['result']['bathrooms']:'';//bathrooms
                $row[] = isset($xml['response']['results']['result']['bedrooms'])?$xml['response']['results']['result']['bedrooms']:'';//bedrooms
                $row[] = isset($xml['response']['results']['result']['totalRooms'])?$xml['response']['results']['result']['totalRooms']:'';//totalRooms
                $row[] = isset($xml['response']['results']['result']['lastSoldDate'])?$xml['response']['results']['result']['lastSoldDate']:'';//lastSoldDate
                $row[] = isset($xml['response']['results']['result']['lastSoldPrice'])?('$'.number_format($xml['response']['results']['result']['lastSoldPrice'])):'';//lastSoldPrice
                $row[] = isset($xml['response']['results']['result']['zestimate']['amount'])?('$'.number_format($xml['response']['results']['result']['zestimate']['amount'])):'';//amount
                $row[] = isset($xml['response']['results']['result']['zestimate']['last-updated'])?$xml['response']['results']['result']['zestimate']['last-updated']:'';//last-updated
                $row[] = isset($xml['response']['results']['result']['zestimate']['oneWeekChange']['@attributes']['deprecated'])?$xml['response']['results']['result']['zestimate']['oneWeekChange']['@attributes']['deprecated']:'';//oneWeekChange

                $valueChanged = isset($xml['response']['results']['result']['zestimate']['valueChange'])?$xml['response']['results']['result']['zestimate']['valueChange']:'';//valueChange
                if($valueChanged != '') {
                    if($valueChanged > 0)
                    {
                        $valueChanged = "<span style='color:#5cb85c;'>$$valueChanged</span>";
                    } else {
                        $valueChanged = "<span style='color:#dd4b39;'>$$valueChanged</span>";
                    }
                }
                $row[] = $valueChanged;
                
                $row[] = 30;    //duration
                $row[] = 'USD'; //currency

                $row[] = isset($xml['response']['results']['result']['zestimate']['valuationRange']['low'])?$xml['response']['results']['result']['zestimate']['valuationRange']['low']:'';//valuationRange_low
                $row[] = isset($xml['response']['results']['result']['zestimate']['valuationRange']['high'])?$xml['response']['results']['result']['zestimate']['valuationRange']['high']:'';//valuationRange_high
                $row[] = isset($xml['response']['results']['result']['zestimate']['percentile'])?$xml['response']['results']['result']['zestimate']['percentile']:'';//percentile
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['zindexValue'])?('$'.$xml['response']['results']['result']['localRealEstate']['region']['zindexValue']):'';//zindexValue
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['links']['overview'])?$xml['response']['results']['result']['localRealEstate']['region']['links']['overview']:'';//overview
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['links']['forSaleByOwner'])?$xml['response']['results']['result']['localRealEstate']['region']['links']['forSaleByOwner']:'';//forSaleByOwner
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['links']['forSale'])?$xml['response']['results']['result']['localRealEstate']['region']['links']['forSale']:'';//forSale
            } else {
                for($k=0;$k<32;$k++)
                    $row[] = '';                
            }
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_address('."'".$person->id."'".')">Edit</a>
                      <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="delete_address('."'".$person->id."'".')">Delete</a>';
                      //<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="view_address('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> View</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->address_model->count_all(),
            "recordsFiltered" => $this->address_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //Get address by id
    public function ajax_edit($id)
    {
        $data = $this->address_model->get_by_id($id);
        echo json_encode($data);
    }    

    public function ajax_update()
	{
		$data = array(
            'street_number' => $this->input->post('street_number'),
            'street_name' => $this->input->post('street_name'),
            'street_suffix' => $this->input->post('street_suffix'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'zipcode' => $this->input->post('zipcode'),
            'data_addtime' => date('Y-m-d'),
            'full_address' => $this->input->post('full_address'),
            'identify'  => $this->input->post('identify'),
		);
		$this->address_model->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
    }
    
    public function ajax_add()
	{
		$data = array(
				'street_number' => $this->input->post('street_number'),
				'street_name' => $this->input->post('street_name'),
				'street_suffix' => $this->input->post('street_suffix'),
				'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zipcode' => $this->input->post('zipcode'),
                'data_addtime' => date('Y-m-d'),
                'full_address' => $this->input->post('full_address'),
                'identify'  => $this->input->post('identify'),
			);
		$insert = $this->address_model->save($data);
		echo json_encode(array("status" => TRUE));
    }
    
    public function ajax_delete($id)
	{
		$this->address_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
    }
    
    public function get_address_info()
    {
        $row = [];
        $list = $this->address_model->getTotalAddress();
        foreach ($list as $item) {            
            $row[] = $item->id;
        }
        
        echo json_encode($row);
    }

    public function update_address_info($id)
    {
        //sleep(1);
        //echo json_encode(array("status" => TRUE));
        $result = $this->address_model->getApiData($id);
        echo json_encode(array("status" => TRUE));
    }

    //get address detail info
    public function ajax_addgree_info($id)
    {
        $data = $this->address_model->get_by_id($id);
        $rt = simplexml_load_string($data->xml);
        $rt = json_decode(json_encode($rt),true);
        echo json_encode($rt);
    }

    /**
     * import csv
     */
    public function import()
    {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        $user_id = $this->session->userdata('logged_in')['users_id'];
        foreach($file_data as $row)
        {
            $data[] = array(
                    'street_number' => $row["Street Number"],
                    'street_name'  => $row["Street Name"],
                    'city'   => $row["City"],
                    'state'   => $row["State"],
                    'zipcode'   => $row["ZipCode"],
                    'data_addtime' => date('Y-m-d'),
                    'user_id' => $user_id,
                    'identify'  => $row['Identify'],
                    'full_address' => sprintf('%s %s, %s, %s, USA',$row["Street Number"],$row["Street Name"],$row["City"],$row["State"]),
            );
        }
        $this->address_model->insert_csv($data);
        echo json_encode(array('status' => TRUE));
    }

    /**
     * export csv
     */
    public function export()
    {
        $user = $this->address_model->get_by_id_from_person();
        $idx = $user->settings;
        $list = $this->address_model->getTotalAddress();

        $list = $this->setting_model->getAllList();
        $title = [];
        foreach($list as $item)
        {
            $title[] = $item->name;
        }

        $settings = $title;//['Identify','Street Number','Street Name','City','State','zipcode','Regist','Start Time','zpid','homedetails','graphsanddata','mapthishome','comparables','latitude','longitude','FIPScounty','useCode','taxAssessmentYear','taxAssessment','yearBuilt','lotSizeSqFt','finishedSqFt','bathrooms','bedrooms','totalRooms','lastSoldDate','lastSoldPrice','amount','last-updated','oneWeekChange','valueChange','Duration','Currency','lowPrice','highPrice','percentile','zindexValue','overview','forSaleByOwner','forSale'];
        $filename = 'export_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        foreach ($list as $person) {            
        
            $row = array();
            $row[] = $person->identify;
            $row[] = $person->street_number;
            $row[] = $person->street_name;
            //$row[] = $person->street_suffix;
            $row[] = $person->city;
            $row[] = $person->state;
            $row[] = $person->zipcode;
            $row[] = $person->data_addtime;
            $row[] = $person->data_starttime;
            $xml = $person->xml;
            if($xml != '' && strlen($xml)!= 0) {
                $xml = simplexml_load_string($xml);        
                $xml = json_decode(json_encode($xml),true);            
                $row[] = isset($xml['response']['results']['result']['zpid'])?$xml['response']['results']['result']['zpid']:'';//zpid
                $row[] = isset($xml['response']['results']['result']['links']['homedetails'])?$xml['response']['results']['result']['links']['homedetails']:'';//homedetails
                $row[] = isset($xml['response']['results']['result']['links']['graphsanddata'])?$xml['response']['results']['result']['links']['graphsanddata']:'';//graphsanddata
                $row[] = isset($xml['response']['results']['result']['links']['mapthishome'])?$xml['response']['results']['result']['links']['mapthishome']:'';//mapthishome
                $row[] = isset($xml['response']['results']['result']['links']['comparables'])?$xml['response']['results']['result']['links']['comparables']:'';//comparables
                $row[] = isset($xml['response']['results']['result']['address']['latitude'])?$xml['response']['results']['result']['address']['latitude']:'';//latitude
                $row[] = isset($xml['response']['results']['result']['address']['longitude'])?$xml['response']['results']['result']['address']['longitude']:'';//longitude
                $row[] = isset($xml['response']['results']['result']['FIPScounty'])?$xml['response']['results']['result']['FIPScounty']:'';//FIPScounty
                $row[] = isset($xml['response']['results']['result']['useCode'])?$xml['response']['results']['result']['useCode']:'';//useCode
                $row[] = isset($xml['response']['results']['result']['taxAssessmentYear'])?$xml['response']['results']['result']['taxAssessmentYear']:'';//taxAssessmentYear
                $row[] = isset($xml['response']['results']['result']['taxAssessment'])?('$'.number_format($xml['response']['results']['result']['taxAssessment'],2)):'';//taxAssessment
                $row[] = isset($xml['response']['results']['result']['yearBuilt'])?$xml['response']['results']['result']['yearBuilt']:'';//yearBuilt
                $row[] = isset($xml['response']['results']['result']['lotSizeSqFt'])?$xml['response']['results']['result']['lotSizeSqFt']:'';//lotSizeSqFt
                $row[] = isset($xml['response']['results']['result']['finishedSqFt'])?$xml['response']['results']['result']['finishedSqFt']:'';//finishedSqFt
                $row[] = isset($xml['response']['results']['result']['bathrooms'])?$xml['response']['results']['result']['bathrooms']:'';//bathrooms
                $row[] = isset($xml['response']['results']['result']['bedrooms'])?$xml['response']['results']['result']['bedrooms']:'';//bedrooms
                $row[] = isset($xml['response']['results']['result']['totalRooms'])?$xml['response']['results']['result']['totalRooms']:'';//totalRooms
                $row[] = isset($xml['response']['results']['result']['lastSoldDate'])?($xml['response']['results']['result']['lastSoldDate']):'';//lastSoldDate
                $row[] = isset($xml['response']['results']['result']['lastSoldPrice'])?('$'.number_format($xml['response']['results']['result']['lastSoldPrice'])):'';//lastSoldPrice
                $row[] = isset($xml['response']['results']['result']['zestimate']['amount'])?('$'.number_format($xml['response']['results']['result']['zestimate']['amount'])):'';//amount
                $row[] = isset($xml['response']['results']['result']['zestimate']['last-updated'])?$xml['response']['results']['result']['zestimate']['last-updated']:'';//last-updated
                $row[] = isset($xml['response']['results']['result']['zestimate']['oneWeekChange']['@attributes']['deprecated'])?$xml['response']['results']['result']['zestimate']['oneWeekChange']['@attributes']['deprecated']:'';//oneWeekChange
                $row[] = isset($xml['response']['results']['result']['zestimate']['valueChange'])?('$'.$xml['response']['results']['result']['zestimate']['valueChange']):'';//valueChange
                $row[] = 30;    
                $row[] = 'USD'; 
                $row[] = isset($xml['response']['results']['result']['zestimate']['valuationRange']['low'])?$xml['response']['results']['result']['zestimate']['valuationRange']['low']:'';//valuationRange_low
                $row[] = isset($xml['response']['results']['result']['zestimate']['valuationRange']['high'])?$xml['response']['results']['result']['zestimate']['valuationRange']['high']:'';//valuationRange_high
                $row[] = isset($xml['response']['results']['result']['zestimate']['percentile'])?$xml['response']['results']['result']['zestimate']['percentile']:'';//percentile
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['zindexValue'])?('$'.$xml['response']['results']['result']['localRealEstate']['region']['zindexValue']):'';//zindexValue
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['links']['overview'])?$xml['response']['results']['result']['localRealEstate']['region']['links']['overview']:'';//overview
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['links']['forSaleByOwner'])?$xml['response']['results']['result']['localRealEstate']['region']['links']['forSaleByOwner']:'';//forSaleByOwner
                $row[] = isset($xml['response']['results']['result']['localRealEstate']['region']['links']['forSale'])?$xml['response']['results']['result']['localRealEstate']['region']['links']['forSale']:'';//forSale
            } else {
                for($k=0;$k<32;$k++)
                    $row[] = '';                
            }
                        
            $data[] = $row;
        }

        $idx = explode(',',$idx);
        $header = [];
        for($i=0; $i<sizeof($idx); $i++) {
            $header[] = $settings[$idx[$i]];
        }

        $file = fopen('php://output','w');
        fputcsv($file,$header);

        $csv_row = [];
        for($i=0; $i<sizeof($data); $i++)
        {
            $item = $data[$i];
            $row = [];
            for($k=0; $k<sizeof($item);$k++) {
                if(in_array($k,$idx))
                    $row[] = $item[$k];
            }
            fputcsv($file,$row); 
        }        
        fclose($file); 
        exit; 
    }
}
