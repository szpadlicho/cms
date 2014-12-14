<?php
        include_once '../classes/connect/load.php';
        $load = new Connect_Load;
        $load->__setTable('index_pieces');
        $q = $load->loadIndex();
        $product_now_display='15';
        
        eval('?>'.$q['php_beafor_html'].'<?php ');
        eval('?>'.$q['html_p1'].'<?php ');
        //--
        $load->__setTable('product_tab');
        $meta = $load->metaDataProduct($product_now_display);
        //--
        $load->__setTable('setting_seo');
        $global = $load->globalMetaData();
        //--
        if ($meta['product_title']!=null) {
            echo '<title>'.$meta['product_title'].'</title>';
        } else {
            echo '<title>'.$global['global_title_product'].'</title>';
        }
        
        if ($meta['product_description']!=null) {
            echo '<meta name="description" content="'.$meta['product_description'].'" />';
        } else {
            echo '<meta name="description" content="'.$global['global_description_product'].'" />';
        }
        
        if ($meta['product_keywords']!=null) {
            echo '<meta name="keywords" content="'.$meta['product_keywords'].'" />';
        } else {
            echo '<meta name="keywords" content="'.$global['global_keywords_product'].'" />';
        }
        //---
        eval('?>'.$q['head_include'].'<?php ');
        eval('?>'.$q['head_p1'].'<?php ');
        eval('?>'.$q['html_p2'].'<?php ');
        //here
        eval('?>'.$q['html_p3'].'<?php ');
        eval('?>'.$q['html_p4'].'<?php ');
        ?>