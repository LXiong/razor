<?php
class getpagedata extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/common','common');
		$this->load->model('api/getpagedatamodel','pagedata');
	}

	function index()
	{
		if (! isset ( $_POST ["content"] ))
		{

			$ret = array (
					'flag' => -1,
					'msg' => 'Invalid content.'
			);
			echo json_encode ( $ret );
			return;
		}
		$activeinfo = $_POST ["content"];
		log_message ( "debug", $activeinfo );
		$content = json_decode($activeinfo);
		$verify=$this->common->verifParameter($content,$info=array('sessionkey','productid','startdate','enddate'));
		if($verify['flag']<=0)
		{
			echo json_encode($verify);
			return;
		}
		if(isset($content->version))
		{
			$ret=$this->pagedata->getdatapagedata($content->sessionkey,$content->productid,$content->startdate,$content->enddate,$content->version);
		}
		else
		{
			$ret=$this->pagedata->getdatapagedata($content->sessionkey,$content->productid,$content->startdate,$content->enddate,$version=null);
				
		}
		echo json_encode($ret);
	}
}