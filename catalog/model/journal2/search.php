<?php
class ModelJournal2Search extends Model {

    public function search($data, $limit = 5, $include_description = false, $more_fields = false) {
        $params = array(
            'filter_name'         => $data,
            'sort'                => 'p.sort_order',
            'order'               => 'ASC',
            'start'               => 0,
            'limit'               => $limit
        );

        if($more_fields){
            $params['filter_meta_title'] = true;
            $params['filter_meta_description'] = true;
            $params['filter_meta_keyword'] = true;
            $params['filter_misspelling_keyword'] = true;
        }

        $this->load->model('catalog/product');
        
        // modify by kelvin poon
        // by default, only product name used for filter
        $more_conditions = [
            0 => ['filter_tag', 'filter_model', 'filter_sku', 'filter_meta_title', 'filter_meta_description', 'filter_meta_keyword', 'filter_misspelling_keyword'],
        ];
        
        if ($include_description) {
            $more_conditions[] = ['filter_description'];
        }
        

        $results = $this->model_catalog_product->getProducts($params);
        
        if(count($results)<$limit){
            foreach($more_conditions as $conditions){
                $params2 = $params;
                foreach($conditions as $condition){
                    $params2[$condition] = true;
                }
                $records = $this->model_catalog_product->getProducts($params2);
                
                foreach($records as $product_id => $record){
                    if(!isset($results[$product_id]) && count($results)<$limit){
                        $results[$product_id] = $record;
                    }
                }
                
                if(count($results)>=$limit){
                    break;
                }
            }
        }

        return $results;
    }

}
?>