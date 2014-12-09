<?php
        include_once '../classes/connect/load.php';
        $load = new Connect_Load;
        $load->__setTable('index_pieces');
        $q = $load->loadIndex();
        $category_now_display='Eboki';
        
        eval('?>'.$q['php_beafor_html'].'<?php ');
        eval('?>'.$q['html_p1'].'<?php ');
        //--
        $load->__setTable('product_category_main');
        $meta = $load->metaDataCategory($category_now_display);
        //--
        $load->__setTable('setting_seo');
        $global = $load->globalMetaData();
        //--
        if ($meta['title']!=null) {
            echo '<title>'.$meta['title'].'</title>';
        } else {
            echo '<title>'.$global['global_title_category'].'</title>';
        }
        
        if ($meta['description']!=null) {
            echo '<meta name="description" content="'.$meta['description'].'" />';
        } else {
            echo '<meta name="description" content="'.$global['global_description_category'].'" />';
        }
        
        if ($meta['keywords']!=null) {
            echo '<meta name="keywords" content="'.$meta['keywords'].'" />';
        } else {
            echo '<meta name="keywords" content="'.$global['global_keywords_category'].'" />';
        }
        //---
        eval('?>'.$q['head_include'].'<?php ');
        eval('?>'.$q['head_p1'].'<?php ');
        eval('?>'.$q['html_p2'].'<?php ');
        //here
        eval('?>'.$q['html_p3'].'<?php ');
        eval('?>'.$q['html_p4'].'<?php ');
        ?>