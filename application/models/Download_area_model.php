<?php

class Download_area_model extends CI_Model
{
    private $table ='download_area';
    private $id ='download_area.id_download';
    var $column_order = array(null, 'judul','teks','file,','slug'); //field yang ada di table user
	var $column_search = array('judul','teks','file,','slug'); //field yang diizin untuk pencarian 
	var $order = array('tanggal_input' => 'asc'); // default order 

    function __construct()
    {
        $this->table = "download_area";
        parent::__construct();
    }

    function semua_data()
    {
        $this->db->select('
            download_area.*
            ');
        $this->db->from('download_area');
        $this->db->order_by('tanggal_input','desc');
        $query = $this->db->get();
        return $query->result();
	}



    function detail_data($id_download)
    {   $this->db->select('
        download_area.*
        ');
        $query =  $this->db->get_where($this->table, array('id_download' => $id_download));
        return $query->row();
    }

    function input_data($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update_data($data, $id_download)
    {
        $this->db->where('id_download', $id_download);
        $this->db->update($this->table, $data);
    }

    function hapus_data($id_data)
    {
        $this->db->where('id_download', $id_data);
        $this->db->delete($this->table);
    }

     // Datatables

     private function _get_datatables_query()
     {
         $this->db->select('
            download_area.*, 
            ');
         $this->db->from($this->table);
 
         $i = 0;
     
         foreach ($this->column_search as $item) // loop column 
         {
             if($_POST['search']['value']) // if datatable send POST for search
             {
                 
                 if($i===0) // first loop
                 {
                     $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                     $this->db->like($item, $_POST['search']['value']);
                 }
                 else
                 {
                     $this->db->or_like($item, $_POST['search']['value']);
                 }
 
                 if(count($this->column_search) - 1 == $i) //last loop
                     $this->db->group_end(); //close bracket
             }
             $i++;
         }
         
         if(isset($_POST['order'])) // here order processing
         {
             $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
         } 
         else if(isset($this->order))
         {
             $order = $this->order;
             $this->db->order_by(key($order), $order[key($order)]);
         }
     }
 
     function get_datatables()
     {
         $this->_get_datatables_query();
         if($_POST['length'] != -1)
         $this->db->limit($_POST['length'], $_POST['start']);
         $query = $this->db->get();
         return $query->result();
     }
 
     function count_filtered()
     {
         $this->_get_datatables_query();
         $query = $this->db->get();
         return $query->num_rows();
     }
 
     public function count_all()
     {
         $this->db->from($this->table);
         return $this->db->count_all_results();
     }

     function total_file()
     {   
        $this->db->select('
            download_area.*
            ');
        $this->db->from('download_area');
         $query = $this->db->get();
         if($query->num_rows()>0)
         {
           return $query->num_rows();
         }
         else
         {
           return 0;
         }
     }


}

?>
