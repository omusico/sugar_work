<?php

function generate_xml($real_id)
{
    $realty = new Realty();
    $realty->retrieve($real_id);

    $real_id_out = $realty->id;


    switch ($realty->type_of_realty)
    {
        case 'living':
            /// Россия
            if ($realty->address_country == 'Россия'){
                // Москва   //todo Новостройка, долей во вторичной недвижимости, гаражи
                if($realty->kind_of_realty=='flat' and ($realty->address_city == 'Москва г' or $realty->address_region == 'Московская обл')){


                        if ($realty->operation == 'buying'){
                            $type_realty = 'flats';
                            $type_of_building = 'flats';


                        }elseif($realty->operation == 'rent') {
                            $type_realty = 'rent';
                            $type_of_building = 'rent';
                        }



                }

                // СПБ
                elseif($realty->kind_of_realty=='flat' and ($realty->address_city == 'Санкт-Петербург г' or $realty->address_region == 'Ленинградская обл')){

                    if ($realty->operation == 'buying'){
                        $type_realty = 'flats_spb';
                        $type_of_building = 'flats';

                    }elseif($realty->operation == 'rent') {
                        $type_realty = 'rent_spb';
                        $type_of_building = 'rent';

                    }
                }

                // Регионы
                else {
                        $type_realty = 'region';
                        $type_of_building = 'flats';
                }
            }
            /// Зарубежом
            else {
                $type_realty = 'foreign';
                $type_of_building = 'foreign';
            }
            if ($type_realty=='foreign'){
                $offer_text = 'obj';
            }else {
                $offer_text = 'flat';
            }

            if ($realty->kind_of_realty=='house' and $realty->address_region == 'Московская обл'){
                $type_realty = 'country_house';
                $type_of_building = 'country_houses';
                $offer_text = 'country_house';
            }else if ($realty->kind_of_realty=='house' and $realty->address_region == 'Ленинградская обл'){
                $type_realty = 'country_house_spb';
                $type_of_building = 'country_houses';
                $offer_text = 'country_house';
            }else if ($realty->kind_of_realty=='house' and $realty->address_region != 'Ленинградская обл' and $realty->address_region != 'Московская обл'){
                $type_realty = 'country_house_region';
                $type_of_building = 'country_houses_region';
                $offer_text = 'country_houses_region';
            }

            break;
        case 'not_living':

            // Россия
            if ($realty->address_country == 'Россия'){
                // Москва
                if($realty->address_city == 'Москва г' or $realty->address_region == 'Московская обл'){
                   $type_realty = 'commercial';
                    $offer_text = 'commercial';
                    $type_of_building = 'commercials';
                }
                //СПБ
                elseif($realty->address_city == 'Санкт-Петербург г' or $realty->address_region == 'Ленинградская обл'){
                    $type_realty = 'commercial_spb';
                    $offer_text = 'commercial';
                    $type_of_building = 'commercials';
                }
                // Регионы
                else {
                    $type_realty = 'region_commercial';
                    $offer_text = 'region_commercial';
                    $type_of_building = 'region_commercial';
                }
            }
            // Зарубежом
            else {
                $type_realty = 'foreign_commercial';
                $type_of_building = 'foreign_commercial';
                $offer_text = 'obj';
            }

            break;

        case 'parcel':
            // Россия
            if ($realty->address_country == 'Россия'){
                // Москва
                if($realty->address_city == 'Москва г' or $realty->address_region == 'Московская обл'){
                    $type_realty = 'county_house';
                }
                // СПБ
                elseif($realty->address_city == 'Санкт-Петербург г' or $realty->address_region == 'Ленинградская обл'){
                    $type_realty = 'county_house_spb';
                }
                // Регионы
                else{
                    $type_realty = 'county_house_region';
                }
            }
            $offer_text = 'county_house';
            $type_of_building = 'county_houses';

            break;

    }


    if (!file_exists("custom/kXML/xml/{$_REQUEST['module']}/baza/".$type_realty.".xml"))
    {

        //$dom = new DOMDocument('1.0', 'windows-1251');
        $dom = new DOMDocument('1.0', 'UTF-8');

        $root = $dom->appendChild($dom->createElement($type_of_building));
        $root->setAttribute('xsi:noNamespaceSchemaLocation', $type_realty.'.xsd');
        $root->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        createNode($dom, $root, $realty, $real_id_out, $type_realty,$offer_text);
    }
    else
    {
      //  $dom = new DOMDocument('1.0', 'windows-1251');
        $dom = new DOMDocument('1.0', 'UTF-8');

        //$filestring = file_get_contents('modules/Realty/baza/baza.xml');

        $dom->load("custom/kXML/xml/{$_REQUEST['module']}/baza/".$type_realty.".xml", LIBXML_NOBLANKS);
        //$dom->loadXML($filestring);

        $commerce=$dom->documentElement;

        $xpath = new DOMXPath($dom);

        // We starts from the root element
        $query = '//commerce/offer/id[. = "'.$real_id_out.'"]';

        $entries = $xpath->query($query);

        foreach($entries as $entry)
        {
            $old=$commerce->removeChild($entry->parentNode);
        }




        $root = $dom->getElementsByTagName($type_of_building)->item(0);
        $root->setAttribute('xsi:noNamespaceSchemaLocation', $type_realty.'.xsd');
        $root->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        createNode($dom, $root, $realty, $real_id_out, $type_realty,$offer_text);

    }

    $dom->formatOutput = true;

    if($dom->save("custom/kXML/xml/{$_REQUEST['module']}/baza/".$type_realty.".xml"))
    {
        echo ("\n Файл custom/kXML/xml/{$_REQUEST['module']}/baza/".$type_realty.".xml успешно сохранён\n ");
    }
    else
    {
        echo ("\n Ошибка при сохранении файла custom/kXML/xml/{$_REQUEST['module']}/baza/".$type_realty.".xml \n ");
    }


}


function createNode(DOMDocument $dom, DOMElement $root, Realty $realty, $real_id_out, $type_realty,$offer_text)
{
    $offer = $root->appendChild($dom->createElement($offer_text));

    $id = $offer->appendChild($dom->createElement('id'));
    $id->appendChild($dom->createTextNode($real_id_out));

    $date = $offer->appendChild($dom->createElement('date'));
    $date->appendChild($dom->createTextNode(date("d.m.Y", strtotime($realty->date_modified))));

    switch ($type_realty){
        case 'flats':
            switch ($realty->kind_of_realty)
            {
                case 'flat':
                    $kind_of_realty = 'квартира';
                    break;
                case 'room':
                    $kind_of_realty = 'комната';
                    $rooms= $offer->appendChild($dom->createElement('rooms'));
                    $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
            }
            if ($realty->address_city == 'Москва г'){
                $area_text = 'Москва';
            }else {
                $area_text = 'Московская обл.';
            }
            break;


        case 'rent':
            switch ($realty->kind_of_realty)
            {
                case 'flat':
                    $kind_of_realty = 'квартира';
                    break;
                case 'room':
                    $kind_of_realty = 'комната';
                    $rooms= $offer->appendChild($dom->createElement('rooms'));
                    $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
                case 'house':
                    $kind_of_realty = 'дом';
            }
            if ($realty->address_city == 'Москва г'){
                $area_text = 'Москва';
            }else {
                $area_text = 'Московская обл.';
            }
            break;
        case 'commercial':
            switch ($realty->kind_of_realty)
            {
                case 'stock':
                    $kind_of_realty = 'Склад';
                    break;
                case 'torg':
                    $kind_of_realty = 'Торговая площадь';
                    break;
                case 'sto':
                    $kind_of_realty = 'квартира';
                    break;
                case 'gost':
                    $kind_of_realty = 'Автосервис';
                    break;
                case 'poly':
                    $kind_of_realty = 'ПСН';
                    break;
                case 'office':
                    $kind_of_realty = 'Офис';

                  //  $rooms= $offer->appendChild($dom->createElement('rooms'));
                   // $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
            }
            if ($realty->address_city == 'Москва г'){
                $area_text = 'Москва';
            }else {
                $area_text = 'Московская обл.';
            }
            break;
        case 'country_house':
            if ($realty->address_city == 'Москва г'){
                $area_text = 'Москва';
            }else {
                $area_text = 'Московская обл.';
            }


            $kind_of_realty = 'дом';
            break;
        case 'flats_spb':
            switch ($realty->kind_of_realty)
            {
                case 'flat':
                    $kind_of_realty = 'квартира';
                    break;
                case 'room':
                    $kind_of_realty = 'комната';
                    $rooms= $offer->appendChild($dom->createElement('rooms'));
                    $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
                case 'house':
                    $kind_of_realty = 'дом';
            }
            break;
        case 'rent_spb':
            switch ($realty->kind_of_realty)
            {
                case 'flat':
                    $kind_of_realty = 'квартира';
                    break;
                case 'room':
                    $kind_of_realty = 'комната';
                    $rooms= $offer->appendChild($dom->createElement('rooms'));
                    $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
                case 'house':
                    $kind_of_realty = 'дом';
                    break;
            }

        case 'commercial_spb':

            switch ($realty->kind_of_realty)
            {
                case 'stock':
                    $kind_of_realty = 'Склад';
                    break;
                case 'torg':
                    $kind_of_realty = 'Торговая площадь';
                    break;
                case 'sto':
                    $kind_of_realty = 'квартира';
                    break;
                case 'gost':
                    $kind_of_realty = 'Автосервис';
                    break;
                case 'poly':
                    $kind_of_realty = 'ПСН';
                    break;
                case 'office':
                    $kind_of_realty = 'Офис';

                    //  $rooms= $offer->appendChild($dom->createElement('rooms'));
                    // $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
            }

            break;
        case 'country_house_spb':
            $kind_of_realty = 'дом';
            break;
        case 'region':
            switch ($realty->kind_of_realty)
            {
                case 'flat':
                    $kind_of_realty = 'квартира';
                    break;
                case 'room':
                    $kind_of_realty = 'комната';
                    $rooms= $offer->appendChild($dom->createElement('rooms'));
                    $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
                case 'house':
                    $kind_of_realty = 'дом';
                    break;
            }

            break;
        case 'region_commercial':
            switch ($realty->kind_of_realty)
            {
                case 'stock':
                    $kind_of_realty = 'Склад';
                    break;
                case 'torg':
                    $kind_of_realty = 'Торговая площадь';
                    break;
                case 'sto':
                    $kind_of_realty = 'квартира';
                    break;
                case 'gost':
                    $kind_of_realty = 'Автосервис';
                    break;
                case 'poly':
                    $kind_of_realty = 'ПСН';
                    break;
                case 'office':
                    $kind_of_realty = 'Офис';

                    //  $rooms= $offer->appendChild($dom->createElement('rooms'));
                    // $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
            }

            break;
        case 'country_house_region':
            $kind_of_realty = 'дом';
            break;
        case 'foreign':
            switch ($realty->kind_of_realty)
            {
                case 'flat':
                    $kind_of_realty = 'квартира';
                    break;
                case 'room':
                    $kind_of_realty = 'комната';
                    break;
                case 'house':
                    $kind_of_realty = 'дом';
                    break;
            }
            break;
        case 'foreign_commercial':
            switch ($realty->kind_of_realty)
            {
                case 'stock':
                    $kind_of_realty = 'Склад';
                    break;
                case 'torg':
                    $kind_of_realty = 'Торговая площадь';
                    break;
                case 'sto':
                    $kind_of_realty = 'квартира';
                    break;
                case 'gost':
                    $kind_of_realty = 'Автосервис';
                    break;
                case 'poly':
                    $kind_of_realty = 'ПСН';
                    break;
                case 'office':
                    $kind_of_realty = 'Офис';

                    //  $rooms= $offer->appendChild($dom->createElement('rooms'));
                    // $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                    break;
            }

            break;
    }

    if ($type_realty=='rent' or $type_realty=='flats' or $type_realty=='flats_spb' or $type_realty=='rent_spb'){
        $actual = $offer->appendChild($dom->createElement('actual'));
        switch ($realty->operation_status)
        {
            case 'in_rent':
                $operation_status = 'арендована';
                break;
            case 'out_rent':
                $operation_status = 'арендуется';
                break;
            case 'bought':
                $operation_status = 'продана';
                break;
            case 'not_bought':
                $operation_status = 'продается';
                break;
        }
        $actual->appendChild($dom->createTextNode($operation_status));

    }else if ($type_realty=='commercial' or $type_realty=='country_house' or $type_realty=='country_house_spb'  or $type_realty=='commercial_spb' or $type_realty=='region_commercial' or $type_realty=='country_house_region' or $type_realty=='foreign' or $type_realty=='foreign_commercial'){
        $actual = $offer->appendChild($dom->createElement('actual'));
        switch ($realty->operation_status)
        {
            case 'in_rent':
                $operation_status = 'продана/арендована';
                break;
            case 'out_rent':
                $operation_status = 'продается/арендуется';
                break;
            case 'bought':
                $operation_status = 'продана/арендована';
                break;
            case 'not_bought':
                $operation_status = 'продается/арендуется';
                break;
        }
        $actual->appendChild($dom->createTextNode($operation_status));
    }

    if ($type_realty=='foreign' or $type_realty=='foreign_commercial'){
        $obtp = $offer->appendChild($dom->createElement('obtp'));
        switch ($realty->kind_of_realty)
        {
            case 'flat':
                $kind_of_realty = 'квартира';
                break;
            case 'room':
                $kind_of_realty = 'комната';
                break;
            case 'house':
                $kind_of_realty = 'дом';
                break;
            case 'stock':
                $kind_of_realty = 'Склад';
                break;
            case 'torg':
                $kind_of_realty = 'Торговая площадь';
                break;
            case 'sto':
                $kind_of_realty = 'квартира';
                break;
            case 'gost':
                $kind_of_realty = 'Автосервис';
                break;
            case 'poly':
                $kind_of_realty = 'ПСН';
                break;
            case 'office':
                $kind_of_realty = 'Офис';

                //  $rooms= $offer->appendChild($dom->createElement('rooms'));
                // $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
                break;
        }

        $obtp->appendChild($dom->createTextNode($kind_of_realty));
    }

    if ($type_realty=='region'){
        $actual = $offer->appendChild($dom->createElement('actual'));
        switch ($realty->operation_status)
        {
            case 'bought':
                $operation_status = 'продана';
                break;
            case 'not_bought':
                $operation_status = 'продается';
                break;
        }
        $actual->appendChild($dom->createTextNode($operation_status));
    }
    if ($type_realty!='foreign' and $type_realty!='foreign_commercial'){
        $aptp = $offer->appendChild($dom->createElement('aptp'));
        $aptp->appendChild($dom->createTextNode($kind_of_realty));
    }
    if ($type_realty=='flats' or $type_realty =='rent' or $type_realty=='flats_spb' or $type_realty=='rent_spb' or $type_realty=='region'){
        //todo если есть новостройка

        if (($type_realty=='rent' and $type_realty!='foreign')  or($type_realty=='rent_spb' and $type_realty!='foreign')){
            $rent_term = $offer->appendChild($dom->createElement('rent_term'));
            switch ($realty->period){
                case 'day':
                    $rent_term_text='посуточно';
                    break;
                case 'month':
                    $rent_term_text='от месяца и более';
                    break;
                case 'year':
                    $rent_term_text='длительный срок';
                    break;
            }

            $rent_term->appendChild($dom->createTextNode($rent_term_text));
        }

        $nova = $offer->appendChild($dom->createElement('nova'));
        $nova->appendChild($dom->createTextNode('-'));


    } else if ($type_realty=='commercial' or $type_realty=='country_house' or $type_realty=='country_house_spb'  or $type_realty=='commercial_spb'  or $type_realty=='region_commercial' or $type_realty=='country_house_region' or $type_realty=='foreign' or $type_realty=='foreign_commercial'){

        if ($type_realty=='foreign'){
            $nova = $offer->appendChild($dom->createElement('nova'));
            $nova->appendChild($dom->createTextNode('-'));
        }

        $optp = $offer->appendChild($dom->createElement('optp'));
        if($realty->operation == 'rent'){
            $optp_text = 'аренда';

            if ($type_realty=='country_house'){
                $rent_term = $offer->appendChild($dom->createElement('rent_term'));
                switch ($realty->period){
                    case 'day':
                        $rent_term_text='Посуточно';
                         break;
                    case 'month':
                        $rent_term_text='От месяца и более';
                        break;
                    case 'year':
                        $rent_term_text='Длительный срок';
                        break;
                }

                $rent_term->appendChild($dom->createTextNode($rent_term_text));
            }


        }else {
            $optp_text = 'продажа';
        }

        $optp->appendChild($dom->createTextNode($optp_text));
    }

    if ($type_realty=='foreign' or $type_realty=='foreign_commercial'){
        $land = $offer->appendChild($dom->createElement('land'));
        $land->appendChild(($dom->createTextNode($realty->address_country)));
        $state = $offer->appendChild($dom->createElement('state'));
        $state->appendChild(($dom->createTextNode($realty->address_region)));
        $field = $offer->appendChild($dom->createElement('field'));
        // todo Регион
        $field->appendChild(($dom->createTextNode('Регион')));
        $town = $offer->appendChild($dom->createElement('town'));
        $town->appendChild(($dom->createTextNode($realty->address_city)));

    }

    if ($type_realty=='flats_spb' or $type_realty=='rent_spb' or $type_realty=='country_house_spb'  or $type_realty=='commercial_spb' or $type_realty=='region' or $type_realty=='region_commercial' or $type_realty=='country_house_region'){
        $region_geo = $offer->appendChild($dom->createElement('region_geo'));
            if ($realty->address_city=='Санкт-Петербург г'){
                $region= 'Санкт-Петербург';
            }else if ($realty->address_region=='Ленинградская обл'){
                $region = 'Ленинградская область';
            }else {
                $region = $realty->address_region;
            }
        $region_geo->appendChild($dom->createTextNode($region));

        $area_geo = $offer->appendChild($dom->createElement('area_geo'));
        //todo Район
        $area_geo->appendChild($dom->createTextNode('Район'));


        $place_geo = $offer->appendChild($dom->createElement('place_geo'));
        $place_geo->appendChild($dom->createTextNode($realty->address_city.'.'));

    }

    if (isset($area_text)){
        if($region == 'Санкт-Петербург' and $region != 'Ленинградская область'){
            $area = $offer->appendChild($dom->createElement('area'));
            $area->appendChild($dom->createTextNode($area_text));
        }

        if($realty->address_region == 'Московская обл'){
            $area = $offer->appendChild($dom->createElement('area'));
            $area->appendChild($dom->createTextNode($area_text));
        }

    }


    if ($region == 'Санкт-Петербург'){
        $metro = $offer->appendChild($dom->createElement('metro'));
        $metro->appendChild($dom->createTextNode($realty->metro));
    }

    if ($realty->address_region == 'Московская обл'){
        if ($realty->address_city != 'Москва г'){
            if ($type_realty=='country_house' or $type_realty=='rent'){
                //todo район для загородного дома
                $locality = $offer->appendChild($dom->createElement('locality'));
                $locality->appendChild($dom->createTextNode('Район'));
                $town = $offer->appendChild($dom->createElement('town'));
                $town->appendChild($dom->createTextNode($realty->address_city));
                //$locality->appendChild($dom->createTextNode($realty->district));
            } else {
            $locality = $offer->appendChild($dom->createElement('locality'));
            $town = $locality->appendChild($dom->createElement('town'));
            $town->appendChild($dom->createTextNode($realty->address_city.'.'));
            }
        }

        if (($type_realty!='country_house' and $area_text == 'Москва') or ($type_realty!='country_house_spb' and $region == 'Санкт-Петербург')){

            $metro_list = $offer->appendChild($dom->createElement('metro_list'));
            $metro = $metro_list->appendChild($dom->createElement('metro'));
            $metro->appendChild($dom->createTextNode($realty->metro));

            if ($realty->way_to_get=='avto'){
                $fartp = 'т';
            }else {
                $fartp = 'п';
            }
            $metro->setAttribute("fartp", $fartp);
            $metro->setAttribute("farval", '5');
        }


    }

    if ($type_realty!='country_house_region'){
        $address = $offer->appendChild($dom->createElement('address'));
        $address->appendChild($dom->createTextNode($realty->address_street.'.'));

        $house = $offer->appendChild($dom->createElement('dom'));
        $house->appendChild($dom->createTextNode($realty->address_house));
    }
    if ($type_realty=='country_house'){
    //todo шоссе
        $highway = $offer->appendChild($dom->createElement('highway'));
        $highway->appendChild($dom->createTextNode('highway'));

        //todo отдаленность от мкада
        $mkad = $offer->appendChild($dom->createElement('otMKAD'));
        $mkad->appendChild($dom->createTextNode('25'));
    }



    $price = $offer->appendChild($dom->createElement('price'));

    //todo Курс валют
/*    if ($realty->currency == 'UAH'){
        /// Парс курса валют для гривны
        class CBRAgent
        {
            protected $list = array();

            public function load()
            {
                $xml = new DOMDocument();
                $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');

                if (@$xml->load($url))
                {
                    $this->list = array();

                    $root = $xml->documentElement;
                    $items = $root->getElementsByTagName('Valute');

                    foreach ($items as $item)
                    {
                        $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                        $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                        $this->list[$code] = floatval(str_replace(',', '.', $curs));
                    }

                    return true;
                }
                else
                    return false;
            }

            public function get($cur)
            {
                return isset($this->list[$cur]) ? $this->list[$cur] : 0;
            }
        }

        $cbr = new CBRAgent();
        if ($cbr->load()){
            $uah_curs = $cbr->get('UAH');
        }
        $cc = $realty->totalcost;
        $cost = $cc*$uah_curs/10;
    }else{*/
        $cost = $realty->totalcost;
  //  }

    $price->appendChild($dom->createTextNode(intval($cost)));

        if ($realty->currency=='UAH'){
            $currency = 'RUB';
        } else if ($realty->currency=='RUR'){
            $currency = 'RUB';
        }
        else{
            $currency = $realty->currency;
        }
    if ($type_realty !='foreign' and $type_realty!='foreign_commercial'){
        $price->setAttribute('currency',$currency);
    }else {
        $f_currency = $offer->appendChild($dom->createElement('currency'));
        $f_currency->appendChild($dom->createTextNode($currency));
    }
    // Колличество комнат
    if ($type_realty=='flats' or $type_realty=='rent' or $type_realty=='flats_spb' or $type_realty=='rent_spb' or $type_realty=='region' or $type_realty=='foreign'){
        $flats = $offer->appendChild($dom->createElement('flats'));
        $flats->appendChild($dom->createTextNode($realty->rooms_quantity));
    }

    if ($type_realty=='foreign' and $kind_of_realty =='квартира'){
        $rooms= $offer->appendChild($dom->createElement('rooms'));
        $rooms->appendChild($dom->createTextNode($realty->rooms_quantity));
    }

    // Площадь
    if ($type_realty=='flats' or $type_realty=='rent' or $type_realty=='flats_spb' or $type_realty=='rent_spb' or $type_realty=='region'){
        $sq= $offer->appendChild($dom->createElement('sq'));
        //Общая площадь
        $sq->setAttribute("pl_ob",$realty->square);
        // Жилая площадь
        $sq->setAttribute("pl",$realty->living_square);
        //Площадь кухни
        $sq->setAttribute("kitch",$realty->kitchen_square);
    }else if ($type_realty=='commercial' or $type_realty=='commercial_spb' or $type_realty=='region_commercial'){
        $sq= $offer->appendChild($dom->createElement('sq'));
        $sq->setAttribute("pl_min",$realty->square);
        $sq->setAttribute("pl_max",$realty->living_square);
    }else if ($type_realty=='country_house' or $type_realty=='country_house_spb'  or $type_realty=='country_house_region'){
        $sq= $offer->appendChild($dom->createElement('sq'));
        $sq->setAttribute("pl_s",$realty->square);
        $sq->setAttribute("pl",$realty->living_square);
    }


    if ($type_realty=='foreign'){
        $pl_ob = $offer->appendChild($dom->createElement('pl_ob'));
        $pl_ob->appendChild($dom->createTextNode($realty->square));
        $pl_s = $offer->appendChild($dom->createElement('pl_s'));
        $pl_s->appendChild($dom->createTextNode($realty->living_square));
    }

    if ($type_realty=='foreign_commercial'){
        $pl = $offer->appendChild($dom->createElement('pl'));
        $pl->appendChild($dom->createTextNode($realty->square));
        $pl_s = $offer->appendChild($dom->createElement('pl_s'));
        $pl_s->appendChild($dom->createTextNode($realty->living_square));
    }
    /* todo разбивка комнат
    $sq->setAttribute("pl_r",$realty->living_square);
    */
    // Этаж


    if ($type_realty!='country_house' and $type_realty!='commercial' and $type_realty!='country_house_spb'  and $type_realty!='commercial_spb' and $type_realty!='country_house_region'){
        $floor= $offer->appendChild($dom->createElement('floor'));
        $floor->appendChild($dom->createTextNode($realty->floor));

        // Колличество этажей

        $number_of_floors= $offer->appendChild($dom->createElement('fl_ob'));
        $number_of_floors->appendChild($dom->createTextNode($realty->number_of_floors));
    }
    // Состояние объекта
    if ($type_realty=='flats' or $type_realty=='rent' or $type_realty=='flats_spb' or $type_realty=='rent_spb' or $type_realty=='region'){
        $remont= $offer->appendChild($dom->createElement('remont'));

        if ($realty->state_of_object == 'major_repair'){
            $remont_q='требуется капитальный ремонт';
            if ($type_realty=='rent_spb' or $type_realty == 'rent'){
                $remont_q = 'требует ремонта';
            }

        }else if ($realty->state_of_object == 'cosmetic_repair'){
            $remont_q='требуется ремонт';
            if ($type_realty=='rent_spb' or $type_realty == 'rent'){
                $remont_q = 'требует ремонта';
            }
        }else if ($realty->state_of_object == 'perfect'){
            $remont_q='отличное состояние';
        }else if ($realty->state_of_object == 'eurorepair'){
            $remont_q='евроремонт';
        }

        $remont->appendChild($dom->createTextNode($remont_q));
    }


    // Телефон

    $telefon= $offer->appendChild($dom->createElement('telefon'));
    $focus = new User();
    $idd = $realty->created_by;
    $focus -> retrieve($idd);
    if (isset($focus->phone_other) and $focus->phone_other!='^|^'){
        $phone = $focus->phone_other;
        $phone = explode('^|^',$phone);
        $tel = $phone[0];
    }
    if (isset($focus->phone_mobile) and $focus->phone_mobile !='^|^'){
        $phone = $focus->phone_mobile;
        $phone = explode('^|^',$phone);
        $tel = $phone[0];
    }
    if (isset($focus->phone_work) and $focus->phone_work !='^|^'){
        $phone = $focus->phone_work;
        $phone = explode('^|^',$phone);
        $tel = $phone[0];
    }

    if ($type_realty=='foreign' or $type_realty=='foreign_commercial'){
        $tel = '+'.$tel;
    }
    $telefon->appendChild($dom->createTextNode($tel));

    // email

    $email= $offer->appendChild($dom->createElement('email'));
    $mail = $focus->email1;
    $email->appendChild($dom->createTextNode($mail));
// Описание
    $remark= $offer->appendChild($dom->createElement('remark'));
    $text = $dom->createCDATASection($realty->d_text);
    $remark->appendChild($text);

    global $sugar_config;
    $dir = "upload/gallery_images/".$realty->id."/";
    if (is_dir($dir))
    {
        foreach (glob("upload/gallery_images/".$realty->id."/*.jpeg") as $Photo)
        {
            $Pictures[] = $Photo;
        }
        $cont_mail = array();
        $photo = $offer->appendChild($dom->createElement('photos'));
        for($i=0; $i<count($Pictures); )
        {

            ++$i;
            if ($i > 5)
            {
                break;
            }

            $photo->appendChild($dom->createTextNode($sugar_config['site_url'].'/'.$Pictures[$i-1].';'));
        }
    }
}

?>
