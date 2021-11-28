<?php

$files = glob('/media/stas/Elements/stas/works/projects/promua_resources/resources/attributes/xml/*.xml');
foreach ($files as $file_xml) {
    $file_json = str_replace('xml', 'json', $file_xml);
    XmlToJson($file_xml, $file_json);
}
function XmlToJson($file_xml,$file_json ) {
    $xml = file_get_contents($file_xml);

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->loadXml($xml);

    $attributes = [];

    $category_ = $dom->getElementsByTagName('category')->item(0);
    $category = [];
    foreach ($category_->attributes as $attribute) {
        $category['category'][$attribute->name] = $attribute->value;
    }

    $attributes_ = $dom->getElementsByTagName('attribute');
    foreach ($attributes_ as $attribute_) {
        $attribute = [];
        foreach ($attribute_->attributes as $value) {
            $attribute[$value->name] = $value->value;
        }

        foreach ($attribute_->getElementsByTagName('attribute_value') as $attribute_value_) {
            $attributes1 = [];
            foreach ($attribute_value_->attributes as $value) {
                $attributes1[$value->name] = $value->value;
            }
            $attribute['attribute_value'][] = $attributes1;
        }
        $attributes[] = $attribute;

    }
    $category['category']['attributes'] = $attributes;


    file_put_contents($file_json, json_encode($category, JSON_UNESCAPED_UNICODE));
}





