<?php 
namespace App\Services;

/*Interfaces */
use App\Interfaces\ServiceInterface;

/*request */
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

/* models */ 
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeService implements ServiceInterface {

    public function store(StoreProductRequest $request, integer $id) : void {
            $attrs = explode(',', $request->attrs);
            $values = json_decode($request->values);
            $prices = json_decode($request->prices);

            foreach ($attrs as $key => $myattr) {

                $prod_attr = Attribute::where('name', $myattr)->first()->id;
                foreach ($values[$key] as $k => $value) {

                    $attribute = AttributeValue::create([
                        'product_id' => $id,
                        'attribute_id' => $prod_attr,
                        'value' => $value,
                        'price_variation' => $prices[$key][$k],

                    ]);
                }
            }
    }
    public function delete(integer $id) : void {
        $attrs = AttributeValue::where('product_id', $id)->get();
        if ($attrs) {
            foreach ($attrs as $attr) {
                $attr->delete();
            }
        }
    }

}