<?php
private $noPre = array(); //1
private $noOn = array(); //2
private $shPre = array(); //3
private $shOn = array(); //4
private $shConPre = array(); //5
private $shConOn = array(); //6

public function basketShipping($id, $pr_id, $amount) //id numer w koszyku pr_id id zakupionego przedmiotu amoun ilosc
{
    $product_tab = 'product_tab';
    if (isset($_SESSION['paid_mod'])) { // pre or on
        $_SESSION['paid_mod'] == 1 ? $paid_mod = 1 : $paid_mod = 0;
    } else {
        $paid_mod = 0; // domyslne pre
    }
    
    $con = $this->connectDB();
    $q = $con->query("SELECT * FROM `".$product_tab."` WHERE `id` = '".$pr_id."'");/*zwraca false jeśli tablica nie istnieje*/
    $q = $q->fetch(PDO::FETCH_ASSOC);
    unset ($con);
    $mod = $q['shipping_mod']; // Pr or Su
    
    if ($mod == 0) { // supplier setup
        $con = $this->connectDB();
        $k = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `weight_of` <= ".$q['weight']." AND `weight_to` >= ".$q['weight']."");
        $k = $k->fetch(PDO::FETCH_ASSOC);
        unset ($con);
        if ($k) { // if weight
            $this->noPre[] = (float)$k['price_prepaid'] * $amount;//cena w sumie no share
            $this->noOn[] = (float)$k['price_ondelivery'] * $amount;//cena w sumie no share
            if ($k['package_share'] == 1) {
                $max = (int)$k['max_item_in_package'];
                $a = 0;
                while( $amount > 0) {
                    $amount = $amount - $max;
                    $a++;
                }
                (int)$am = $a;
                $this->shPre[] = (float)$k['price_prepaid'] * $am;//cena w sumie with share
                $this->shOn[] = (float)$k['price_ondelivery'] * $am;//cena w sumie with share
                
                if ($k['connect_package'] == 1) {
                    if (! array_key_exists($k['price_prepaid'], $this->shConPre)) {
                        $this->shConPre[$k['price_prepaid']] = (int)$amount; // cena => ilosc
                    } else {
                        $this->shConPre[$k['price_prepaid']] += (int)$amount; // cena => ilosc
                    }
                    
                    if (! array_key_exists($k['price_ondelivery'], $this->shConOn)) {
                        $this->shConOn[$k['price_ondelivery']] = (int)$amount; // cena => ilosc
                    } else {
                        $this->shConOn[$k['price_ondelivery']] += (int)$amount; // cena => ilosc
                    }
                }
            }
        } else {
            $con = $this->connectDB();
            $d = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `price_of` <= ".$q['product_price']." AND `price_to` >= ".$q['product_price']."");
            $d = $d->fetch(PDO::FETCH_ASSOC);
            unset ($con);
            if ($d) {
                $this->noPre[] = (float)$d['price_prepaid'] * $amount;//cena w sumie no share
                $this->noOn[] = (float)$d['price_ondelivery'] * $amount;//cena w sumie no share
                if ($d['package_share'] == 1) {
                    $max = (int)$d['max_item_in_package'];
                    $a = 0;
                    while( $amount > 0) {
                        $amount = $amount - $max;
                        $a++;
                    }
                    (int)$am = $a;
                    $this->shPre[] = (float)$d['price_prepaid'] * $am;//cena w sumie with share
                    $this->shOn[] = (float)$d['price_ondelivery'] * $am;//cena w sumie with share
                    
                    if ($d['connect_package'] == 1) {
                        if (! array_key_exists($d['price_prepaid'], $this->shConPre)) {
                            $this->shConPre[$d['price_prepaid']] = (int)$amount; // cena => ilosc
                        } else {
                            $this->shConPre[$d['price_prepaid']] += (int)$amount; // cena => ilosc
                        }
                        
                        if (! array_key_exists($d['price_ondelivery'], $this->shConOn)) {
                            $this->shConOn[$d['price_ondelivery']] = (int)$amount; // cena => ilosc
                        } else {
                            $this->shConOn[$d['price_ondelivery']] += (int)$amount; // cena => ilosc
                        }
                    }
                }
            } else {
                $con = $this->connectDB();
                $f = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `configuration_mod` = 'simple'");
                $f = $f->fetch(PDO::FETCH_ASSOC);
                //var_dump($f);
                unset ($con);
                if ($f) {
                    $this->noPre[] = (float)$f['price_prepaid'] * $amount;//cena w sumie no share
                    $this->noOn[] = (float)$f['price_ondelivery'] * $amount;//cena w sumie no share
                    if ($f['package_share'] == 1) {
                        $max = (int)$f['max_item_in_package'];
                        $a = 0;
                        while( $amount > 0) {
                            $amount = $amount - $max;
                            $a++;
                        }
                        (int)$am = $a;
                        $this->shPre[] = (float)$f['price_prepaid'] * $am;//cena w sumie with share
                        $this->shOn[] = (float)$f['price_ondelivery'] * $am;//cena w sumie with share
                        if ($f['connect_package'] == 1) {
                            if (! array_key_exists($f['price_prepaid'], $this->shConPre)) {
                                $this->shConPre[$f['price_prepaid']] = (int)$amount; // cena => ilosc
                            } else {
                                $this->shConPre[$f['price_prepaid']] += (int)$amount; // cena => ilosc
                            }
                            
                            if (! array_key_exists($f['price_ondelivery'], $this->shConOn)) {
                                $this->shConOn[$f['price_ondelivery']] = (int)$amount; // cena => ilosc
                            } else {
                                $this->shConOn[$f['price_ondelivery']] += (int)$amount; // cena => ilosc
                            }
                        }
                    }
                } else {
                    // ???
                }
            }
        }
    } elseif ($mod == 1) { // own setup
        // prepaid
        if ($q['allow_prepaid'] == 1) {
            $this->noPre[] = (float)$q['price_prepaid'] * $amount;//cena w sumie no share;
        }
        // on delivery
        if ($q['allow_ondelivery'] == 1) {
            $this->noOn[] = (float)$q['price_ondelivery'] * $amount;//cena w sumie no share;
        }
        // calculate amount for package share
        if ($q['package_share'] == 1) {
            $max = (int)$q['max_item_in_package'];
            $a = 0;
            while( $amount > 0) {
                $amount = $amount - $max;
                $a++;
            }
            (int)$am = $a;
            $this->shPre[] = (float)$q['price_prepaid'] * $am;//cena w sumie with share
            $this->shOn[] = (float)$q['price_ondelivery'] * $am;//cena w sumie with share
            // calculate amount for connect package
            if ($q['connect_package'] == 1) {
                if (! array_key_exists($q['price_prepaid'], $this->shConPre)) {
                    $this->shConPre[$q['price_prepaid']] = (int)$amount; // cena => ilosc
                } else {
                    $this->shConPre[$q['price_prepaid']] += (int)$amount; // cena => ilosc
                }
                
                if (! array_key_exists($q['price_ondelivery'], $this->shConOn)) {
                    $this->shConOn[$q['price_ondelivery']] = (int)$amount; // cena => ilosc
                } else {
                    $this->shConOn[$q['price_ondelivery']] += (int)$amount; // cena => ilosc
                }
                /*tu cos powinno byc - to z elsifa matki $pre i $on powinny wynosic co inneg albo 0*/
                /*jesli to sie wykonyje to rodzic elseif nie powinien sie dodac*/
            }
        }
    }
    /*amount*/
    // if (! $q['connect_package'] == 1) {
        // if ($paid_mod == 0) { // prepaid
            // $add = $pre*$amount;
            // $this->sum_shipping[] = $add;
            // return $add;
        // } elseif ($paid_mod == 1) { // on delivery
            // $add = $on*$amount;
            // $this->sum_shipping[] = $add;
            // return $add;
        // }
    // } else {
        // // co ?
    // }
}