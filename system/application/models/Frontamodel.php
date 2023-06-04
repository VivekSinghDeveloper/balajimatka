<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Frontamodel extends CI_Model {

	public function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	public function getData($tb){
		return $this->db->get($tb)->result();
	}
	
	function getDataSelectBy($tb,$select,$by,$order_type)
	{
		$this->db->select($select);
		$this->db->order_by($by, $order_type);
		return $this->db->get($tb)->result();
	}
	 function getDataSelectBy_where($tb,$select,$by,$order_type,$where)
	{
		$this->db->select($select);
		$this->db->order_by($by, $order_type);
		return $this->db->get_where($tb,$where)->result();
	}
   
	function getDataSelectBy1($tb,$select,$by,$order_type,$group_by)
	{
		$this->db->select($select);
		
		$this->db->group_by($group_by);
		$this->db->order_by($by, $order_type);
		return $this->db->get($tb)->result();
	}
	
	function get_data_batch ($tb,$id,$status)
	{
		$this->db->select('batch_id, batch_name');
		$this->db->where('status', $status);
		$this->db->where('find_in_set("'.$id.'", subject_id) <> 0');
		return $this->db->get($tb)->result();
	}
	
	public function getDataRow($tb){
		return $this->db->get($tb)->row();
	}
		
	function get_data($tb,$where_array)
	{
		return $this->db->get_where($tb,$where_array)->result();
	}
	function get_data_offset($tb,$start,$end)
	{
		
		$this->db->limit($end,$start);
		return $this->db->get($tb)->result();
	}
	
	function get_data_where($tb,$where_array)
	{
		$this->db->where($where_array);
		return $this->db->get($tb)->result();
	}
	
	function get_data_or_where_row($tb,$where,$where2)
	{
		$this->db->where($where);	
		$this->db->or_where($where2);	
		return $this->db->get($tb)->row();
	}
	
	function get_data_one_with($tb,$by)
	{
		$this->db->limit("1");
		$this->db->order_by($by, "desc");
		return $this->db->get($tb)->result();
	}
	
	function get_data_like($tb,$like_col,$search_value)
	{
		$this->db->like($like_col,$search_value);
		return $this->db->get($tb)->result();
	}
	
	
	public function get_like_desc_scroll($tb, $columns,$by,$start,$end,$like_col,$search_value)	{
		
		$this->db->select($columns);
		$this->db->limit($end,$start);
		$this->db->order_by($by, "desc");
		$this->db->like($like_col,$search_value);
		return $this->db->get($tb)->result();
	}
	
	function getDataSelect($tb,$select)
	{
		$this->db->select($select);
		return $this->db->get($tb)->result();
	}
	function getDataSelectByWhere($tb,$select,$by,$order_type,$where_array)
	{
		$this->db->select($select);
		$this->db->order_by($by, $order_type);
		return $this->db->get_where($tb,$where_array)->result();
	}
	function getDataWhereDesc($tb, $where_array, $by)
	{	
		$this->db->order_by($by, "desc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	public function get_data_desc($tb,$where,$by,$limit)
	{
		$this->db->limit($limit);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($tb,$where)->result();
	}
	
	function get_data_select($tb,$where_array,$select)
	{
		$this->db->select($select);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_select_type($tb,$where_array,$select,$by,$type)
	{
		$this->db->select($select);
		$this->db->order_by($by, $type);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_select3where($tb,$where,$where2,$where3,$select)
	{
		$this->db->select($select);
		$this->db->where($where3);
		$this->db->or_where($where);
		$this->db->or_where($where2);
		return $this->db->get($tb)->result();
	}
	
	function get_trend_post($tb,$where_array,$select,$by,$limit)
	{
		$this->db->limit($limit);
		$this->db->order_by($by, "desc");
		$this->db->select($select);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	
	function get_data_multiple_select($tb,$where_array,$select)
	{
		$this->db->select($tb.".*")->select('('.$select.') as ch',FALSE);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	
	public function get_data_row($tb,$where){
		return $this->db->get_where($tb,$where)->row();
		
	}
	
	public function get_data_or_where($tb,$where,$where2)
	{
		$this->db->where($where);
		$this->db->or_where($where2);
		return $this->db->get($tb)->result();
		
	}
	
	public function get_data_in_where($tb,$where,$where2)
	{
		$this->db->where($where);
		$this->db->or_where($where2);
		return $this->db->get($tb)->result();
		
	}
	
	public function get_data_or_where_select($tb,$where,$where2,$select)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->or_where($where2);
		return $this->db->get($tb)->result();
		
	}
	
	public function get_data_where_select_asc($tb,$where,$where2,$select,$by)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->where($where2);
		$this->db->order_by($by, "asc");
		return $this->db->get($tb)->result();
		
	}
	
	public function get_data_in_where_select($tb,$where,$where2,$select)
	{
		$this->db->select($select);
		$this->db->where($where);
		$this->db->where_in($where2);
		return $this->db->get($tb)->result();
		
	}
	
	public function get_data_or_where_select_main($tb,$where2,$select,$main_where)
	{
		$this->db->select($select);
		$this->db->where($where2);
		return $this->db->get_where($tb,$main_where)->result();
		
		
	}
	
	function getDataLatest($tb,$by)
	{	
		$this->db->order_by($by, "asc");
		return $this->db->get($tb)->result();
	}
	
	function getDataLatestWhere($tb, $where_array, $by)
	{	
		$this->db->order_by($by, "asc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_latest_where_asc($tb,$where_array,$by,$select)
	{
		$this->db->select($select);
		$this->db->order_by($by, "asc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_latest_where_asc_limit($tb,$where_array,$by,$select,$start,$end)
	{
		$this->db->select($select);
		$this->db->limit($end,$start);
		$this->db->order_by($by, "asc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_latest_where_desc($tb,$where_array,$by,$select)
	{
		$this->db->select($select);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_latest_where_random($tb,$where_array,$by,$select)
	{
		$this->db->select($select);
		$this->db->order_by($by, "random");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	
	public function get_joins_where($table, $columns, $joins,$where)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_where_desc($table, $columns, $joins,$where,$by)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where)->result();
	}
	public function get_joins_where_asc($table, $columns, $joins,$where,$by)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		

		$this->db->order_by($by, "asc");
		return $this->db->get_where($table,$where)->result();
	}
	
	
	public function get_joins_where_asc_game($table, $columns, $joins,$where,$by)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		
		$this->db->where('WEEKOFYEAR(result_date) = WEEKOFYEAR(NOW())-1', NULL, FALSE);
		$this->db->order_by($by, "asc");
		return $this->db->get_where($table,$where)->result();
	}
	
	
	public function get_joins_where_desc_random($table, $columns, $joins,$where,$by)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->order_by($by, "random");
		$this->db->limit(10);
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_where_desc_scroll($table, $columns, $joins,$where,$by,$start,$end)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->limit($end,$start);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_where_scroll($table, $columns, $joins,$where,$start,$end)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->limit($end,$start);
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_where_desc_scroll($table, $columns,$where,$by,$start,$end)	{
		
		$this->db->select($columns);
		$this->db->limit($end,$start);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where)->result();
	}
	public function get_joins_where_type_scroll($table, $columns, $joins,$where,$by,$start,$end,$type)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->limit($end,$start);
		$this->db->order_by($by, $type);
		return $this->db->get_where($table,$where)->result();
	}
	
	
	public function get_joins_where_like($table, $columns, $joins,$where,$like,$by)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->like('product_name',$like);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_where_group($table, $columns, $joins,$where,$group_by)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->group_by($group_by);
		return $this->db->get_where($table,$where)->result();
	}
	public function get_joins_where_group_distinct($table, $columns, $joins,$where,$group_by)	{
		$this->db->distinct();
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->group_by($group_by);
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_group_by_where($table, $columns, $joins, $by ,$group_by,$where)
	{
		$this->db->select($columns);	
		
		if (is_array($joins) && count($joins) > 0){			
			foreach($joins as $k => $v){	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}
		$this->db->order_by($by, "desc");
		$this->db->group_by($group_by);	
	
		return $this->db->get_where($table,$where)->result();
	}
	public function get_joins_group_by_asc($table, $columns, $joins, $by ,$group_by,$where)
	{
		$this->db->select($columns);	
		
		if (is_array($joins) && count($joins) > 0){			
			foreach($joins as $k => $v){	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}
		$this->db->order_by($by, "asc");
		$this->db->group_by($group_by);	
	
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_group_where($table, $columns, $joins,$group_by,$where,$where2)
	{
		$this->db->select($columns);	
		if (is_array($joins) && count($joins) > 0){			
			foreach($joins as $k => $v){	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}
		//$this->db->group_by($group_by);	
		$this->db->where($where);	
		$this->db->or_where($where2);	
	
		return $this->db->get($table)->result();
	}
	
	public function get_joins_group_where_custom_by($table, $columns, $joins,$group_by,$where,$by)
	{
		$this->db->select($columns);	
		if (is_array($joins) && count($joins) > 0){			
			foreach($joins as $k => $v){	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}
		$this->db->group_by($group_by);
		$this->db->order_by($by, "desc");		
		$this->db->where($where);	
	
		return $this->db->get($table)->result();
	}
	
	
	public function get_joins_trending_post($table, $columns, $joins,$where,$by,$limit)
	{
		$this->db->select($columns);	
		
		if (is_array($joins) && count($joins) > 0){			
			foreach($joins as $k => $v){	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}
		$this->db->order_by($by, "desc");
		$this->db->limit($limit);	
	
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_where_desc_scroll_custom($table, $columns, $joins,$where,$by,$start,$end,$type)	{
		
		$this->db->select($columns);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->limit($end,$start);
		$this->db->order_by($by, $type);
		return $this->db->get_where($table,$where)->result();
	}
	
	public function get_joins_where_row($table , $columns, $joins, $where)
	{
		$this->db->select($columns);	
		if (is_array($joins) && count($joins) > 0){			
			foreach($joins as $k => $v){	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}	
		return $this->db->get_where($table,$where)->row();
	}
	
	function allDataCountWhere($tb,$where)
    {   
        $query = $this->db->get_where($tb,$where);
		return $query->num_rows();  

    }
	
	function data_search($sql)
    {		
		$query = $this->db->query($sql);		
        
		if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
	
	function data_search_count($sql)
    {
		$query = $this->db->query($sql);
        return $query->num_rows();
    }
	
	function get_data_one_with_select($tb,$by,$select)
	{
		$this->db->select($select);
		$this->db->limit("1");
		$this->db->order_by($by, "desc");
		return $this->db->get($tb)->result();
	}
	
	public function get_joins_where_team_select($table, $columns, $joins,$where,$select2,$group_by)
	{
		$this->db->select($columns)->select('('.$select2.') as total_ph',FALSE);
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);
			}
		}
		$this->db->group_by($group_by);
		return $this->db->get_where($table,$where)->result();
	}
	
	function get_data_select_group_by($tb,$where_array,$select,$group_by)
	{
		$this->db->select($select);
		$this->db->group_by($group_by);
		return $this->db->get_where($tb,$where_array)->result();
	}
	function getSubjectNameByIDS($ids,$table,$select)
	{
		$this->db->select($select);
		$this->db->where_in('subject_id',$ids);
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
	}
	
	public function updateSetDataAddAmount($tb,$where,$col,$amount)
	{
		$this->db->where($where);
		$this->db->set($col, $col.'+'.$amount, FALSE);
		$this->db->update($tb);
	}

	public function updateSetDataIsSeen($tb,$where,$col,$value)
	{ 
		$this->db->where($where);
		$this->db->set($col, $value);
		$this->db->update($tb);
	}
	
	function custom_query($query)
	{
		$query = $this->db->query($query);
		$result = $query->result();
		return $result;
	}
	
	public function get_joins_group_by($table, $columns, $joins,$by, $group_by,$where=null)	
	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		$this->db->order_by($by, "desc");
		$this->db->group_by($group_by); 
		if($where!=null)
		{
			$this->db->where($where); 
		}
		return $this->db->get($table)->result();
	}
	public function updateSetDataMinusAmount($tb,$where,$col,$amount)
	{
		$this->db->where($where);
		$this->db->set($col, $col.'-'.$amount, FALSE);
		$this->db->update($tb);
	}
	function getJodiDigitSell($tb,$by,$where_array,$select,$group_by,$number)
	{
		$this->db->select($select);
		$this->db->order_by($by, "desc");
		$this->db->like('digits ',$number,'after');
		$this->db->group_by($group_by);	
		return $this->db->get_where($tb,$where_array)->result();
	}
}
