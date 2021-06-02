<?php

/**
 * .
 * User: duykhanhqv
 * Date: 02/06/2020
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Product\ListProductsByDateAjax;

/**
 * Class GetPartnerListing - Get more partner
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetProductByDate extends AbstractAjax
{

    protected $functions = [
        'get_products' =>  'get_product_by_date',

    ];
    /**
     * .
     * User: duykhanhqv
     * Date: ajax get product from to date
     * Time: 12h00
     */
    public function get_product_by_date()
    {
        global $wpdb;
        $query = <<<EOT
            SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id  LEFT JOIN wp_postmeta AS mt3 ON mt1.post_id = mt3.post_id 
            WHERE
                p.post_type = 'product' AND
                ( mt1.meta_key LIKE 'training_types_%_execution_of_training_has_live_course' AND mt1.meta_value = '1' ) AND
                ( mt2.meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_0_date' AND mt2.meta_value = '{$_GET['date_from']}' ) AND
                ( mt3.meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_1_date' AND mt3.meta_value = '{$_GET['date_to']}' ) AND
                ( REPLACE(mt1.meta_key, '_execution_of_training_has_live_course', '') = REPLACE(mt2.meta_key, '_execution_of_training_live_course_dates_0_date', '') ) AND
                ( REPLACE(mt1.meta_key, '_execution_of_training_has_live_course', '') = REPLACE(mt3.meta_key, '_execution_of_training_live_course_dates_1_date', '') )
            GROUP BY p.id
            EOT;
        $products = $wpdb->get_results($query);
        debug($products, true);
    }
}
