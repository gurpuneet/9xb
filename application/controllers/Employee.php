<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller
{

	public function __construct()
	{
        parent::__construct();
        $this->load->model("employee_model");
    }
	public function index()
	{
		$dataResults = $this->fetchRecords();    // Fetch already entered data from db
		$dataArray['employee_count'] = $dataResults['count'];
		$dataArray['employee_list'] = $dataResults['employee_records'];
		
		$this->load->view('employee', $dataArray);
	}
	public function newRecord()
	{
		$this->employee_model->insert_record();
		redirect('/employee/', 'refresh');
	}
	public function fetchRecords()
	{
		$model_results = $this->employee_model->select_records();

		if($model_results['count']!='0')
		{
			$returnArray['count'] = $model_results['count'];
			$returnArray['employee_records'] = $model_results['list'];
		}
		else
		{
			$returnArray['count'] = $model_results['count'];
			$returnArray['employee_records'] = '';
		}

		return $returnArray;
	}
	public function deleteRecord($param)
	{
		$empid = $param;

		$model_data['empid'] = $empid;
		$this->employee_model->delete_records($model_data);
		redirect('/employee/', 'refresh');
	}
}
?>