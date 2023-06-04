<?php

class Adminamodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	function allDataCount($tb)
    {   
        $query = $this->db->get($tb);
		return $query->num_rows();  

    }
	
	function getDataSelect($tb,$select)
	{
		$this->db->select($select);
		return $this->db->get($tb)->result();
	}
	
	function allDataCountWhere($tb,$where)
    {   
        $query = $this->db->get_where($tb,$where);
		return $query->num_rows();  

    }
	function allDataCountGroupBy($tb,$group_by)
    {   
		$this->db->group_by($group_by);
        $query = $this->db->get($tb);
		return $query->num_rows();  

    }
	function allDataLimitOrderBy($tb,$limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($tb);
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }	
	
	function data_search($sql)
    {
        /* $query = $this
                ->db
                ->like('id',$search)
                ->or_like('title',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get($tb); */
				
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
	
	
	function getJodiDigitSell($tb,$by,$where_array,$select,$group_by,$number)
	{
		$this->db->select($select);
		$this->db->order_by($by, "desc");
		$this->db->like('digits ',$number,'after');
		$this->db->group_by($group_by);	
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function custom_search($sql)
    {
        
				
		$query = $this->db->query($sql);		
       
            return $query->result();  
        
    }
	
	
	function data_search_count($sql)
    {
        /* $query = $this
                ->db
                ->like('id',$search)
                ->or_like('title',$search)
                ->get($tb); */
		$query = $this->db->query($sql);
        return $query->num_rows();
    } 
   
	function getDataSelectBy($tb,$select,$by,$order_type)
	{
		$this->db->select($select);
		$this->db->order_by($by, $order_type);
		return $this->db->get($tb)->result();
	}
	
	function getDataWhereSelectBy($tb,$select,$where,$by,$order_type)
	{
		$this->db->select($select);
		$this->db->order_by($by, $order_type);
		return $this->db->get_where($tb,$where)->result();
	}
	
	function getData($table)
	{	
		return $this->db->get($table)->result();
	}
	
	//get data by where 
	function get_data($tb,$where_array)
	{
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_select($tb,$where_array,$select)
	{
		$this->db->select($select);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_row($tb,$where_array)
	{
		return $this->db->get_where($tb,$where_array)->row();
	}
	
	function get_data_row_select($tb,$where_array,$select,$group_by=null)
	{
		$this->db->select($select);
		if($group_by!=null)
		$this->db->group_by($group_by); 
		return $this->db->get_where($tb,$where_array)->row();
	}
	
	//get data by where 
	function get_data_latest_where($tb,$by,$where_array)
	{
		$this->db->order_by($by, "desc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	function get_data_latest_where_asc($tb,$by,$where_array)
	{
		$this->db->order_by($by, "asc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_latest_where_desc($tb,$where_array,$by,$select)
	{
		$this->db->select($select);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_where_desc_limit($tb,$by,$where_array,$limit)
	{
		$this->db->order_by($by, "desc");
		$this->db->limit($limit);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	function get_data_where_in($tb,$field,$ids,$where)
	{
		$this->db->where_in($field, $ids);
		return $this->db->get_where($tb,$where)->result();
	}
	
	function getDataLatest($table,$by)
	{	
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result();
	}
	
	function getDataLatestArray($table,$by)
	{	
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result_array();
	}
	
	function getDataLimitDesc($table, $by, $limit)
	{	
		$this->db->order_by($by, "desc");
		$this->db->limit($limit);
		return $this->db->get($table)->result();
	}
	
	function getDataLatestAsc($table,$by)
	{	
		$this->db->order_by($by, "asc");
		return $this->db->get($table)->result();
	}
	
	function getDataLatestDesc($table,$by)
	{	
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result();
	}
	
	function getDataLimitOfset($table, $columns, $limit, $ofset)
	{	
		$this->db->select($columns);
		$this->db->limit($limit,$ofset);
		return $this->db->get($table)->result();
	}
	
	public function getJoinData($table, $columns, $joins)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		return $this->db->get($table)->result();
	}
	
	public function get_joins($table, $columns, $joins, $by)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{				
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result();
	}
	
	public function get_joins_asc($table, $columns, $joins, $by)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{				
			foreach($joins as $k => $v)	
			{
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		$this->db->order_by($by, "asc");
		return $this->db->get($table)->result();
	}
	
	public function get_joins_limit($table, $columns, $joins, $by, $limit)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		$this->db->limit($limit);
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result();
	}
	
	public function get_joins_latest_pagi($table, $columns, $joins, $by,$limit, $offset)	{
		$this->db->select($columns);	
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}	
		$this->db->limit($limit,$offset);
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result();
	}
	
	public function get_joins_where($table, $columns, $joins, $where)	{
		
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
	
	public function get_joins_where_by($table, $columns, $joins, $by,$where)	{
		
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
	public function get_joins_by($table, $columns, $joins, $by)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		$this->db->order_by($by, "desc");
		return $this->db->get($table)->result();
	}
	
	public function get_joins_where_by_asc($table, $columns, $joins, $by,$where)	{
		
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
	
	public function get_joins_where_by_group_by($table, $columns, $joins, $by,$where,$group_by)	{
		
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
		return $this->db->get_where($table,$where)->result();
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
	
	function get_data_select_group_by($tb,$where_array,$select,$group_by)
	{
		$this->db->select($select);
		$this->db->group_by($group_by);
		return $this->db->get_where($tb,$where_array)->result();
	}
	
	 
	
	public function get_joins_where_group_by($table, $columns, $joins, $where,$group_by)
	{
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
	
	
	
	function get_data_latest_where_asc_select($tb,$by,$where_array,$select)
	{
		$this->db->select($select);
		$this->db->order_by($by, "asc");
		return $this->db->get_where($tb,$where_array)->result();
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
	public function getDataJoinLimitOffsetWhereNotIn($table, $columns, $joins, $where,$by,$limit, $start,$ignore)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->where_not_in('order_status', $ignore);
		
		$this->db->limit($limit, $start);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where)->result();
	}
	
	public function getDataWhereJoinLimitOffset($table, $columns, $joins, $where_array,$where,$by,$limit, $start)	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		if($where!=""){
			$this->db->where($where);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where_array)->result();
	}
	
	public function getDataJoinWhereOrderbyLimitRow($table, $columns, $joins, $where,$by,$limit)
	{
		$this->db->select($columns);	
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		}	
		$this->db->limit($limit);
		$this->db->order_by($by, "desc");
		$query = $this->db->get_where($table,$where);
		if($query->num_rows()>0){
			return $query->row(); 
        }else{
            return null;
        }
	}
	
	public function getDataJoinWhereOrderby($table, $columns, $joins, $where,$by)
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
		return $this->db->get_where($table,$where)->result();
	}
	
	public function getDataJoinWhereOrderbyLimit($table, $columns, $joins, $where,$by,$limit)
	{
		
		$this->db->select($columns);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}	
		$this->db->limit($limit);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($table,$where)->result();
	}
	
	public function getDataJoinWhereCount($table, $columns, $joins, $where)
	{
		$this->db->select($columns)->from($table);	
			
		if (is_array($joins) && count($joins) > 0)	
		{			
			foreach($joins as $k => $v)	
			{	
				
				$this->db->join($v['table'], $v['condition'], $v['jointype'], false);		
			}
		
		}
		$this->db->where($where);
        $totalRows = $this->db->count_all_results();
		return $totalRows;
	}
	
	
	
	function getDataSelectRowWhere($tb,$columns,$where)
	{
		$this->db->select($columns);
		$query = $this->db->get_where($tb,$where);
		if($query->num_rows()>0){
            return $query->row(); 
        }else{
            return null;
        }
	}
	
	function getDataLimitOffset($tb,$select,$where,$by,$limit,$start)
	{
		$this->db->select($select);
		$this->db->limit($limit, $start);
		$this->db->order_by($by, "desc");
		return $this->db->get_where($tb,$where)->result();
	}
	
	public function updateSetDataAddAmount($tb,$where,$col,$amount)
	{
		$this->db->where($where);
		$this->db->set($col, $col.'+'.$amount, FALSE);
		$this->db->update($tb);
	}
	
	public function updateSetDataMinusAmount($tb,$where,$col,$amount)
	{
		$this->db->where($where);
		$this->db->set($col, $col.'-'.$amount, FALSE);
		$this->db->update($tb);
	}
	
}
