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
                public function __setTable($tab_name)
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
            }
            $load = new ConnectCls();
            $load->__setTable('index_pieces');
            $q = $load->loadIndex();
            
            eval('?>'.$q['php_beafor_html'].'<?php ');
            eval('?>'.$q['html_p1'].'<?php ');
            eval('?>'.$q['head_title'].'<?php ');
            eval('?>'.$q['head_description'].'<?php ');
            eval('?>'.$q['head_keywords'].'<?php ');
            eval('?>'.$q['head_include'].'<?php ');
            eval('?>'.$q['head_p1'].'<?php ');
            eval('?>'.$q['html_p2'].'<?php ');
            //here
            $category_now_display='PS 3';
            eval('?>'.$q['html_p3'].'<?php ');
            eval('?>'.$q['html_p4'].'<?php ');
            ?>