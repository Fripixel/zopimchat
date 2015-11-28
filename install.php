<?php

$layouts = $this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE code = 'zopimchat' ");

$layouts = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout");
 
if ($layouts->num_rows > 0) {
     foreach ($layouts->rows as $layout) {
		 $this->db->query(" INSERT ". DB_PREFIX ."layout_module SET layout_id = " . $layout['layout_id'] . ", position = 'content_bottom', code = 'zopimchat' ");    	
    }
}

?>