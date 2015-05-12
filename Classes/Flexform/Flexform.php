<?php
namespace PHTH\Catalog\Flexform;

class flexform {


    function extendedItemList($config){
        // get data
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            'field_of_reference_level1, count(uid) AS count',
            'tx_catalog_domain_model_article',
            '1=1 AND field_of_reference_level1 != \'\' AND hidden != 1 AND deleted != 1',
            'field_of_reference_level1'
        );
        // create option list
        $optionList = array();
        $optionList[0] = array(
                                0 => 'bitte wählen',
                                1 => '0'
                        );
        //debug($result);
        foreach($result as $item){
            $label =  $item['field_of_reference_level1'].' ('.$item['count'].')';
            $value = $item['field_of_reference_level1'];

            $optionList[] = array(0 => $label, 1 => crc32($value));
        }

        // return config
        $config['items'] = $optionList;

        return $config;
    }
} 