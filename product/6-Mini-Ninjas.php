<?php
        class ConnectCls{
            private $host='sql.bdl.pl';
            private $port='';
            private $dbname='szpadlic_cms';
            private $charset='utf8';
            private $user='szpadlic_baza';
            private $pass='haslo';
            private $table;// ma miec
            private $row;
            private $path;
            public function _setTable($tab_name)
            {
                $this->table=$tab_name;
            }
            public function connectDB()
            {
                $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
                return $con;
                unset ($con);
            }
            public function loadIndex()
            {
                $con=$this->connectDB();
                $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='1'");/*zwraca false jesli tablica nie istnieje*/
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
            public function metaData($id)
            {
                $con=$this->connectDB();
                $q = $con->query("SELECT `product_title`,`product_description`,`product_keywords` FROM `".$this->table."` WHERE `id`='$id'");/*zwraca false jesli tablica nie istnieje*/
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
            public function globalMetaData()
            {
                $con=$this->connectDB();
                $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='1'");/*zwraca false jesli tablica nie istnieje*/
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
        }
        $load = new ConnectCls();
        $load->_setTable('index_pieces');
        $q = $load->loadIndex();
        
        eval('?>'.$q['php_beafor_html'].'<?php ');
        eval('?>'.$q['html_p1'].'<?php ');
        //--
        $product_now_display='6';
        //--
        $load->_setTable('product_tab');
        $meta = $load->metaData($product_now_display);
        //--
        $load->_setTable('global_setting');
        $global = $load->globalMetaData();
        //--
        if($meta['product_title']!=null)
        {
            echo '<title>'.$meta['product_title'].'</title>';
        }
        else{
            echo '<title>'.$global['global_title_product'].'</title>';
        }
        
        if($meta['product_description']!=null)
        {
            echo '<meta name="description" content="'.$meta['product_description'].'" />';
        }
        else{
            echo '<meta name="description" content="'.$global['global_description_product'].'" />';
        }
        
        if($meta['product_keywords']!=null)
        {
            echo '<meta name="keywords" content="'.$meta['product_keywords'].'" />';
        }
        else{
            echo '<meta name="keywords" content="'.$global['global_keywords_product'].'" />';
        }
        //---
        eval('?>'.$q['head_include'].'<?php ');
        eval('?>'.$q['head_p1'].'<?php ');
        eval('?>'.$q['html_p2'].'<?php ');
        //here
        $product_now_display='6';
        eval('?>'.$q['html_p3'].'<?php ');
        eval('?>'.$q['html_p4'].'<?php ');
        ?>